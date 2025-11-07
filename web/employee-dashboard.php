<?php
session_start();
if (!isset($_SESSION['ems_user']) || $_SESSION['ems_user']['role'] !== 'employee') {
    header('Location: index.php');
    exit;
}
$user = $_SESSION['ems_user'];
// fetch employee record by username match (simple demo)
require_once __DIR__ . '/../backend/config.php';
$stmt = $pdo->prepare('SELECT * FROM employees WHERE email = :e OR name = :n LIMIT 1');
$stmt->execute([':e'=>$user['username'].'@example.com', ':n'=>ucfirst($user['username'])]);
$emp = $stmt->fetch();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Employee Dashboard</title>
<link rel="stylesheet" href="assets/css/style.css"><script src="https://cdn.jsdelivr.net/npm/chart.js"></script></head><body>
<div class="app">
  <div class="header"><div class="brand"><div class="logo">EMS</div><h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1></div><div><a href="../backend/logout.php" class="btn ghost">Logout</a></div></div>
  <div class="grid">
    <aside class="sidebar"><nav class="nav"><a href="employee-dashboard.php">🏠 My Dashboard</a><a href="leaves.php">📅 My Leaves</a><a href="about.php">ℹ️ About</a></nav></aside>
    <section class="content">
      <div class="card"><h3>My Info</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($emp['name'] ?? $user['username']); ?></p>
        <p><strong>Position:</strong> <?php echo htmlspecialchars($emp['position'] ?? 'N/A'); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($emp['email'] ?? ($user['username'].'@example.com')); ?></p>
      </div>
      <div class="card"><h3>Your Progress</h3><canvas id="progChart" height="120"></canvas></div>
    </section>
  </div>
</div>
<script>
const ctx=document.getElementById('progChart').getContext('2d');
new Chart(ctx,{type:'line',data:{labels:['Week1','Week2','Week3','Week4'],datasets:[{label:'Productivity',data:[65,72,78,85],fill:false}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
</script>
</body></html>