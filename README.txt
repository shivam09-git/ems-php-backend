EMS Final Package (Gradient UI) - Quick Start
-------------------------------------------

Files:
- backend/   (PHP backend endpoints)
- web/       (PHP pages & assets)
- database/  (ems_db.sql) - import or run init_db.php

Demo accounts:
- admin / admin123  (role: admin)
- john / john123    (role: employee)
- priya / priya123
- alex / alex123
- sarah / sarah123

Installation:
1. Copy this folder to your web server root (e.g., C:\xampp\htdocs\ems_php_backend_final).
2. Start Apache & MySQL (XAMPP/WAMP).
3. Import database/ems_db.sql via phpMyAdmin OR open:
   http://localhost:8081/ems_php_backend_final/backend/init_db.php
4. Edit backend/config.php if your DB credentials differ.
5. Open:
   http://localhost:8081/ems_php_backend_final/web/index.php
6. Login using admin/admin123 or any demo employee. On first login MD5 passwords will be migrated to secure hashing.

Notes:
- Demo employee usernames are 'john', 'priya', 'alex', 'sarah'. Their emails in employees table are john@example.com, etc.
- For production, replace MD5-migration approach and ensure HTTPS, stronger validation, and CSRF protections.