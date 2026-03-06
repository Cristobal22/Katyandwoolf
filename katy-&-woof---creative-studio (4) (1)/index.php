<?php 
require_once 'config.php'; 
$settings = getSiteSettings();
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Katy & Woof | Atelier de Retratos Artísticos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="<?php echo $settings['site_favicon']; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Lora:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">
  </head>
  <body class="antialiased overflow-x-hidden">
    <?php include 'header.php'; ?>

    <!-- Blobs Decorativos -->
    <div class="blob w-[500px] h-[500px] bg-[#99CED3] top-[-100px] left-[-100px]"></div>
    <div class="blob w-[400px] h-[400px] bg-[#A6757D] bottom-[20%] right-[-100px]"></div>

    <!-- HERO SECTION: PARALLAX & MASK REVEAL -->
    <section id="hero-section" class="relative min-h-screen flex flex-col items-center justify-center px-8 overflow-hidden">
      <div class="absolute inset-0 z-[-1] opacity-20 scale-110" id="hero-parallax" style="background-image: url('<?php echo $settings['hero_image']; ?>'); background-size: cover; background-position: center;"></div>
      
      <div class="max-w-5xl text-center relative z-10">
        <div class="reveal overflow-hidden mb-6">
            <span class="inline-block text-[var(--pink-deep)] font-black uppercase tracking-[0.6em] text-[10px]">L’Atelier des Compagnons</span>
        </div>
        
        <h1 class="hero-title font-bold serif mb-10 leading-[0.9] reveal" style="transition-delay: 0.2s;">
            <?php 
                $words = explode(' ', $settings['hero_title']);
                foreach($words as $index => $word) {
                    echo ($index == 2) ? "<span class='text-stone-300 italic'>$word</span> " : "$word ";
                }
            ?>
        </h1>

        <p class="text-xl md:text-2xl text-stone-600 font-light max-w-2xl mx-auto mb-16 leading-relaxed italic reveal" style="transition-delay: 0.4s;">
            <?php echo $settings['hero_description']; ?>
        </p>

        <div class="flex flex-col sm:flex-row gap-8 justify-center reveal" style="transition-delay: 0.6s;">
            <a href="contacto" class="btn-magnetic px-14 py-6 bg-[var(--midnight)] text-white rounded-full font-black uppercase tracking-[0.25em] text-[10px] shadow-2xl">
                Encargar Pieza
            </a>
            <a href="galeria" class="btn-magnetic px-14 py-6 border border-stone-200 bg-white/50 backdrop-blur-md rounded-full font-black uppercase tracking-[0.25em] text-[10px] text-stone-800">
                El Archivo
            </a>
        </div>
      </div>

      <!-- Marquee transition -->
      <div class="absolute bottom-0 left-0 w-full marquee-container">
          <div class="marquee-content">
              Fine Art &bull; Pet Studio &bull; Hand Painted &bull; Digital Atelier &bull; Legacy &bull; Fine Art &bull; Pet Studio &bull; Hand Painted &bull; Digital Atelier &bull; Legacy &bull;
          </div>
      </div>
    </section>

    <!-- NOSOTROS: MASK REVEAL IMAGE -->
    <section id="nosotros" class="py-40 bg-white relative">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-32 items-center px-8">
            <div class="reveal">
                <span class="text-[var(--pink-deep)] font-black uppercase tracking-[0.5em] text-[9px] mb-8 block">La Filosofía</span>
                <h2 class="text-6xl font-bold serif italic leading-[1.1] mb-10"><?php echo $settings['nosotros_title']; ?></h2>
                <div class="space-y-8 text-stone-500 font-light leading-relaxed italic text-xl">
                    <?php echo nl2br($settings['our_history']); ?>
                </div>
                <div class="mt-16">
                    <a href="como-funciona" class="group text-xs font-black uppercase tracking-widest flex items-center gap-4">
                        Descubre nuestro proceso 
                        <span class="w-12 h-[1px] bg-stone-200 group-hover:w-20 transition-all duration-500"></span>
                    </a>
                </div>
            </div>
            <div class="relative reveal">
                <div class="mask-reveal rounded-[4rem] overflow-hidden shadow-2xl h-[700px] float-element">
                    <img src="<?php echo $settings['nosotros_image']; ?>" class="w-full h-full object-cover" alt="Katy & Woof Studio">
                </div>
                <!-- Decoración -->
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-[var(--soft-blue)] rounded-full opacity-20 blur-3xl"></div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="whatsapp.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Header Scroll Effect
            const header = document.querySelector('header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Parallax Hero
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const parallax = document.getElementById('hero-parallax');
                if(parallax) {
                    parallax.style.transform = `translateY(${scrolled * 0.4}px) scale(1.1)`;
                }
            });

            // Intersection Observer para Animaciones
            const observerOptions = { threshold: 0.15, rootMargin: "0px 0px -50px 0px" };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal, .mask-reveal').forEach(el => observer.observe(el));
            
            // Hamburger
            const btn = document.getElementById('hamburger-toggle');
            const nav = document.getElementById('mobile-nav');
            if (btn && nav) {
                btn.onclick = () => {
                    const active = nav.classList.toggle('is-visible');
                    document.body.style.overflow = active ? 'hidden' : '';
                };
            }
        });
    </script>
  </body>
</html>