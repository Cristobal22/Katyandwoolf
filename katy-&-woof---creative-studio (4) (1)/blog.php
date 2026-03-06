<?php 
require_once 'config.php'; 
$settings = getSiteSettings();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog | Katy & Woof</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="<?php echo $settings['site_favicon']; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Lora:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
  </head>
  <body class="pt-32 antialiased">
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto py-24 px-8 min-h-screen">
        <header class="text-center mb-20 reveal">
            <h1 class="text-5xl md:text-7xl font-bold serif italic mb-6">Crónicas del <span class="text-[var(--pink-deep)]">Atelier</span></h1>
            <p class="text-xl text-stone-500 max-w-xl mx-auto italic">Historias de lealtad, arte y el vínculo que nos une a ellos.</p>
        </header>
        <div id="blog-grid" class="grid grid-cols-1 md:grid-cols-2 gap-12"></div>
    </main>

    <div id="story-modal" class="hidden fixed inset-0 bg-black/80 z-[200] flex items-center justify-center p-4 md:p-8 transition-opacity duration-300">
      <div class="bg-white rounded-[3rem] shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden relative">
          <button id="close-modal" class="absolute top-4 right-4 text-stone-400 text-5xl hover:text-midnight z-50">&times;</button>
          <div class="bg-stone-100 p-4">
              <img id="modal-img" src="" class="w-full max-h-[60vh] object-contain">
          </div>
          <div class="p-8 md:p-10 overflow-y-auto">
              <div id="modal-story" class="prose max-w-none"></div>
          </div>
      </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="whatsapp.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loadBlog = async () => {
                const res = await fetch(`api.php?action=get_blog&v=${Date.now()}`);
                const data = await res.json();
                document.getElementById('blog-grid').innerHTML = data.map(p => `
                    <div class="bg-white rounded-[2rem] p-6 blog-card cursor-pointer group reveal" onclick="openStoryModal(${p.id})">
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-stone-100 mb-6">
                            <img src="${p.img_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-stone-400 mb-2 block">${p.category}</span>
                        <h2 class="text-2xl serif font-bold group-hover:text-[var(--pink-deep)] transition-colors">${p.title}</h2>
                        <p class="text-stone-500 text-sm italic mt-2">Leer historia &rarr;</p>
                    </div>
                `).join('');
                window.blogData = data;
                initReveal();
            };

            window.openStoryModal = (id) => {
                const p = window.blogData.find(item => item.id == id);
                if (!p) return;
                document.getElementById('modal-img').src = p.img_url;
                document.getElementById('modal-story').innerHTML = `<h2 class="text-3xl font-bold serif italic mb-6">${p.title}</h2>${p.content.split('\n').map(par => `<p>${par}</p>`).join('')}`;
                document.getElementById('story-modal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                document.getElementById('story-modal').classList.add('hidden');
                document.body.style.overflow = '';
            };

            document.getElementById('close-modal').onclick = closeModal;
            document.getElementById('story-modal').onclick = (e) => { if(e.target.id === 'story-modal') closeModal(); };

            function initReveal() {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => { if(entry.isIntersecting) entry.target.classList.add('active'); });
                }, { threshold: 0.1 });
                document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            }

            loadBlog();
        });
    </script>
  </body>
</html>