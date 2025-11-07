<?php
session_start();
if (!isset($_SESSION['ems_user']) || $_SESSION['ems_user']['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
$user = $_SESSION['ems_user'];
?>
<!doctype html><html><head><meta charset="utf-8"><title>EMS - Dashboard</title>
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head><body>
<div class="app">
  <div class="header">
    <div class="brand"><div class="logo">EMS</div><h1>Apex Solutions - Admin</h1></div>
    <div><span style="opacity:0.9">Welcome, <?php echo htmlspecialchars($user['username']); ?></span>&nbsp;&nbsp;<a href="../backend/logout.php" class="btn ghost">Logout</a></div>
  </div>
  <div class="grid">
    <aside class="sidebar">
      <nav class="nav">
        <a href="dashboard.php">🏠 Dashboard</a>
        <a href="employees.php">👥 Employees</a>
        <a href="leaves.php">📅 Leaves</a>
        <a href="reports.php">📊 Reports</a>
        <a href="about.php">ℹ️ About</a>
      </nav>
    </aside>
    <section class="content">
      <div class="cards">
        <div class="card"><h3>Total Employees</h3><div id="totalEmployees" style="font-size:28px;margin-top:8px">--</div></div>
        <div class="card"><h3>Pending Leaves</h3><div id="pendingLeaves" style="font-size:28px;margin-top:8px">--</div></div>
        <div class="card"><h3>Today Check-ins</h3><div id="todayCheck" style="font-size:28px;margin-top:8px">--</div></div>
      </div>
      <div class="card"><h3>Employees Overview</h3><canvas id="empChart" height="120"></canvas></div>
    </section>
  </div>
</div>
<script src="assets/js/app.js"></script>
<script>
async function loadStats(){
  const empRes = await fetch('../backend/get_employees.php', {credentials:'same-origin'});
  const empData = await empRes.json();
  document.getElementById('totalEmployees').textContent = empData.status==='ok' ? empData.employees.length : '--';
  const leavesRes = await fetch('../backend/get_leaves.php', {credentials:'same-origin'});
  const leavesData = await leavesRes.json();
  const pending = leavesData.status==='ok' ? leavesData.leaves.filter(l=>l.status==='pending').length : 0;
  document.getElementById('pendingLeaves').textContent = pending;
  // draw chart
  const ctx = document.getElementById('empChart').getContext('2d');
  const labels = empData.employees.map(e=>e.name);
  const values = empData.employees.map(()=>Math.floor(Math.random()*10)+1);
  new Chart(ctx,{type:'bar',data:{labels:labels,datasets:[{label:'Performance',data:values}]},options:{scales:{y:{beginAtZero:true}},plugins:{legend:{display:false}}}});
}
loadStats();
</script>
</body></html>