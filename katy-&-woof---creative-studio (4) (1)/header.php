<?php $settings = getSiteSettings(); ?>
<header class="fixed top-0 left-0 w-full z-[100] transition-all duration-500 bg-transparent">
  <div class="nav-stripe" style="height: 4px; width: 100%; background: linear-gradient(to right, #1E2B3E 20%, #4D6D9A 20% 40%, #99CED3 40% 60%, #A6757D 60% 80%, #1A1A1A 80%);"></div>
  <div class="max-w-7xl mx-auto px-8 h-24 md:h-32 flex items-center justify-between transition-all duration-500">
    <a href="index" class="flex items-center space-x-4 z-[1001] group">
      <img id="header-logo" src="<?php echo $settings['site_logo']; ?>" alt="Katy & Woof Logo" class="h-12 md:h-16 w-auto transition-all duration-500 group-hover:scale-105">
      <div class="flex flex-col border-l border-stone-200 pl-4">
        <span class="text-xl md:text-2xl font-bold serif italic tracking-tighter" style="font-family: 'Lora', serif; color: #1E2B3E;">Katy & Woof</span>
        <span class="text-[8px] uppercase tracking-[0.5em] font-black text-stone-400">Atelier de Retratos</span>
      </div>
    </a>
    
    <nav class="hidden lg:flex items-center space-x-12 text-[10px] font-black uppercase tracking-[0.3em] text-stone-500">
      <a href="galeria" class="nav-link hover:text-black transition-colors relative group">
        Portafolio
        <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-black transition-all group-hover:w-full"></span>
      </a>
      <a href="servicios" class="nav-link hover:text-black transition-colors relative group">
        Servicios
        <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-black transition-all group-hover:w-full"></span>
      </a>
      <a href="como-funciona" class="nav-link hover:text-black transition-colors relative group">
        Proceso
        <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-black transition-all group-hover:w-full"></span>
      </a>
      <a href="blog" class="nav-link hover:text-black transition-colors relative group">
        Blog
        <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-black transition-all group-hover:w-full"></span>
      </a>
      <a href="contacto" class="px-8 py-3 bg-[#1E2B3E] text-white rounded-full hover:scale-105 transition-all shadow-lg">Contacto</a>
    </nav>

    <div id="hamburger-toggle" class="lg:hidden cursor-pointer group p-2">
      <div class="flex flex-col justify-between w-8 h-5">
        <span class="h-[2px] w-full bg-[#1E2B3E] rounded-full transition-all group-hover:w-1/2"></span>
        <span class="h-[2px] w-full bg-[#1E2B3E] rounded-full transition-all"></span>
        <span class="h-[2px] w-full bg-[#1E2B3E] rounded-full transition-all group-hover:w-3/4"></span>
      </div>
    </div>
  </div>
</header>

<div id="mobile-nav" class="fixed inset-0 bg-[#1E2B3E] flex flex-col items-center justify-center z-[900] opacity-0 pointer-events-none transition-all duration-700 backdrop-blur-xl">
  <nav class="flex flex-col items-center space-y-10">
    <a href="galeria" class="text-white text-4xl font-bold serif italic hover:scale-110 transition-transform">Portafolio</a>
    <a href="servicios" class="text-white text-4xl font-bold serif italic hover:scale-110 transition-transform">Servicios</a>
    <a href="como-funciona" class="text-white text-4xl font-bold serif italic hover:scale-110 transition-transform">El Proceso</a>
    <a href="blog" class="text-white text-4xl font-bold serif italic hover:scale-110 transition-transform">Blog</a>
    <a href="contacto" class="px-16 py-6 bg-white text-[#1E2B3E] rounded-full font-black uppercase text-xs tracking-widest">Contacto</a>
  </nav>
</div>