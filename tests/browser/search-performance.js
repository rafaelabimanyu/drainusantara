// Run in the foreground tab with mobile viewport on a freshly loaded public page.
(async () => {
    const check = (ok, message) => { if (!ok) throw Error(message); };
    const settle = () => new Promise(resolve => setTimeout(resolve, 400));
    const dialog = document.getElementById('area-search-dialog');
    check(dialog.querySelectorAll('a').length === 0, 'Closed search must not render result links');
    const trigger = document.querySelector('[aria-controls="area-search-dialog"]');
    trigger.focus();
    trigger.click();
    await settle();
    const visibleLinks = () => [...dialog.querySelectorAll('a')].filter(a => a.getClientRects().length);
    check(dialog.open && visibleLinks().length > 0, 'Opening search renders default regions');
    const input = document.getElementById('area-search-input');
    input.value = 'Ciracas';
    input.dispatchEvent(new Event('input', {bubbles: true}));
    await settle();
    check(visibleLinks().some(a => a.href.endsWith('/jakarta-timur/ciracas')), 'Search finds Ciracas');
    input.value = 'zzzz-no-region';
    input.dispatchEvent(new Event('input', {bubbles: true}));
    await settle();
    check(visibleLinks().length === 0, 'Unknown query has no results');
    check(dialog.innerText.includes('Wilayah tidak ditemukan'), 'Empty-state message remains visible');
    dialog.querySelector('[aria-label="Tutup pencarian"]').click();
    await settle();
    check(!dialog.open && document.activeElement === trigger, 'Closing restores trigger focus');
    check(dialog.querySelectorAll('a').length === 0, 'Closing releases result DOM');
    trigger.click();
    await settle();
    check(input.value === 'zzzz-no-region' && visibleLinks().length === 0, 'Reopen preserves query');
    dialog.querySelector('[aria-label="Hapus kata kunci pencarian"]').click();
    await settle();
    check(visibleLinks().length > 0, 'Clear restores default regions');
    dialog.querySelector('[aria-label="Tutup pencarian"]').click();
    return {passed: true, path: location.pathname};
})()
