/**
 * Drainusantara Conversion Rate Optimization (CRO) & Analytics Tracking Module
 * Integrated with Google Tag Manager (GTM) dataLayer
 */

window.dataLayer = window.dataLayer || [];

/**
 * Push structured event data into GTM dataLayer safely
 */
export function trackConversion(eventName, eventData = {}) {
    window.dataLayer.push({
        event: eventName,
        ...eventData,
        timestamp: new Date().toISOString(),
    });
}

// Make accessible to Alpine.js and inline components
window.trackConversion = trackConversion;

/**
 * Initialize automatic listeners for WhatsApp and Phone Call clicks
 */
export function initAutoTracking() {
    document.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href') || '';

        // 1. WhatsApp click auto-detection
        if (href.includes('wa.me') || href.includes('whatsapp.com')) {
            const trackLocation = link.getAttribute('data-track-location') || 
                                  (link.closest('header') ? 'navbar' : 
                                  (link.closest('.mobile-nav-dock') ? 'mobile_dock' : 
                                  (link.closest('dialog') ? 'drawer_or_modal' : 
                                  (link.closest('footer') ? 'footer' : 'content'))));

            trackConversion('whatsapp_click', {
                cta_location: trackLocation,
                target_url: href,
                page_path: window.location.pathname,
                page_title: document.title,
            });
            return;
        }

        // 2. Direct Call click auto-detection (tel:)
        if (href.startsWith('tel:')) {
            const trackLocation = link.getAttribute('data-track-location') || 'content';
            const phoneNumber = href.replace('tel:', '').trim();

            trackConversion('call_click', {
                cta_location: trackLocation,
                phone_number: phoneNumber,
                page_path: window.location.pathname,
                page_title: document.title,
            });
        }
    }, { capture: true, passive: true });
}

