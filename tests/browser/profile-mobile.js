// Run in browser console on /tentang-kami/profil at mobile and desktop widths.
(() => {
    const check = (ok, message) => { if (!ok) throw Error(message); };
    const width = document.documentElement.clientWidth;
    check(document.querySelector('#staff-kami'), 'Company profile loaded');
    check(document.documentElement.scrollWidth <= width, `Page overflow: ${document.documentElement.scrollWidth} > ${width}`);
    const dock = document.querySelector('.mobile-nav-dock');
    const desktop = document.querySelector('header nav');
    const mobile = !matchMedia('(min-width: 1024px)').matches;
    check((getComputedStyle(dock).display !== 'none') === mobile, 'Correct mobile navigation breakpoint');
    check((getComputedStyle(desktop).display !== 'none') === !mobile, 'Correct desktop navigation breakpoint');
    if (mobile) {
        const rect = dock.getBoundingClientRect();
        check(rect.left >= 0 && rect.right <= width, 'Dock fits viewport without zooming');
        check(rect.bottom <= visualViewport.height + visualViewport.offsetTop + 1, 'Dock visible without zooming');
        for (const button of document.querySelectorAll('#staff-kami .carousel-dot')) {
            const rect = button.getBoundingClientRect();
            if (!rect.width) continue;
            check(rect.left >= 0 && rect.right <= width, 'Staff indicator fits viewport');
            check(rect.width >= 44 && rect.height >= 44, 'Staff indicator keeps touch target');
        }
    }
    return {width, scrollWidth: document.documentElement.scrollWidth, mobile, passed: true};
})()
