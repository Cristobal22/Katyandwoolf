/**
 * Katy & Woof - Admin Taxonomy & Settings Module v1.6 (Isolated Context Saving)
 */
const AdminTaxonomy = {
    async loadLists() {
        const lists = await AdminAPI.fetch('get_lists');
        const populateSelect = (id, key) => {
            const el = document.getElementById(id); if(!el) return;
            const currentVal = el.value;
            const items = lists.filter(l => l.list_key === key);
            el.innerHTML = '<option value="">Seleccionar...</option>' + 
                items.map(i => `<option value="${i.item_value}">${i.item_value}</option>`).join('');
            if (currentVal && items.some(i => i.item_value === currentVal)) el.value = currentVal;
        };

        populateSelect('art-style', 'art_styles');
        populateSelect('service-category', 'service_categories');
        populateSelect('blog-category', 'blog_categories');

        ['art_styles', 'service_categories', 'blog_categories'].forEach(key => {
            const listEl = document.getElementById(`list-${key}`); if(!listEl) return;
            const items = lists.filter(l => l.list_key === key);
            if (items.length === 0) {
                listEl.innerHTML = '<p class="text-[9px] text-stone-300 italic text-center py-4 border border-dashed border-stone-100 rounded-xl">Sin categorías</p>';
                return;
            }
            listEl.innerHTML = items.map(i => `
                <div class="flex justify-between items-center bg-white p-2.5 rounded-xl border border-stone-100 text-[9px] group hover:border-midnight transition-all">
                    <span class="font-bold uppercase tracking-widest text-stone-500">${i.item_value}</span>
                    <button onclick="AdminTaxonomy.deleteListItem(${i.id})" class="text-stone-300 hover:text-red-500 transition-colors px-2 text-base leading-none">&times;</button>
                </div>
            `).join('');
        });
    },

    async loadSettings() {
        const settings = await AdminAPI.fetch('get_settings');
        settings.forEach(s => {
            const el = document.getElementById(`setting-${s.setting_key}`) || document.getElementById(`id-${s.setting_key}`);
            if (el) el.value = s.setting_value;
            const previewEl = document.getElementById(`preview-${s.setting_key}`);
            if (previewEl) previewEl.src = s.setting_value + '?v=' + Date.now();
        });
    },

    async saveIdentitySettings() {
        AdminUI.toggleLoading(true);
        const fd = new FormData();
        const textKeys = ['contact_email', 'contact_whatsapp', 'contact_address', 'social_instagram', 'footer_philosophy'];
        textKeys.forEach(k => {
            const el = document.getElementById(`id-${k}`);
            if(el) fd.append(k, el.value);
        });
        const fileInputs = {'site_logo': 'site-logo-input', 'site_favicon': 'site-favicon-input'};
        for (const [key, inputId] of Object.entries(fileInputs)) {
            const el = document.getElementById(inputId);
            if(el && el.files[0]) fd.append(key, el.files[0]);
        }
        try {
            await AdminAPI.post('save_settings', fd);
            await this.loadSettings();
            AdminUI.showToast("Datos de identidad guardados");
        } catch (e) { AdminUI.showToast("Error al guardar"); }
        AdminUI.toggleLoading(false);
    },

    async saveVisualSettings() {
        AdminUI.toggleLoading(true);
        const fd = new FormData();
        const textKeys = ['hero_title', 'hero_description', 'nosotros_title'];
        textKeys.forEach(k => {
            const el = document.getElementById(`id-${k}`);
            if(el) fd.append(k, el.value);
        });
        const fileInputs = {'hero_image': 'hero-image-input', 'nosotros_image': 'nosotros-image-input'};
        for (const [key, inputId] of Object.entries(fileInputs)) {
            const el = document.getElementById(inputId);
            if(el && el.files[0]) fd.append(key, el.files[0]);
        }
        try {
            await AdminAPI.post('save_settings', fd);
            await this.loadSettings();
            AdminUI.showToast("Contenido visual actualizado");
        } catch (e) { AdminUI.showToast("Error al guardar"); }
        AdminUI.toggleLoading(false);
    },

    async saveSettings() {
        AdminUI.toggleLoading(true);
        const fd = new FormData();
        fd.append('our_history', document.getElementById('setting-our_history').value);
        try {
            await AdminAPI.post('save_settings', fd);
            AdminUI.showToast("Textos de historia actualizados");
        } catch (e) { AdminUI.showToast("Error al guardar"); }
        AdminUI.toggleLoading(false);
    }
};