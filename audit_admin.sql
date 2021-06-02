-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2020 at 07:26 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `audit_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `_brands_`
--

CREATE TABLE `_brands_` (
  `_bID_` int(11) NOT NULL,
  `_brand_name_` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_brands_`
--

INSERT INTO `_brands_` (`_bID_`, `_brand_name_`) VALUES
(1, 'HP'),
(2, 'LG'),
(3, 'HANNS.G'),
(4, 'ACER');

-- --------------------------------------------------------

--
-- Table structure for table `_chat_`
--

CREATE TABLE `_chat_` (
  `_cID_` int(11) NOT NULL,
  `_uID_` int(11) NOT NULL,
  `_text_` varchar(200) NOT NULL,
  `_date_` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_chat_`
--

INSERT INTO `_chat_` (`_cID_`, `_uID_`, `_text_`, `_date_`) VALUES
(17, 4, '49bbfcf8e1ba038c7ca145d5ae03b452EKou30gEA52H2I0eyqxvibH241c=', '09/05/2020 04:20:05pm');

-- --------------------------------------------------------

--
-- Table structure for table `_classes_`
--

CREATE TABLE `_classes_` (
  `_caID_` int(11) NOT NULL,
  `_classes_` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_classes_`
--

INSERT INTO `_classes_` (`_caID_`, `_classes_`) VALUES
(2, 'LA1'),
(3, 'E2'),
(4, 'E15'),
(5, 'E3'),
(6, 'E1'),
(7, 'E5'),
(8, 'M6'),
(9, 'M13'),
(10, 'IT1'),
(11, 'IT4'),
(12, 'HOME'),
(13, 'IT7'),
(14, 'IT2');

-- --------------------------------------------------------

--
-- Table structure for table `_company_`
--

CREATE TABLE `_company_` (
  `_comID_` int(11) NOT NULL,
  `_company_name_` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `_decomission_`
--

CREATE TABLE `_decomission_` (
  `_decID_` int(11) NOT NULL,
  `_item_id_` int(11) NOT NULL,
  `_SN_` varchar(100) NOT NULL,
  `_TAG_` varchar(100) NOT NULL,
  `_dec_visible_` int(11) NOT NULL,
  `_dec_qty_` int(11) NOT NULL,
  `_day_added_` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_decomission_`
--

INSERT INTO `_decomission_` (`_decID_`, `_item_id_`, `_SN_`, `_TAG_`, `_dec_visible_`, `_dec_qty_`, `_day_added_`) VALUES
(28, 4, '0c971d4fa5d9b6983d7d732209338a196qOkYnAUjBZief82', '9b3d2966e8e56607ccda8113bd8bb3020DEWsU5zWw==', 1, 9, ''),
(29, 4, 'ff6ddb00d1a72ff2197aec3edc237695b3e80ZhAqfnkLg==', '43a09b01b8449e7cdc8e9866c1bc0bc6nGhyWGsGXJQl', 1, 9, ''),
(35, 4, '03b94702e8851f1ffba2093a15b6130fkiPK5AKBm7K7lawkYPg=', '76de5327be4b4fc212eea410dec58ef8M6CCvG0XLJT6', 1, 9, ''),
(37, 4, '13bf00b526adf3501ac57f67367cd2adT3uAmIlUr69O3Q==', '3bdb316499842682892b7c0ee0a202e5pE8L/SLFQg==', 1, 9, ''),
(38, 4, '05e9c6e81f65f171b1c6fa9bc0312a9bQvuQ5+t30o+ml3v4W2w2', '31f71d0ec289cdba44b8b387ffe1b6302NDIKvRrG0WwIg==', 1, 9, ''),
(39, 4, '05c8cc5325eb180d47e9ae1f8b4195080Vg7OXioaiTn', '4c2e9171aecad96db07cf5a61dbcdd17oai2DZ7mNg==', 1, 9, ''),
(40, 4, '205acd802fad52b6852dfec349c80ee7lj6K00BV+NKVWKr4', 'f0e88daf8a013e7bd71c94d4ce60a167j5jJAQ==', 1, 9, ''),
(41, 21, '2bea822095eca78b1edb77ff563ea91eehdqzwb9BXFl', '8b2785dd0fa161585ccad088fe6f296fLBxmZYc=', 1, 13, ''),
(42, 21, '5541558691690939f60cf30a441479b9kHrlnGaNCI/j', '8b55cfb8bf8cdef27b7c78f775dc365fod9ANd92Vw==', 1, 13, '2020-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `_decomission_item_`
--

CREATE TABLE `_decomission_item_` (
  `_di_ID_` int(11) NOT NULL,
  `_typy_ID_` int(11) NOT NULL,
  `_brand_ID_` int(11) NOT NULL,
  `_mode_id_` int(11) NOT NULL,
  `_visible_` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_decomission_item_`
--

INSERT INTO `_decomission_item_` (`_di_ID_`, `_typy_ID_`, `_brand_ID_`, `_mode_id_`, `_visible_`) VALUES
(4, 4, 2, 5, 1),
(5, 4, 3, 6, 1),
(6, 5, 1, 7, 1),
(7, 5, 1, 8, 0),
(10, 4, 4, 9, 1),
(11, 1, 1, 10, 1),
(12, 2, 1, 11, 1),
(13, 1, 1, 12, 1),
(15, 1, 1, 13, 1),
(16, 1, 1, 14, 1),
(21, 1, 4, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_decom_quantity_`
--

CREATE TABLE `_decom_quantity_` (
  `_dcID_` int(11) NOT NULL,
  `_quantity_` int(11) NOT NULL,
  `_past_present_` int(11) NOT NULL,
  `_decom_date_` varchar(25) NOT NULL,
  `_reason_id_` int(11) NOT NULL,
  `_decom_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_decom_quantity_`
--

INSERT INTO `_decom_quantity_` (`_dcID_`, `_quantity_`, `_past_present_`, `_decom_date_`, `_reason_id_`, `_decom_ID`) VALUES
(9, 7, 1, '12/03/2020', 5, 4),
(10, 0, 1, '13/03/2020', 8, 1),
(13, 2, 1, '04/05/2020', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_departments_`
--

CREATE TABLE `_departments_` (
  `_dID_` int(11) NOT NULL,
  `_deparment_name_` varchar(30) NOT NULL,
  `_visible_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_departments_`
--

INSERT INTO `_departments_` (`_dID_`, `_deparment_name_`, `_visible_`) VALUES
(1, 'ICT Technician', 1),
(2, 'Maths', 1),
(3, 'Technician', 1),
(5, 'Humanities', 1),
(6, 'Drama', 1),
(7, 'Art', 1);

-- --------------------------------------------------------

--
-- Table structure for table `_devices_`
--

CREATE TABLE `_devices_` (
  `_devID_` int(11) NOT NULL,
  `_item_id_` int(11) NOT NULL,
  `_specs_id_` int(11) NOT NULL,
  `_SN_` varchar(100) NOT NULL,
  `_TAG_` varchar(100) NOT NULL,
  `_classes_id_` int(11) NOT NULL,
  `_faculty_id_` int(11) NOT NULL,
  `_ut_id_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_devices_`
--

INSERT INTO `_devices_` (`_devID_`, `_item_id_`, `_specs_id_`, `_SN_`, `_TAG_`, `_classes_id_`, `_faculty_id_`, `_ut_id_`) VALUES
(15, 13, 2, 'c190f63f01f5720e3a7cc70db3cd806acIPbJvKXD0A63vrtXEFaUEff', 'e40aec75757c4c5d8af1dded9aab4b92XgFGc+bQcEXG', 4, 3, 1),
(17, 13, 3, 'c356094dd4bcb77aaab975bd63f317a8rResgZuKHCByrrDjcAiI6xo=', '940105c4134ba68df4a034930d24ddd6O/gy/oh3vQ==', 6, 3, 1),
(18, 13, 3, 'a0137e3b4f93f7dcac610362bd0986b2dZ6PZlNCmwUxz0CSPr4=', 'beccb86c8313e6832f421aeb1818b7b21o1lrp9a', 7, 3, 1),
(19, 13, 3, '356fa6f4b4e00732794f6db8be7f7923V3Yjbay4ecHIdDHGyFGoNCzZoQ==', '4a389768ffb03a185ce723af5bf790b5BClMT45Jj0hqGA==', 8, 4, 2),
(22, 15, 2, 'f2fd896a8bef8fbe22b61c65db454ad4aE+Rfquyojt85c37HoUWRA==', 'e400ea186759d6ed065376eb47c2e333N7QqpWEClC8E', 11, 2, 1),
(84, 16, 2, '64f62ce7718d047a85d10d606dd0fcb4Vi1C0pSOT9udHXGwfjQ=', '3adbcd6a5a907fd3b83b60213ce76fb2NGkLfhyV1EA=', 14, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_devices_names_`
--

CREATE TABLE `_devices_names_` (
  `_dn_ID_` int(11) NOT NULL,
  `_devID_` int(11) NOT NULL,
  `_device_name_` varchar(100) NOT NULL,
  `_additional_` varchar(30) DEFAULT 'None',
  `_userID_` int(11) NOT NULL,
  `_facID_` int(11) NOT NULL,
  `_locID_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_devices_names_`
--

INSERT INTO `_devices_names_` (`_dn_ID_`, `_devID_`, `_device_name_`, `_additional_`, `_userID_`, `_facID_`, `_locID_`) VALUES
(85, 15, '76639fa6aa70ab268ba051c592449afd7249F3jC', 'SSD', 1, 2, 11),
(86, 15, '46fd6bd59092a318d6e46d5159a8d453FSy2qHPc', 'SSD', 1, 2, 11),
(87, 15, 'c31a7e08bb473f2eb8cc9be6b4333fb0+9SCjtfl', 'SSD', 1, 2, 11),
(88, 15, '1d904581fd54b53d135050a88824c7acdX9oWTrY', 'SSD', 1, 2, 11),
(89, 15, '142f80ef4e95734156190438fc5968a9mGbYTkOk', 'SSD', 1, 2, 11),
(90, 15, 'bac130d66223fcd72b0f485a75057e4c/2q1ffZg', 'SSD', 1, 2, 11),
(91, 15, 'f3913c3a9a6890bcf2b7e3787a47c70e20AJ9gkA', 'SSD', 1, 2, 11),
(98, 15, '47f3e103cba944aacac3a5f032ae75b8n1ziFXF+', 'SSD', 1, 2, 13),
(100, 15, '11bcc8456842a7548de740f1ce1934dfPjsBNkhU', 'SSD', 1, 2, 13),
(102, 15, 'd11b6e2b725dcec4cbc12e32c54c920e8Mvt6VBH', 'SSD', 1, 2, 13),
(106, 11, 'f97813582f84b10467535568629d494fQ97tZwNlEA1MQw==', 'N/A', 1, 3, 6),
(107, 11, '43b801cff1ceadf535e8d7f3c14f4091HJP9w9owU7O1Uw==', 'N/A', 1, 3, 6),
(108, 11, 'fafac8a5988a3f3439be39ee4efc82ecVfGkEab/re19oQ==', 'SSD', 1, 3, 6),
(109, 11, '5a478e6db4221e59ff66944a5ec25e1dByW7XMyj7sQdkQ==', 'SSD', 1, 3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `_faculty_`
--

CREATE TABLE `_faculty_` (
  `_facID_` int(11) NOT NULL,
  `_faculty_name_` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_faculty_`
--

INSERT INTO `_faculty_` (`_facID_`, `_faculty_name_`) VALUES
(2, 'ICT'),
(3, 'ENGLISH'),
(4, 'MATHS');

-- --------------------------------------------------------

--
-- Table structure for table `_model_`
--

CREATE TABLE `_model_` (
  `_mID_` int(11) NOT NULL,
  `_model_name_` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_model_`
--

INSERT INTO `_model_` (`_mID_`, `_model_name_`) VALUES
(1, 'ProDesk 400 G4 SFF'),
(2, 'COMPAQ DC5900'),
(5, 'FLATRON E1942C-BN'),
(6, 'HA191'),
(7, 'BIOSB-0801-00'),
(8, 'LASERJET PRO CM1415FN COLOUR FNP'),
(9, 'V173 D'),
(10, 'TPC-P04-SF'),
(11, '350 A'),
(12, '400 G1'),
(13, 'ALL-IN-ONE G1 400'),
(14, 'ALL-IN-ONE G2.5 600');

-- --------------------------------------------------------

--
-- Table structure for table `_name_`
--

CREATE TABLE `_name_` (
  `_nID_` int(11) NOT NULL,
  `_name_` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_name_`
--

INSERT INTO `_name_` (`_nID_`, `_name_`) VALUES
(1, 'Krystian'),
(2, 'Nana'),
(3, 'Kwabena'),
(4, 'Krzysztof'),
(5, 'test'),
(6, 'second'),
(7, 'David'),
(8, 'empty'),
(9, 'New'),
(10, 'DJ'),
(11, 'King'),
(12, 'Ortol'),
(13, 'John'),
(14, 'Vadimir'),
(15, 'Super'),
(16, 'TheLast'),
(17, 'Mateus');

-- --------------------------------------------------------

--
-- Table structure for table `_orders_`
--

CREATE TABLE `_orders_` (
  `_oID_` int(11) NOT NULL,
  `_staff_id_` int(11) NOT NULL,
  `_item_id_` int(11) NOT NULL,
  `_quantity_` int(11) NOT NULL,
  `_total_price_` double NOT NULL,
  `_date_` varchar(30) NOT NULL,
  `_dep_id_` int(11) NOT NULL,
  `_current_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_orders_`
--

INSERT INTO `_orders_` (`_oID_`, `_staff_id_`, `_item_id_`, `_quantity_`, `_total_price_`, `_date_`, `_dep_id_`, `_current_`) VALUES
(15, 13, 4, 1, 65.5, '2020-04-12', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_order_item_`
--

CREATE TABLE `_order_item_` (
  `_oiID_` int(11) NOT NULL,
  `_si_ID_` int(11) NOT NULL,
  `_price_` double NOT NULL,
  `_QTY_` int(11) NOT NULL,
  `_visible_` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_order_item_`
--

INSERT INTO `_order_item_` (`_oiID_`, `_si_ID_`, `_price_`, `_QTY_`, `_visible_`) VALUES
(4, 9, 65.5, 4, 1),
(5, 11, 105.15, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_reason_`
--

CREATE TABLE `_reason_` (
  `_rID_` int(11) NOT NULL,
  `_reason_` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_reason_`
--

INSERT INTO `_reason_` (`_rID_`, `_reason_`) VALUES
(1, 'Broken screen'),
(2, 'RUN OUT OF LIFE - DO NOT MEET REQUIRMENTS'),
(5, 'DAMAGE - DISPLAY ISSUE'),
(6, 'DAMAGED - FAILING TO PRINT'),
(7, 'DAMAGE - BROKEN SCANNER'),
(8, 'DAMAGED - POWER FAILURE');

-- --------------------------------------------------------

--
-- Table structure for table `_specs_`
--

CREATE TABLE `_specs_` (
  `_secID_` int(11) NOT NULL,
  `_specs_` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_specs_`
--

INSERT INTO `_specs_` (`_secID_`, `_specs_`) VALUES
(2, 'INTELCORE I3, 4GB RAM'),
(3, 'INTELCORE I7 4490, 4GB RAM');

-- --------------------------------------------------------

--
-- Table structure for table `_staff_`
--

CREATE TABLE `_staff_` (
  `_sID_` int(11) NOT NULL,
  `_name_id_` int(11) NOT NULL,
  `_s_name_id_` int(11) DEFAULT NULL,
  `_surname_` varchar(45) NOT NULL,
  `_email_` varchar(60) NOT NULL,
  `_title_id_` int(11) NOT NULL,
  `_visible_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_staff_`
--

INSERT INTO `_staff_` (`_sID_`, `_name_id_`, `_s_name_id_`, `_surname_`, `_email_`, `_title_id_`, `_visible_`) VALUES
(1, 1, 8, 'Malkowski', 'kmalkowski@kingsford.newham.sch.uk', 1, 1),
(6, 3, 2, 'Owusu', 'knana@kingsford.newham.sch.uk', 1, 1),
(7, 4, 8, 'Malkowski', 'kmalkowski1@kingsford.newham.sch.uk', 1, 1),
(12, 5, 6, 'user', 'test@kingsford.newham.sch.uk', 3, 0),
(13, 7, 10, 'West', 'dwest@kingsford.newham.sch.uk', 1, 0),
(28, 17, 8, 'Wazny', 'mwazny@gmail.com', 6, 1),
(29, 5, 8, 'testowy', 'testlast@gamil.com', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_supply_item_`
--

CREATE TABLE `_supply_item_` (
  `_sp_ID_` int(11) NOT NULL,
  `_type_id_` int(11) NOT NULL,
  `_item_name_` varchar(30) NOT NULL,
  `_brand_ID_` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_supply_item_`
--

INSERT INTO `_supply_item_` (`_sp_ID_`, `_type_id_`, `_item_name_`, `_brand_ID_`) VALUES
(7, 6, 'CE505', 1),
(8, 6, 'CF226A', 1),
(9, 6, 'CF410A', 1),
(10, 6, 'CF266A', 1),
(11, 6, 'CE505A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `_title_`
--

CREATE TABLE `_title_` (
  `_tID_` int(11) NOT NULL,
  `_title_name_` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_title_`
--

INSERT INTO `_title_` (`_tID_`, `_title_name_`) VALUES
(1, 'ICT Technician'),
(2, 'Maths'),
(3, 'Test'),
(4, 'Humans Logic'),
(6, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `_types_`
--

CREATE TABLE `_types_` (
  `_tID_` int(11) NOT NULL,
  `_type_name_` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_types_`
--

INSERT INTO `_types_` (`_tID_`, `_type_name_`) VALUES
(1, 'Computer'),
(2, 'Laptop'),
(3, 'Speakers'),
(4, 'MONITOR'),
(5, 'PRINTER'),
(6, 'TONER');

-- --------------------------------------------------------

--
-- Table structure for table `_user_log_`
--

CREATE TABLE `_user_log_` (
  `_uID_` int(11) NOT NULL,
  `_staff_id_` int(11) NOT NULL,
  `_username_` varchar(45) NOT NULL,
  `_password_` varchar(90) NOT NULL,
  `_is_admin_` tinyint(1) NOT NULL,
  `_is_active_` tinyint(1) NOT NULL,
  `password_change` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_user_log_`
--

INSERT INTO `_user_log_` (`_uID_`, `_staff_id_`, `_username_`, `_password_`, `_is_admin_`, `_is_active_`, `password_change`) VALUES
(2, 6, 'knana', '$2y$10$JZXHjTywU4v4BRuPZxVnUuCu6/fF1t5XY/CrrwPm0nYryrXi0IlTG', 1, 1, 0),
(4, 1, 'kmalkowski', '$2y$10$if3eUow4LrGRu/oYUawmbe93MWGfyt1vKSpBBuwedq6SIPziRjlwW', 1, 1, 0),
(5, 13, 'dwest', '$2y$10$XLXg6j1f.sKQHhSoLmRy6.2zKnRG3YybIoqkuwQTXEsbPDU5erwZm', 0, 0, 0),
(6, 7, 'kmalkowski1', '$2y$10$gMIwOpSUUPTY90LunMXYFegJ4INUcOxQD0c2AW8AxatrrobAI3hVC', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_user_type_`
--

CREATE TABLE `_user_type_` (
  `_utID_` int(11) NOT NULL,
  `_utype_name_` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `_user_type_`
--

INSERT INTO `_user_type_` (`_utID_`, `_utype_name_`) VALUES
(1, 'STUDENT'),
(2, 'TEACHER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `_brands_`
--
ALTER TABLE `_brands_`
  ADD PRIMARY KEY (`_bID_`);

--
-- Indexes for table `_chat_`
--
ALTER TABLE `_chat_`
  ADD PRIMARY KEY (`_cID_`),
  ADD KEY `_uID_` (`_uID_`);

--
-- Indexes for table `_classes_`
--
ALTER TABLE `_classes_`
  ADD PRIMARY KEY (`_caID_`);

--
-- Indexes for table `_company_`
--
ALTER TABLE `_company_`
  ADD PRIMARY KEY (`_comID_`);

--
-- Indexes for table `_decomission_`
--
ALTER TABLE `_decomission_`
  ADD PRIMARY KEY (`_decID_`),
  ADD KEY `_type_id_` (`_item_id_`),
  ADD KEY `_dec_qty_` (`_dec_qty_`);

--
-- Indexes for table `_decomission_item_`
--
ALTER TABLE `_decomission_item_`
  ADD PRIMARY KEY (`_di_ID_`),
  ADD UNIQUE KEY `_typy_ID_` (`_typy_ID_`,`_brand_ID_`,`_mode_id_`),
  ADD KEY `_typy_ID__2` (`_typy_ID_`,`_brand_ID_`,`_mode_id_`),
  ADD KEY `_brand_ID_` (`_brand_ID_`),
  ADD KEY `_mode_id_` (`_mode_id_`);

--
-- Indexes for table `_decom_quantity_`
--
ALTER TABLE `_decom_quantity_`
  ADD PRIMARY KEY (`_dcID_`),
  ADD KEY `_reason_id_` (`_reason_id_`),
  ADD KEY `_type_id_` (`_decom_ID`);

--
-- Indexes for table `_departments_`
--
ALTER TABLE `_departments_`
  ADD PRIMARY KEY (`_dID_`);

--
-- Indexes for table `_devices_`
--
ALTER TABLE `_devices_`
  ADD PRIMARY KEY (`_devID_`),
  ADD KEY `_item_id_` (`_item_id_`,`_specs_id_`),
  ADD KEY `_specs_id_` (`_specs_id_`),
  ADD KEY `_classes_id_` (`_classes_id_`),
  ADD KEY `_faculty_id_` (`_faculty_id_`),
  ADD KEY `_ut_id_` (`_ut_id_`);

--
-- Indexes for table `_devices_names_`
--
ALTER TABLE `_devices_names_`
  ADD PRIMARY KEY (`_dn_ID_`),
  ADD KEY `_devID_` (`_devID_`),
  ADD KEY `_userID_` (`_userID_`),
  ADD KEY `_facID_` (`_facID_`),
  ADD KEY `_locID_` (`_locID_`);

--
-- Indexes for table `_faculty_`
--
ALTER TABLE `_faculty_`
  ADD PRIMARY KEY (`_facID_`);

--
-- Indexes for table `_model_`
--
ALTER TABLE `_model_`
  ADD PRIMARY KEY (`_mID_`);

--
-- Indexes for table `_name_`
--
ALTER TABLE `_name_`
  ADD PRIMARY KEY (`_nID_`);

--
-- Indexes for table `_orders_`
--
ALTER TABLE `_orders_`
  ADD PRIMARY KEY (`_oID_`),
  ADD KEY `_staff_id_` (`_staff_id_`),
  ADD KEY `_item_id_` (`_item_id_`),
  ADD KEY `_dep_id_` (`_dep_id_`);

--
-- Indexes for table `_order_item_`
--
ALTER TABLE `_order_item_`
  ADD PRIMARY KEY (`_oiID_`),
  ADD KEY `_type_ID_` (`_si_ID_`);

--
-- Indexes for table `_reason_`
--
ALTER TABLE `_reason_`
  ADD PRIMARY KEY (`_rID_`);

--
-- Indexes for table `_specs_`
--
ALTER TABLE `_specs_`
  ADD PRIMARY KEY (`_secID_`);

--
-- Indexes for table `_staff_`
--
ALTER TABLE `_staff_`
  ADD PRIMARY KEY (`_sID_`),
  ADD KEY `_name_id_` (`_name_id_`,`_s_name_id_`,`_title_id_`),
  ADD KEY `_title_id_` (`_title_id_`),
  ADD KEY `_s_name_id_` (`_s_name_id_`);

--
-- Indexes for table `_supply_item_`
--
ALTER TABLE `_supply_item_`
  ADD PRIMARY KEY (`_sp_ID_`),
  ADD KEY `_type_id_` (`_type_id_`),
  ADD KEY `_type_id__2` (`_type_id_`),
  ADD KEY `_brand_ID_` (`_brand_ID_`);

--
-- Indexes for table `_title_`
--
ALTER TABLE `_title_`
  ADD PRIMARY KEY (`_tID_`);

--
-- Indexes for table `_types_`
--
ALTER TABLE `_types_`
  ADD PRIMARY KEY (`_tID_`);

--
-- Indexes for table `_user_log_`
--
ALTER TABLE `_user_log_`
  ADD PRIMARY KEY (`_uID_`),
  ADD UNIQUE KEY `_staff_id_` (`_staff_id_`);

--
-- Indexes for table `_user_type_`
--
ALTER TABLE `_user_type_`
  ADD PRIMARY KEY (`_utID_`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `_brands_`
--
ALTER TABLE `_brands_`
  MODIFY `_bID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_chat_`
--
ALTER TABLE `_chat_`
  MODIFY `_cID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `_classes_`
--
ALTER TABLE `_classes_`
  MODIFY `_caID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `_company_`
--
ALTER TABLE `_company_`
  MODIFY `_comID_` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_decomission_`
--
ALTER TABLE `_decomission_`
  MODIFY `_decID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `_decomission_item_`
--
ALTER TABLE `_decomission_item_`
  MODIFY `_di_ID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `_decom_quantity_`
--
ALTER TABLE `_decom_quantity_`
  MODIFY `_dcID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `_departments_`
--
ALTER TABLE `_departments_`
  MODIFY `_dID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `_devices_`
--
ALTER TABLE `_devices_`
  MODIFY `_devID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `_devices_names_`
--
ALTER TABLE `_devices_names_`
  MODIFY `_dn_ID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `_faculty_`
--
ALTER TABLE `_faculty_`
  MODIFY `_facID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `_model_`
--
ALTER TABLE `_model_`
  MODIFY `_mID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `_name_`
--
ALTER TABLE `_name_`
  MODIFY `_nID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `_orders_`
--
ALTER TABLE `_orders_`
  MODIFY `_oID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `_order_item_`
--
ALTER TABLE `_order_item_`
  MODIFY `_oiID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `_reason_`
--
ALTER TABLE `_reason_`
  MODIFY `_rID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `_specs_`
--
ALTER TABLE `_specs_`
  MODIFY `_secID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_staff_`
--
ALTER TABLE `_staff_`
  MODIFY `_sID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `_supply_item_`
--
ALTER TABLE `_supply_item_`
  MODIFY `_sp_ID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `_title_`
--
ALTER TABLE `_title_`
  MODIFY `_tID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_types_`
--
ALTER TABLE `_types_`
  MODIFY `_tID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `_user_log_`
--
ALTER TABLE `_user_log_`
  MODIFY `_uID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `_user_type_`
--
ALTER TABLE `_user_type_`
  MODIFY `_utID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `_chat_`
--
ALTER TABLE `_chat_`
  ADD CONSTRAINT `_chat__ibfk_1` FOREIGN KEY (`_uID_`) REFERENCES `_user_log_` (`_uID_`);

--
-- Constraints for table `_decomission_`
--
ALTER TABLE `_decomission_`
  ADD CONSTRAINT `_decomission__ibfk_2` FOREIGN KEY (`_item_id_`) REFERENCES `_decomission_item_` (`_di_ID_`),
  ADD CONSTRAINT `_decomission__ibfk_3` FOREIGN KEY (`_dec_qty_`) REFERENCES `_decom_quantity_` (`_dcID_`);

--
-- Constraints for table `_decomission_item_`
--
ALTER TABLE `_decomission_item_`
  ADD CONSTRAINT `_decomission_item__ibfk_1` FOREIGN KEY (`_typy_ID_`) REFERENCES `_types_` (`_tID_`),
  ADD CONSTRAINT `_decomission_item__ibfk_2` FOREIGN KEY (`_brand_ID_`) REFERENCES `_brands_` (`_bID_`),
  ADD CONSTRAINT `_decomission_item__ibfk_3` FOREIGN KEY (`_mode_id_`) REFERENCES `_model_` (`_mID_`);

--
-- Constraints for table `_decom_quantity_`
--
ALTER TABLE `_decom_quantity_`
  ADD CONSTRAINT `_decom_quantity__ibfk_2` FOREIGN KEY (`_reason_id_`) REFERENCES `_reason_` (`_rID_`),
  ADD CONSTRAINT `_decom_quantity__ibfk_3` FOREIGN KEY (`_decom_ID`) REFERENCES `_types_` (`_tID_`);

--
-- Constraints for table `_devices_`
--
ALTER TABLE `_devices_`
  ADD CONSTRAINT `_devices__ibfk_1` FOREIGN KEY (`_item_id_`) REFERENCES `_decomission_item_` (`_di_ID_`),
  ADD CONSTRAINT `_devices__ibfk_2` FOREIGN KEY (`_specs_id_`) REFERENCES `_specs_` (`_secID_`),
  ADD CONSTRAINT `_devices__ibfk_3` FOREIGN KEY (`_classes_id_`) REFERENCES `_classes_` (`_caID_`),
  ADD CONSTRAINT `_devices__ibfk_4` FOREIGN KEY (`_faculty_id_`) REFERENCES `_faculty_` (`_facID_`),
  ADD CONSTRAINT `_devices__ibfk_5` FOREIGN KEY (`_ut_id_`) REFERENCES `_user_type_` (`_utID_`);

--
-- Constraints for table `_devices_names_`
--
ALTER TABLE `_devices_names_`
  ADD CONSTRAINT `_devices_names__ibfk_1` FOREIGN KEY (`_devID_`) REFERENCES `_decomission_item_` (`_di_ID_`),
  ADD CONSTRAINT `_devices_names__ibfk_2` FOREIGN KEY (`_locID_`) REFERENCES `_classes_` (`_caID_`),
  ADD CONSTRAINT `_devices_names__ibfk_3` FOREIGN KEY (`_facID_`) REFERENCES `_faculty_` (`_facID_`),
  ADD CONSTRAINT `_devices_names__ibfk_4` FOREIGN KEY (`_userID_`) REFERENCES `_user_type_` (`_utID_`);

--
-- Constraints for table `_orders_`
--
ALTER TABLE `_orders_`
  ADD CONSTRAINT `_orders__ibfk_1` FOREIGN KEY (`_dep_id_`) REFERENCES `_departments_` (`_dID_`),
  ADD CONSTRAINT `_orders__ibfk_2` FOREIGN KEY (`_item_id_`) REFERENCES `_order_item_` (`_oiID_`),
  ADD CONSTRAINT `_orders__ibfk_3` FOREIGN KEY (`_staff_id_`) REFERENCES `_staff_` (`_sID_`);

--
-- Constraints for table `_order_item_`
--
ALTER TABLE `_order_item_`
  ADD CONSTRAINT `_order_item__ibfk_1` FOREIGN KEY (`_si_ID_`) REFERENCES `_supply_item_` (`_sp_ID_`);

--
-- Constraints for table `_staff_`
--
ALTER TABLE `_staff_`
  ADD CONSTRAINT `_staff__ibfk_1` FOREIGN KEY (`_title_id_`) REFERENCES `_title_` (`_tID_`),
  ADD CONSTRAINT `_staff__ibfk_2` FOREIGN KEY (`_name_id_`) REFERENCES `_name_` (`_nID_`),
  ADD CONSTRAINT `_staff__ibfk_3` FOREIGN KEY (`_s_name_id_`) REFERENCES `_name_` (`_nID_`);

--
-- Constraints for table `_supply_item_`
--
ALTER TABLE `_supply_item_`
  ADD CONSTRAINT `_supply_item__ibfk_1` FOREIGN KEY (`_type_id_`) REFERENCES `_types_` (`_tID_`),
  ADD CONSTRAINT `_supply_item__ibfk_2` FOREIGN KEY (`_brand_ID_`) REFERENCES `_brands_` (`_bID_`);

--
-- Constraints for table `_user_log_`
--
ALTER TABLE `_user_log_`
  ADD CONSTRAINT `_user_log__ibfk_1` FOREIGN KEY (`_staff_id_`) REFERENCES `_staff_` (`_sID_`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
