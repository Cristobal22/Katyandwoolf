<?php $settings = getSiteSettings(); ?>
<footer class="bg-[#1A1A1A] text-white py-20 px-8 rounded-t-[3rem] md:rounded-t-[4rem] mt-24">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-16 border-b border-white/5 pb-16 mb-12">
    <div class="space-y-6">
      <h5 class="text-[10px] font-black uppercase tracking-[0.4em] text-stone-400">Filosofía</h5>
      <p class="text-stone-400 text-lg font-light leading-relaxed italic">
        <?php echo $settings['footer_philosophy']; ?>
      </p>
    </div>
    <div class="space-y-6">
      <h5 class="text-[10px] font-black uppercase tracking-[0.4em] text-[#A6757D]">Estudio</h5>
      <ul class="space-y-4 text-xs font-bold uppercase tracking-[0.2em] text-stone-400">
        <li><a href="galeria.php" class="hover:text-white transition-colors">Portafolio</a></li>
        <li><a href="servicios.php" class="hover:text-white transition-colors">Servicios</a></li>
        <li><a href="como-funciona.php" class="hover:text-white transition-colors">El Proceso</a></li>
        <li><a href="blog.php" class="hover:text-white transition-colors">Blog</a></li>
        <li><a href="index.php#nosotros" class="hover:text-white transition-colors">Nosotros</a></li>
        <li><a href="contacto.php" class="hover:text-white transition-colors font-bold text-white">Contacto</a></li>
      </ul>
    </div>
    <div class="space-y-6">
      <h5 class="text-[10px] font-black uppercase tracking-[0.4em] text-[#99CED3]">Atelier Directo</h5>
      <div class="space-y-6">
        <div>
          <p class="text-[9px] text-stone-400 uppercase tracking-widest mb-1">Email de contacto</p>
          <a href="mailto:<?php echo $settings['contact_email']; ?>" class="text-base text-white font-medium hover:text-[#99CED3] transition-colors border-b border-stone-800 pb-1 block">
            <?php echo $settings['contact_email']; ?>
          </a>
        </div>
        <div>
          <p class="text-[9px] text-stone-400 uppercase tracking-widest mb-1">WhatsApp de atención</p>
          <a href="https://wa.me/<?php echo preg_replace('/\s+/', '', $settings['contact_whatsapp']); ?>" class="text-base text-white font-medium hover:text-[#99CED3] transition-colors">
            <?php echo $settings['contact_whatsapp']; ?>
          </a>
        </div>
        <div>
          <p class="text-[9px] text-stone-400 uppercase tracking-widest mb-1">Ubicación</p>
          <p class="text-xs text-stone-500 font-bold uppercase tracking-widest"><?php echo $settings['contact_address']; ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
    <div class="flex flex-col gap-2">
      <p class="text-[9px] font-black uppercase tracking-[0.5em] text-stone-400">
        © <?php echo date("Y"); ?> KATY & WOOF STUDIO. HECHO POR PET LOVERS.
      </p>
    </div>
    <div class="flex items-center gap-8 text-[9px] font-black uppercase tracking-widest text-stone-400">
      <a href="<?php echo $settings['social_instagram']; ?>" target="_blank" class="hover:text-[#A6757D] transition-colors">Instagram</a>
      <a href="#" class="hover:text-white transition-colors">Privacidad</a>
    </div>
  </div>
</footer>