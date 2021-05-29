SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP DATABASE productRating;

CREATE DATABASE IF NOT EXISTS `productRating` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;
USE `productRating`;

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `userName` varchar(255) NOT NULL,
                         `passwordHash` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
(1, 'scr4', '$2y$10$0dhe3ngxlmzgZrX6MpSHkeoDQ.dOaceVTomUq/nQXV0vSkFojq.VG');

ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userName` (`userName`);

ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;