SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS productRating;

CREATE DATABASE IF NOT EXISTS `productRating` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `productRating`;

-- table creation
CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `userName` varchar(255) NOT NULL,
                         `passwordHash` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `products` (
                            `id` int(11) NOT NULL,
                            `producer` varchar(255) NOT NULL,
                            `userId` int(11) NOT NULL,
                            `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ratings` (
                           `id` int(11) NOT NULL,
                           `userId` int(11) NOT NULL,
                           `productId` int(11) NOT NULL,
                           `rating` int(1) NOT NULL,
                           `comment` varchar(255) NULL,
                           `createdDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- primary keys
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`);

ALTER TABLE `products`
    ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

ALTER TABLE `ratings`
    ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `productId` (`productId`);;

-- auto incrementing ids
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `products`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `ratings`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `products`
    ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ratings`
    ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;