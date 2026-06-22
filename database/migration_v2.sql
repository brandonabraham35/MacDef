-- MACDEF CMS Migration V2

-- Homepage Content
CREATE TABLE IF NOT EXISTS homepage_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    welcome_title VARCHAR(255) NULL,
    welcome_body TEXT NULL,
    welcome_image VARCHAR(255) NULL,
    card1_title VARCHAR(255) NULL,
    card1_body TEXT NULL,
    card1_button_text VARCHAR(100) NULL,
    card1_button_link VARCHAR(255) NULL,
    card2_title VARCHAR(255) NULL,
    card2_body TEXT NULL,
    card2_button_text VARCHAR(100) NULL,
    card2_button_link VARCHAR(255) NULL,
    card3_title VARCHAR(255) NULL,
    card3_body TEXT NULL,
    card3_button_text VARCHAR(100) NULL,
    card3_button_link VARCHAR(255) NULL,
    newsletter_title VARCHAR(255) NULL,
    newsletter_body TEXT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Footer Settings
CREATE TABLE IF NOT EXISTS footer_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    footer_logo VARCHAR(255) NULL,
    footer_description TEXT NULL,
    copyright_text VARCHAR(255) NULL,
    social_facebook VARCHAR(255) NULL,
    social_twitter VARCHAR(255) NULL,
    social_instagram VARCHAR(255) NULL,
    social_linkedin VARCHAR(255) NULL,
    address TEXT NULL,
    phone VARCHAR(100) NULL,
    email VARCHAR(100) NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- News Table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT NULL,
    content LONGTEXT NULL,
    featured_image VARCHAR(255) NULL,
    author VARCHAR(100) NULL,
    published_at DATE NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Publications Table
CREATE TABLE IF NOT EXISTS publications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    file_path VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) NULL,
    category VARCHAR(100) NULL,
    download_count INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Downloads Table
CREATE TABLE IF NOT EXISTS downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    file_path VARCHAR(255) NOT NULL,
    category VARCHAR(100) NULL,
    download_count INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Resources Table
CREATE TABLE IF NOT EXISTS resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    resource_type ENUM('Report', 'Research', 'Policy Brief', 'Presentation', 'Guide') DEFAULT 'Report',
    file_path VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Opportunities Table
CREATE TABLE IF NOT EXISTS opportunities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('Job', 'Tender', 'Scholarship', 'Volunteer') DEFAULT 'Job',
    description TEXT NULL,
    deadline DATE NULL,
    attachment VARCHAR(255) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Donations Table
CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(50) NULL,
    donation_type VARCHAR(100) NULL,
    amount DECIMAL(15, 2) NULL,
    message TEXT NULL,
    status ENUM('Pending', 'Contacted', 'Received', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Donation Methods Table
CREATE TABLE IF NOT EXISTS donation_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(100) NOT NULL,
    account_details TEXT NULL,
    instructions TEXT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Newsletter Subscribers Table
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    status ENUM('Subscribed', 'Unsubscribed') DEFAULT 'Subscribed',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memberships Table
CREATE TABLE IF NOT EXISTS memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(50) NULL,
    address TEXT NULL,
    occupation VARCHAR(150) NULL,
    membership_type ENUM('Ordinary', 'Associate', 'Honorary') DEFAULT 'Ordinary',
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default Content Seeds
INSERT INTO homepage_content (id, welcome_title, welcome_body, card1_title, card1_body, card1_button_text, card1_button_link, card2_title, card2_body, card2_button_text, card2_button_link, card3_title, card3_body, card3_button_text, card3_button_link, newsletter_title, newsletter_body)
VALUES (1, 'Ma\'di Cultural and Development Foundation', 'Built on strong values and a commitment to the Ma\'di people, our foundation guides everything we do.', 'Our Work', 'Discover how MACDEF is making a difference through cultural preservation and community development.', 'Learn More', 'goals.php', 'Membership', 'Join our community and contribute to the empowerment of the Ma\'di people home and abroad.', 'Learn More', 'contact.php', 'Resources', 'Access our latest reports, publications, and cultural resources for the Ma\'di community.', 'Learn More', 'mission.php', 'STAY UPDATED', 'Signup for our newsletter to stay updated on the latest news and events from the Ma\'di community.')
ON DUPLICATE KEY UPDATE welcome_title=VALUES(welcome_title);

INSERT INTO footer_settings (id, copyright_text, footer_description, address, phone, email)
VALUES (1, '© 2024 MACDEF. All Rights Reserved.', 'Ma\'di Cultural and Development Foundation (MACDEF) is dedicated to preserving heritage and fostering development.', 'Uganda', '+256 000 000 000', 'info@macdef.org')
ON DUPLICATE KEY UPDATE copyright_text=VALUES(copyright_text);
