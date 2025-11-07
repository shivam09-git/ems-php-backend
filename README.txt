🧑‍💼 Employee Management System (EMS)

A modern **Employee Management System** built with **PHP**, **MySQL**, and a smooth **gradient UI**.  
Includes **Admin** and **Employee** dashboards, secure login, attendance, leave tracking, and analytics.

---

🚀 Features

- 🔐 Secure login system for Admin and Employees  
- 🧾 Manage employee records, leaves, and performance  
- 📊 Dashboard analytics with animated gradient UI  
- 💾 MySQL backend with demo data  
- ⚙️ Easy local setup on XAMPP (port 8081)  
- 🧠 Clean PHP backend (no frameworks)  
- 🌈 Responsive gradient design using CSS animations  

---

🧩 Project Structure

ems_php_backend_final/
│
├── backend/ # PHP backend (database, authentication, APIs)
├── web/ # Frontend pages (HTML, PHP, JS)
├── assets/ # CSS, JS, and image assets
├── ems_db.sql # MySQL schema + demo data
└── README.md # Project documentation

yaml
Copy code

---

🧰 Installation Guide

1️⃣ Prerequisites
- Install [XAMPP](https://www.apachefriends.org/)
- Start **Apache** and **MySQL** in XAMPP Control Panel
- Default URL: [http://localhost:8081/](http://localhost:8081/)

2️⃣ Setup Steps
1. Copy the folder **`ems_php_backend_final`** into:
C:\xampp\htdocs\

sql
Copy code
2. Open phpMyAdmin → Create a new database:
ems_db

mathematica
Copy code
3. Import the file **ems_db.sql**
4. Open your browser and go to:
http://localhost:8081/ems_php_backend_final/web/

yaml
Copy code

---

🔐 Demo Credentials

| Role | Username | Password |
|------|-----------|-----------|
| Admin | admin | admin123 |
| John Carter | john | john123 |
| Priya Mehta | priya | priya123 |
| Alex Johnson | alex | alex123 |
| Sarah Lee | sarah | sarah123 |

---
🖥️ Pages

| Page | Description |
|------|--------------|
| `login.php` | Admin & Employee login page |
| `dashboard.php` | Admin dashboard with employee stats |
| `employee-dashboard.php` | Employee personal dashboard |
| `employees.php` | Manage all employees |
| `leaves.php` | Manage leave requests |
| `reports.php` | Monthly analytics and attendance data |
| `about.php` | About company and system |

---

🛡️ Security

- Passwords stored using PHP’s `password_hash()` function  
- Input validation on both frontend and backend  
- Role-based access control (Admin vs Employee)

---

💡 Author

👨‍💻 Developed by **[Shivam Naik](https://github.com/shivam09-git)**  
Project structure and UI refined with help from **OpenAI ChatGPT (GPT-5)** for design optimization and clarity.

---

📄 License

Released under the **MIT License**.  
Feel free to use, modify, and distribute this project with attribution.
⚙️ .gitignore
bash
Copy code
System files
.DS_Store
Thumbs.db

IDE configs
.vscode/
.idea/

Logs and temporary files
*.log
*.tmp

Vendor or node modules
vendor/
node_modules/

Environment and local configs
.env
config.php
