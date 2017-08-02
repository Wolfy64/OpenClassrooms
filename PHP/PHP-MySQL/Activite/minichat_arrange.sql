-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 28, 2017 at 12:17 AM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `activite`
--

-- --------------------------------------------------------

--
-- Table structure for table `minichat_arrange`
--

CREATE TABLE `minichat_arrange` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL COMMENT 'pseudo de l''utilisateur',
  `date_message` datetime NOT NULL COMMENT 'date et heure du message',
  `message` varchar(255) NOT NULL COMMENT 'message de l''utilisateur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `minichat_arrange`
--

INSERT INTO `minichat_arrange` (`id`, `pseudo`, `date_message`, `message`) VALUES
(411, 'Mathieu', '2017-05-27 23:55:41', 'Bonjour !'),
(412, 'Tom', '2017-05-27 23:56:06', 'Salut toi !'),
(413, 'Mathieu', '2017-05-27 23:57:05', 'Ca va Tom ?'),
(414, 'Tom', '2017-05-27 23:58:14', 'Ben ouais ça fait un bail qu\'on s\'est pas vu !'),
(415, 'Tom', '2017-05-27 23:58:52', 'Au moins 2 jours !!!'),
(416, 'Mathieu', '2017-05-27 23:59:57', 'Oui je n\'ai pas eu besoins de GPS ces jours ci'),
(417, 'Tom', '2017-05-28 00:01:45', 'Tu me rassures car je balise avec Waze'),
(418, 'Mathieu', '2017-05-28 00:04:45', 'Faut avoué c\'est top Waze ;-)'),
(419, 'Waze', '2017-05-28 00:05:39', 'Besoins d\'un itinéraire ?'),
(420, 'Tom', '2017-05-28 00:06:26', 'Pfff je me met en veille...'),
(421, 'Mathieu', '2017-05-28 00:07:10', 'TomTom revient.... !');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `minichat_arrange`
--
ALTER TABLE `minichat_arrange`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `minichat_arrange`
--
ALTER TABLE `minichat_arrange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
