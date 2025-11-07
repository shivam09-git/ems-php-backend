<?php
session_start();
if (!isset($_SESSION['ems_user'])) { header('Location: index.php'); exit; }
$user = $_SESSION['ems_user'];
?>
<!doctype html><html><head><meta charset="utf-8"><title>Leaves - EMS</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<div class="app">
  <div class="header"><div class="brand"><div class="logo">EMS</div><h1>Leaves</h1></div><div><span>Welcome, <?php echo htmlspecialchars($user['username']); ?></span>&nbsp;&nbsp;<a href="../backend/logout.php" class="btn ghost">Logout</a></div></div>
  <div class="grid"><aside class="sidebar"><nav class="nav"><a href="dashboard.php">🏠 Dashboard</a><a href="employees.php">👥 Employees</a><a href="leaves.php">📅 Leaves</a></nav></aside>
  <section class="content"><div class="card">
    <h3>Leave Requests</h3>
    <div style="display:flex;gap:8px;align-items:center;margin-top:8px">
      <?php if($user['role'] === 'admin'): ?>
        <div style="opacity:0.85">Admins can approve/reject requests below.</div>
      <?php else: ?>
        <select id="employeeSelect" style="padding:8px;border-radius:6px"></select>
        <input id="startDate" type="date" style="padding:8px;border-radius:6px">
        <input id="endDate" type="date" style="padding:8px;border-radius:6px">
        <input id="reason" placeholder="Reason" style="padding:8px;border-radius:6px">
        <button id="applyLeave" class="btn">Apply</button>
      <?php endif; ?>
    </div>
    <table id="leavesTable" class="table" style="margin-top:12px"><thead><tr><th>ID</th><th>Employee</th><th>Start</th><th>End</th><th>Reason</th><th>Status</th><th>Actions</th></tr></thead><tbody></tbody></table>
  </div></section></div></div>
<script src="assets/js/app.js"></script>
<script>
async function loadEmployeesForSelect(){ const res = await fetch('../backend/get_employees.php', {credentials:'same-origin'}); const d = await res.json(); const sel = document.getElementById('employeeSelect'); if(!sel) return; sel.innerHTML=''; if(d.status==='ok'){ d.employees.forEach(e=>{ const o=document.createElement('option'); o.value=e.id; o.textContent=e.name; sel.appendChild(o); }); } }
async function loadLeaves(){ const res = await fetch('../backend/get_leaves.php', {credentials:'same-origin'}); const d = await res.json(); const tbody = document.querySelector('#leavesTable tbody'); tbody.innerHTML=''; if(d.status==='ok'){ d.leaves.forEach(l=>{ const tr=document.createElement('tr'); tr.innerHTML=`<td>${l.id}</td><td>${l.employee_name}</td><td>${l.start_date}</td><td>${l.end_date}</td><td>${l.reason}</td><td>${l.status}</td><td>${ (<?php echo ($user['role']==='admin')? 'true':'false'; ?>) ? '<button class="btn ghost" onclick="updateStatus('+l.id+',\'approved\')">Approve</button> <button class="btn ghost" onclick="updateStatus('+l.id+',\'rejected\')">Reject</button> <button class="btn" onclick="deleteLeave('+l.id+')">Delete</button>' : '—' }</td>`; tbody.appendChild(tr); }); } }
document.addEventListener('DOMContentLoaded', function(){ loadEmployeesForSelect(); loadLeaves(); });
document.getElementById('applyLeave') && document.getElementById('applyLeave').addEventListener('click', async function(){ const employee_id = document.getElementById('employeeSelect').value; const start = document.getElementById('startDate').value; const end = document.getElementById('endDate').value; const reason = document.getElementById('reason').value.trim(); if (!employee_id || !start || !end){ alert('Please complete fields'); return; } const fd = new FormData(); fd.append('employee_id', employee_id); fd.append('start_date', start); fd.append('end_date', end); fd.append('reason', reason); const res = await fetch('../backend/save_leave.php', {method:'POST', body: fd, credentials:'same-origin'}); const j = await res.json(); if (j.status==='ok'){ loadLeaves(); document.getElementById('reason') && (document.getElementById('reason').value=''); } else alert(j.error||'Error'); });
async function updateStatus(id,status){ const fd = new FormData(); fd.append('id', id); fd.append('status', status); const res = await fetch('../backend/update_leave_status.php', {method:'POST', body: fd, credentials:'same-origin'}); const j = await res.json(); if (j.status==='ok') loadLeaves(); else alert(j.error||'Error'); }
async function deleteLeave(id){ if(!confirm('Delete leave?')) return; const fd = new FormData(); fd.append('id', id); const res = await fetch('../backend/delete_leave.php', {method:'POST', body: fd, credentials:'same-origin'}); const j = await res.json(); if (j.status==='ok') loadLeaves(); else alert(j.error||'Error'); }
</script>
</body></html>