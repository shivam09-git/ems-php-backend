<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['ems_user'])) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';
if ($id<=0 || !$status) { http_response_code(400); echo json_encode(['error'=>'Invalid']); exit; }
try { $stmt = $pdo->prepare('UPDATE leaves SET status = :s WHERE id = :id'); $stmt->execute([':s'=>$status,':id'=>$id]); echo json_encode(['status'=>'ok']); } catch (Exception $e) { http_response_code(500); echo json_encode(['error'=>$e->getMessage()]); }
?>