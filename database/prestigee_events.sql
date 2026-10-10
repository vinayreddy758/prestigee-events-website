CREATE DATABASE IF NOT EXISTS `prestigee_events` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `prestigee_events`;

-- Admin login is auto-seeded by admin/includes/init.php if admins table is empty:
-- username: aaron
-- password: aaron@5500

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(120) NOT NULL DEFAULT 'Administrator',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `services` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `category` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(180) NOT NULL,
  `category` varchar(120) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `about_content` (
  `id` tinyint unsigned NOT NULL,
  `who_we_are` text NOT NULL,
  `experience_text` text NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `strengths` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `quotes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `company` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(190) NOT NULL,
  `event_type` varchar(120) NOT NULL,
  `event_date` date NOT NULL,
  `location` varchar(180) NOT NULL,
  `budget` varchar(80) NOT NULL,
  `message` text NOT NULL,
  `is_contacted` tinyint(1) NOT NULL DEFAULT '0',
  `contacted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `subject` varchar(180) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_key` varchar(80) NOT NULL,
  `setting_value` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `services` DROP COLUMN IF EXISTS `description`;
ALTER TABLE `portfolio` DROP COLUMN IF EXISTS `description`;

INSERT INTO `about_content` (`id`, `who_we_are`, `experience_text`, `mission`, `vision`, `strengths`) VALUES
(1,
'We are strategic planners, creative thinkers, and execution specialists who transform ideas into immersive event journeys with measurable impact.',
'From executive conferences and launches to private luxury celebrations, our team has hands-on experience managing diverse event formats, vendor ecosystems, and live production timelines.',
'To deliver seamless, meaningful, and memorable events that elevate brand perception, strengthen relationships, and create lasting value for every client.',
'To be the most trusted premium event partner known for reliability, innovation, and flawless execution across every touchpoint.',
'Client-first planning approach|Strong vendor and production network|Detail-driven execution standards|Creative concept-to-delivery capability|On-ground coordination excellence|Clear communication and accountability')
ON DUPLICATE KEY UPDATE
`who_we_are` = VALUES(`who_we_are`),
`experience_text` = VALUES(`experience_text`),
`mission` = VALUES(`mission`),
`vision` = VALUES(`vision`),
`strengths` = VALUES(`strengths`);

INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES
('phone', ''),
('whatsapp', ''),
('email', ''),
('address', ''),
('facebook', ''),
('instagram', ''),
('linkedin', '');

INSERT INTO `services` (`title`, `category`) VALUES
('Event Managers', 'Manpower Services'),
('Event Coordinators', 'Manpower Services'),
('Hostesses / Welcome Staff', 'Manpower Services'),
('Registration Desk Executives', 'Manpower Services'),
('Floor & Guest Management Team', 'Manpower Services'),
('Backstage / Stage Crew', 'Manpower Services'),
('Promoters & Brand Activation Staff', 'Manpower Services'),
('Technical Support Crew', 'Manpower Services'),
('Hospitality Support Team', 'Manpower Services'),
('Security & Queue Management Staff', 'Manpower Services'),
('Conferences & Seminars', 'Corporate Events'),
('Appreciation Events', 'Corporate Events'),
('Award Shows', 'Corporate Events'),
('Team Outings', 'Corporate Events'),
('Team Building Activities', 'Corporate Events'),
('Office Get-Togethers', 'Corporate Events'),
('Workshops & Trainings', 'Corporate Events'),
('Live Streaming', 'Corporate Events'),
('Trade Shows & Expos', 'Corporate Events'),
('Product Launches', 'Corporate Events'),
('Annual Events', 'Corporate Events'),
('Conclaves & Confluences', 'Corporate Events'),
('Themed Office Decoration', 'Corporate Events'),
('Client Visits', 'Corporate Events'),
('Music Concerts', 'Corporate Events'),
('Exhibition Stalls', 'Corporate Events'),
('Town Halls & All-Hands', 'Corporate Events'),
('Sports Meets', 'Corporate Events'),
('DJ Nights & Karaoke Setup', 'Corporate Events'),
('Festive Themed Events', 'Corporate Events'),
('Welcome Arch', 'Event Services - Welcome'),
('Welcome Board', 'Event Services - Welcome'),
('Direction Board', 'Event Services - Welcome'),
('Welcome Standee', 'Event Services - Welcome'),
('Pillars', 'Event Services - Welcome'),
('Cubes', 'Event Services - Welcome'),
('Flags', 'Event Services - Welcome'),
('Welcome Girls', 'Event Services - Welcome'),
('Hostesses / Models', 'Event Services - Welcome'),
('Welcome Dancers', 'Event Services - Welcome'),
('Red Carpet Entry', 'Event Services - Welcome'),
('Pathway Themes', 'Event Services - Welcome'),
('Registration Desk', 'Event Services - Welcome'),
('Digital Registration', 'Event Services - Welcome'),
('ID Card', 'Event Services - Welcome'),
('Selfie Booth', 'Event Services - Welcome'),
('Photo Booth', 'Event Services - Welcome'),
('Decoration', 'Event Services - Event'),
('Lamp Lighting', 'Event Services - Event'),
('Bouquets for Guests', 'Event Services - Event'),
('Main Stage / Platform', 'Event Services - Event'),
('PA System', 'Event Services - Event'),
('LED Display', 'Event Services - Event'),
('Lighting', 'Event Services - Event'),
('PR & Press Media', 'Event Services - Event'),
('Furniture', 'Event Services - Event'),
('Photography', 'Event Services - Event'),
('Videography', 'Event Services - Event'),
('MC', 'Event Services - Event'),
('VJ', 'Event Services - Event'),
('DJ', 'Event Services - Event'),
('Digital Welcome Standee', 'Event Services - Creative Options'),
('Interactive Floor', 'Event Services - Creative Options'),
('Instant Photobooth', 'Event Services - Creative Options'),
('Digital Graffiti Wall', 'Event Services - Creative Options'),
('Fog Screen Display', 'Event Services - Creative Options'),
('Selfie Sling Shot', 'Event Services - Creative Options'),
('360 Degree Videobooth', 'Event Services - Creative Options'),
('Virtual Paparazzi', 'Event Services - Creative Options'),
('LED Dance Floor', 'Event Services - Creative Options'),
('Dance Troupe', 'Event Services - Entertainment Options'),
('Music Band', 'Event Services - Entertainment Options'),
('Celebrity Singers', 'Event Services - Entertainment Options'),
('Stand-up Comedian', 'Event Services - Entertainment Options'),
('Reality Show Performers', 'Event Services - Entertainment Options'),
('Illusionist', 'Event Services - Entertainment Options'),
('Concerts', 'Event Services - Entertainment Options'),
('Team Building', 'Event Services - Others'),
('Carnival Games', 'Event Services - Others'),
('Drone Shoot', 'Event Services - Others'),
('Structures', 'Event Services - Others'),
('Motivational Session', 'Event Services - Others'),
('Wellness Session', 'Event Services - Others'),
('Stalls', 'Event Services - Others'),
('IT Solution', 'Event Services - Others'),
('Live Streaming', 'Event Services - Others'),
('3D Event Layout', 'Event Services - Others');

INSERT INTO `portfolio` (`title`, `category`, `image_url`) VALUES
('Annual Gala Night', 'Corporate', 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80'),
('Product Launch Experience', 'Brand Activation', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80'),
('Executive Summit', 'Corporate', 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=1200&q=80'),
('Destination Celebration', 'Luxury Celebration', 'https://images.unsplash.com/photo-1478146896981-b80fe463b330?auto=format&fit=crop&w=1200&q=80'),
('Live Entertainment Night', 'Entertainment', 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1200&q=80'),
('Luxury Wedding Production', 'Wedding', 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&w=1200&q=80');
