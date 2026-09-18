document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.village-navigation');
    if (toggle && navigation) {
        toggle.hidden = false;
        const close = () => {
            toggle.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('is-open');
        };
        toggle.addEventListener('click', () => {
            const open = toggle.getAttribute('aria-expanded') !== 'true';
            toggle.setAttribute('aria-expanded', String(open));
            navigation.classList.toggle('is-open', open);
        });
        navigation.addEventListener('click', event => { if (event.target.closest('a')) close(); });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') { close(); toggle.focus(); }
        });
        document.addEventListener('click', event => { if (!event.target.closest('.village-header')) close(); });
        window.matchMedia('(min-width: 961px)').addEventListener('change', close);
    }
    const lightbox = document.querySelector('[data-gallery-lightbox]');
    if (lightbox) {
        // Keep keyboard focus inside the open image viewer.
        lightbox.addEventListener('keydown', event => {
            if (event.key !== 'Tab') return;
            const controls = [...lightbox.querySelectorAll('button')];
            const first = controls[0], last = controls[controls.length - 1];
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
        });
    }
});
