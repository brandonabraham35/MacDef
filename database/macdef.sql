-- MACDEF PHP + MySQL database setup
CREATE DATABASE IF NOT EXISTS macdef_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE macdef_db;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin') NOT NULL DEFAULT 'admin',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS settings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contact_submissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  event_date VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'MACDEF'),
('site_title', 'Ma\'di Cultural and Development Foundation'),
('contact_phone', '+256 000 000 000'),
('contact_email', 'info@macdef.org'),
('contact_address', 'Uganda'),
('facebook_url', '#'),
('twitter_url', '#'),
('instagram_url', '#')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

INSERT INTO events (title, event_date, description) VALUES
('Community Cultural Gathering', 'Coming Soon', 'A MACDEF community gathering focused on unity, heritage, and development.'),
('Youth Development Meeting', 'Coming Soon', 'A youth-focused engagement to encourage leadership, skills, and cultural pride.')
ON DUPLICATE KEY UPDATE title = title;

INSERT INTO gallery (title, image_path) VALUES
('Community Celebration', 'uploads/gallery/madi-community-celebration.jpg'),
('Elders Council', 'uploads/gallery/madi-elders-council.jpg'),
('Traditional Performance', 'uploads/gallery/traditional-performance-dancers.jpg'),
('Youth Cultural Activity', 'uploads/gallery/youth-cultural-activity.jpg')
ON DUPLICATE KEY UPDATE title = title;

-- Default admin login:
-- Email: admin@macdef.org
-- Password: admin123
-- Change this password immediately after first login.
INSERT INTO users (full_name, email, password, role) VALUES
('MACDEF Administrator', 'admin@macdef.org', '$2y$12$.15ROoS4n4cnKFbNCejK/O8clS23tLRVlH8cloo8Ph9UN0EzkNckW', 'admin')
ON DUPLICATE KEY UPDATE email = email;
