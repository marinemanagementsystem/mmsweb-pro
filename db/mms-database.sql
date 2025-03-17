-- --------------------------------------------------------
-- MMS - Marine Management System
-- Database Structure
-- --------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Database: `mms_database`
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `mms_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mms_database`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `content_sections`
-- --------------------------------------------------------

CREATE TABLE `content_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_key` (`section_key`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `content_sections_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `content_sections` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `content_translations`
-- --------------------------------------------------------

CREATE TABLE `content_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `language` varchar(5) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_lang_key` (`section_id`,`language`,`key`),
  KEY `section_id` (`section_id`),
  KEY `language` (`language`),
  CONSTRAINT `content_translations_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `content_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `demo_requests`
-- --------------------------------------------------------

CREATE TABLE `demo_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','contacted','completed') NOT NULL DEFAULT 'pending',
  `notes` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `contact_messages`
-- --------------------------------------------------------

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') NOT NULL DEFAULT 'unread',
  `reply` text,
  `replied_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `settings`
-- --------------------------------------------------------

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `languages`
-- --------------------------------------------------------

CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `admin_activity_logs`
-- --------------------------------------------------------

CREATE TABLE `admin_activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `admin_activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `visitor_stats`
-- --------------------------------------------------------

CREATE TABLE `visitor_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `visitors` int(11) NOT NULL DEFAULT '0',
  `page_views` int(11) NOT NULL DEFAULT '0',
  `unique_visitors` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `visitor_sessions`
-- --------------------------------------------------------

CREATE TABLE `visitor_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `referrer` varchar(255) DEFAULT NULL,
  `language` varchar(5) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `visited_pages` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `backups`
-- --------------------------------------------------------

CREATE TABLE `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `backup_type` enum('full','database','files') NOT NULL DEFAULT 'full',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `backups_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Insert initial data
-- --------------------------------------------------------

-- Insert default admin user
INSERT INTO `users` (`username`, `password`, `email`, `full_name`, `role`, `status`, `created_at`) VALUES
('admin', '$2y$10$LwcHBGgPHIbVU0OGhiDIyuHQ9i95JWObPh0BDDgLWY9KWe5p2Druy', 'admin@marinemanagementsystem.com', 'Administrator', 'admin', 'active', NOW());
-- Note: Password is 'admin123' (hashed with bcrypt)

-- Insert languages
INSERT INTO `languages` (`code`, `name`, `is_active`, `is_default`) VALUES
('tr', 'Türkçe', 1, 1),
('en', 'English', 1, 0);

-- Insert content sections
INSERT INTO `content_sections` (`section_key`, `parent_id`, `order`, `is_active`) VALUES
('about', NULL, 1, 1),
('vision', NULL, 2, 1),
('mission', NULL, 3, 1),
('promises', NULL, 4, 1),
('software', NULL, 5, 1),
('solutions', NULL, 6, 1),
('features', NULL, 7, 1),
('packages', NULL, 8, 1),
('technical', NULL, 9, 1),
('team', NULL, 10, 1),
('conclusion', NULL, 11, 1);

-- Insert default settings
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_title', 'Marine Management System (MMS)'),
('site_description', 'Innovative ERP solutions for the shipbuilding industry.'),
('contact_email', 'info@marinemanagementsystem.com'),
('contact_phone', '+90 507 574 2666'),
('address', 'Bilişim Vadisi - Kocaeli'),
('social_instagram', 'https://www.instagram.com/marinemanagementsystem/'),
('social_facebook', 'https://www.facebook.com/profile.php?id=61560348505866'),
('social_linkedin', 'https://www.linkedin.com/company/mms-erp'),
('social_whatsapp', 'https://wa.me/+905075742666'),
('meta_keywords', 'Marine Management System, MMS, ERP, Shipbuilding, Ship Repair, Yacht Building, Maritime ERP, Tersane, Gemi İnşa'),
('enable_social_meta', '1');

-- Insert sample content translations for About section (English)
INSERT INTO `content_translations` (`section_id`, `language`, `key`, `value`) VALUES
(1, 'en', 'about_text', 'Our founders are a team of Istanbul Technical University graduates from various disciplines, including a Naval Architect, Computer Engineer, and Electrical-Electronics Engineer, each with up to 15 years of experience. This team operates as a software company, offering unique solutions with its innovative and industry-specific ERP software. Formed by young entrepreneurs focused on innovation and quality, our company aims to provide innovative and effective solutions to the needs of the sector.');

-- Insert sample content translations for About section (Turkish)
INSERT INTO `content_translations` (`section_id`, `language`, `key`, `value`) VALUES
(1, 'tr', 'about_text', 'Kurucularımız, farklı disiplinlerden gelen ve kendi alanlarında 15 yıla varan deneyime sahip İstanbul Teknik Üniversitesi mezunu bir Gemi Mühendisi ile Bilgisayar ve Elektrik-Elektronik Mühendislerinden oluşmaktadır. Bu ekip, yenilikçi ve sektöre özgü bir yaklaşımla geliştirdiği ERP yazılımıyla özgün çözümler sunan bir yazılım şirketi olarak faaliyet göstermektedir. İnovasyona ve kaliteye odaklanan genç girişimcilerin bir araya gelmesiyle oluşan şirketimiz, sektördeki ihtiyaçlara yenilikçi ve etkili çözümler sunmayı hedeflemektedir.');

-- Insert sample visitor stats for the last 7 days
INSERT INTO `visitor_stats` (`date`, `visitors`, `page_views`, `unique_visitors`) VALUES
(DATE_SUB(CURDATE(), INTERVAL 6 DAY), 120, 320, 80),
(DATE_SUB(CURDATE(), INTERVAL 5 DAY), 135, 280, 95),
(DATE_SUB(CURDATE(), INTERVAL 4 DAY), 95, 190, 70),
(DATE_SUB(CURDATE(), INTERVAL 3 DAY), 150, 390, 110),
(DATE_SUB(CURDATE(), INTERVAL 2 DAY), 180, 420, 130),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), 90, 210, 65),
(CURDATE(), 110, 240, 85);
