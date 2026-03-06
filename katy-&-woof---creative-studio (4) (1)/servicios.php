<?php 
require_once 'config.php'; 
$settings = getSiteSettings();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Servicios | Katy & Woof</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="<?php echo $settings['site_favicon']; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Lora:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
  </head>
  <body class="pt-32 antialiased">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto py-24 px-8 min-h-screen">
        <header class="text-center mb-16 reveal">
            <h1 class="text-5xl md:text-7xl font-bold serif italic mb-6">Servicios de <span class="text-[var(--soft-blue)]">Autor</span></h1>
            <p class="text-xl text-stone-500 max-w-xl mx-auto italic">Experiencias creativas diseñadas para elevar el vínculo con tu mascota.</p>
        </header>
        
        <div id="filters-container" class="flex flex-wrap justify-center gap-4 mb-20 reveal"></div>
        <div id="services-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12"></div>
    </main>

    <div id="service-modal" class="fixed inset-0 bg-black/60 z-[200] flex items-center justify-center p-4 md:p-8 overflow-y-auto opacity-0 pointer-events-none transition-opacity duration-500">
      <div id="modal-inner" class="bg-white rounded-[3rem] shadow-2xl w-full max-w-5xl flex flex-col lg:flex-row overflow-hidden relative my-auto transform scale-95 opacity-0 transition-all duration-300">
          <button id="close-modal" class="absolute top-6 right-6 text-stone-400 hover:text-midnight text-4xl font-light z-50 p-2 leading-none">&times;</button>
          <div class="lg:w-1/2 bg-stone-100 h-[300px] lg:h-auto overflow-hidden">
              <img id="modal-main-img" src="" class="w-full h-full object-cover">
          </div>
          <div class="lg:w-1/2 p-10 lg:p-16 flex flex-col justify-center bg-white">
              <span class="text-[var(--pink-deep)] font-black uppercase tracking-[0.4em] text-[10px] mb-6 block">Katy & Woof Atelier</span>
              <h2 id="modal-title" class="text-4xl lg:text-5xl serif font-bold mb-8 leading-tight"></h2>
              <div id="modal-description" class="prose max-w-none text-lg italic font-light text-stone-600 mb-12"></div>
              <div class="pt-8 border-t border-stone-50">
                  <a id="modal-whatsapp" href="#" target="_blank" class="w-full inline-flex items-center justify-center gap-4 py-6 bg-[#25d366] text-white rounded-full font-black uppercase tracking-[0.3em] text-[10px] shadow-xl hover:bg-[#20ba5a] transition-all">
                    Consultar este Servicio
                  </a>
              </div>
          </div>
      </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="whatsapp.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let allServicesData = [];
            const modal = document.getElementById('service-modal');
            const modalInner = document.getElementById('modal-inner');

            const loadData = async () => {
                const res = await fetch(`api.php?action=get_services&v=${Date.now()}`);
                allServicesData = await res.json();
                renderFilters();
                renderServices(allServicesData);
            };

            const renderFilters = () => {
                const categories = ['Todos', ...new Set(allServicesData.map(s => s.category).filter(Boolean))];
                const filtersContainer = document.getElementById('filters-container');
                filtersContainer.innerHTML = categories.map(cat => 
                    `<button class="filter-btn px-6 py-3 rounded-full text-xs font-black uppercase tracking-widest transition-colors ${cat === 'Todos' ? 'active' : ''}" data-category="${cat}">${cat}</button>`
                ).join('');

                filtersContainer.onclick = (e) => {
                    if (e.target.classList.contains('filter-btn')) {
                        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                        e.target.classList.add('active');
                        const category = e.target.dataset.category;
                        renderServices(category === 'Todos' ? allServicesData : allServicesData.filter(s => s.category === category));
                    }
                };
            };

            const renderServices = (services) => {
                document.getElementById('services-grid').innerHTML = services.map(s => `
                    <button class="gallery-item reveal group text-left" onclick="openServiceModal(${s.id})">
                        <div class="aspect-[4/5] rounded-[2rem] overflow-hidden bg-stone-100 mb-8">
                            <img src="${s.main_image_url}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-[0.3em] text-stone-400 mb-2 block">${s.category || 'Atelier'}</span>
                        <h2 class="text-2xl serif font-bold group-hover:text-midnight transition-colors mb-3">${s.title}</h2>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-[var(--pink-deep)]">Ver Detalle &rarr;</p>
                    </button>
                `).join('');
                initReveal();
            };

            window.openServiceModal = (id) => {
                const s = allServicesData.find(item => item.id == id);
                if (!s) return;
                document.getElementById('modal-title').textContent = s.title;
                document.getElementById('modal-description').innerHTML = s.description.split('\n').map(p => `<p>${p}</p>`).join('');
                document.getElementById('modal-main-img').src = s.main_image_url;
                const waNum = "<?php echo preg_replace('/\s+/', '', $settings['contact_whatsapp']); ?>";
                document.getElementById('modal-whatsapp').href = `https://wa.me/${waNum}?text=Me interesa: ${s.title}`;
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modalInner.classList.remove('scale-95', 'opacity-0');
            };

            const closeModal = () => {
                modalInner.classList.add('scale-95', 'opacity-0');
                modal.classList.add('opacity-0');
                setTimeout(() => modal.classList.add('pointer-events-none'), 500);
            };

            document.getElementById('close-modal').onclick = closeModal;
            modal.onclick = (e) => { if (e.target === modal) closeModal(); };

            function initReveal() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => { if(entry.isIntersecting) entry.target.classList.add('active'); });
                }, { threshold: 0.1 });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            }

            loadData();
        });
    </script>
  </body>
</html>