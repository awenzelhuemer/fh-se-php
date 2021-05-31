SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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
(2, 1, 2, 4, 'Works good!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(3, 1, 3, 3, 'Works perfectly, some parts are missing!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(4, 1, 4, 4, 'Works fine!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(5, 1, 5, 5, 'Works perfectly!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(6, 1, 6, 5, 'Works perfectly!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(7, 1, 7, 2, 'Not working!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(8, 1, 7, 2, 'Not good at all!', NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(9, 1, 7, 1, NULL, NOW());
INSERT INTO `ratings` (`id`, `userId`, `productId`, `rating`, `comment`, `createdDate`) VALUES
(10, 1, 8, 1, 'Total crap!', NOW());
COMMIT;
