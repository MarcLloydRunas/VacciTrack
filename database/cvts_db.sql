-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2022 at 06:20 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cvts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `username`, `activity`, `date`) VALUES
(156, 'shamela', 'Added a new record for Carl Runas at RHU-Tuba', '2022-07-18 10:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `health_declaration`
--

CREATE TABLE `health_declaration` (
  `id` int(11) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `suffixes` varchar(255) NOT NULL,
  `conditions` varchar(255) NOT NULL,
  `medical_allergies` varchar(255) NOT NULL,
  `tobacco_history` varchar(255) NOT NULL,
  `illegal_drugs` varchar(255) NOT NULL,
  `alcohol_consumption` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `health_declaration`
--

INSERT INTO `health_declaration` (`id`, `id_number`, `last_name`, `first_name`, `middle_name`, `suffixes`, `conditions`, `medical_allergies`, `tobacco_history`, `illegal_drugs`, `alcohol_consumption`) VALUES
(1, '1852889667', 'Rafols', 'Jarmie Mae', 'Laciste', '', 'Hepatitis,Anxiety/Stress/Depression,Stomach/Esophagus/Digestion', '', 'No', 'No', 'No'),
(2, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', 'Asthma/Emphysema/COPD,', 'Unsure', 'No', 'No', 'No'),
(3, '2409295845', 'Runas', 'Marc', 'Sahoy', '', 'Pituitary/Adrenal,Infertility', 'No', 'No', 'No', 'No'),
(4, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'High Blood Pressure,Down\'s Syndrome,Kidney/Bladder/Urinary', 'No', 'No', 'No', 'No'),
(6, '2355996825', 'Runas', 'Earl', 'Lloyd', '', 'Chronic Fatigue, Cleft Palate, Infertility, Sickle Cell Anemia, Emphysema/ Pulmonary, Liver/ Spleen/ Pancreas, Stomach/ Esophagus/ Digestion, Multiples Clerosis', 'No', 'No', 'No', 'No'),
(7, '953897514', 'Viray', 'Ramses', 'Vicente', '', 'Infertility, Stomach/ Esophagus/ Digestion, Mental/ Emotional/ Nervous', 'No', 'No', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `Filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `Filename`) VALUES
(1, 'DTI2.jpg'),
(2, 'copyright.png'),
(3, 'copyright.png');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `image` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `name`, `image`) VALUES
(1, 'Screenshot (9).png', 'upload/Screenshot (9).png'),
(2, 'Screenshot (8).png', 'upload/Screenshot (8).png'),
(3, 'Municipal Permit .jpg', 'upload/Municipal Permit .jpg'),
(4, 'copyright.png', 'upload/copyright.png'),
(5, 'Screenshot (56).png', 'upload/Screenshot (56).png');

-- --------------------------------------------------------

--
-- Table structure for table `past_imm`
--

CREATE TABLE `past_imm` (
  `id` int(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `past_vacc` varchar(255) NOT NULL,
  `vacc_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `past_imm`
--

INSERT INTO `past_imm` (`id`, `id_number`, `first_name`, `past_vacc`, `vacc_year`) VALUES
(129, '', 'Jarmie Mae', 'BCG', '2002'),
(130, '1852889667', 'Jarmie Mae', 'Pfizer', '2021'),
(131, '953897514', 'Ramses', 'MEASLES, MUMPS, RUBELLA', ''),
(132, '953897514', 'Ramses', 'ORAL POLIO VACCINE', ''),
(137, '769280378', 'Carl', 'Pfizer', '2021'),
(138, '953897514', 'Ramses', 'Pfizer', '2021'),
(139, '769280378', 'Carl', 'Pfizer', '2022');

-- --------------------------------------------------------

--
-- Table structure for table `pie_graph`
--

CREATE TABLE `pie_graph` (
  `id` int(255) NOT NULL,
  `vaccination_site` varchar(255) NOT NULL,
  `entries` int(255) NOT NULL,
  `percent_of_total` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pie_graph`
--

INSERT INTO `pie_graph` (`id`, `vaccination_site`, `entries`, `percent_of_total`) VALUES
(1, 'RHU-Benguet', 3, '30'),
(2, 'San Pascual Clinic', 6, '40'),
(3, 'Asin Clinic', 7, '20'),
(4, 'Nangalisan Clinic', 6, '30');

-- --------------------------------------------------------

--
-- Table structure for table `public_user`
--

CREATE TABLE `public_user` (
  `id` int(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `suffixes` varchar(255) NOT NULL,
  `birth_date` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `address_permanent` varchar(255) NOT NULL,
  `address_current` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `mother_last_name` varchar(255) NOT NULL,
  `mother_first_name` varchar(255) NOT NULL,
  `mother_middle_name` varchar(255) NOT NULL,
  `father_last_name` varchar(255) NOT NULL,
  `father_first_name` varchar(255) NOT NULL,
  `father_middle_name` varchar(255) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `public_user`
--

INSERT INTO `public_user` (`id`, `id_number`, `last_name`, `first_name`, `middle_name`, `suffixes`, `birth_date`, `sex`, `address_permanent`, `address_current`, `contact_number`, `email_address`, `mother_last_name`, `mother_first_name`, `mother_middle_name`, `father_last_name`, `father_first_name`, `father_middle_name`, `date_added`) VALUES
(36, '1852889667', 'Rafols', 'Jarmie Mae', 'Laciste', '', '1999-07-20', 'female', '#86 Upper Sto. Rosario Valley, B.C', '#86 Upper Sto. Rosario Valley, B.C', '0956594835', 'jarmaerafols@gmail.com', 'Rafols', 'Jevy', 'Laciste', 'N/A', 'N/A', 'N/A', '2022-03-17'),
(37, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', '2000-03-18', 'male', 'DB-38 Camp Dangwa La Trinidad Benguet', 'DB-38 Camp Dangwa La Trinidad Benguet', '09195453239', 'joshcodiamat@gmail.com', 'Angagan', 'Flordeliza', 'O-lao', 'Codiamat', 'Chester', 'Alingcotan', '2022-03-17'),
(38, '2409295845', 'Runas', 'Marc', 'Sahoy', '', '2000-09-01', 'male', 'Poblacion, Tuba, Benguet', 'Poblacion, Tuba, Benguet', '09196896992', 'marcsahoy477@gmail.com', 'Sahoy', 'Lorna', 'Estolas', 'Runas', 'Robert', 'Borcio', '2022-03-17'),
(39, '769280378', 'Runas', 'Carl', 'Sahoy', '', '2004-01-09', 'male', 'Nangalisan, Tuba, Benguet', 'Nangalisan, Tuba, Benguet', '09289223750', 'karl@gmail.com', 'Sahoy', 'Lorna', 'Estolas', 'Runas', 'Robert', 'Borcio', '2022-03-17'),
(40, '1719988263', 'Runas', 'Culovet Joy', 'Sito', '', '2011-12-07', 'female', 'Poblacion, Tuba, Benguet', 'Poblacion, Tuba, Benguet', '09123456789', 'cutelove@gmail.com', 'Sito', 'Jelina', 'Patras', 'Runas', 'Roben', 'Borcio', '2022-03-21'),
(41, '2355996825', 'Runas', 'Earl', 'Lloyd', '', '2004-01-09', 'male', '#08 Upper Poblacion Tuba Benguet', '009 Upper Poblacion Tuba, Benguet', '+639167433477', 'marcsahoy@gmail.com', 'Sahoy', 'Lorna', 'Estolas', 'Runas', 'Robert', 'Borcio', '2022-04-02'),
(44, '953897514', 'Viray', 'Ramses', 'Vicente', '', '1988-05-25', 'male', 'Poblacion, Tuba, Benguet', 'Poblacion, Tuba, Benguet', '09167433477', 'ramsesvi@gmail.com', 'Runas', 'Brenda', 'Borcio', 'Viray', 'Romeo', 'Vicente', '2022-04-04');

-- --------------------------------------------------------

--
-- Table structure for table `stat_graph`
--

CREATE TABLE `stat_graph` (
  `id` int(11) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `entries` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stat_graph`
--

INSERT INTO `stat_graph` (`id`, `vaccine_name`, `entries`) VALUES
(1, 'Pfizer', '10'),
(2, 'Moderna', '24'),
(3, 'Astra Zeneca', '7'),
(4, 'Sinovac', '18');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) NOT NULL,
  `account_type` varchar(30) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `site_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `username`, `password`, `last_name`, `first_name`, `middle_name`, `account_type`, `date_added`, `site_name`) VALUES
(13, 'joshue', '$2y$10$rFKeYJGQ6js0YnDjhMC8x.RtLY3e8p28DukwZSVmFDmvJX.OiK/Me', 'Codiamat', 'Joshue', 'A', 'admin', '2022-02-08', 'RHU-Benguet'),
(14, 'test', '$2y$10$RK3IWxPdczM6E7Hh/rF0LeGkaySx5EV7x7CgTd37.yo84e0r4wRR.', 'Yan', 'Test', 'Lang', 'admin', '2022-02-08', 'RHU-Benguet'),
(15, 'marc', '$2y$10$p0tx0etfUMtGXSOUcYvi2eOOD9fYuLH6s6jD63fAvNhsBXV.1cIuy', 'Runas', 'Marc', 'Sahoy', 'admin', '2022-02-09', 'RHU-Tuba'),
(16, 'jarmie', '$2y$10$5YdjjyEGhYhP0vA5L.KO2.Gg03d9T.sDdpeQHmY9WDqL7aH1cUmAG', 'Rafols', 'Jarmie', 'Lac', 'admin', '2022-02-09', 'Asin - Clinic'),
(17, 'rjs123', '$2y$10$2LQm9xe7zxAajDkZKTy2r.H0zekxDIS/EDZZX7S8U.wltnGTlPGw2', 'Runas', 'Raybert', 'Sahoy', 'user', '2022-02-09', 'Clinic Apni'),
(18, 'mackytotzky', '$2y$10$2nUDKzXNkUNvmuUWWAmmwOv9qKAjsYCg26Rb7kRuKvkwnfW6TyT6u', 'Viray', 'Dimples', 'Runas', 'admin', '2022-02-09', 'RHU-Benguet'),
(35, 'yayiyo', '$2y$10$aJv.0.eYhQ082J70sJHFmewIvoUgo/6XIGnEh5bZxQfanDrH5ZG3W', 'yi', 'yasuo', 'ya', 'user', '2022-03-05', 'Clinic San Pascual'),
(37, 'nikita477', '$2y$10$nCyAdvAvx0GgBqanlPKMP.GAXJ8FDEcGGVZzuDxUQx8FJXaaT4lvi', 'Licuben', 'Nikita', 'Anderson', 'Select', '2022-03-17', 'Asin - Clinic'),
(38, 'nikita', '$2y$10$9R8Y/d/XjnKHdNJWVqOKCOIp1V1SahrNWLXigBgRwnFJ.o2YSCnxS', 'Licuben', 'nikita', 'Anderson', 'user', '2022-03-17', 'Asin - Clinic'),
(39, 'joshue123', '$2y$10$QMCePJ.V.eh1gfwRci2YZO7CoeKD4h.QnF0emn10Cha7cllnW/2Lu', 'Codiamat', 'Joshue', 'hsadhjsad', 'user', '2022-03-17', 'Asin - Clinic'),
(40, 'valdez', '$2y$10$3gFWf8dJeiXCBUt2zqw4VOHWPYtZoowJFyQK6cYl9hxgA4oA09zzG', 'Doclas', 'Shamela', 'Mansano', 'user', '2022-03-18', 'RHU-Tuba'),
(41, 'mackytotz', '$2y$10$opH7Hw81KAbKKVgc0Qf4We.MG5wZN0TC6Fl.ramYZLv9y.MszwnX2', 'Runas', 'Marc', 'Sahoy', 'user', '2022-03-21', 'RHU-Tuba'),
(42, 'latesttest2', '$2y$10$Aa/RN19LiKn1PYtJq2OQreIp0Iyg9XX4iLmBQhs6AEU/cG2YT9FYe', 'Caluza', 'Jarmie', 'Sito', 'user', '2022-03-27', 'Nangalisan - Clinic'),
(43, 'rayray', '$2y$10$.ojpnV78E3DB2clwSZa1FuumX3cxh0zwl3V/ObrlowmJ5KJ/c8QiO', 'Caluza', 'Jarmie', 'Sito', 'user', '2022-03-29', 'RHU-Tuba'),
(44, 'raybertjades', '$2y$10$fOIzPRaXvr2A2FYXidtV2ukAooIBWjmlSToYNleNRfY1QVpuRXsbq', 'Runas', 'Joan', 'Sahoy', 'user', '2022-03-29', 'Nangalisan - Clinic'),
(45, 'marc1234', '$2y$10$wOwaxbgUvChN/W8iwtsTLe1JuruzjMJxxgvtvGrJyyPpksNqYPz9q', 'Runas', 'Joan', 'Sito', 'user', '2022-03-30', 'Nangalisan - Clinic'),
(46, 'raybert123', '$2y$10$qa2qe.8XduknSoTPy27CeOUUI1EpfAH/RQg7CzHNxMLA4ZTj8jD0u', 'Caluza', 'Culovet Joy', 'Sahoy', 'user', '2022-03-30', 'RHU-Tuba'),
(47, 'rayvert777jade', '$2y$10$rbamm7CMBbw18MiuWwCbvezwRXq/Zrsf0YcTuzABEJ61pEkOwxuAa', 'Runas', 'Joan', 'Sahoy', 'user', '2022-03-30', 'RHU-Tuba'),
(48, 'raybert00000jade', '$2y$10$oHJHoh4rGOt4m3NWoNH74eLHiu/w6PfBJmYSicG/5KuFCERzgnqum', 'Caluza', 'Culovet Joy', 'Laciste', 'user', '2022-03-30', 'San Pascual - Clinic'),
(49, 'jarmraf', '$2y$10$oGqGr6tGmK/D/wSmsHRAbe3qd8jxo2Da2hcnUH6fXk3cItgYQRRVi', 'Rafols', 'Jarmie', 'Laciste', 'user', '2022-03-30', 'Nangalisan - Clinic'),
(50, 'latesttest', '$2y$10$hxCMnPLJpEf1jJr5tOv4pef6msyUX.hnvFItllEr3YOjTEAIL1MI.', 'Runas', 'Joan', 'Sito', 'user', '2022-04-12', 'Nangalisan - Clinic'),
(51, 'dimdim345', '$2y$10$ZsiU9XWExlZNlQrdY9fXaeCE2uab4n455sRZHyt13ju9mDEpRKgtm', 'Viray', 'Dimples', 'Runas', 'user', '2022-04-19', 'Nangalisan - Clinic'),
(52, 'joshue477', '$2y$10$aoObvCN.Qj0EJJthQ9bckeZUggS0cPH8JI5we/6FoJtilY60vEg5G', 'Codiamat', 'Joshue', 'something', 'user', '2022-07-18', 'Asin - Clinic'),
(53, 'lol123', '$2y$10$wVGS/UciNYDohwvL9/h0CuQzZ/cMNJ/E373qw6LJXkdoW3F/iNuqq', 'Runas', 'Marc', 'Lloyd', 'user', '2022-07-19', 'Nangalisan - Clinic');

-- --------------------------------------------------------

--
-- Table structure for table `user_request`
--

CREATE TABLE `user_request` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `photoID` varchar(255) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `contact` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_request`
--

INSERT INTO `user_request` (`id`, `first_name`, `middle_name`, `last_name`, `username`, `site_name`, `account_type`, `photoID`, `date_added`, `contact`, `password`) VALUES
(150, 'Marc', 'Lloyd', 'Runas', 'lalaparuza', 'Nangalisan - Clinic', 'user', 'Municipal Permit .jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$.xVYQFOxEOqNLKyWFiS7.uauHSnE.zn9O/lCkBrVwKK6ab6kncO7O'),
(151, 'Marc', 'Lloyd', 'Runas', 'lalaparuza1', 'Asin - Clinic', 'user', 'Municipal Permit .jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$84Cd.AJQDk6ucU4DTKg9COl8SrvmAwud.T1K39CbeywPd4UWqnGBy'),
(152, 'Marc', 'Lloyd', 'Runas', 'lalaparuza123', 'Nangalisan - Clinic', 'user', 'Municipal Permit .jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$4cuIAs5DbLdc6xbpzQiurO4SyumZ3BfNZxSDtgzmdBmucphFU.gSm'),
(153, 'Marc', 'Lloyd', 'Runas', 'lalaparuza1234', 'San Pascual - Clinic', 'user', 'Municipal Permit .jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$P6SgY98TE054CVwl6Iz2xu0Pjb9PDNbCL4Nbab1nnmf2IX9x1wUKK'),
(154, 'Marc', 'Lloyd', 'Runas', 'lalaparuza12345', 'San Pascual - Clinic', 'user', 'ketopedia.jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$nqyehdZPuV0/vRUhnbjpieDnMa8IWXZ4uyHAAz1Ws7WeZCtjxQHOS'),
(155, 'Marc', 'Lloyd', 'Runas', 'lalaparuza123456', 'Nangalisan - Clinic', 'user', 'ketopedia.jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$Rd/TljVxbODxUMz.sT22ReH3dt/DNirPhUMMMMv7y2R2e8FaE3OI.'),
(156, 'Marc', 'Lloyd', 'Runas', 'lalaparuza1234567', 'San Pascual - Clinic', 'user', 'Municipal Permit .jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$mb94ob5sJkXb3ir/P3OkHu9k8dHC7vP5wgQ7OFAWAnozIyU2ZJrkO'),
(157, 'Marc', 'Lloyd', 'Runas', 'lalaparuza12345675', 'Nangalisan - Clinic', 'user', 'ketopedia.jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$taJs.Q7Me0t7/ep02uiMI.fDDI9ll5mmoQd00aDe9okSxSoN/88iS'),
(158, 'Marc', 'Lloyd', 'Runas', 'lalaparuza11111', 'San Pascual - Clinic', 'user', 'ketopedia.jpg', '2022-07-19', 'marcsahoy@gmail.com', '$2y$10$DtAiL72fuicaagE.VCoff.suNHKzKzAo30mw8/tkT0SWbdxDtr1.6');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_record`
--

CREATE TABLE `vaccination_record` (
  `id` int(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `suffixes` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `current_age` varchar(255) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `dose` varchar(255) NOT NULL,
  `vaccine_date` date NOT NULL DEFAULT current_timestamp(),
  `site_name` varchar(255) NOT NULL,
  `serial_code` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `symptoms` varchar(255) NOT NULL,
  `medications` varchar(255) NOT NULL,
  `pregnant` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccination_record`
--

INSERT INTO `vaccination_record` (`id`, `id_number`, `last_name`, `first_name`, `middle_name`, `suffixes`, `sex`, `current_age`, `vaccine_name`, `dose`, `vaccine_date`, `site_name`, `serial_code`, `remarks`, `symptoms`, `medications`, `pregnant`) VALUES
(204, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', 'male', '21', 'Pfizer', '1st dose', '2022-03-17', 'Clinic Apni', '---', 'ongoing', '', '', ''),
(205, '1852889667', 'Rafols', 'Jarmie Mae', 'Laciste', '', 'female', '22', 'Moderna', '1st dose', '2022-03-17', 'Clinic Apni', '---', 'ongoing', '', '', ''),
(206, '1852889667', 'Rafols', 'Jarmie Mae', 'Laciste', '', 'female', '22', 'Dengue', '1st dose', '2022-03-17', 'Clinic Apni', '---', 'complete', '', '', ''),
(207, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', 'male', '21', 'Pfizer', '2nd dose', '2022-03-17', 'Asin - Clinic', '---', 'complete', '', '', ''),
(208, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', 'male', '21', 'Pfizer', 'booster', '2022-03-17', 'Asin - Clinic', '---', 'complete', '', '', ''),
(209, '2409295845', 'Runas', 'Marc', 'Sahoy', '', 'male', '21', 'HEPATITIS B', '1st dose', '2022-03-17', 'Clinic Apni', '', 'ongoing', '', '', ''),
(210, '2409295845', 'Runas', 'Marc', 'Sahoy', '', 'male', '21', 'HEPATITIS B', '2nd dose', '2022-03-17', 'Clinic Apni', '', 'ongoing', '', '', ''),
(211, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'male', '18', 'Moderna', '1st dose', '2022-03-17', 'Clinic Apni', '', 'ongoing', '', '', ''),
(212, '1719988263', 'Runas', 'Culovet Joy', 'Sito', '', 'female', '10', 'HEPATITIS B', '1st dose', '2022-03-21', 'RHU-Tuba', '---', 'ongoing', '', '', ''),
(213, '1852889667', 'Rafols', 'Jarmie Mae', 'Laciste', '', 'female', '22', 'PNEUMOCOCCAL CONJUGATE VACCINE', '1st dose', '2022-03-30', 'RHU-Tuba', '', 'ongoing', '', '', ''),
(214, '1852889667', 'Rafols', 'Jarmie Mae', 'Laciste', '', 'female', '22', 'Dengue', '2nd dose', '2022-03-30', 'Asin - Clinic', '---', 'complete', '', '', ''),
(217, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', 'male', '22', 'PENTAVALENT VACCINE', '1st dose', '2022-04-05', 'RHU-Tuba', '', 'ongoing', '', '', ''),
(218, '1211787298', 'Codiamat', 'Joshue', 'Angagan', '', 'male', '22', 'PNEUMOCOCCAL CONJUGATE VACCINE', '1st dose', '2022-04-05', 'RHU-Tuba', '', 'ongoing', '', '', ''),
(221, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'male', '18', 'PENTAVALENT VACCINE', '1st dose', '2022-04-06', 'RHU-Tuba', '', 'ongoing', '', '', ''),
(222, '953897514', 'Viray', 'Ramses', 'Vicente', '', 'male', '33', 'PENTAVALENT VACCINE', '1st dose', '2022-04-06', 'RHU-Tuba', '', 'ongoing', '', '', ''),
(223, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'male', '18', 'ORAL POLIO VACCINE', '1st dose', '2022-04-06', 'RHU-Tuba', '', 'ongoing', '', '', ''),
(224, '953897514', 'Viray', 'Ramses', 'Vicente', '', 'male', '33', 'Moderna', '1st dose', '2022-04-06', 'RHU-Tuba', '---', 'ongoing', 'Fever/ chills, Sore Throat, Rashes, Weakness, Loss of smell/ taste', 'No', 'No'),
(225, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'male', '18', 'Moderna', '2nd dose', '2022-04-07', 'RHU-Tuba', '', 'ongoing', 'Loss of smell/ taste', 'Yes', 'No'),
(226, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'male', '18', 'ORAL POLIO VACCINE', '2nd dose', '2022-05-30', 'RHU-Tuba', 'none', 'ongoing', 'Rashes', 'No', 'No'),
(227, '953897514', 'Viray', 'Ramses', 'Vicente', '', 'male', '34', 'HEPATITIS B', '1st dose', '2022-05-31', 'RHU-Tuba', '', 'ongoing', 'Weakness', 'No', 'No'),
(228, '769280378', 'Runas', 'Carl', 'Sahoy', '', 'male', '18', 'Jhonsons', '1st dose', '2022-07-18', 'RHU-Tuba', '', 'ongoing', 'Myalgia', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_site`
--

CREATE TABLE `vaccination_site` (
  `id` int(30) NOT NULL,
  `site_name` varchar(255) NOT NULL,
  `site_address` varchar(255) NOT NULL,
  `count` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccination_site`
--

INSERT INTO `vaccination_site` (`id`, `site_name`, `site_address`, `count`) VALUES
(11, 'San Pascual - Clinic', 'San Pascual , Tuba , Benguet , 2603', 1),
(14, 'Asin - Clinic', 'San Pascual , Tuba , Benguet , 2600', 1),
(16, 'Tuba - RHU', 'Poblacion , Tuba , Benguet , 2603', 1),
(17, 'Nangalisan - Clinic', 'Nangalisan , Tuba , Benguet , 2603', 1),
(18, 'Tadiangan - Clinic', 'Tadiangan , Tuba , Benguet , 2603', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `id` int(30) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `doses` varchar(30) NOT NULL,
  `vaccine_type` varchar(255) NOT NULL,
  `contraindications` varchar(255) NOT NULL,
  `ad_reactions` varchar(255) NOT NULL,
  `spec_precautions` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `inject_type` varchar(255) NOT NULL,
  `inject_site` varchar(255) NOT NULL,
  `date_added` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`id`, `vaccine_name`, `doses`, `vaccine_type`, `contraindications`, `ad_reactions`, `spec_precautions`, `dosage`, `inject_type`, `inject_site`, `date_added`) VALUES
(1, 'BCG', '1', '', '', '', '', '', '', '', '2022-02-08'),
(2, 'HEPATITIS B', '1', '', '', '', '', '', '', '', '2022-02-08'),
(3, 'PENTAVALENT VACCINE', '3', '', '', '', '', '', '', '', '2022-02-08'),
(4, 'ORAL POLIO VACCINE', '3', '', '', '', '', '', '', '', '2022-02-08'),
(5, 'INACTIVATED POLIO VACCINE', '1', '', '', '', '', '', '', '', '2022-02-08'),
(6, 'PNEUMOCOCCAL CONJUGATE VACCINE', '3', '', '', '', '', '', '', '', '2022-02-08'),
(7, 'MEASLES, MUMPS, RUBELLA', '2', '', '', '', '', '', '', '', '2022-02-08'),
(8, 'Astra Zeneca', '2', '', '', '', '', '', '', '', '2022-02-08'),
(9, 'Pfizer', '2', '', '', '', '', '', '', '', '2022-02-09'),
(19, 'Jhonsons', '1', '', '', '', '', '', '', '', '2022-02-12'),
(24, 'Moderna', '1', '', '', '', '', '', '', '', '2022-02-12'),
(26, 'Dengue', '2', 'Pneumoccoccal Polysaccharide', 'Slight Fever, Body Aches', 'Mild Skin Irritation', 'Do not take [] for the first 4 hours', '0.5ml', 'Intramuscular', 'Rectus', '2022-03-04'),
(27, 'Astra v.2', '2', 'Inactivated vaccine', 'ola', 'buldigi', 'tae tae', '0.5ml', 'Intramuscular', 'Anterolateral thigh muscle', '2022-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_schedule`
--

CREATE TABLE `vaccine_schedule` (
  `id` int(30) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `dose` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `site_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `health_declaration`
--
ALTER TABLE `health_declaration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `past_imm`
--
ALTER TABLE `past_imm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pie_graph`
--
ALTER TABLE `pie_graph`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `public_user`
--
ALTER TABLE `public_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`);

--
-- Indexes for table `stat_graph`
--
ALTER TABLE `stat_graph`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_request`
--
ALTER TABLE `user_request`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vaccination_record`
--
ALTER TABLE `vaccination_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccination_site`
--
ALTER TABLE `vaccination_site`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_name` (`site_name`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vaccine_name` (`vaccine_name`);

--
-- Indexes for table `vaccine_schedule`
--
ALTER TABLE `vaccine_schedule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `health_declaration`
--
ALTER TABLE `health_declaration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `past_imm`
--
ALTER TABLE `past_imm`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `pie_graph`
--
ALTER TABLE `pie_graph`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `public_user`
--
ALTER TABLE `public_user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `stat_graph`
--
ALTER TABLE `stat_graph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user_request`
--
ALTER TABLE `user_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `vaccination_record`
--
ALTER TABLE `vaccination_record`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `vaccination_site`
--
ALTER TABLE `vaccination_site`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vaccine_schedule`
--
ALTER TABLE `vaccine_schedule`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
