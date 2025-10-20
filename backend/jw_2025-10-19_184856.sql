CREATE TABLE `coordinates` (
    `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    `create_time` datetime DEFAULT NULL COMMENT 'Create Time',
    `name` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `publishers` varchar(255) DEFAULT NULL,
    `congregation` varchar(255) DEFAULT NULL,
    `longitude` varchar(255) DEFAULT NULL,
    `latitude` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4