-- Voorivex Weblog Backup - 2025-05-28 13:45:47

DROP TABLE IF EXISTS categories;
CREATE TABLE `categories` (
  `categories_id` int NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(255) NOT NULL,
  `ategory_description` varchar(2000) NOT NULL,
  PRIMARY KEY (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO categories VALUES
("1","Security","The post about securty field"),
("2","Programming","The post are about programming.");

DROP TABLE IF EXISTS post_tags;
CREATE TABLE `post_tags` (
  `post_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS posts;
CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `publication_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO posts VALUES
("1","slmslm","slm","17","2","2025-05-22 19:13:31"),
("2","ali is kharre","mn ye parandammm arezo drm to yarm bashi","17","1","2025-05-22 19:50:33"),
("3","hi mamad","mn einjam ke begam yes i can do this","17","1","2025-05-26 11:48:21"),
("4","samane","oskoli?یییی","1","1","2025-05-26 13:15:37");

DROP TABLE IF EXISTS tags;
CREATE TABLE `tags` (
  `tag_id` int NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `bio` varchar(2000) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`,`password`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO users VALUES
("1","voorivex","y.shahinzadeh@gmail.com","yashar","shahin","hacker","123","","2025-05-09 11:33:53","0"),
("2","macan","macan@example.com","mamad","yekta","hi","P@ssword","f4d859830795e7d929bc2a5c24d94193","2025-05-10 23:20:37","0"),
("3","testuser","test@example.com","","","","123456","","2025-05-10 23:20:37","0"),
("4","admin","admin@example.com","","","","adminpass","628f4c022a03869f33720dbf55bbd90a","2025-05-10 23:20:37","1"),
("9","test1","test@test.com","","","","test","","2025-05-11 23:28:31","0"),
("10","test","ssd","","","","ddf","","2025-05-12 01:04:15","0"),
("11","aaa","aaa","","","","aaa","","2025-05-12 01:04:36","0"),
("12","test2","test2@gmail.com","","","","test1","","2025-05-12 16:34:28","0"),
("13","asali","","","","","","","2025-05-12 18:24:59","0"),
("17"," webmacan","sdfghjkl","","","","1234","","2025-05-14 00:15:15","0");

