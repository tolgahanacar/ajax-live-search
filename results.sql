-- Database initialization script for livesearch
-- Table: results

CREATE DATABASE IF NOT EXISTS `livesearch` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `livesearch`;

DROP TABLE IF EXISTS `results`;

CREATE TABLE `results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `results` (`description`) VALUES
('HTML5 - HyperText Markup Language'),
('CSS3 - Cascading Style Sheets'),
('JavaScript - High-level programming language'),
('PHP - Hypertext Preprocessor'),
('MySQL - Relational Database Management System'),
('Python - Multi-purpose programming language'),
('Java - Object-oriented programming language'),
('React - JavaScript library for building user interfaces'),
('Vue.js - Progressive JavaScript framework'),
('Angular - Platform for building mobile and desktop web applications'),
('Node.js - JavaScript runtime environment'),
('Laravel - The PHP Framework for Web Artisans'),
('Git - Distributed version control system'),
('GitHub - Hosting service for software development version control'),
('jQuery - Fast, small, and feature-rich JavaScript library'),
('Bootstrap - Front-end open source toolkit'),
('AJAX - Asynchronous JavaScript and XML'),
('REST API - Representational State Transfer'),
('JSON - JavaScript Object Notation'),
('XML - Extensible Markup Language');
