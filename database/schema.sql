-- Generic Real Estate CMS — Database Schema
-- MySQL 8+ / MariaDB, InnoDB, utf8mb4

CREATE DATABASE IF NOT EXISTS `realestate_cms` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `realestate_cms`;

SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------
CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(190) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
    `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `last_login_at` DATETIME NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- media (library)
-- ---------------------------------------------------------------------
CREATE TABLE `media` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `filename` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `path` VARCHAR(500) NOT NULL,
    `mime_type` VARCHAR(100) NOT NULL,
    `file_type` ENUM('image','document','video') NOT NULL DEFAULT 'image',
    `size` INT UNSIGNED NOT NULL DEFAULT 0,
    `alt_text` VARCHAR(255) NULL,
    `uploaded_by` INT UNSIGNED NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_media_type` (`file_type`),
    CONSTRAINT `fk_media_user` FOREIGN KEY (`uploaded_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- settings (centralized branding/config key-value store)
-- ---------------------------------------------------------------------
CREATE TABLE `settings` (
    `setting_key` VARCHAR(100) NOT NULL PRIMARY KEY,
    `setting_value` LONGTEXT NULL,
    `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general',
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- cities / areas
-- ---------------------------------------------------------------------
CREATE TABLE `cities` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    UNIQUE KEY `uq_cities_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `areas` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `city_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(120) NOT NULL,
    `slug` VARCHAR(140) NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    UNIQUE KEY `uq_areas_city_slug` (`city_id`,`slug`),
    CONSTRAINT `fk_areas_city` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- property_types / features
-- ---------------------------------------------------------------------
CREATE TABLE `property_types` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `icon` VARCHAR(100) NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY `uq_property_types_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `features` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(120) NOT NULL,
    `icon` VARCHAR(100) NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    UNIQUE KEY `uq_features_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- agents
-- ---------------------------------------------------------------------
CREATE TABLE `agents` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(170) NOT NULL,
    `photo_media_id` INT UNSIGNED NULL,
    `designation` VARCHAR(150) NULL,
    `phone` VARCHAR(30) NULL,
    `whatsapp` VARCHAR(30) NULL,
    `email` VARCHAR(190) NULL,
    `bio` TEXT NULL,
    `facebook_url` VARCHAR(255) NULL,
    `instagram_url` VARCHAR(255) NULL,
    `linkedin_url` VARCHAR(255) NULL,
    `twitter_url` VARCHAR(255) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_agents_slug` (`slug`),
    CONSTRAINT `fk_agents_media` FOREIGN KEY (`photo_media_id`) REFERENCES `media`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- projects / project_images
-- ---------------------------------------------------------------------
CREATE TABLE `projects` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(180) NOT NULL,
    `slug` VARCHAR(200) NOT NULL,
    `developer` VARCHAR(150) NULL,
    `city_id` INT UNSIGNED NULL,
    `location` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `logo_media_id` INT UNSIGNED NULL,
    `starting_price` DECIMAL(15,2) NULL,
    `price_label` VARCHAR(100) NULL,
    `status` ENUM('upcoming','ongoing','completed') NOT NULL DEFAULT 'upcoming',
    `completion_date` DATE NULL,
    `amenities` TEXT NULL,
    `payment_plan` TEXT NULL,
    `brochure_media_id` INT UNSIGNED NULL,
    `video_url` VARCHAR(255) NULL,
    `map_url` VARCHAR(500) NULL,
    `latitude` DECIMAL(10,7) NULL,
    `longitude` DECIMAL(10,7) NULL,
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `seo_title` VARCHAR(255) NULL,
    `seo_description` VARCHAR(500) NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_projects_slug` (`slug`),
    KEY `idx_projects_status` (`status`,`is_published`),
    CONSTRAINT `fk_projects_city` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_projects_logo` FOREIGN KEY (`logo_media_id`) REFERENCES `media`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_projects_brochure` FOREIGN KEY (`brochure_media_id`) REFERENCES `media`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `project_images` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT UNSIGNED NOT NULL,
    `media_id` INT UNSIGNED NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_primary` TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT `fk_project_images_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_project_images_media` FOREIGN KEY (`media_id`) REFERENCES `media`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- properties / property_images / property_features
-- ---------------------------------------------------------------------
CREATE TABLE `properties` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(200) NOT NULL,
    `slug` VARCHAR(220) NOT NULL,
    `property_type_id` INT UNSIGNED NULL,
    `purpose` ENUM('sale','rent') NOT NULL DEFAULT 'sale',
    `price` DECIMAL(15,2) NOT NULL DEFAULT 0,
    `price_label` VARCHAR(100) NULL,
    `currency` VARCHAR(10) NOT NULL DEFAULT 'PKR',
    `status` ENUM('available','sold','rented','under_offer') NOT NULL DEFAULT 'available',
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `city_id` INT UNSIGNED NULL,
    `area_id` INT UNSIGNED NULL,
    `address` VARCHAR(255) NULL,
    `latitude` DECIMAL(10,7) NULL,
    `longitude` DECIMAL(10,7) NULL,
    `map_url` VARCHAR(500) NULL,
    `bedrooms` SMALLINT UNSIGNED NULL,
    `bathrooms` SMALLINT UNSIGNED NULL,
    `kitchens` SMALLINT UNSIGNED NULL,
    `parking_spaces` SMALLINT UNSIGNED NULL,
    `floors` SMALLINT UNSIGNED NULL,
    `area_size` DECIMAL(10,2) NULL,
    `area_unit` VARCHAR(20) NOT NULL DEFAULT 'Marla',
    `covered_area` DECIMAL(10,2) NULL,
    `lot_area` DECIMAL(10,2) NULL,
    `year_built` YEAR NULL,
    `furnished_status` ENUM('unfurnished','semi_furnished','furnished') NOT NULL DEFAULT 'unfurnished',
    `short_description` VARCHAR(500) NULL,
    `description` LONGTEXT NULL,
    `video_url` VARCHAR(255) NULL,
    `virtual_tour_url` VARCHAR(255) NULL,
    `agent_id` INT UNSIGNED NULL,
    `seo_title` VARCHAR(255) NULL,
    `seo_description` VARCHAR(500) NULL,
    `seo_keywords` VARCHAR(255) NULL,
    `views_count` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_by` INT UNSIGNED NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_properties_slug` (`slug`),
    KEY `idx_properties_search` (`purpose`,`status`,`is_published`,`property_type_id`,`city_id`),
    KEY `idx_properties_price` (`price`),
    KEY `idx_properties_featured` (`is_featured`,`is_published`),
    FULLTEXT KEY `ft_properties_text` (`title`,`short_description`),
    CONSTRAINT `fk_properties_type` FOREIGN KEY (`property_type_id`) REFERENCES `property_types`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_properties_city` FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_properties_area` FOREIGN KEY (`area_id`) REFERENCES `areas`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_properties_agent` FOREIGN KEY (`agent_id`) REFERENCES `agents`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_properties_creator` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `property_images` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `property_id` INT UNSIGNED NOT NULL,
    `media_id` INT UNSIGNED NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_primary` TINYINT(1) NOT NULL DEFAULT 0,
    CONSTRAINT `fk_property_images_property` FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_property_images_media` FOREIGN KEY (`media_id`) REFERENCES `media`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `property_features` (
    `property_id` INT UNSIGNED NOT NULL,
    `feature_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`property_id`,`feature_id`),
    CONSTRAINT `fk_property_features_property` FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_property_features_feature` FOREIGN KEY (`feature_id`) REFERENCES `features`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- services
-- ---------------------------------------------------------------------
CREATE TABLE `services` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(170) NOT NULL,
    `icon` VARCHAR(100) NULL,
    `short_description` VARCHAR(500) NULL,
    `description` TEXT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_services_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- testimonials
-- ---------------------------------------------------------------------
CREATE TABLE `testimonials` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `client_name` VARCHAR(150) NOT NULL,
    `photo_media_id` INT UNSIGNED NULL,
    `designation` VARCHAR(150) NULL,
    `content` TEXT NOT NULL,
    `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_testimonials_media` FOREIGN KEY (`photo_media_id`) REFERENCES `media`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- blog
-- ---------------------------------------------------------------------
CREATE TABLE `blog_categories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(120) NOT NULL,
    `slug` VARCHAR(140) NOT NULL,
    UNIQUE KEY `uq_blog_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tags` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(80) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    UNIQUE KEY `uq_tags_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_posts` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(220) NOT NULL,
    `slug` VARCHAR(240) NOT NULL,
    `author_id` INT UNSIGNED NULL,
    `category_id` INT UNSIGNED NULL,
    `featured_image_id` INT UNSIGNED NULL,
    `excerpt` VARCHAR(500) NULL,
    `content` LONGTEXT NULL,
    `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
    `seo_title` VARCHAR(255) NULL,
    `seo_description` VARCHAR(500) NULL,
    `published_at` DATETIME NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_blog_posts_slug` (`slug`),
    KEY `idx_blog_posts_status` (`status`,`published_at`),
    CONSTRAINT `fk_blog_posts_author` FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_blog_posts_category` FOREIGN KEY (`category_id`) REFERENCES `blog_categories`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_blog_posts_image` FOREIGN KEY (`featured_image_id`) REFERENCES `media`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blog_post_tags` (
    `blog_post_id` INT UNSIGNED NOT NULL,
    `tag_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`blog_post_id`,`tag_id`),
    CONSTRAINT `fk_blog_post_tags_post` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_blog_post_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- menus
-- ---------------------------------------------------------------------
CREATE TABLE `menus` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `location` ENUM('header','footer') NOT NULL DEFAULT 'header',
    `label` VARCHAR(100) NOT NULL,
    `url` VARCHAR(255) NOT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `target` VARCHAR(10) NOT NULL DEFAULT '_self',
    `parent_id` INT UNSIGNED NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    KEY `idx_menus_location` (`location`,`is_active`,`sort_order`),
    CONSTRAINT `fk_menus_parent` FOREIGN KEY (`parent_id`) REFERENCES `menus`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- pages / page_sections (lightweight page builder)
-- ---------------------------------------------------------------------
CREATE TABLE `pages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(140) NOT NULL,
    `title` VARCHAR(200) NOT NULL,
    `seo_title` VARCHAR(255) NULL,
    `seo_description` VARCHAR(500) NULL,
    `og_image_id` INT UNSIGNED NULL,
    `status` ENUM('draft','published') NOT NULL DEFAULT 'published',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_pages_slug` (`slug`),
    CONSTRAINT `fk_pages_og_image` FOREIGN KEY (`og_image_id`) REFERENCES `media`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `page_sections` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `page_id` INT UNSIGNED NOT NULL,
    `section_type` VARCHAR(50) NOT NULL,
    `heading` VARCHAR(255) NULL,
    `subheading` VARCHAR(500) NULL,
    `content` LONGTEXT NULL,
    `image_id` INT UNSIGNED NULL,
    `config` JSON NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    KEY `idx_page_sections_page` (`page_id`,`sort_order`),
    CONSTRAINT `fk_page_sections_page` FOREIGN KEY (`page_id`) REFERENCES `pages`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_page_sections_image` FOREIGN KEY (`image_id`) REFERENCES `media`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- inquiries / contact_messages
-- ---------------------------------------------------------------------
CREATE TABLE `inquiries` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `property_id` INT UNSIGNED NULL,
    `project_id` INT UNSIGNED NULL,
    `agent_id` INT UNSIGNED NULL,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(30) NULL,
    `email` VARCHAR(190) NULL,
    `message` TEXT NULL,
    `inquiry_type` ENUM('details','visit','whatsapp','call','general') NOT NULL DEFAULT 'general',
    `status` ENUM('new','contacted','closed') NOT NULL DEFAULT 'new',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_inquiries_status` (`status`,`created_at`),
    CONSTRAINT `fk_inquiries_property` FOREIGN KEY (`property_id`) REFERENCES `properties`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_inquiries_project` FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_inquiries_agent` FOREIGN KEY (`agent_id`) REFERENCES `agents`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contact_messages` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(190) NOT NULL,
    `phone` VARCHAR(30) NULL,
    `subject` VARCHAR(200) NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `is_contacted` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_contact_messages_read` (`is_read`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- login_attempts (rate limiting support)
-- ---------------------------------------------------------------------
CREATE TABLE `login_attempts` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(190) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `attempted_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY `idx_login_attempts_lookup` (`email`,`ip_address`,`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
