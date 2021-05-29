SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE productRating;

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
                           `createdDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- seeding
INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
(1, 'scr4', '$2y$10$0dhe3ngxlmzgZrX6MpSHkeoDQ.dOaceVTomUq/nQXV0vSkFojq.VG');

INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(1, 'Bosch', 1, 'Schlagbohrmaschine GSB 13 RE');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(2, 'Bosch', 1, 'Schlagbohrmaschine EasyImpact 550');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(3, 'Tilswall', 1, 'Schlagbohrmaschine 3000');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(4, 'Bosch', 1, 'Bosch Schlagbohrmaschine UniversalImpact');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(5, 'Einhell', 1, 'Schlagbohrmaschine TC-ID 650E');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(6, 'Makita', 1, 'Schlagbohrmaschine HP1631');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(7, 'Makita', 1, 'Kombihammer SDS-Plus');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(8, 'Metabo', 1, 'Schlagbohrmaschine SBEV 1000-2');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(9, 'Hi-Spec', 1, 'Akkubohrmaschinenset');
INSERT INTO `products` (`id`, `producer`, `userId`, `name`) VALUES
(10, 'Bosch', 1, 'Schlagbohrmaschine GSP 19-2 RE');

INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(1, 1, 1, 5, 'Works perfectly!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(2, 1, 1, 4, 'Works good!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(3, 1, 1, 3, 'Works perfectly, some parts are missing!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(4, 1, 1, 4, 'Works fine!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(5, 1, 1, 5, 'Works perfectly!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(6, 1, 1, 5, 'Works perfectly!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(7, 1, 1, 2, 'Not working!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(8, 1, 1, 2, 'Not good at all!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(9, 1, 1, 1, NULL, NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(10, 1, 1, 1, 'Total crap!', NOW());

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