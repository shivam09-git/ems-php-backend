<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['ems_user'])) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
$employee_id = isset($_POST['employee_id']) ? intval($_POST['employee_id']) : 0;
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
if ($employee_id <= 0 || !$start_date || !$end_date) { http_response_code(400); echo json_encode(['error'=>'Missing fields']); exit; }
try {
    $stmt = $pdo->prepare('INSERT INTO leaves (employee_id, start_date, end_date, reason, status) VALUES (:eid,:sd,:ed,:r,"pending")');
    $stmt->execute([':eid'=>$employee_id,':sd'=>$start_date,':ed'=>$end_date,':r'=>$reason]);
    echo json_encode(['status'=>'ok','id'=>$pdo->lastInsertId()]);
} catch (Exception $e) {
    http_response_code(500); echo json_encode(['error'=>$e->getMessage()]);
}
?>