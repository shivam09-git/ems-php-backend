-- ems_db schema and demo data
CREATE DATABASE IF NOT EXISTS ems_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ems_db;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'employee',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Demo users: admin + employees (passwords stored as MD5 for migration on first login)
INSERT INTO users (username, password, role) VALUES
('admin', MD5('admin123'), 'admin'),
('john', MD5('john123'), 'employee'),
('priya', MD5('priya123'), 'employee'),
('alex', MD5('alex123'), 'employee'),
('sarah', MD5('sarah123'), 'employee');

DROP TABLE IF EXISTS employees;
CREATE TABLE employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  position VARCHAR(255),
  salary DECIMAL(10,2) DEFAULT 0.00,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO employees (name, email, position, salary) VALUES
('John Carter', 'john@example.com', 'HR Executive', 50000.00),
('Priya Mehta', 'priya@example.com', 'Software Engineer', 75000.00),
('Alex Johnson', 'alex@example.com', 'Technician', 40000.00),
('Sarah Lee', 'sarah@example.com', 'Sales Manager', 68000.00);

DROP TABLE IF EXISTS leaves;
CREATE TABLE leaves (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  reason TEXT,
  status VARCHAR(50) DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO leaves (employee_id, start_date, end_date, reason, status) VALUES
(1, DATE_SUB(CURDATE(), INTERVAL 15 DAY), DATE_SUB(CURDATE(), INTERVAL 13 DAY), 'Medical', 'approved'),
(2, DATE_SUB(CURDATE(), INTERVAL 7 DAY), DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'Conference', 'approved'),
(3, DATE_ADD(CURDATE(), INTERVAL 3 DAY), DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'Personal', 'pending');

DROP TABLE IF EXISTS attendance;
CREATE TABLE attendance (
  id INT AUTO_INCREMENT PRIMARY KEY,
  employee_id INT NOT NULL,
  date DATE,
  status VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- sample attendance records (last 7 days)
INSERT INTO attendance (employee_id, date, status) VALUES
(1, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 'present'),
(1, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'present'),
(1, DATE_SUB(CURDATE(), INTERVAL 4 DAY), 'present'),
(2, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 'present'),
(2, DATE_SUB(CURDATE(), INTERVAL 5 DAY), 'absent'),
(3, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 'present'),
(4, DATE_SUB(CURDATE(), INTERVAL 6 DAY), 'present');