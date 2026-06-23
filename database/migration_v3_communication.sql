-- Migration for MACDEF Admin Dashboard Redesign & Communication System

-- Update contact_submissions table for reply system
ALTER TABLE contact_submissions
ADD COLUMN status ENUM('New', 'Read', 'Replied') DEFAULT 'New',
ADD COLUMN replied_at TIMESTAMP NULL,
ADD COLUMN reply_subject VARCHAR(255) NULL,
ADD COLUMN reply_body TEXT NULL;

-- Update memberships table to include 'Contacted' status
ALTER TABLE memberships
MODIFY COLUMN status ENUM('Pending', 'Approved', 'Rejected', 'Contacted') DEFAULT 'Pending';

-- Update email_logs table to include email_type
ALTER TABLE email_logs
ADD COLUMN email_type VARCHAR(50) NULL AFTER subject,
ADD COLUMN sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
