<?php ?>
<!doctype html><html><head><meta charset="utf-8"><title>EMS - Login</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head><body>
<div class="login-wrap">
  <div class="login-card fade-in">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
      <div class="logo">EMS</div>
      <div><h2 style="margin:0">Apex Solutions</h2><div style="opacity:0.8">Sign in to continue</div></div>
    </div>
    <form id="loginForm">
      <input id="username" name="username" placeholder="Username" class="input" required>
      <input id="password" name="password" type="password" placeholder="Password" class="input" required>
      <button type="submit" class="btn" style="width:100%;margin-top:8px">Login</button>
      <div id="msg" style="margin-top:10px;color:#ffdede"></div>
    </form>
    <p style="margin-top:12px;font-size:13px;opacity:0.85">Demo accounts: admin/admin123 and sample employees (see README).</p>
  </div>
</div>
<script>
document.getElementById('loginForm').addEventListener('submit', async function(e){
  e.preventDefault();
  document.getElementById('msg').textContent = '';
  var form = e.target;
  var data = new FormData(form);
  try{
    var res = await fetch('../backend/login.php', { method: 'POST', body: data, credentials: 'same-origin' });
    var text = await res.text();
    var json = JSON.parse(text);
    if (res.ok && json.status === 'ok') {
      // redirect based on role
      if (json.role && json.role === 'admin') window.location.href = 'dashboard.php';
      else window.location.href = 'employee-dashboard.php';
    } else {
      document.getElementById('msg').textContent = json.error || 'Login failed';
    }
  } catch(err){
    document.getElementById('msg').textContent = 'Network or server error';
  }
});
</script>
</body></html>