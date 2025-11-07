<?php
session_start();
if (!isset($_SESSION['ems_user']) || $_SESSION['ems_user']['role'] !== 'admin') { header('Location: index.php'); exit; }
$user = $_SESSION['ems_user'];
?>
<!doctype html><html><head><meta charset="utf-8"><title>Employees - EMS</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<div class="app">
  <div class="header"><div class="brand"><div class="logo">EMS</div><h1>Employees</h1></div><div><span>Welcome, <?php echo htmlspecialchars($user['username']); ?></span>&nbsp;&nbsp;<a href="../backend/logout.php" class="btn ghost">Logout</a></div></div>
  <div class="grid"><aside class="sidebar"><nav class="nav"><a href="dashboard.php">🏠 Dashboard</a><a href="employees.php">👥 Employees</a><a href="leaves.php">📅 Leaves</a></nav></aside>
  <section class="content"><div class="card"><button id="openAdd" class="btn">+ Add Employee</button><table id="employeesTable" class="table"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Position</th><th>Salary</th><th>Actions</th></tr></thead><tbody></tbody></table></div></section></div></div>
<div id="modalRoot" class="modal-backdrop" style="display:none"><div class="modal"><h3>Add / Edit Employee</h3><input id="ename" placeholder="Name"><input id="eemail" placeholder="Email"><input id="eposition" placeholder="Position"><input id="esalary" placeholder="Salary" type="number"><div style="display:flex;gap:8px;margin-top:8px"><button id="saveEmp" class="btn">Save</button><button class="btn ghost" onclick="closeModal()">Cancel</button></div></div></div>
<script src="assets/js/app.js"></script></body></html>