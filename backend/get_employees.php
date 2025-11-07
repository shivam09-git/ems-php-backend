<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['ems_user'])) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }
try {
    $stmt = $pdo->query('SELECT id, name, email, position, salary FROM employees ORDER BY id DESC');
    $rows = $stmt->fetchAll();
    echo json_encode(['status'=>'ok','employees'=>$rows]);
} catch (Exception $e) {
    http_response_code(500); echo json_encode(['error'=>$e->getMessage()]);
}
?>