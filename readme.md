# Calorie tracker

Just a quick thing I threw together. Remember to edit the db.php file for your environment and run the SQL listed below.

Beware: Spaghetti code :(

#### Database
``` 
DROP TABLE IF EXISTS `entries`;

CREATE TABLE `entries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `amount` bigint(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
