<?php 
require_once 'config.php'; 
$settings = getSiteSettings();
$pdo = getDBConnection();

$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: blog.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $post['title']; ?> | Katy & Woof Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" type="image/x-icon" href="<?php echo $settings['site_favicon']; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Lora:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
  </head>
  <body class="pt-32 antialiased bg-cream">
    <?php include 'header.php'; ?>

    <article class="max-w-4xl mx-auto px-6 py-20 min-h-screen reveal active">
      <header class="mb-16 text-center">
        <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[var(--pink-deep)] mb-6 block"><?php echo $post['category']; ?></span>
        <h1 class="text-4xl md:text-6xl font-bold serif italic leading-tight mb-10 text-midnight"><?php echo $post['title']; ?></h1>
        <div class="rounded-[3rem] overflow-hidden shadow-2xl aspect-[16/9] mb-12 bg-stone-100">
          <img src="<?php echo $post['img_url']; ?>" class="w-full h-full object-cover" alt="<?php echo $post['title']; ?>">
        </div>
      </header>
      
      <div class="article-content max-w-2xl mx-auto text-stone-600 font-light italic text-xl leading-relaxed space-y-8">
          <?php echo nl2br($post['content']); ?>
      </div>

      <div class="mt-24 pt-12 border-t border-stone-200 text-center">
          <a href="blog.php" class="text-[10px] font-black uppercase tracking-widest text-stone-400 hover:text-midnight transition-colors">&larr; Volver a Crónicas</a>
      </div>
    </article>

    <?php include 'footer.php'; ?>
    <script src="whatsapp.js"></script>
  </body>
</html>