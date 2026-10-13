# Run through browser_exec: exec(open('tests/browser/drawer-regression.py').read())
# pyright: reportUndefinedVariable=false
# Requires disposable server seeded with six service categories (first price 0,
# second price 765432), built Vite assets, and no production database/media.
import json
import os
import time
from pathlib import Path

BASE_URL = os.environ.get('DRAWER_TEST_URL', 'http://127.0.0.1:54351')
results = []


def evaluate(expression):
    return js(expression)


def key(name, shift=False):
    code = {'Tab': 9, 'Escape': 27}[name]
    for kind in ['keyDown', 'keyUp']:
        cdp('Input.dispatchKeyEvent', type=kind, key=name, code=name,
            windowsVirtualKeyCode=code, modifiers=8 if shift else 0)
    time.sleep(.1)


def settle():
    time.sleep(.45)


new_tab(BASE_URL)
cdp('Page.bringToFront')
cdp('Page.addScriptToEvaluateOnNewDocument', source='window.drawerErrors=[];window.addEventListener("error",e=>{if(e.message)window.drawerErrors.push(e.message)});')
for width in [390, 768, 1023]:
    goto_url(BASE_URL)
    wait_for_load()
    cdp('Emulation.setDeviceMetricsOverride', width=width, height=844,
        deviceScaleFactor=1, mobile=True)
    settle()
    assert evaluate('innerWidth') == width
    assert evaluate('[...document.scripts].some(s => /\\/build\\/assets\\/app-.*\\.js$/.test(s.src))')
    evaluate('window.drawerTrigger=document.querySelector(\'[aria-label="Menu Lengkap"]\');window.drawerDialog=document.querySelector(\'[aria-labelledby="mobile-drawer-title"]\');document.documentElement.style.overflow="auto";document.body.style.overflow="visible";window.scrollTo(0,300)')
    for close_method in ['Escape', 'top', 'bottom', 'backdrop']:
        evaluate('drawerTrigger.focus();drawerTrigger.click()')
        settle()
        assert evaluate('drawerDialog.matches(":modal")'), 'Native modal/inert background'
        assert evaluate('drawerDialog.contains(document.activeElement)'), 'Initial focus inside drawer'
        assert evaluate('getComputedStyle(document.documentElement).overflow === "hidden" && getComputedStyle(document.body).overflow === "hidden"'), 'Scroll lock'
        old_scroll = evaluate('scrollY')
        cdp('Input.dispatchMouseEvent', type='mouseWheel', x=10, y=400, deltaX=0, deltaY=200)
        settle()
        assert evaluate('scrollY') == old_scroll, 'Background wheel must not scroll'
        for expanded in [True, False]:
            evaluate('drawerDialog.querySelector(\'button[aria-controls="drawer-company-links"]\').click()')
            settle()
            assert evaluate('drawerDialog.querySelector(\'button[aria-controls="drawer-company-links"]\').getAttribute("aria-expanded")') == str(expanded).lower()
            assert evaluate('getComputedStyle(document.getElementById("drawer-company-links")).display !== "none"') == expanded
            evaluate('window.drawerFocusables=[...drawerDialog.querySelectorAll("button:not([disabled]), a[href]")].filter(e=>e.getClientRects().length);drawerFocusables.at(-1).focus()')
            key('Tab')
            assert evaluate('document.activeElement===drawerFocusables[0]'), 'Forward Tab wraps'
            key('Tab', shift=True)
            assert evaluate('document.activeElement===drawerFocusables.at(-1)'), 'Backward Tab wraps'
        if close_method == 'Escape':
            key('Escape')
        elif close_method == 'top':
            evaluate('drawerDialog.querySelector(\'[aria-label="Tutup menu navigasi"]\').click()')
        elif close_method == 'bottom':
            evaluate('[...drawerDialog.querySelectorAll("button")].at(-1).click()')
        else:
            click_at_xy(10, 400)
        settle()
        assert evaluate('!drawerDialog.open && document.activeElement===drawerTrigger'), 'Close restores original trigger'
        assert evaluate('document.documentElement.style.overflow==="auto" && document.body.style.overflow==="visible"'), 'Restore prior scroll styles'
        results.append({'width': width, 'close': close_method, 'passed': True})
    evaluate('drawerTrigger.focus();drawerTrigger.click()')
    settle()
    cdp('Emulation.setDeviceMetricsOverride', width=1024, height=844, deviceScaleFactor=1, mobile=True)
    settle()
    assert evaluate('!drawerDialog.open'), 'Desktop breakpoint closes hidden modal'
    assert evaluate('document.documentElement.style.overflow==="auto"'), 'Resize unlocks scroll'
    assert evaluate('window.drawerErrors') == [], 'No runtime errors'

for route in ['/', '/area/provinsi/dki-jakarta', '/area/jakarta-selatan', '/area/jakarta-selatan/tebet']:
    goto_url(BASE_URL + route)
    wait_for_load()
    cdp('Emulation.setDeviceMetricsOverride', width=1280, height=900, deviceScaleFactor=1, mobile=False)
    settle()
    evaluate('window.serviceImages=[...document.querySelectorAll("h3")].map(h=>h.previousElementSibling?.querySelector("img")).filter(Boolean);serviceImages.forEach(i=>i.loading="eager")')
    settle()
    assert evaluate('serviceImages.length') == 6, 'All six category fixtures present'
    assert evaluate('serviceImages.every(i=>i.complete && i.naturalWidth>0 && i.src.endsWith("/assets/placeholders/service.svg"))'), 'Empty images load real fallback'
    evaluate('serviceImages.forEach((i,n)=>i.src="/missing-service-regression-"+n+".webp")')
    settle()
    assert evaluate('serviceImages.every(i=>i.complete && i.naturalWidth>0 && i.src.endsWith("/assets/placeholders/service.svg"))'), 'Failed images load real fallback'
    assert evaluate('serviceImages[0].closest("div.flex-col").textContent.includes("Hubungi untuk harga")'), 'Zero means price unset'
    assert evaluate('serviceImages[1].closest("div.flex-col").textContent.includes("Rp 765.432")'), 'Positive price exact'
    assert evaluate('window.drawerErrors') == [], 'No runtime errors'
    results.append({'route': route, 'categories': 6, 'emptyAndFailedImages': True, 'prices': True})

artifact = Path(os.environ.get('DRAWER_TEST_RESULT', '/home/ubuntu/.hermes/cache/scratch/drawer-regression-results.json'))
artifact.write_text(json.dumps(results, indent=2))
print(json.dumps({'passed': True, 'checks': len(results), 'results': str(artifact)}))
