<?php
// backend/login.php - supports password_hash() and legacy MD5 migration
header('Content-Type: application/json');
session_start();
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing username or password']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id, username, password, role FROM users WHERE username = :u LIMIT 1');
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch();
    if ($user) {
        $stored = $user['password'];
        // If stored hash is created by password_hash()
        if (password_verify($password, $stored)) {
            $_SESSION['ems_user'] = ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']];
            echo json_encode(['status' => 'ok', 'username' => $user['username'], 'role' => $user['role']]);
            exit;
        }
        // Legacy MD5 check: if matches, rehash and update
        if ($stored === md5($password)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $u = $pdo->prepare('UPDATE users SET password = :p WHERE id = :id');
            $u->execute([':p' => $newHash, ':id' => $user['id']]);
            $_SESSION['ems_user'] = ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']];
            echo json_encode(['status' => 'ok', 'username' => $user['username'], 'role' => $user['role'], 'migrated' => true]);
            exit;
        }
    }
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>