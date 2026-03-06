/**
 * Katy & Woof - Admin API Module v1.0
 */
const AdminAPI = {
    async fetch(action, params = {}) {
        const query = new URLSearchParams({ action, v: Date.now(), ...params }).toString();
        const res = await fetch(`api.php?${query}`);
        if (!res.ok) throw new Error("API Network Error");
        return res.json();
    },

    async post(action, formData) {
        const res = await fetch(`api.php?action=${action}`, {
            method: 'POST',
            body: formData
        });
        if (!res.ok) throw new Error("API Post Error");
        return res.json();
    },

    async delete(action, id) {
        const res = await fetch(`api.php?action=${action}&id=${id}`, {
            method: 'GET' // Usamos GET con acción específica para mayor compatibilidad
        });
        return res.json();
    }
};