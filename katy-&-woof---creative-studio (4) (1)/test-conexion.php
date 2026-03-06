<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Conexión - Katy & Woof</title>
    <style>
        body { font-family: system-ui; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #1e2b3e; margin-bottom: 30px; }
        .status { padding: 15px; border-radius: 8px; margin: 15px 0; }
        .success { background: #d4edda; border-left: 4px solid #28a745; color: #155724; }
        .error { background: #f8d7da; border-left: 4px solid #dc3545; color: #721c24; }
        .info { background: #d1ecf1; border-left: 4px solid #17a2b8; color: #0c5460; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .btn { display: inline-block; padding: 12px 24px; background: #1e2b3e; color: white; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn:hover { background: #2d3e5a; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🔌 Test de Conexión MySQL</h1>
        
        <?php
        // Configuración
        define('DB_HOST', 'localhost'); 
        define('DB_NAME', 'dbyh6du0yfle1i');
        define('DB_USER', 'uiuxyllculkca');
        define('DB_PASS', 'fotopet2026');

        echo '<div class="info"><strong>📋 Configuración:</strong><br>';
        echo 'Host: ' . DB_HOST . '<br>';
        echo 'Base de datos: ' . DB_NAME . '<br>';
        echo 'Usuario: ' . DB_USER . '<br>';
        echo 'Contraseña: ' . str_repeat('*', strlen(DB_PASS)) . '</div>';

        // Probar conexión
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
            echo '<div class="success">';
            echo '<strong>✅ CONEXIÓN EXITOSA</strong><br><br>';
            echo 'La conexión a MySQL se estableció correctamente.<br>';
            
            // Verificar tablas
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $table_count = count($tables);
            
            echo '<br><strong>Tablas encontradas: ' . $table_count . '</strong>';
            
            if ($table_count > 0) {
                echo '<pre>';
                foreach ($tables as $table) {
                    $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
                    echo "  • $table ($count registros)\n";
                }
                echo '</pre>';
                
                echo '<div class="info" style="margin-top: 20px;">';
                echo '<strong>✨ La base de datos está configurada y lista.</strong><br>';
                echo 'Puedes acceder al panel de administración.';
                echo '</div>';
                
            } else {
                echo '<div class="info" style="margin-top: 20px;">';
                echo '<strong>⚠️ La base de datos está vacía.</strong><br>';
                echo 'Necesitas ejecutar el configurador para crear las tablas.';
                echo '</div>';
            }
            
            echo '<br><a href="setup-db.php" class="btn">🏗️ Configurar Base de Datos</a>';
            echo '<a href="admin.html" class="btn" style="background: #28a745;">🎨 Ir al Panel Admin</a>';
            
            echo '</div>';
            
        } catch (PDOException $e) {
            echo '<div class="error">';
            echo '<strong>❌ ERROR DE CONEXIÓN</strong><br><br>';
            echo '<strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage()) . '<br><br>';
            
            echo '<strong>Posibles causas:</strong><br>';
            echo '<ul>';
            echo '<li>El servidor MySQL no está ejecutándose</li>';
            echo '<li>La base de datos "dbyh6du0yfle1i" no existe</li>';
            echo '<li>El usuario no tiene permisos</li>';
            echo '<li>Las credenciales son incorrectas</li>';
            echo '<li>El host configurado no es correcto</li>';
            echo '</ul>';
            
            echo '<strong>Verifica en tu panel de hosting:</strong><br>';
            echo '<ul>';
            echo '<li>Que MySQL esté activo</li>';
            echo '<li>Que la base de datos exista</li>';
            echo '<li>Que el usuario tenga acceso a esa base de datos</li>';
            echo '</ul>';
            echo '</div>';
        }
        ?>
        
        <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px; font-size: 0.9em;">
            <strong>ℹ️ Nota:</strong> Después de verificar la conexión, puedes eliminar este archivo (test-conexion.php) por seguridad.
        </div>
    </div>
</body>
</html>
