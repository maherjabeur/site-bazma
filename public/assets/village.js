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

    const slider = document.querySelector('[data-hero-slider]');
    if (slider) {
        const slides = [...slider.querySelectorAll('[data-hero-slide]')];
        const number = slider.querySelector('[data-slide-number]');
        const togglePlay = slider.querySelector('[data-slide-toggle]');
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let current = 0;
        let playing = !reducedMotion && slides.length > 1;
        let timer;

        const show = index => {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                slide.classList.toggle('is-active', slideIndex === current);
                slide.setAttribute('aria-hidden', String(slideIndex !== current));
            });
            if (number) number.textContent = String(current + 1).padStart(2, '0');
        };
        const schedule = () => {
            window.clearInterval(timer);
            if (playing) timer = window.setInterval(() => show(current + 1), 5500);
        };
        const step = direction => { show(current + direction); schedule(); };
        slider.querySelector('[data-slide-prev]')?.addEventListener('click', () => step(-1));
        slider.querySelector('[data-slide-next]')?.addEventListener('click', () => step(1));
        togglePlay?.addEventListener('click', () => {
            playing = !playing;
            togglePlay.textContent = playing ? 'Ⅱ' : '▶';
            togglePlay.setAttribute('aria-label', playing ? togglePlay.dataset.pauseLabel : togglePlay.dataset.playLabel);
            schedule();
        });
        slider.addEventListener('mouseenter', () => window.clearInterval(timer));
        slider.addEventListener('mouseleave', schedule);
        show(0);
        schedule();
    }

    const filterButtons = [...document.querySelectorAll('[data-story-filter]')];
    const stories = [...document.querySelectorAll('[data-story-category]')];
    filterButtons.forEach(button => button.addEventListener('click', () => {
        const filter = button.dataset.storyFilter;
        filterButtons.forEach(item => {
            const selected = item === button;
            item.classList.toggle('is-active', selected);
            item.setAttribute('aria-pressed', String(selected));
        });
        stories.forEach(story => {
            const visible = filter === 'all' || story.dataset.storyCategory === filter;
            story.hidden = !visible;
        });
    }));

    const animatedItems = document.querySelectorAll('.village-section > *, .oasis-introduction > *, .village-pulse > div');
    if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.classList.add('has-reveal');
        const revealObserver = new IntersectionObserver(entries => entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-revealed');
            revealObserver.unobserve(entry.target);
        }), {threshold: .08, rootMargin: '0px 0px -35px'});
        animatedItems.forEach(item => revealObserver.observe(item));
    }

    const counters = document.querySelectorAll('[data-count-to]');
    if ('IntersectionObserver' in window && counters.length && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const countObserver = new IntersectionObserver(entries => entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const element = entry.target;
            const target = Number(element.dataset.countTo) || 0;
            const start = performance.now();
            const animate = now => {
                const progress = Math.min((now - start) / 850, 1);
                element.textContent = String(Math.round(target * (1 - Math.pow(1 - progress, 3))));
                if (progress < 1) requestAnimationFrame(animate);
            };
            requestAnimationFrame(animate);
            countObserver.unobserve(element);
        }), {threshold: .6});
        counters.forEach(counter => countObserver.observe(counter));
    }

    const progress = document.querySelector('[data-scroll-progress]');
    if (progress) {
        const updateProgress = () => {
            const available = document.documentElement.scrollHeight - window.innerHeight;
            progress.style.transform = `scaleX(${available > 0 ? window.scrollY / available : 0})`;
        };
        updateProgress();
        window.addEventListener('scroll', updateProgress, {passive: true});
        window.addEventListener('resize', updateProgress);
    }
});
