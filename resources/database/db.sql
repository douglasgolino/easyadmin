CREATE DATABASE `easyadmin`;

USE `easyadmin`;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(16) NOT NULL default '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `comments` */

CREATE TABLE `comments` (
  `id` int(16) unsigned NOT NULL auto_increment,
  `domain_id` int(16) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `comment` text,
  `status` char(1) NOT NULL default '0',
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `contents` */

CREATE TABLE `contents` (
  `id` int(16) unsigned NOT NULL auto_increment,
  `domain_id` int(16) unsigned NOT NULL,
  `tag_title` varchar(130) NOT NULL,
  `tag_body` text,
  `status` char(1) NOT NULL default '0',
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `idx_domain_id` (`domain_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `domains` */

CREATE TABLE `domains` (
  `id` int(16) unsigned NOT NULL auto_increment,
  `url` varchar(120) NOT NULL,
  `subdomain` char(1) NOT NULL default '0',
  `theme` varchar(40) default NULL,
  `image_logo` varchar(40) default NULL,
  `tag_title` varchar(130) default NULL,
  `scripts_js` text,
  `tag_description` varchar(200) default NULL,
  `tag_keywords` varchar(200) default NULL,
  `facebook_like` text NOT NULL,
  `fixed_text` text,
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `poll_answers` */

CREATE TABLE `poll_answers` (
  `id` int(11) NOT NULL auto_increment,
  `poll_question_id` int(16) unsigned NOT NULL,
  `answer` varchar(255) NOT NULL,
  `votes` int(16) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `poll_questions` */

CREATE TABLE `poll_questions` (
  `id` int(16) NOT NULL auto_increment,
  `domain_id` int(16) unsigned NOT NULL,
  `question` varchar(255) NOT NULL,
  `status` char(1) NOT NULL default '0',
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` int(16) unsigned NOT NULL auto_increment,
  `login` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `last_access` datetime NOT NULL default '0000-00-00 00:00:00',
  `create_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

/* password: 123456 */
INSERT INTO `users` (`id`, `login`, `password`, `last_access`, `create_date`) VALUES
	(1, 'admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', '2012-02-15 14:02:55', NOW());