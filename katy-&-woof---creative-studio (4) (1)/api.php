<?php
/**
 * Katy & Woof - MySQL API Manager v5.8 (Core Edition)
 */
require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$upload_dir = 'uploads/';
$pdo = getDBConnection();
$action = $_GET['action'] ?? null;

if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

// Inicialización de Base de Datos
if ($action === 'setup') {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `portfolio` (`id` INT(11) NOT NULL AUTO_INCREMENT, `name` VARCHAR(255) NOT NULL, `style` VARCHAR(150) DEFAULT NULL, `img_url` VARCHAR(500) NOT NULL, `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $pdo->exec("CREATE TABLE IF NOT EXISTS `services` (`id` INT(11) NOT NULL AUTO_INCREMENT, `title` VARCHAR(255) NOT NULL, `description` TEXT, `category` VARCHAR(100) DEFAULT 'General', `main_image_url` VARCHAR(500) NOT NULL, `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $pdo->exec("CREATE TABLE IF NOT EXISTS `blog_posts` (`id` INT(11) NOT NULL AUTO_INCREMENT, `title` VARCHAR(255) NOT NULL, `content` TEXT, `category` VARCHAR(100) DEFAULT 'General', `img_url` VARCHAR(500) NOT NULL, `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $pdo->exec("CREATE TABLE IF NOT EXISTS `process_steps` (`id` INT(11) NOT NULL AUTO_INCREMENT, `step_number` INT(11), `title` VARCHAR(255), `description` TEXT, `img_url` VARCHAR(500), PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $pdo->exec("CREATE TABLE IF NOT EXISTS `site_settings` (`id` INT(11) NOT NULL AUTO_INCREMENT, `setting_key` VARCHAR(100) UNIQUE NOT NULL, `setting_value` TEXT, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        $pdo->exec("CREATE TABLE IF NOT EXISTS `site_lists` (`id` INT(11) NOT NULL AUTO_INCREMENT, `list_key` VARCHAR(50) NOT NULL, `item_value` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $defaults = [
            'our_history' => 'Nuestra pasión por el arte comenzó...', 
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
        foreach ($defaults as $k => $v) { $stmt->execute([$k, $v]); }
        echo json_encode(["success" => true, "msg" => "v5.8 Ready"]);
        exit;
    } catch (PDOException $e) { http_response_code(500); exit(json_encode(["error" => $e->getMessage()])); }
}

// Router de Acciones
switch ($action) {
    case 'get_settings': 
        echo json_encode($pdo->query("SELECT * FROM site_settings")->fetchAll()); 
        break;
        
    case 'save_settings':
        foreach ($_POST as $k => $v) { 
            $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?")->execute([$v, $k]); 
        }
        $file_fields = ['site_logo', 'site_favicon', 'hero_image', 'nosotros_image'];
        foreach ($file_fields as $f) {
            if (isset($_FILES[$f]) && $_FILES[$f]['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES[$f]['name'], PATHINFO_EXTENSION);
                $path = $upload_dir . "brand_{$f}_" . time() . "." . $ext;
                if (move_uploaded_file($_FILES[$f]['tmp_name'], $path)) { 
                    $pdo->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?")->execute([$path, $f]); 
                }
            }
        }
        echo json_encode(["success" => true]);
        break;

    case 'get_services': 
        echo json_encode($pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll()); 
        break;
        
    case 'save_service': 
        if (!empty($_POST['id'])) {
            $stmt = $pdo->prepare("UPDATE services SET title = ?, category = ?, description = ? WHERE id = ?");
            $stmt->execute([$_POST['title'], $_POST['category'], $_POST['description'], $_POST['id']]);
            if (isset($_FILES['main_file'])) {
                $img = $upload_dir."svc_".time()."_".$_FILES['main_file']['name']; 
                move_uploaded_file($_FILES['main_file']['tmp_name'],$img);
                $pdo->prepare("UPDATE services SET main_image_url = ? WHERE id = ?")->execute([$img, $_POST['id']]);
            }
        } else {
            $img = 'img/placeholder.jpg'; 
            if(isset($_FILES['main_file'])){$img=$upload_dir."svc_".time()."_".$_FILES['main_file']['name'];move_uploaded_file($_FILES['main_file']['tmp_name'],$img);} 
            $pdo->prepare("INSERT INTO services (title, category, description, main_image_url) VALUES (?, ?, ?, ?)")->execute([$_POST['title'], $_POST['category'], $_POST['description'], $img]); 
        }
        echo json_encode(["success" => true]); 
        break;

    case 'get_blog': 
        echo json_encode($pdo->query("SELECT * FROM blog_posts ORDER BY id DESC")->fetchAll()); 
        break;

    case 'get_process': 
        echo json_encode($pdo->query("SELECT * FROM process_steps ORDER BY step_number ASC")->fetchAll()); 
        break;

    case 'get_lists': 
        echo json_encode($pdo->query("SELECT * FROM site_lists ORDER BY item_value ASC")->fetchAll()); 
        break;

    case 'delete_service': $pdo->prepare("DELETE FROM services WHERE id = ?")->execute([$_GET['id']]); echo json_encode(["success" => true]); break;
    case 'delete_blog': $pdo->prepare("DELETE FROM blog_posts WHERE id = ?")->execute([$_GET['id']]); echo json_encode(["success" => true]); break;
    case 'delete_portfolio': $pdo->prepare("DELETE FROM portfolio WHERE id = ?")->execute([$_GET['id']]); echo json_encode(["success" => true]); break;
    case 'delete_list_item': $pdo->prepare("DELETE FROM site_lists WHERE id = ?")->execute([$_GET['id']]); echo json_encode(["success" => true]); break;

    default:
        echo json_encode($pdo->query("SELECT * FROM portfolio ORDER BY id DESC")->fetchAll());
        break;
}
?>