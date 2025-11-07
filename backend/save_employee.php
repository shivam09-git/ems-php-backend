<?php
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/config.php';
if (!isset($_SESSION['ems_user'])) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit; }
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$position = isset($_POST['position']) ? trim($_POST['position']) : '';
$salary = isset($_POST['salary']) ? floatval($_POST['salary']) : 0;
if ($name === '' || $email === '') { http_response_code(400); echo json_encode(['error' => 'Name and email are required']); exit; }
try {
    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE employees SET name = :name, email = :email, position = :position, salary = :salary WHERE id = :id');
        $stmt->execute([':name'=>$name, ':email'=>$email, ':position'=>$position, ':salary'=>$salary, ':id'=>$id]);
        echo json_encode(['status'=>'ok','message'=>'Employee updated']);
    } else {
        $stmt = $pdo->prepare('INSERT INTO employees (name, email, position, salary) VALUES (:name, :email, :position, :salary)');
        $stmt->execute([':name'=>$name, ':email'=>$email, ':position'=>$position, ':salary'=>$salary]);
        echo json_encode(['status'=>'ok','message'=>'Employee added','id'=>$pdo->lastInsertId()]);
    }
} catch (Exception $e) {
    http_response_code(500); echo json_encode(['error' => $e->getMessage()]);
}
?>