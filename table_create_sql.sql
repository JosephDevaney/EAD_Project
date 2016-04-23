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
CREATE TABLE `pokemon` (
 `id` int(10) unsigned NOT NULL COMMENT 'Usual Pokemon ID. 1: Bulbasaur etc',
 `name` varchar(30) NOT NULL,
 `height` int(11) NOT NULL,
 `weight` int(11) NOT NULL,
 `hp` int(11) NOT NULL,
 `move1_id` int(11) NOT NULL,
 `move2_id` int(11) DEFAULT NULL,
 `move3_id` int(11) DEFAULT NULL,
 `move4_id` int(11) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1

--Moves
CREATE TABLE `ead_project`.`moves` ( `move_id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `move_name` VARCHAR(30) NOT NULL , `accuracy` INT NOT NULL , `pp` INT NOT NULL , `power` INT NOT NULL , PRIMARY KEY (`move_id`)) ENGINE = InnoDB;
