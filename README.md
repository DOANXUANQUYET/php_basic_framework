# php_basic_framework
php_basic_framework

cần config lại file :
config/config.php
config/database.php

database - table :

CREATE TABLE `tbl_post` (
`id_post` int(11) NOT NULL AUTO_INCREMENT,
`post_title` varchar(255) DEFAULT NULL,
`post_content` varchar(255) DEFAULT NULL,
`post_image` varchar(255) DEFAULT NULL,
`id_category_post` int(11) DEFAULT NULL,
PRIMARY KEY (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `tbl_category_post` (
`id_category_post` int(11) NOT NULL AUTO_INCREMENT,
`title_category_post` varchar(255) DEFAULT NULL,
`desc_category_post` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id_category_post`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `php_mvc`.`tbl_post`( `post_title`, `post_content`, `post_image`, `id_category_post`) VALUES ('sample12', 'test insert post', 'image 41642123335.jpg', 3);
INSERT INTO `php_mvc`.`tbl_category_post`(`title_category_post`, `desc_category_post`) VALUES ('technology', 'the methods for using scientific discoveries for practical purposes');
INSERT INTO `php_mvc`.`tbl_category_post`(`title_category_post`, `desc_category_post`) VALUES ('politics', 'the activities of the government, members of law-making organizations');
INSERT INTO `php_mvc`.`tbl_category_post`(`title_category_post`, `desc_category_post`) VALUES ('economic', 'relating to trade, industry, and money');
INSERT INTO `php_mvc`.`tbl_category_post`(`title_category_post`, `desc_category_post`) VALUES ('art', 'the making of objects, images, music, etc. that are beautiful');
INSERT INTO `php_mvc`.`tbl_category_post`(`title_category_post`, `desc_category_post`) VALUES ('entertainment', 'shows, films, television, or other performances or activities');


