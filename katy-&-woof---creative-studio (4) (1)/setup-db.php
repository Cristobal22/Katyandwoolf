<?php
/**
 * Katy & Woof - Inicializador de Base de Datos
 * Ejecuta este archivo UNA VEZ para crear todas las tablas necesarias
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost'); 
define('DB_NAME', 'dbyh6du0yfle1i');
define('DB_USER', 'uiuxyllculkca');
define('DB_PASS', 'fotopet2026');

echo "<h1>🎨 Katy & Woof - Configurador de Base de Datos</h1>";
echo "<pre>";

// Paso 1: Probar conexión
echo "📡 PASO 1: Probando conexión a MySQL...\n";
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    echo "✅ CONEXIÓN EXITOSA a la base de datos: " . DB_NAME . "\n\n";
} catch (PDOException $e) {
    echo "❌ ERROR DE CONEXIÓN: " . $e->getMessage() . "\n";
    echo "Verifica:\n";
    echo "  - Que MySQL esté ejecutándose\n";
    echo "  - Que la base de datos 'dbyh6du0yfle1i' exista\n";
    echo "  - Que el usuario 'uiuxyllculkca' tenga permisos\n";
    exit;
}

// Paso 2: Crear tablas
echo "🏗️  PASO 2: Creando estructura de tablas...\n";

$tables = [
    'portfolio' => "CREATE TABLE IF NOT EXISTS `portfolio` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `style` VARCHAR(150) DEFAULT NULL,
        `img_url` VARCHAR(500) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'services' => "CREATE TABLE IF NOT EXISTS `services` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT,
        `category` VARCHAR(100) DEFAULT 'General',
        `main_image_url` VARCHAR(500) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'blog_posts' => "CREATE TABLE IF NOT EXISTS `blog_posts` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) NOT NULL,
        `content` TEXT,
        `category` VARCHAR(100) DEFAULT 'General',
        `img_url` VARCHAR(500) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'process_steps' => "CREATE TABLE IF NOT EXISTS `process_steps` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `step_number` INT(11),
        `title` VARCHAR(255),
        `description` TEXT,
        `img_url` VARCHAR(500),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'site_settings' => "CREATE TABLE IF NOT EXISTS `site_settings` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `setting_key` VARCHAR(100) UNIQUE NOT NULL,
        `setting_value` TEXT,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    'site_lists' => "CREATE TABLE IF NOT EXISTS `site_lists` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `list_key` VARCHAR(50) NOT NULL,
        `item_value` VARCHAR(255) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];

foreach ($tables as $name => $sql) {
    try {
        $pdo->exec($sql);
        echo "  ✅ Tabla '$name' creada/verificada\n";
    } catch (PDOException $e) {
        echo "  ❌ Error creando '$name': " . $e->getMessage() . "\n";
    }
}

// Paso 3: Insertar configuración inicial
echo "\n⚙️  PASO 3: Configurando valores por defecto...\n";

$defaults = [
    'our_history' => 'Nuestra pasión por el arte comenzó con el amor por nuestras mascotas. Cada retrato es una obra única que captura la personalidad de tu compañero fiel.',
    'contact_email' => 'hello@katyandwoof.art',
    'contact_whatsapp' => '+34 000 000 000',
    'contact_address' => 'Atelier Barcelona, España',
    'site_logo' => 'img/logo.png',
    'site_favicon' => 'favicon.ico',
    'hero_title' => 'Eterniza su alma en un lienzo.',
    'hero_description' => 'Retratos de autor pintados a mano digitalmente que capturan la esencia única de tu compañero más fiel.',
    'hero_image' => 'img/hero-placeholder.jpg',
    'nosotros_image' => 'img/nosotros.jpg',
    'nosotros_title' => 'Donde el arte encuentra la lealtad.',
    'footer_philosophy' => 'Especializados en capturar la esencia de tu compañero más fiel a través del arte digital de autor. Un tributo eterno a la lealtad.',
    'social_instagram' => 'https://instagram.com/katyandwoof'
];

$stmt = $pdo->prepare("INSERT IGNORE INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
$count = 0;
foreach ($defaults as $key => $value) {
    $stmt->execute([$key, $value]);
    if ($stmt->rowCount() > 0) {
        $count++;
        echo "  ✅ Configuración '$key' guardada\n";
    }
}

if ($count === 0) {
    echo "  ℹ️  Configuraciones ya existían (no se duplicaron)\n";
}

// Paso 4: Crear categorías iniciales
echo "\n📋 PASO 4: Creando categorías iniciales...\n";

$initial_categories = [
    ['list_key' => 'art_styles', 'item_value' => 'Realista'],
    ['list_key' => 'art_styles', 'item_value' => 'Acuarela'],
    ['list_key' => 'art_styles', 'item_value' => 'Pop Art'],
    ['list_key' => 'service_categories', 'item_value' => 'Retrato Individual'],
    ['list_key' => 'service_categories', 'item_value' => 'Retrato Doble'],
    ['list_key' => 'blog_categories', 'item_value' => 'Consejos'],
    ['list_key' => 'blog_categories', 'item_value' => 'Historias'],
];

$stmt_cat = $pdo->prepare("INSERT IGNORE INTO site_lists (list_key, item_value) VALUES (?, ?)");
foreach ($initial_categories as $cat) {
    $stmt_cat->execute([$cat['list_key'], $cat['item_value']]);
}
echo "  ✅ Categorías iniciales creadas\n";

// Paso 5: Crear directorio de uploads
echo "\n📁 PASO 5: Verificando directorio de uploads...\n";
$upload_dir = 'uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
    echo "  ✅ Directorio 'uploads/' creado\n";
} else {
    echo "  ℹ️  Directorio 'uploads/' ya existe\n";
}

// Resumen final
echo "\n" . str_repeat("=", 60) . "\n";
echo "✨ ¡CONFIGURACIÓN COMPLETADA CON ÉXITO!\n";
echo str_repeat("=", 60) . "\n\n";

echo "📊 RESUMEN:\n";
$table_count = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'")->fetchColumn();
echo "  • Tablas en la base de datos: $table_count\n";

$settings_count = $pdo->query("SELECT COUNT(*) FROM site_settings")->fetchColumn();
echo "  • Configuraciones guardadas: $settings_count\n";

$lists_count = $pdo->query("SELECT COUNT(*) FROM site_lists")->fetchColumn();
echo "  • Categorías creadas: $lists_count\n";

echo "\n🎯 PRÓXIMOS PASOS:\n";
echo "  1. Accede al panel admin: admin.html\n";
echo "  2. Ingresa con la clave: fotopet2026\n";
echo "  3. ¡Empieza a gestionar tu contenido!\n\n";

echo "⚠️  IMPORTANTE: Elimina este archivo (setup-db.php) después de ejecutarlo\n";
echo "    por razones de seguridad.\n";

echo "</pre>";
?>
