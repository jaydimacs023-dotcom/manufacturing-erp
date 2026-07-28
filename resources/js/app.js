

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const pageLoader = document.querySelector('[data-page-loader]');

if (pageLoader) {
    let safetyTimer;

    const setLoading = (loading) => {
        window.clearTimeout(safetyTimer);
        pageLoader.setAttribute('aria-hidden', loading ? 'false' : 'true');
        document.body.setAttribute('aria-busy', loading ? 'true' : 'false');

        if (loading) {
            safetyTimer = window.setTimeout(() => setLoading(false), 10000);
        }
    };

    const hideLoader = () => setLoading(false);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', hideLoader, { once: true });
    } else {
        hideLoader();
    }

    window.addEventListener('load', hideLoader, { once: true });
    window.addEventListener('pageshow', hideLoader);

    document.addEventListener('click', (event) => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
            return;
        }

        const link = event.target.closest('a[href]');
        if (!link || link.target === '_blank' || link.hasAttribute('download')) {
            return;
        }

        const rawHref = link.getAttribute('href');
        if (!rawHref || rawHref.startsWith('#') || rawHref.startsWith('javascript:')) {
            return;
        }

        const destination = new URL(link.href, window.location.href);
        const current = new URL(window.location.href);
        const isHashOnly = destination.origin === current.origin
            && destination.pathname === current.pathname
            && destination.search === current.search
            && destination.hash !== current.hash;

        if (destination.origin === current.origin && !isHashOnly) {
            setLoading(true);
        }
    });

    document.addEventListener('submit', (event) => {
        if (event.defaultPrevented) {
            return;
        }

        const form = event.target;
        const destination = new URL(form.action || window.location.href, window.location.href);

        if (destination.origin === window.location.origin && (!form.target || form.target === '_self')) {
            setLoading(true);
        }
    });
}
