<?php 
require_once 'config.php'; 
$settings = getSiteSettings();
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Archivo de Obra | Katy & Woof</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="<?php echo $settings['site_favicon']; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Lora:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>
<body class="antialiased pt-40">
    <?php include 'header.php'; ?>

    <section class="max-w-7xl mx-auto py-24 px-8 min-h-screen">
      <div class="text-center mb-32 reveal">
        <span class="text-[var(--pink-deep)] font-black uppercase tracking-[0.6em] text-[10px] mb-8 block">Le Portfolio Curaté</span>
        <h1 class="text-6xl md:text-8xl font-bold serif italic mb-10 leading-none">Archivo de <br /><span class="text-stone-300">L'Atelier.</span></h1>
        <p class="text-2xl text-stone-500 max-w-2xl mx-auto italic font-light">Donde cada trazo digital captura el alma de un compañero único.</p>
      </div>

      <div id="dynamic-gallery" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
          <!-- JS Hydration with mask reveal -->
      </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="whatsapp.js"></script>
    <script>
      async function loadGallery() {
        try {
          const res = await fetch(`api.php?t=${Date.now()}`);
          const data = await res.json();
          const gallery = document.getElementById('dynamic-gallery');
          gallery.innerHTML = data.map((item, index) => `
            <div class="gallery-item group reveal" style="transition-delay: ${index * 0.1}s">
              <div class="mask-reveal rounded-[3rem] overflow-hidden aspect-[3/4] mb-8 bg-stone-50">
                <img src="${item.img_url}" class="gallery-img w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" alt="${item.name}">
              </div>
              <div class="px-4">
                <span class="text-[9px] font-black uppercase tracking-widest text-[var(--pink-deep)] mb-2 block">${item.style}</span>
                <h3 class="text-3xl font-bold serif italic group-hover:text-midnight transition-colors">${item.name}</h3>
              </div>
            </div>
          `).join('');
          
          initEffects();
        } catch (e) {
          console.error("Gallery failed", e);
        }
      }

      function initEffects() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { 
                if(entry.isIntersecting) {
                    entry.target.classList.add('active');
                    const mask = entry.target.querySelector('.mask-reveal');
                    if(mask) mask.classList.add('active');
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
      }

      document.addEventListener('DOMContentLoaded', () => {
          loadGallery();
          const header = document.querySelector('header');
          window.addEventListener('scroll', () => {
              if (window.scrollY > 50) header.classList.add('scrolled');
              else header.classList.remove('scrolled');
          });
          const btn = document.getElementById('hamburger-toggle');
          if (btn) btn.onclick = () => document.getElementById('mobile-nav').classList.toggle('is-visible');
      });
    </script>
</body>
</html>