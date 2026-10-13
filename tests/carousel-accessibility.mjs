import assert from 'node:assert/strict';
import { readFileSync, existsSync, readdirSync } from 'node:fs';

const entry = readFileSync(new URL('../resources/js/app.js', import.meta.url), 'utf8');
assert.match(entry, /import \{ registerCarousels \} from '\.\/carousel'/, 'production entry imports carousel lifecycle');
assert.ok(entry.indexOf('registerCarousels(Alpine)') < entry.indexOf('Alpine.start()'), 'register before Alpine starts');
assert.ok(!entry.includes("Alpine.data('mobileCarousel'"), 'no legacy registration overrides shared lifecycle');

// DOM and clock stand-ins keep lifecycle checks runnable without dependencies.
let factory;
const Alpine = { data(name, value) { if (name === 'mobileCarousel') factory = value; } };
if (existsSync(new URL('../resources/js/carousel.js', import.meta.url))) {
    const { registerCarousels } = await import('../resources/js/carousel.js');
    registerCarousels(Alpine);
} else {
    const source = readFileSync(new URL('../resources/js/app.js', import.meta.url), 'utf8');
    Function('Alpine', source.slice(source.indexOf("Alpine.data('mobileCarousel'"), source.indexOf('\nregisterWebMcpTools();')))(Alpine);
}

function fixture(reduced = false, groupSize = 1) {
    const timers = new Map();
    let timerId = 0;
    globalThis.setInterval = (callback) => { timers.set(++timerId, callback); return timerId; };
    globalThis.clearInterval = (id) => timers.delete(id);
    const media = Object.assign(new EventTarget(), { matches: reduced });
    globalThis.window = Object.assign(new EventTarget(), { innerWidth: 390, matchMedia: () => media });
    globalThis.document = Object.assign(new EventTarget(), { hidden: false, activeElement: null });
    globalThis.requestAnimationFrame = (callback) => setTimeout(callback, 0);
    globalThis.cancelAnimationFrame = clearTimeout;
    const slider = {
        scrollWidth: 1800, clientWidth: 300, offsetLeft: 0, scrollLeft: 0,
        children: Array.from({ length: 6 }, (_, i) => ({
            nodeType: 1, tagName: 'DIV', hidden: false, style: {}, offsetLeft: i * 300,
            clientWidth: 300, classList: { contains: () => false }, getClientRects: () => [1],
        })),
        scrollTo(options) { this.lastScroll = options; this.scrollLeft = options.left; },
    };
    const root = Object.assign(new EventTarget(), { contains: (node) => node === slider });
    const carousel = factory(6, 4000, groupSize);
    Object.assign(carousel, { $refs: { slider }, $root: root, $el: root, $nextTick: (callback) => callback() });
    carousel.init();
    return { carousel, slider, root, media, timers };
}

const reduced = fixture(true);
await new Promise((resolve) => setTimeout(resolve, 2600));
assert.equal(reduced.timers.size, 0, 'reduced motion must prevent initial autoplay');
console.log('PASS initial reduced-motion autoplay');
reduced.media.matches = false;
reduced.media.dispatchEvent(new Event('change'));
assert.equal(reduced.timers.size, 1, 'live no-preference enables autoplay');
reduced.media.matches = true;
reduced.media.dispatchEvent(new Event('change'));
assert.equal(reduced.timers.size, 0, 'live reduced motion stops autoplay');
reduced.carousel.goTo(1);
assert.equal(reduced.slider.lastScroll.behavior, 'instant', 'manual reduced-motion navigation must not animate');
console.log('PASS live reduced motion and instant navigation');

const normal = fixture();
normal.carousel.startAutoScroll();
assert.equal(typeof normal.carousel.toggleAutoplay, 'function', 'explicit stop/start action required');
normal.carousel.toggleAutoplay();
assert.equal(normal.timers.size, 0, 'stop clears running timer');
normal.carousel.pause();
normal.carousel.resume();
normal.carousel.startAutoScroll();
normal.media.dispatchEvent(new Event('change'));
document.dispatchEvent(new Event('visibilitychange'));
window.dispatchEvent(new Event('resize'));
assert.equal(normal.timers.size, 0, 'explicit stop survives lifecycle and interaction events');
normal.carousel.toggleAutoplay();
assert.equal(normal.timers.size, 1, 'explicit start restores autoplay');
normal.root.dispatchEvent(new Event('focusin'));
assert.equal(normal.timers.size, 0, 'keyboard focus pauses autoplay');
normal.carousel.pause();
normal.carousel.resume();
assert.equal(normal.timers.size, 0, 'pointer release cannot override focus pause');
normal.root.dispatchEvent(Object.assign(new Event('focusout'), { relatedTarget: normal.slider }));
assert.equal(normal.timers.size, 0, 'focus moving inside carousel stays paused');
normal.root.dispatchEvent(Object.assign(new Event('focusout'), { relatedTarget: null }));
assert.equal(normal.timers.size, 1, 'leaving carousel resumes autoplay');
document.hidden = true;
document.dispatchEvent(new Event('visibilitychange'));
assert.equal(normal.timers.size, 0, 'hidden document pauses autoplay');
document.hidden = false;
document.dispatchEvent(new Event('visibilitychange'));
assert.equal(normal.timers.size, 1);
normal.carousel.destroy();
normal.media.dispatchEvent(new Event('change'));
window.dispatchEvent(new Event('resize'));
assert.equal(normal.timers.size, 0, 'destroy removes timers and listeners');
console.log('PASS persistent controls, focus, visibility, cleanup');

const grouped = fixture(false, 3);
assert.equal(grouped.carousel.total, 2, 'B2B retains one page per three cards');
grouped.carousel.goTo(1);
assert.equal(grouped.slider.lastScroll.left, 900, 'B2B page starts at fourth card');
grouped.carousel.next();
assert.equal(grouped.carousel.active, 0, 'last page wraps');
grouped.carousel.prev();
assert.equal(grouped.carousel.active, 1, 'previous wraps');
grouped.carousel.destroy();
console.log('PASS grouped portfolio navigation');

const empty = fixture();
empty.slider.children = [];
empty.carousel.total = 0;
empty.carousel.next();
empty.carousel.prev();
assert.equal(empty.carousel.active, 0, 'empty carousel navigation stays finite');
empty.carousel.destroy();

const observed = fixture();
observed.carousel.destroy();
let observerCallback;
window.IntersectionObserver = class {
    constructor(callback) { observerCallback = callback; }
    observe() {}
    disconnect() {}
};
const watched = factory(6, 4000);
Object.assign(watched, { $refs: { slider: observed.slider }, $root: observed.root, $nextTick: (callback) => callback() });
watched.init();
assert.equal(observed.timers.size, 0, 'offscreen carousel waits');
observerCallback([{ isIntersecting: true }]);
assert.equal(observed.timers.size, 1, 'onscreen carousel plays');
watched.toggleAutoplay();
observerCallback([{ isIntersecting: false }]);
observerCallback([{ isIntersecting: true }]);
assert.equal(observed.timers.size, 0, 'intersection cannot override explicit stop');
watched.destroy();
console.log('PASS empty carousel and intersection lifecycle');

const views = new URL('../resources/views/', import.meta.url);
let tracks = 0;
let nativeTracks = 0;
for (const file of readdirSync(views, { recursive: true }).filter((file) => file.endsWith('.blade.php'))) {
    const source = readFileSync(new URL(file, views), 'utf8');
    for (const track of source.matchAll(/<div\b(?:[^>"']|"[^"]*"|'[^']*')*>/g)) {
        if (!/class="[^"]*\bsnap-x\b/.test(track[0])) continue;
        nativeTracks++;
        assert.match(track[0], /tabindex="0"/, `${file}: native carousel keyboard focus`);
        assert.match(track[0], /aria-label="[^"]+"/, `${file}: native carousel name`);
    }
    if (!/mobileCarousel\(|setInterval/.test(source)) continue;
    assert.ok(!source.includes('setInterval'), `${file}: duplicated autoplay must use shared lifecycle`);
    for (const track of source.matchAll(/<div\b(?:[^>"']|"[^"]*"|'[^']*')*x-ref="(?:slider|\w*Slider)"(?:[^>"']|"[^"]*"|'[^']*')*>/g)) {
        tracks++;
        assert.match(track[0], /tabindex="0"/, `${file}: track keyboard focus`);
        assert.match(track[0], /aria-label="[^"]+"/, `${file}: track accessible name`);
    }
    const names = [...source.matchAll(/role="region" aria-label="([^"]+)"/g)].map((match) => match[1]);
    if (!file.includes('equipment.blade.php')) assert.equal(new Set(names).size, names.length, `${file}: distinct track names`);
    assert.ok(!source.includes('toggleAutoplay()'), `${file}: autoplay button removed`);
    for (const button of source.matchAll(/<button\b(?:[^>"']|"[^"]*"|'[^']*')*>/g)) {
        if (/@click="(?:goTo|prev|next)/.test(button[0])) {
            assert.match(button[0], /carousel-(?:dot|control)/, `${file}: 44px controls`);
            if (button[0].includes('goTo(')) assert.match(button[0], /:aria-current=/, `${file}: active indicator semantics`);
        }
    }
}
assert.equal(tracks, 23, 'every known carousel track covered');
assert.equal(nativeTracks, 24, 'native district scroller also covered');
const css = readFileSync(new URL('../resources/css/app.css', import.meta.url), 'utf8');
assert.match(css, /\.carousel-dot[\s\S]*?min-width:\s*44px/, '44px indicator width');
assert.match(css, /\.carousel-dot[\s\S]*?min-height:\s*44px/, '44px indicator height');
console.log(`PASS ${nativeTracks} named keyboard tracks, ${tracks} carousels without autoplay buttons`);
