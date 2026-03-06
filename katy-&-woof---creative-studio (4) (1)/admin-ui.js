/**
 * Katy & Woof - Admin UI Module v1.0
 */
const AdminUI = {
    AUTH_KEY: 'fotopet2026',

    attemptAuth() {
        const input = document.getElementById('auth-input');
        if (input.value === this.AUTH_KEY) {
            localStorage.setItem('kw_admin', 'ok');
            this.unlock();
        } else {
            alert("Acceso Denegado: Clave incorrecta");
        }
    },

    unlock() {
        document.getElementById('login-portal').classList.add('hidden');
        document.getElementById('admin-content').classList.remove('hidden');
        setTimeout(() => document.getElementById('admin-content').style.opacity = '1', 100);
        this.loadAll();
    },

    switchTab(id) {
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.getElementById(`tab-${id}`).classList.remove('hidden');
        document.querySelector(`[data-tab="${id}"]`).classList.add('active');
    },

    toggleLoading(show) {
        document.getElementById('loading-screen').style.display = show ? 'flex' : 'none';
    },

    showToast(msg) {
        const t = document.getElementById('toast');
        t.innerText = msg;
        t.classList.add('active');
        setTimeout(() => t.classList.remove('active'), 3000);
    },

    async loadAll() {
        this.toggleLoading(true);
        try {
            await AdminTaxonomy.loadLists();
            await AdminTaxonomy.loadSettings();
            await Promise.all([
                AdminContent.loadPortfolio(),
                AdminContent.loadServices(),
                AdminContent.loadBlog(),
                AdminContent.loadProcessSteps()
            ]);
        } catch (e) {
            console.error("Load Error:", e);
            this.showToast("Error al sincronizar datos");
        }
        this.toggleLoading(false);
    }
};