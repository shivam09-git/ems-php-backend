<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['ems_user'])) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }
try {
    $stmt = $pdo->query('SELECT l.id, l.employee_id, e.name as employee_name, l.start_date, l.end_date, l.reason, l.status FROM leaves l JOIN employees e ON e.id = l.employee_id ORDER BY l.id DESC');
    $rows = $stmt->fetchAll();
    echo json_encode(['status'=>'ok','leaves'=>$rows]);
} catch (Exception $e) {
    http_response_code(500); echo json_encode(['error'=>$e->getMessage()]);
}
?>