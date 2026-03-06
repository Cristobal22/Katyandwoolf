/**
 * Katy & Woof - Admin Content Module v1.2 (Edit Support)
 */
const AdminContent = {
    // Portafolio
    async loadPortfolio() {
        const data = await AdminAPI.fetch(''); 
        window.portfolioData = data;
        const list = document.getElementById('portfolio-list');
        list.innerHTML = data.map(i => `
            <div class="aspect-square bg-stone-100 rounded-lg overflow-hidden relative group">
                <img src="${i.img_url}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-midnight/80 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-center items-center gap-2 p-2">
                    <button onclick="AdminContent.editArt(${i.id})" class="w-full py-2 bg-white text-midnight uppercase text-[8px] font-black rounded-md hover:bg-soft-blue transition-colors">Editar</button>
                    <button onclick="AdminContent.deleteArt(${i.id})" class="w-full py-2 bg-red-500 text-white uppercase text-[8px] font-black rounded-md">Eliminar</button>
                </div>
            </div>
        `).join('');
    },

    editArt(id) {
        const item = window.portfolioData.find(i => i.id == id);
        if(!item) return;
        
        document.getElementById('art-id').value = item.id;
        document.getElementById('art-name').value = item.name;
        document.getElementById('art-style').value = item.style;
        
        document.getElementById('portfolio-title-form').innerText = "Editando Obra";
        document.getElementById('art-submit-btn').innerText = "Actualizar en Archivo";
        document.getElementById('art-cancel-btn').classList.remove('hidden');
        document.getElementById('portfolio-form-container').classList.add('ring-4', 'ring-soft-blue/20', 'bg-white');
        
        AdminUI.switchTab('portfolio');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    async savePortfolio() {
        const fd = new FormData();
        const id = document.getElementById('art-id').value;
        if(id) fd.append('id', id);
        
        fd.append('name', document.getElementById('art-name').value);
        fd.append('style', document.getElementById('art-style').value);
        const file = document.getElementById('art-file').files[0];
        if (file) fd.append('file', file);

        AdminUI.toggleLoading(true);
        await AdminAPI.post('save_portfolio', fd);
        await this.loadPortfolio();
        this.cancelEdit('portfolio');
        AdminUI.toggleLoading(false);
        AdminUI.showToast(id ? "Obra Actualizada" : "Obra Guardada");
    },

    async deleteArt(id) {
        if (!confirm("¿Eliminar obra?")) return;
        await AdminAPI.delete('delete_portfolio', id);
        this.loadPortfolio();
        AdminUI.showToast("Eliminado");
    },

    // Servicios
    async loadServices() {
        const data = await AdminAPI.fetch('get_services');
        window.servicesData = data;
        document.getElementById('services-list').innerHTML = data.map(s => `
            <div class="bg-white p-4 rounded-xl flex justify-between items-center border border-stone-50 group hover:border-soft-blue transition-colors">
                <div class="flex flex-col">
                    <span class="text-xs font-bold serif text-midnight">${s.title}</span>
                    <span class="text-[8px] uppercase tracking-widest text-stone-400">${s.category}</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="AdminContent.editService(${s.id})" class="px-3 py-1 bg-stone-50 text-stone-500 rounded-md text-[8px] font-black uppercase tracking-widest hover:bg-midnight hover:text-white transition-all">Editar</button>
                    <button onclick="AdminContent.deleteService(${s.id})" class="px-3 py-1 text-red-300 hover:text-red-500 text-lg">&times;</button>
                </div>
            </div>
        `).join('');
    },

    editService(id) {
        const item = window.servicesData.find(i => i.id == id);
        if(!item) return;
        
        document.getElementById('service-id').value = item.id;
        document.getElementById('service-title').value = item.title;
        document.getElementById('service-category').value = item.category;
        document.getElementById('service-desc').value = item.description;

        document.getElementById('service-title-form').innerText = "Modificar Servicio";
        document.getElementById('service-submit-btn').innerText = "Actualizar Servicio";
        document.getElementById('service-cancel-btn').classList.remove('hidden');
        document.getElementById('services-form-container').classList.add('ring-4', 'ring-soft-blue/20', 'bg-white');
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    async saveService() {
        const fd = new FormData();
        const id = document.getElementById('service-id').value;
        if(id) fd.append('id', id);
        
        fd.append('title', document.getElementById('service-title').value);
        fd.append('category', document.getElementById('service-category').value);
        fd.append('description', document.getElementById('service-desc').value);
        const file = document.getElementById('service-file').files[0];
        if (file) fd.append('main_file', file);

        AdminUI.toggleLoading(true);
        await AdminAPI.post('save_service', fd);
        await this.loadServices();
        this.cancelEdit('services');
        AdminUI.toggleLoading(false);
        AdminUI.showToast("Sincronizado");
    },

    async deleteService(id) {
        if(!confirm("¿Borrar servicio?")) return;
        await AdminAPI.delete('delete_service', id);
        this.loadServices();
    },

    // Blog
    async loadBlog() {
        const data = await AdminAPI.fetch('get_blog');
        window.blogData = data;
        document.getElementById('blog-list').innerHTML = data.map(p => `
            <div class="bg-white p-4 rounded-xl flex justify-between items-center border border-stone-50">
                <div class="flex flex-col">
                    <span class="text-xs font-bold serif text-midnight">${p.title}</span>
                    <span class="text-[8px] uppercase tracking-widest text-stone-400">${p.category}</span>
                </div>
                <div class="flex gap-2">
                    <button onclick="AdminContent.editBlog(${p.id})" class="px-3 py-1 bg-stone-50 text-stone-500 rounded-md text-[8px] font-black uppercase tracking-widest hover:bg-midnight hover:text-white transition-all">Editar</button>
                    <button onclick="AdminContent.deleteBlog(${p.id})" class="px-3 py-1 text-red-300 hover:text-red-500 text-lg">&times;</button>
                </div>
            </div>
        `).join('');
    },

    editBlog(id) {
        const item = window.blogData.find(i => i.id == id);
        if(!item) return;

        document.getElementById('blog-id').value = item.id;
        document.getElementById('blog-title').value = item.title;
        document.getElementById('blog-category').value = item.category;
        document.getElementById('blog-content').value = item.content;

        document.getElementById('blog-title-form').innerText = "Editar Historia";
        document.getElementById('blog-submit-btn').innerText = "Actualizar Blog";
        document.getElementById('blog-cancel-btn').classList.remove('hidden');
        document.getElementById('blog-form-container').classList.add('ring-4', 'ring-soft-blue/20', 'bg-white');
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    async saveBlog() {
        const fd = new FormData();
        const id = document.getElementById('blog-id').value;
        if(id) fd.append('id', id);

        fd.append('title', document.getElementById('blog-title').value);
        fd.append('category', document.getElementById('blog-category').value);
        fd.append('content', document.getElementById('blog-content').value);
        const file = document.getElementById('blog-file').files[0];
        if (file) fd.append('file', file);

        AdminUI.toggleLoading(true);
        await AdminAPI.post('save_blog', fd);
        await this.loadBlog();
        this.cancelEdit('blog');
        AdminUI.toggleLoading(false);
        AdminUI.showToast("Blog Actualizado");
    },

    async deleteBlog(id) {
        if(!confirm("¿Borrar post?")) return;
        await AdminAPI.delete('delete_blog', id);
        this.loadBlog();
    },

    // Proceso Creativo
    async loadProcessSteps() {
        const data = await AdminAPI.fetch('get_process');
        window.processData = data;
        const list = document.getElementById('process-list');
        list.innerHTML = data.map(s => `
            <div class="bg-white p-4 rounded-xl flex justify-between items-center border border-stone-100">
                <div class="flex items-center gap-4">
                    <span class="text-xl font-black serif">${s.step_number}</span>
                    <p class="text-[10px] font-black uppercase tracking-widest">${s.title}</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="AdminContent.editProcess(${s.id})" class="px-3 py-1 bg-stone-50 text-stone-500 rounded-md text-[8px] font-black uppercase tracking-widest hover:bg-midnight hover:text-white transition-all">Editar</button>
                    <button onclick="AdminContent.deleteProcessStep(${s.id})" class="text-red-400 hover:text-red-600 px-2 text-xl">&times;</button>
                </div>
            </div>
        `).join('');
    },

    editProcess(id) {
        const item = window.processData.find(i => i.id == id);
        if(!item) return;

        document.getElementById('process-id').value = item.id;
        document.getElementById('step-number').value = item.step_number;
        document.getElementById('step-title').value = item.title;
        document.getElementById('step-description').value = item.description;

        document.getElementById('proceso-title-form').innerText = "Editar Paso";
        document.getElementById('process-submit-btn').innerText = "Actualizar Paso";
        document.getElementById('process-cancel-btn').classList.remove('hidden');
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    async saveProcessStep() {
        const fd = new FormData();
        const id = document.getElementById('process-id').value;
        if(id) fd.append('id', id);

        fd.append('step_number', document.getElementById('step-number').value);
        fd.append('title', document.getElementById('step-title').value);
        fd.append('description', document.getElementById('step-description').value);
        const file = document.getElementById('step-file').files[0];
        if (file) fd.append('file', file);

        AdminUI.toggleLoading(true);
        await AdminAPI.post('save_process', fd);
        await this.loadProcessSteps();
        this.cancelEdit('proceso');
        AdminUI.toggleLoading(false);
        AdminUI.showToast("Paso Actualizado");
    },

    async deleteProcessStep(id) {
        if(!confirm("¿Borrar paso?")) return;
        await AdminAPI.delete('delete_process', id);
        this.loadProcessSteps();
        AdminUI.showToast("Paso eliminado");
    },

    // Global Cancel
    cancelEdit(section) {
        if (section === 'portfolio') {
            document.getElementById('portfolio-form').reset();
            document.getElementById('art-id').value = "";
            document.getElementById('portfolio-title-form').innerText = "Archivar Obra";
            document.getElementById('art-submit-btn').innerText = "Subir al Archivo";
            document.getElementById('art-cancel-btn').classList.add('hidden');
            document.getElementById('portfolio-form-container').classList.remove('ring-4', 'ring-soft-blue/20', 'bg-white');
        } else if (section === 'services') {
            document.getElementById('service-form').reset();
            document.getElementById('service-id').value = "";
            document.getElementById('service-title-form').innerText = "Nuevo Servicio";
            document.getElementById('service-submit-btn').innerText = "Publicar Servicio";
            document.getElementById('service-cancel-btn').classList.add('hidden');
            document.getElementById('services-form-container').classList.remove('ring-4', 'ring-soft-blue/20', 'bg-white');
        } else if (section === 'blog') {
            document.getElementById('blog-form').reset();
            document.getElementById('blog-id').value = "";
            document.getElementById('blog-title-form').innerText = "Nueva Historia";
            document.getElementById('blog-submit-btn').innerText = "Publicar en Blog";
            document.getElementById('blog-cancel-btn').classList.add('hidden');
            document.getElementById('blog-form-container').classList.remove('ring-4', 'ring-soft-blue/20', 'bg-white');
        } else if (section === 'proceso') {
            document.getElementById('process-form').reset();
            document.getElementById('process-id').value = "";
            document.getElementById('proceso-title-form').innerText = "Paso del Proceso";
            document.getElementById('process-submit-btn').innerText = "Guardar Paso";
            document.getElementById('process-cancel-btn').classList.add('hidden');
        }
    }
};