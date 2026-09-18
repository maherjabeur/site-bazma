document.addEventListener('DOMContentLoaded', () => {
    document.body.classList.add('is-enhanced');
    const menu = document.querySelector('.cms-menu');
    const sidebar = document.querySelector('.cms-sidebar');
    const closeMenu = () => { sidebar?.classList.remove('is-open'); menu?.setAttribute('aria-expanded', 'false'); };
    if (menu && sidebar) {
        menu.hidden = false;
        menu.addEventListener('click', () => {
            const open = menu.getAttribute('aria-expanded') !== 'true';
            menu.setAttribute('aria-expanded', String(open));
            sidebar.classList.toggle('is-open', open);
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && sidebar.classList.contains('is-open')) { closeMenu(); menu.focus(); }
        });
        document.addEventListener('click', event => { if (!sidebar.contains(event.target) && !menu.contains(event.target)) closeMenu(); });
        window.matchMedia('(min-width: 851px)').addEventListener('change', closeMenu);
    }

    const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('fr');
    document.querySelectorAll('[data-cms-list]').forEach(section => {
        const tools = section.querySelector('.cms-list-tools');
        if (!tools) return;
        const items = [...section.querySelectorAll('.admin-item, .admin-gallery-card')];
        if (!items.length) return;
        tools.hidden = false;
        const search = tools.querySelector('[data-cms-search]');
        const status = tools.querySelector('[data-cms-status]');
        const counter = tools.querySelector('.cms-result-count');
        const entries = items.map(item => ({item, text: normalize(item.textContent), status: item.querySelector('.status-pill')?.textContent.trim() || ''}));
        [...new Set(entries.map(entry => entry.status).filter(Boolean))].sort().forEach(value => status.add(new Option(value, value)));
        if (status.options.length < 3) status.closest('label').hidden = true;
        const empty = document.createElement('p');
        empty.className = 'admin-empty';
        empty.textContent = 'Aucun résultat pour cette recherche.';
        empty.hidden = true;
        section.append(empty);
        const pagination = document.createElement('div');
        pagination.className = 'cms-pagination';
        pagination.innerHTML = '<button type="button" title="Page précédente" aria-label="Page précédente"><img src="/assets/icons/chevron-left.svg" alt=""></button><span aria-live="polite"></span><button type="button" title="Page suivante" aria-label="Page suivante"><img src="/assets/icons/chevron-right.svg" alt=""></button>';
        section.append(pagination);
        const [previous, next] = pagination.querySelectorAll('button');
        let page = 1;
        const size = 12;
        const render = () => {
            const query = normalize(search.value.trim());
            const matches = entries.filter(entry => entry.text.includes(query) && (!status.value || entry.status === status.value));
            const pages = Math.max(1, Math.ceil(matches.length / size));
            page = Math.min(page, pages);
            entries.forEach(entry => { entry.item.hidden = true; });
            matches.slice((page - 1) * size, page * size).forEach(entry => { entry.item.hidden = false; });
            counter.textContent = `${matches.length} résultat${matches.length === 1 ? '' : 's'}`;
            empty.hidden = matches.length !== 0;
            pagination.hidden = pages <= 1;
            pagination.querySelector('span').textContent = `${page} / ${pages}`;
            previous.disabled = page === 1;
            next.disabled = page === pages;
        };
        search.addEventListener('input', () => { page = 1; render(); });
        status.addEventListener('change', () => { page = 1; render(); });
        previous.addEventListener('click', () => { page--; render(); tools.scrollIntoView({block: 'start'}); });
        next.addEventListener('click', () => { page++; render(); tools.scrollIntoView({block: 'start'}); });
        render();
    });

    document.querySelectorAll('form.admin-form').forEach(form => {
        const slug = form.querySelector('input[id$="_slug"]');
        const title = form.querySelector('input[id$="_title"]');
        if (slug && title && !slug.value && !slug.disabled) {
            let automatic = true;
            slug.addEventListener('input', () => { automatic = false; });
            title.addEventListener('input', () => {
                if (automatic) slug.value = normalize(title.value).replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            });
        }
        const fields = [...form.querySelectorAll('[data-cms-locale]')].filter(field => field.dataset.cmsLocale);
        let setLanguage = () => {};
        if (fields.length) {
            const tabs = document.createElement('div');
            tabs.className = 'cms-language-tabs';
            tabs.setAttribute('role', 'group');
            tabs.setAttribute('aria-label', 'Langue du contenu');
            const languages = {fr: 'Français', ar: 'العربية', en: 'English'};
            Object.entries(languages).forEach(([code, label]) => {
                const button = document.createElement('button');
                button.type = 'button'; button.textContent = label; button.lang = code;
                button.dataset.language = code;
                button.addEventListener('click', () => setLanguage(code));
                tabs.append(button);
            });
            form.querySelector('.admin-form-grid').before(tabs);
            setLanguage = language => {
                fields.forEach(field => { field.hidden = field.dataset.cmsLocale !== language; });
                tabs.querySelectorAll('button').forEach(button => button.setAttribute('aria-pressed', String(button.dataset.language === language)));
            };
            const invalid = fields.find(field => field.querySelector('ul, [aria-invalid="true"]'));
            setLanguage(invalid?.dataset.cmsLocale || 'fr');
        }
        form.addEventListener('invalid', event => {
            const field = event.target.closest('[data-cms-locale]');
            if (field?.dataset.cmsLocale) setLanguage(field.dataset.cmsLocale);
            if (event.target.classList.contains('wysiwyg-hidden')) {
                event.preventDefault();
                const editor = event.target.parentElement.querySelector('.wysiwyg-editor');
                editor?.setAttribute('aria-invalid', 'true');
                editor?.focus();
                let error = event.target.parentElement.querySelector('.cms-required-error');
                if (!error) {
                    error = document.createElement('p'); error.className = 'cms-required-error alert';
                    error.textContent = 'Ce contenu est obligatoire.'; event.target.parentElement.append(error);
                }
            }
        }, true);
        const state = document.createElement('span');
        state.className = 'cms-save-state'; state.setAttribute('role', 'status');
        form.querySelector('.admin-submit-bar')?.prepend(state);
        let dirty = false;
        const markDirty = () => { dirty = true; state.textContent = 'Modifications non enregistrées'; };
        form.addEventListener('input', markDirty);
        form.addEventListener('change', markDirty);
        form.addEventListener('cms:changed', markDirty);
        form.addEventListener('submit', event => {
            if (event.defaultPrevented) return;
            dirty = false; state.textContent = 'Enregistrement en cours…';
        });
        window.addEventListener('beforeunload', event => {
            if (dirty) { event.preventDefault(); event.returnValue = ''; }
        });
        form.querySelectorAll('input[type="file"][accept*="image"]').forEach(input => {
            let objectUrl;
            input.addEventListener('change', () => {
                if (objectUrl) URL.revokeObjectURL(objectUrl);
                const old = input.parentElement.querySelector('.cms-upload-preview'); old?.remove();
                const file = input.files[0];
                if (!file || !file.type.startsWith('image/')) return;
                const preview = document.createElement('img');
                objectUrl = URL.createObjectURL(file); preview.src = objectUrl;
                preview.alt = file.name; preview.className = 'cms-upload-preview';
                preview.style.cssText = 'max-width:240px;max-height:160px;object-fit:contain;margin-top:12px';
                input.after(preview);
            });
        });
    });
});
