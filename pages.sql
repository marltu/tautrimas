CREATE TABLE `pages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `url` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `lang` char(2) NOT NULL
) COMMENT='';
