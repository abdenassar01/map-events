-- phpMyAdmin SQL Dump
-- version 5.2.1-1.fc38
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 08, 2023 at 08:32 AM
-- Server version: 8.0.33
-- PHP Version: 8.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `map_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `path` varchar(1024) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `size` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

CREATE TABLE `departement` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departement`
--

INSERT INTO `departement` (`id`, `name`) VALUES
(2, 'Bénoué'),
(3, 'MayoRey'),
(4, 'Faro'),
(5, 'MayoDanay'),
(6, 'MayoSava'),
(7, 'MayoKani'),
(8, 'SanagaMaritime'),
(9, 'Mifi'),
(10, 'Diamaré'),
(11, 'FaroetDéo'),
(12, 'Djerem'),
(13, 'MayoBanyo'),
(14, 'Mbéré'),
(15, 'Vina'),
(16, 'HauteSanaga'),
(17, 'MefouetAkono'),
(18, 'Lekié'),
(19, 'MbametKim'),
(20, 'MbametInoubou'),
(21, 'MefouetAfamba'),
(22, 'NyongetKéllé'),
(23, 'Mfoundi'),
(24, 'NyongetSo\'o'),
(25, 'NyongetMfoumou'),
(26, 'BoumbaetNgoko'),
(27, 'HautNyong'),
(28, 'Kadey'),
(29, 'LometDjerem'),
(30, 'MayoTsanaga'),
(31, 'LogoneetChari'),
(32, 'Wouri'),
(33, 'MayoLouti'),
(34, 'Moungo'),
(35, 'Nkam'),
(36, 'Momo'),
(37, 'Bamboutos'),
(38, 'NgoKetunjia'),
(39, 'Boyo'),
(40, 'Bui'),
(41, 'HautsPlateaux'),
(42, 'DongaMantung'),
(43, 'Menchum'),
(44, 'KoungKhi'),
(45, 'Mezam'),
(46, 'HautNkam'),
(47, 'Menoua'),
(48, 'Fako'),
(49, 'DjaetLobo'),
(50, 'Ndé'),
(51, 'ValléeduNtem'),
(52, 'Noun'),
(53, 'Mvila'),
(54, 'Océan'),
(55, 'KoupéManengouba'),
(56, 'Manyu'),
(57, 'Lebialem'),
(58, 'Meme'),
(59, 'Ndian');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int NOT NULL,
  `departement_id` int DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(2555) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'unapproved',
  `lng` double DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `start_time` date DEFAULT NULL,
  `end_time` date DEFAULT NULL,
  `date_created` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `departement_id`, `title`, `description`, `type`, `image`, `status`, `lng`, `lat`, `user_id`, `start_time`, `end_time`, `date_created`) VALUES
(1, 49, 'title event', '<h4><font face=\"sans-serif\">Description</font></h4><span style=\"</div\"></span>', 'liberation', 'image.jpg', 'approved', 12.453002929688, 2.7952276914617, 2, '2023-04-29', '2023-06-21', '2023-05-01'),
(2, 27, 'title', '\r\n                    hjsggakj                <p><br></p><h3><font face=', 'culture', 'image.jpg', 'approved', 14.188842773438, 2.9050467245281, 2, '2023-04-29', '2023-04-30', '2023-05-01'),
(32, 37, 'This is the Title', 'description', 'liberation', '', 'approved', 10.195999145507814, 5.651518917890183, 2, '2023-04-06', '2023-04-30', '2023-05-10'),
(33, 20, 'This is title', 'this is a description', 'culture', 'image.jpg', 'approved', 11.076965332031, 4.9207753626958, 2, '2023-04-30', '2023-05-18', '2023-05-01'),
(34, 46, 'befang', 'Tseesstag', 'autre', 'image.jpg', 'approved', 10.102615356445314, 5.1315379941197765, 2, '2023-04-30', '2023-05-26', '2023-05-01'),
(35, 3, 'new event', 'test', 'compagne', 'image.jpg', 'approved', 14.738159179688, 8.0905532733866, 2, '2023-05-03', '2023-05-26', '2023-05-01'),
(36, 19, 'noun event', '<h4><font face=', 'compagne', 'image.jpg', 'approved', 11.252059936523, 5.5488725164011, 2, '2023-05-02', '2023-05-24', '2023-05-01'),
(37, 19, 'title event', '<h2><font face=\"sans-serif\">Description Title</font></h2><p><font face=\"sans-serif\"><br></font></p><p><font face=\"sans-serif\">description content</font></p>', 'autre', 'image.jpg', 'approved', 11.294631958007814, 5.372423395159833, 2, '2023-05-02', '2023-05-25', '2023-05-01'),
(38, 29, 'new event', '<h5><font face=', 'compagne', 'image.jpg', 'approved', 14.021301269531252, 5.680182266547986, 2, '2023-05-02', '2023-05-12', '2023-05-01'),
(39, 27, 'Event', 'Welcome event', 'culture', 'image.jpg', 'approved', 13.353881835937502, 2.905046724528068, 2, '2023-05-27', '2023-06-01', '2023-05-01'),
(40, 38, 'Réunion publique', 'Hello world', 'liberation', 'image.jpg', 'approved', 10.544815063476562, 5.85366127073939, 2, '2023-05-04', '2023-05-27', '2023-05-01'),
(41, 19, 'Réunion de boucle départementale', 'Description&nbsp;', 'compagne', 'image.jpg', 'approved', 11.36192321777344, 5.794894566979694, 2, '2023-05-04', '2023-05-12', '2023-05-01'),
(42, 27, 'title', '\r\n                    hjsggakj                <p><br></p><h3><font face=', 'culture', 'image.jpg', 'approved', 14.188842773438, 2.9050467245281, 2, '2023-04-29', '2023-04-30', '2023-05-01'),
(43, 27, 'title', '\r\n                    hjsggakj                <p><br></p><h3><font face=', 'culture', 'image.jpg', 'approved', 14.188842773438, 2.9050467245281, 2, '2023-04-29', '2023-04-30', '2023-05-01'),
(44, 27, 'title', '\r\n                    hjsggakj                <p><br></p><h3><font face=', 'culture', 'image.jpg', 'approved', 14.188842773438, 2.9050467245281, 2, '2023-04-29', '2023-04-30', '2023-05-01'),
(45, 19, 'Réunion de boucle départementale', 'Description&nbsp;', 'compagne', 'image.jpg', 'approved', 11.36192321777344, 5.794894566979694, 2, '2023-05-04', '2023-05-12', '2023-05-10'),
(46, 19, 'Réunion de boucle départementale', 'Description ', 'compagne', 'image.jpg', 'approved', 11.909866333007814, 5.891886920119309, 2, '2023-05-04', '2023-05-12', '2023-05-01'),
(47, 19, 'Réunion de boucle départementale', 'Description ', 'culture', 'image.jpg', 'approved', 11.532211303711, 5.4817883938508, 2, '2023-05-04', '2023-05-12', '2023-05-01'),
(48, 19, 'Réunion de boucle départementale', 'Description ', 'autre', 'image.jpg', 'approved', 11.688766479492, 5.5542602289641, 2, '2023-05-04', '2023-05-12', '2023-05-01'),
(49, 19, 'Réunion de boucle départementale', 'Description ', 'autre', 'image.jpg', 'approved', 11.911239624023, 6.1596557729755, 2, '2023-05-04', '2023-05-12', '2023-05-01'),
(50, 19, 'Réunion de boucle départementale', 'Description ', 'liberation', 'image.jpg', 'approved', 11.459426879883, 5.2520087544708, 2, '2023-05-04', '2023-05-12', '2023-05-01'),
(51, 37, 'Réunion de boucle départementale', 'Réunion de boucle départementale\r\n                                    <p><br></p><p>Description Réunion de boucle départementale<br></p>', 'culture', 'image.jpg', 'approved', 10.473403930664062, 5.700581748475489, 2, '2023-05-12', '2023-05-26', '2023-05-01'),
(52, 54, 'Latest event should appear', 'helloooow', 'compagne', '', 'approved', 10.008544921875, 2.6138389710985, 2, '2023-05-03', '2023-05-27', '2023-05-06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`, `name`, `lastname`) VALUES
(1, 'user@mail.com', '$2y$10$EbVZX8X7tiDvMx/R3Shv9Ojt4.abkJYrnaW6Oag/eq6xH46vTjC.K', 'USER', 'amimi', 'abde'),
(2, 'admin@mail.com', '$2y$10$9FbrOMz4JxB39bQT4b/KeuY39Vffn2bN2Mxk4qfPvXaeDeXKf4NyK', 'ADMIN', 'ABDENASSAR', 'AMIMI');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_event_id` (`event_id`);

--
-- Indexes for table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_departement_id` (`departement_id`),
  ADD KEY `FK_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departement`
--
ALTER TABLE `departement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `FK_event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_departement_id` FOREIGN KEY (`departement_id`) REFERENCES `departement` (`id`),
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
