CREATE TABLE `users` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `name` varchar(50) NOT NULL,
 `surname` varchar(50) NOT NULL,
 `email` varchar(100) NOT NULL,
 `password` varchar(50) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1