CREATE DATABASE IF NOT EXISTS repair_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE repair_system;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(100) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 fullname VARCHAR(150) NOT NULL,
 role ENUM('admin','user','technician') NOT NULL DEFAULT 'user',
 email VARCHAR(150),
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE repair_requests (
 id INT AUTO_INCREMENT PRIMARY KEY,
 request_no VARCHAR(30) NOT NULL UNIQUE,
 user_id INT NOT NULL,
 building VARCHAR(100) NOT NULL,
 room VARCHAR(50) NOT NULL,
 problem_type ENUM('electrical','furniture','computer','aircon','network','other') NOT NULL,
 description TEXT NOT NULL,
 urgency ENUM('low','medium','high') NOT NULL DEFAULT 'medium',
 status ENUM('pending','accepted','in_progress','completed','cancelled') NOT NULL DEFAULT 'pending',
 assigned_to INT NULL,
 due_date DATE NULL,
 completion_date DATETIME NULL,
 cost DECIMAL(10,2) NOT NULL DEFAULT 0,
 result TEXT NULL,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id),
 FOREIGN KEY(assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE repair_images (
 id INT AUTO_INCREMENT PRIMARY KEY,
 repair_id INT NOT NULL,
 image_type ENUM('before','after') NOT NULL,
 image_path VARCHAR(255) NOT NULL,
 uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(repair_id) REFERENCES repair_requests(id) ON DELETE CASCADE
);

CREATE TABLE repair_comments (
 id INT AUTO_INCREMENT PRIMARY KEY,
 repair_id INT NOT NULL,
 user_id INT NOT NULL,
 comment TEXT NOT NULL,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(repair_id) REFERENCES repair_requests(id) ON DELETE CASCADE,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE repair_parts (
 id INT AUTO_INCREMENT PRIMARY KEY,
 repair_id INT NOT NULL,
 part_name VARCHAR(150) NOT NULL,
 quantity INT NOT NULL DEFAULT 1,
 unit_price DECIMAL(10,2) NOT NULL DEFAULT 0,
 FOREIGN KEY(repair_id) REFERENCES repair_requests(id) ON DELETE CASCADE
);

CREATE TABLE repair_history (
 id INT AUTO_INCREMENT PRIMARY KEY,
 repair_id INT NOT NULL,
 user_id INT NOT NULL,
 old_status VARCHAR(30),
 new_status VARCHAR(30),
 note TEXT,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(repair_id) REFERENCES repair_requests(id) ON DELETE CASCADE,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users(username,password,fullname,role,email) VALUES
('admin', '$2y$12$sPyA8oltGEtymqbaMx.KNuG.SVjJ0PpJdw3rOT0bXoVXAE4PDc0Z2', 'ผู้ดูแลระบบ','admin','admin@example.com'),
('teacher', '$2y$12$dwj8.s95iYaKDp54cbayROybQPrfcdZ5NdZyy6iDPh3wqlcO1.XFy', 'ผู้แจ้งตัวอย่าง','user','teacher@example.com'),
('tech', '$2y$12$kxuYL0bmmYq0gSjqq/BjVO/WpOIrZpt025QqjoTMiN3pRwIaiZrGy', 'ช่างตัวอย่าง','technician','tech@example.com');

-- รหัสผ่านของบัญชีตัวอย่างทั้ง 3 บัญชี: 123456
