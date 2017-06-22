-- Adminer 4.2.5 MySQL dump
use 'app'


SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `like`;
CREATE TABLE `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `isDislike` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `like_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `content` varchar(500) CHARACTER SET armscii8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `post` (`id`, `user_id`, `title`, `content`) VALUES
(1,	3,	'First post!',	'This is my first post!'),
(6,	3,	'Second Post',	'This is my Second Post');

DROP TABLE IF EXISTS `right`;
CREATE TABLE `right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET armscii8 NOT NULL,
  `cancratecontent` tinyint(4) NOT NULL,
  `candeleteanycontent` tinyint(4) NOT NULL,
  `cancreateuser` tinyint(4) NOT NULL,
  `candeleteuser` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `right` (`id`, `name`, `cancratecontent`, `candeleteanycontent`, `cancreateuser`, `candeleteuser`) VALUES
(1,	'admin',	1,	1,	1,	1);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `right_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isActivated` tinyint(4) NOT NULL,
  `activationCode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `right_id` (`right_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`right_id`) REFERENCES `right` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `right_id`, `email`, `password`, `isActivated`, `activationCode`) VALUES
(3,	1,	'Ofaso.1234567890@gmail.com',	'$2y$10$yXFHsEZaJt7aqD06nzUXE.6q7b.hx2MpumJpa6.wS3aXD8BulABcW',	1,	'jnv1DOwHWWRLoGqk'),
(4,	1,	'mario.gwerder@gmail.com',	'$2y$10$8H0wdWJL28dA7/Z6kUhQeex8MLmXHsnMo6FIwfbI9Q.iyCqlNy8Xy',	1,	'DCj006wBPe2Q5Gv5');

-- 2017-06-22 08:16:15
