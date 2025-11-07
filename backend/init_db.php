<?php
require_once __DIR__ . '/config.php';
try {
    $sql = file_get_contents(__DIR__ . '/../database/ems_db.sql');
    $pdo->exec($sql);
    echo "Database initialized. Open web/index.php to login (admin/admin123)";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>