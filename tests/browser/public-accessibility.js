// Run in browser console on /, /tentang-kami/faq and /area/jakarta-timur.
(async () => {
    const check = (ok, message) => { if (!ok) throw Error(message); };
    const settle = () => new Promise(resolve => setTimeout(resolve, 350));
    check(document.documentElement.lang === 'id', 'Indonesian document language');
    const raw = new DOMParser().parseFromString(await (await fetch(location.href)).text(), 'text/html');
    const links = [...raw.querySelectorAll('a')].filter(a => a.getAttribute(':href')?.includes('wa.me'));
    check(links.length >= 4, 'Layout contact links exist');
    links.forEach(a => {
        const href = a.getAttribute('href');
        check(href?.startsWith('https://wa.me/'), 'Contact link has server-rendered href');
        check(new URL(href).searchParams.get('text')?.startsWith('Halo Admin Drainusantara,'), 'Encoded contact message');
    });
    for (const button of document.querySelectorAll('#faq button[aria-controls], #faq-page button[aria-controls]')) {
        const original = button.getAttribute('aria-expanded');
        button.click();
        await settle();
        const open = button.getAttribute('aria-expanded') === 'true';
        const answer = document.getElementById(button.getAttribute('aria-controls'));
        check(button.getAttribute('aria-expanded') !== original, 'FAQ expansion updates');
        check((getComputedStyle(answer).display !== 'none') === open, 'FAQ expansion matches visible answer');
    }
    const canvas = document.createElement('canvas').getContext('2d');
    const luminance = color => {
        canvas.fillStyle = color;
        canvas.fillRect(0, 0, 1, 1);
        return [...canvas.getImageData(0, 0, 1, 1).data].slice(0, 3).map(value => {
            value /= 255;
            return value <= .04045 ? value / 12.92 : ((value + .055) / 1.055) ** 2.4;
        }).reduce((sum, value, i) => sum + value * [.2126, .7152, .0722][i], 0);
    };
    const contrast = [...document.querySelectorAll('#daftar-kecamatan .grid > div > div:first-child > span')].map(label => {
        const foreground = luminance(getComputedStyle(label).color);
        const background = luminance(getComputedStyle(label.parentElement.parentElement).backgroundColor);
        const ratio = (Math.max(foreground, background) + .05) / (Math.min(foreground, background) + .05);
        check(ratio >= 4.5, 'District label contrast at least 4.5:1');
        return ratio;
    });
    if (innerWidth < 1024) {
        const trigger = document.querySelector('[aria-controls="area-search-dialog"]');
        const dialog = document.getElementById('area-search-dialog');
        trigger.focus();
        trigger.click();
        await settle();
        check(dialog.open && dialog.matches(':modal'), 'Search is native modal');
        check(document.getElementById(dialog.getAttribute('aria-labelledby'))?.textContent.trim(), 'Dialog has accessible name');
        const input = document.getElementById('area-search-input');
        check(document.activeElement !== input && dialog.contains(document.activeElement), 'Opening search does not focus input');
        check(!input.autofocus, 'Search input has no autofocus');
        check(input.labels.length > 0, 'Search input has label');
        input.focus();
        check(document.activeElement === input, 'Search input remains manually focusable');
        const buttons = [...dialog.querySelectorAll('button')];
        buttons.at(-1).focus();
        document.activeElement.dispatchEvent(new KeyboardEvent('keydown', {key: 'Tab', bubbles: true, cancelable: true}));
        check(document.activeElement === buttons[0], 'Tab wraps to first control');
        document.activeElement.dispatchEvent(new KeyboardEvent('keydown', {key: 'Tab', shiftKey: true, bubbles: true, cancelable: true}));
        check(document.activeElement === buttons.at(-1), 'Shift Tab wraps to last control');
        dialog.dispatchEvent(new Event('cancel', {cancelable: true}));
        await settle();
        check(!dialog.open && document.activeElement === trigger, 'Close restores trigger focus');
        trigger.click();
        await settle();
        buttons[0].click();
        await settle();
        check(!dialog.open && document.activeElement === trigger, 'Close button restores trigger focus');
    }
    return {path: location.pathname, passed: true, contactLinks: links.length, districtContrast: contrast};
})()
