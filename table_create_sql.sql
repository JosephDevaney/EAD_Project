CREATE TABLE `users` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `name` varchar(50) NOT NULL,
 `surname` varchar(50) NOT NULL,
 `email` varchar(100) NOT NULL,
 `password` varchar(50) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


--Pokemon
CREATE TABLE `ead_project`.`pokemon` ( `id` INT UNSIGNED NOT NULL COMMENT 'Usual Pokemon ID. 1: Bulbasaur etc' , `name` VARCHAR(30) NOT NULL , `height` INT NOT NULL , `weight` INT NOT NULL , `move1_id` INT NOT NULL , `move2_id` INT NOT NULL , `move3_id` INT NOT NULL , `move4_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;