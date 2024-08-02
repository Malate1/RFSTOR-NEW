-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2022 at 09:24 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rfstor`
--

-- --------------------------------------------------------

--
-- Table structure for table `burole`
--

CREATE TABLE `burole` (
  `id` int(10) NOT NULL,
  `bunit_code` varchar(4) NOT NULL,
  `user_id` int(8) NOT NULL,
  `company_code` varchar(4) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `burole`
--

INSERT INTO `burole` (`id`, `bunit_code`, `user_id`, `company_code`, `status`) VALUES
(1, '1', 18, '01', 'Active'),
(2, '9', 18, '02', 'Active'),
(3, '33', 18, '03', 'Active'),
(4, '34', 18, '03', 'Active'),
(5, '35', 18, '03', 'Active'),
(6, '2', 18, '01', 'Inactive'),
(7, '3', 18, '01', 'Inactive'),
(8, '4', 18, '01', 'Inactive'),
(9, '5', 18, '01', 'Active'),
(10, '1', 8, '01', 'Active'),
(11, '1', 1, '01', 'Active'),
(12, '5', 1, '01', 'Active'),
(13, '5', 15, '01', 'Active'),
(14, '1', 15, '01', 'Active'),
(15, '5', 13, '01', 'Active'),
(16, '1', 19, '01', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `business_unit`
--

CREATE TABLE `business_unit` (
  `id` int(8) NOT NULL,
  `bcode` int(4) UNSIGNED ZEROFILL DEFAULT NULL,
  `business_unit` varchar(100) NOT NULL,
  `company_code` int(2) UNSIGNED ZEROFILL NOT NULL,
  `bunit_code` int(2) UNSIGNED ZEROFILL NOT NULL,
  `status` char(8) NOT NULL,
  `acroname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `business_unit`
--

INSERT INTO `business_unit` (`id`, `bcode`, `business_unit`, `company_code`, `bunit_code`, `status`, `acroname`) VALUES
(1, 0101, 'HEAD OFFICE', 01, 01, 'active', 'HO'),
(2, 0102, 'GROUP 1 - Grocery Group Management', 01, 02, 'active', 'Group 1'),
(3, 0103, 'GROUP 2 - Home and Fashion, Fixrite', 01, 03, 'active', 'Group 2'),
(4, 0104, 'GROUP 3 - Food Group Management', 01, 04, 'active', 'Group 3'),
(5, 0105, 'GROUP 4 - FARMS', 01, 05, 'active', 'Group 4'),
(6, 0106, 'MOTORPOOL', 01, 06, 'active', 'Motorpool'),
(7, 0107, 'WAREHOUSES', 01, 07, 'active', 'Warehouses'),
(8, 0108, 'LOGISTICS', 01, 08, 'active', 'Logistics'),
(9, 0201, 'ASC: MAIN', 02, 01, 'active', 'ASCMAIN'),
(10, 0202, 'ALTURAS TALIBON', 02, 02, 'active', 'ASC Tal'),
(11, 0203, 'ISLAND CITY MALL', 02, 03, 'active', 'ICM'),
(12, 0204, 'KAMISETA- ICM', 02, 04, 'active', 'Kamiseta-ICM'),
(13, 0205, 'MOSSIMO- ICM', 02, 05, 'inactive', ''),
(14, 0206, 'GUESS- ICM', 02, 06, 'active', 'Guess-ICM'),
(15, 0207, 'MARCELA HOMES', 02, 07, 'inactive', ''),
(16, 0208, 'HABITAT', 02, 08, 'inactive', ' '),
(17, 0209, 'ANAHAW', 02, 09, 'inactive', ''),
(18, 0210, 'ESPUELAS', 02, 10, 'active', 'Espuelas'),
(19, 0211, 'GRAHAM', 02, 11, 'inactive', ''),
(20, 0212, 'DAMPAS DORM', 02, 12, 'inactive', ''),
(21, 0213, 'DAMPAS COTTAGE', 02, 13, 'inactive', ''),
(22, 0214, 'VAN DORM', 02, 14, 'inactive', ''),
(23, 0215, 'MARIA CLARA', 02, 15, 'inactive', ''),
(24, 0216, 'WHITE HOUSE', 02, 16, 'inactive', ''),
(25, 0217, 'MA. CLARA CONSTRUCTION', 02, 17, 'inactive', ''),
(26, 0218, 'PLANNING & ARCHITECTURE', 02, 18, 'inactive', ''),
(27, 0219, 'GLASS SERVICE- TALIBON', 02, 19, 'active', 'Glass Tal'),
(28, 0220, 'GLASS SERVICE- TAGBILARAN', 02, 20, 'active', 'Glass Tagb'),
(29, 0221, 'ALTURAS TUBIGON', 02, 21, 'active', 'ASC Tubigon'),
(30, 0222, 'ZAMORA DORMITORY', 02, 22, 'active', 'Zamora Dorms'),
(31, 0223, 'ALTA CITTA', 02, 23, 'active', 'Alta Citta'),
(32, 0224, 'FIXRITE PANGLAO', 02, 24, 'active', 'Fixrite Panglao'),
(33, 0301, 'PLAZA MARCELA', 03, 01, 'active', 'Plaza Marcela'),
(34, 0302, 'FEEDMILL', 03, 02, 'active', 'Feedmill'),
(35, 0303, 'RICEMILL', 03, 03, 'active', 'Ricemill'),
(36, 0304, 'DEMO FARMS / CONTRACT FARMING', 03, 04, 'inactive', ''),
(37, 0305, 'POST HARVEST', 03, 05, 'inactive', ''),
(38, 0306, 'MFI PIGGERY (CORTES)', 03, 06, 'active', 'Piggery(Cortes)'),
(39, 0307, 'MFI Slaughterhouse & Meat Cutting Plant I', 03, 07, 'active', 'Slaughterhouse I'),
(40, 0308, 'MFI POULTRY LAYER', 03, 08, 'active', 'Poultry Layer'),
(41, 0309, 'MFI POULTRY BROILER-BILAR BREEDER', 03, 09, 'active', 'Bilar Breeder'),
(42, 0310, 'MFI POULTRY BROILER-RIZAL BREEDER', 03, 10, 'active', 'Rizal Breeder'),
(43, 0311, 'MFI POULTRY BROILER- HATCHERY', 03, 11, 'active', 'Hatchery'),
(44, 0312, 'MFI POULTRY BROILER- GROWOUT', 03, 12, 'active', 'Growout'),
(45, 0313, 'MFI POULTRY BROILER-DRESSING PLANT', 03, 13, 'inactive', ''),
(46, 0314, 'BACONG FARMS', 03, 14, 'active', 'Bacong'),
(47, 0315, 'BANANA PLANTATION', 03, 15, 'inactive', ''),
(48, 0316, 'AGRI FARMS (UBAY)', 03, 16, 'active', 'Agri Farms'),
(49, 0317, 'AGRI-FARMS (CARMEN)', 03, 17, 'active', 'Agri-Farms(Carmen)'),
(50, 0318, 'AGRI- FARMS (TABALONG)', 03, 18, 'inactive', ''),
(51, 0319, 'COLD STORAGE COMMISSARY', 03, 19, 'active', 'Cold Storage'),
(52, 0320, 'FOOD SERVICE COMMISSARY', 03, 20, 'active', 'FS Commi'),
(53, 0321, 'BAKESHOPPE COMMISSARY', 03, 21, 'active', 'BS Commi'),
(54, 0322, 'NOODLES FACTORY', 03, 22, 'active', 'Noodles'),
(55, 0323, 'MFI REPACKING SERVICES', 03, 23, 'active', 'Repacking Srvcs'),
(56, 0324, 'ICE PLANT', 03, 24, 'active', 'Ice Plant'),
(57, 0325, 'CATAGBACAN FARMS', 03, 25, 'active', 'Catagbacan'),
(58, 0326, 'ORTIGAS FARMS', 03, 26, 'active', 'Ortigas'),
(59, 0327, 'MARIBOJOC FARMS', 03, 27, 'active', 'Maribojoc'),
(60, 0328, 'BOHOL MILKFISH CORPORATION', 03, 28, 'active', 'BMC'),
(61, 0329, 'TIPCAN FARMS', 03, 29, 'active', 'Tipcan'),
(62, 0330, 'PHARMA DISTRIBUTION (UNILAB)', 03, 30, 'active', 'Pharma'),
(63, 0331, 'COPRA BUYING STATION (UBAY)', 03, 31, 'active', 'Copra'),
(64, 0332, 'THE PRAWN FARM', 03, 32, 'active', 'TPF'),
(65, 0333, 'COMMISSARY COMPOUND', 03, 33, 'active', 'Commi Compound'),
(66, 0334, 'MFI DRESSING PLANT', 03, 34, 'active', 'Dressing Plant'),
(67, 0335, 'HEAVY EQUIPMENT', 03, 35, 'active', 'Heavy Equipment'),
(68, 0336, 'MFI POULTRY BROILER BILAR HATCHERY', 03, 36, 'inactive', ''),
(69, 0337, 'MFI Slaughterhouse & Meat Cutting Plant II', 03, 37, 'active', 'MFI-SlaughterhouseII'),
(70, 0338, 'MFI POULTRY BROILER - CANHAYUPON BREEDER', 03, 38, 'active', 'Canhayupon'),
(71, 0339, 'MFI POULTRY BROILER - LAPSAON BREEDER', 03, 39, 'active', 'Lapsaon'),
(72, 0340, 'MFI-PIGGERY (Untaga, Alicia)', 03, 40, 'active', 'Piggery(Alicia)'),
(73, 0341, 'MFI TILAPIA BREEDER', 03, 41, 'active', 'Tilapia Breeder'),
(74, 0401, 'MFRI- LILA', 04, 01, 'active', 'MFRI-Lila'),
(75, 0402, 'MFRI- TANGNAN', 04, 02, 'active', 'MFRI-Tangnan'),
(76, 0501, 'Bohol Online', 05, 01, 'active', ''),
(77, 0601, 'DISTRIBUTION SALES GROUP', 06, 01, 'active', 'DSG'),
(78, 0602, 'WHOLESALE DISTRIBUTION GROUP', 06, 02, 'active', 'WDG'),
(79, 0701, 'COLONNADE- COLON', 07, 01, 'active', 'COL-C'),
(80, 0702, 'COLONNADE- MANDAUE', 07, 02, 'active', 'COL-M'),
(81, 0703, 'CHOWKING- COLONNADE COLON', 07, 03, 'active', ''),
(82, 0801, 'TUBIGON PLANT', 08, 01, 'active', 'Tubigon Plant'),
(83, 0901, 'PEANUT KISSES', 09, 01, 'active', 'PK'),
(84, 0902, 'CORALANDIA', 09, 02, 'active', ''),
(85, 1001, 'SOUTH PALMS RESORT PANGLAO', 10, 01, 'active', 'SPRP'),
(86, 1002, 'BOHOL SEA RESORT', 10, 02, 'active', ' '),
(87, 1003, 'North Zen Villas', 10, 03, 'inactive', ''),
(88, 1004, 'SOUTH FARM', 10, 04, 'active', 'South Farm'),
(89, 1101, 'GREENWICH- PLAZA MARCELA', 11, 01, 'active', 'GW-PM'),
(90, 1102, 'JOLLIBEE- PLAZA MARCELA', 11, 02, 'active', 'Jollibee-PM'),
(91, 1103, 'JOLLIBEE- ISLAND CITY MALL', 11, 03, 'active', 'Jollibee-ICM'),
(92, 1104, 'CHOWKING- ISLAND CITY MALL', 11, 04, 'active', 'CK-ICM'),
(93, 1105, 'CHOWKING- ALTURAS', 11, 05, 'active', 'CK-AMall'),
(94, 1106, 'ACCOUNTING/FRANCHISE', 11, 06, 'active', ''),
(95, 1107, 'WAREHOUSE', 11, 07, 'active', ''),
(96, 1108, 'ADMIN-CHOWKING', 11, 08, 'active', ''),
(97, 1109, 'WAREHOUSE-CHOWKING', 11, 09, 'active', ''),
(98, 1110, 'GREENWICH- ALTURAS MALL', 11, 10, 'active', 'GW-AMall'),
(99, 1111, 'CHOWKING- ALTA CITTA', 11, 11, 'active', 'CK-ALTA'),
(100, 1112, 'CHOWKING - ALTURAS TALIBON', 11, 12, 'active', ' CK - TALIBON'),
(101, 1201, 'JOLLIBEE- ALTURAS', 12, 01, 'active', ''),
(102, 1202, 'GREENWICH- ISLAND CITY MALL', 12, 02, 'active', 'Greenwich-ICM'),
(103, 1203, 'RED RIBBON- ALTURAS', 12, 03, 'active', ''),
(104, 1204, 'RED RIBBON- ISLAND CITY MALL', 12, 04, 'active', 'Red Ribbon-ICM'),
(105, 1205, 'RED RIBBON-TALIBON', 12, 05, 'active', 'RRTAL'),
(106, 1301, 'ASC TECH- TAGBILARAN', 13, 01, 'active', 'ASC Tech-Tagb'),
(107, 1302, 'ASC TECH- TALIBON', 13, 02, 'active', 'ASC TECH- TAL'),
(108, 1401, 'ABENSON TAGBILARAN - ICM', 14, 01, 'active', 'Abenson Tagb-ICM'),
(109, 1402, 'ABENSON TAGBILARAN - ASC Main', 14, 02, 'active', 'Abenson Tagb-ASC'),
(110, 1403, 'ABENSON TALIBON', 14, 03, 'active', ' '),
(111, 1404, 'BOHOL DEPOT', 14, 04, 'active', ' '),
(112, 1501, 'NETMAN', 15, 01, 'active', 'Netman'),
(113, 1601, 'NAUTICA SHIPPING', 16, 01, 'active', 'Nautica'),
(114, 1701, 'Bohol Tech Voc', 17, 01, 'active', 'BTV'),
(115, 1801, 'MANG INASAL - ISLAND CITY MALL', 18, 01, 'active', 'Mang Inasal - ICM'),
(116, 1901, 'JOLLIBEE DRIVE THRU', 19, 01, 'active', 'JB DRIVE THRU'),
(117, 1902, 'JOLLIBEE-TALIBON', 19, 02, 'active', ' JB Talibon'),
(118, 1903, 'JOLLIBEE ALTA CITTA', 19, 03, 'active', ''),
(119, 1904, 'JOLLIBEE-PANGLAO', 19, 04, 'active', 'JB PANGLAO'),
(120, 2001, 'NORTH ZEN VILLAS', 20, 01, 'active', 'NORTH ZEN'),
(121, 2101, 'BMHI-LILA', 21, 01, 'active', 'BMHI-LILA');

-- --------------------------------------------------------

--
-- Table structure for table `butaskrole`
--

CREATE TABLE `butaskrole` (
  `id` int(10) UNSIGNED NOT NULL,
  `buid` int(10) UNSIGNED NOT NULL,
  `taskid` int(10) UNSIGNED NOT NULL,
  `requesttype` enum('RFS','TOR','ISR') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `butaskrole`
--

INSERT INTO `butaskrole` (`id`, `buid`, `taskid`, `requesttype`, `status`) VALUES
(11, 2, 1, 'RFS', 'Active'),
(12, 2, 4, 'RFS', 'Active'),
(13, 1, 1, 'RFS', 'Active'),
(14, 1, 4, 'RFS', 'Active'),
(15, 3, 1, 'RFS', 'Active'),
(16, 3, 4, 'RFS', 'Active'),
(17, 1, 1, 'TOR', 'Active'),
(18, 1, 4, 'TOR', 'Active'),
(19, 1, 1, 'ISR', 'Active'),
(20, 1, 4, 'ISR', 'Active'),
(21, 33, 1, 'RFS', 'Active'),
(22, 33, 4, 'RFS', 'Active'),
(23, 57, 1, 'RFS', 'Active'),
(24, 57, 4, 'RFS', 'Active'),
(25, 57, 1, 'TOR', 'Active'),
(26, 57, 2, 'TOR', 'Active'),
(27, 57, 4, 'TOR', 'Active'),
(28, 34, 1, 'RFS', 'Active'),
(29, 34, 4, 'RFS', 'Active'),
(30, 74, 1, 'RFS', 'Active'),
(31, 74, 4, 'RFS', 'Active'),
(32, 33, 1, 'TOR', 'Active'),
(33, 33, 4, 'TOR', 'Active'),
(34, 1, 2, 'RFS', 'Inactive'),
(35, 1, 3, 'RFS', 'Inactive'),
(36, 1, 2, 'ISR', 'Inactive'),
(37, 1, 2, 'TOR', 'Inactive'),
(38, 79, 1, 'RFS', 'Active'),
(39, 79, 4, 'RFS', 'Active'),
(40, 79, 1, 'TOR', 'Active'),
(41, 79, 4, 'TOR', 'Active'),
(42, 5, 1, 'RFS', 'Active'),
(43, 5, 4, 'RFS', 'Active'),
(44, 5, 3, 'RFS', 'Active'),
(45, 5, 2, 'RFS', 'Inactive'),
(46, 5, 1, 'TOR', 'Active'),
(47, 5, 2, 'TOR', 'Inactive'),
(48, 5, 3, 'TOR', 'Active'),
(49, 5, 4, 'TOR', 'Active'),
(50, 58, 1, 'RFS', 'Active'),
(51, 58, 2, 'RFS', 'Active'),
(52, 58, 4, 'RFS', 'Active'),
(53, 41, 1, 'RFS', 'Active'),
(54, 41, 4, 'RFS', 'Active'),
(55, 41, 1, 'TOR', 'Active'),
(56, 41, 4, 'TOR', 'Active'),
(57, 41, 2, 'TOR', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_code` varchar(3) NOT NULL,
  `company` varchar(100) NOT NULL,
  `acroname` varchar(30) NOT NULL,
  `status` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_code`, `company`, `acroname`, `status`) VALUES
('01', 'ALTURAS GROUP OF COMPANIES', 'AGC', 'active'),
('02', 'ALTURAS SUPERMARKET CORPORATION', 'ASC', 'active'),
('03', 'MARCELA FARMS INCORPORATED', 'MFI', 'active'),
('04', 'MARCELA\'S FRONTIER RESOURCES, INC', 'MFRI', 'active'),
('05', 'BOHOL ONLINE SYSTEMS, INC', 'BOHOL ONLINE', 'inactive'),
('06', 'LEONARDO DISTRIBUTORS, INC', 'LDI', 'active'),
('07', 'CEBO DEVELOPMENT CORPORATION', 'CEBO', 'active'),
('08', 'BOHOL AGRO-MARINE DEVELOPMENT CORPORATION', 'AGROMARINE', 'active'),
('09', 'BUCAREZ FOOD PROCESSING CORPORATION', 'BUCAREZ\n', 'active'),
('10', 'PANGLAO BAY PREMIERE PARKS & RESORTS CORPORATION', 'PANGLAO BAY\n', 'active'),
('11', 'ROSE EN HONEY FOODLINE, INC', 'ROSE EN HONEY\n', 'active'),
('12', 'CRUST & PEPPER FOODLANE, INC', 'CRUSTPEPPER', 'active'),
('13', 'ASC TECH. SOLUTIONS, INC', 'ASC TECH\n', 'active'),
('14', 'ALTURAS-ABENSON APPLIANCE BOHOL, INC', 'ABENSON\n', 'active'),
('15', 'NETMAN DIST., INC', 'NETMAN', 'active'),
('16', 'NAUTICA SHIPPING & INTEGRATED SERV. INC.', 'NAUTICA', 'active'),
('17', 'BOHOL TECH VOC, INC', 'BTV', 'active'),
('18', 'CHARCOAL AND CHOP FOODLINE INC', 'CCFI', 'active'),
('19', 'ROAST AND TOAST FOODLINE INC', 'RTFI', 'active'),
('20', 'KOMPAS RESORTS AND HOTELS, INC.', ' KOMPAS RESORTS', 'active'),
('21', 'BISAYAN MARINE HATCHERY, INC.', 'BMHI', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL DEFAULT '',
  `phone` varchar(50) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `FirstName`, `LastName`, `phone`, `address`, `city`, `country`) VALUES
(1, 'Carine ', 'Schmitt', '40.32.2555', '54, rue Royale', 'Nantes', 'France'),
(2, 'Jean', 'King', '7025551838', '8489 Strong St.', 'Las Vegas', 'USA'),
(3, 'Peter', 'Ferguson', '03 9520 4555', '636 St Kilda Road', 'Melbourne', 'Australia'),
(4, 'Janine ', 'Labrune', '40.67.8555', '67, rue des Cinquante Otages', 'Nantes', 'France'),
(5, 'Jonas ', 'Bergulfsen', '07-98 9555', 'Erling Skakkes gate 78', 'Stavern', 'Norway'),
(6, 'Susan', 'Nelson', '4155551450', '5677 Strong St.', 'San Rafael', 'USA'),
(7, 'Zbyszek ', 'Piestrzeniewicz', '(26) 642-7555', 'ul. Filtrowa 68', 'Warszawa', 'Poland'),
(8, 'Roland', 'Keitel', '+49 69 66 90 2555', 'Lyonerstr. 34', 'Frankfurt', 'Germany'),
(9, 'Julie', 'Murphy', '6505555787', '5557 North Pendale Street', 'San Francisco', 'USA'),
(10, 'Kwai', 'Lee', '2125557818', '897 Long Airport Avenue', 'NYC', 'USA'),
(11, 'Diego ', 'Freyre', '(91) 555 94 44', 'C/ Moralzarzal, 86', 'Madrid', 'Spain'),
(12, 'Christina ', 'Berglund', '0921-12 3555', 'Berguvsvägen  8', 'Luleå', 'Sweden'),
(13, 'Jytte ', 'Petersen', '31 12 3555', 'Vinbæltet 34', 'Kobenhavn', 'Denmark'),
(14, 'Mary ', 'Saveley', '78.32.5555', '2, rue du Commerce', 'Lyon', 'France'),
(15, 'Eric', 'Natividad', '+65 221 7555', 'Bronz Sok.', 'Singapore', 'Singapore'),
(16, 'Jeff', 'Young', '2125557413', '4092 Furth Circle', 'NYC', 'USA'),
(17, 'Kelvin', 'Leong', '2155551555', '7586 Pompton St.', 'Allentown', 'USA'),
(18, 'Juri', 'Hashimoto', '6505556809', '9408 Furth Circle', 'Burlingame', 'USA'),
(19, 'Wendy', 'Victorino', '+65 224 1555', '106 Linden Road Sandown', 'Singapore', 'Singapore'),
(20, 'Veysel', 'Oeztan', '+47 2267 3215', 'Brehmen St. 121', 'Bergen', 'Norway  '),
(21, 'Keith', 'Franco', '2035557845', '149 Spinnaker Dr.', 'New Haven', 'USA'),
(22, 'Isabel ', 'de Castro', '(1) 356-5555', 'Estrada da saúde n. 58', 'Lisboa', 'Portugal'),
(23, 'Martine ', 'Rancé', '20.16.1555', '184, chaussée de Tournai', 'Lille', 'France'),
(24, 'Marie', 'Bertrand', '(1) 42.34.2555', '265, boulevard Charonne', 'Paris', 'France'),
(25, 'Jerry', 'Tseng', '6175555555', '4658 Baden Av.', 'Cambridge', 'USA'),
(26, 'Julie', 'King', '2035552570', '25593 South Bay Ln.', 'Bridgewater', 'USA'),
(27, 'Mory', 'Kentary', '+81 06 6342 5555', '1-6-20 Dojima', 'Kita-ku', 'Japan'),
(28, 'Michael', 'Frick', '2125551500', '2678 Kingston Rd.', 'NYC', 'USA'),
(29, 'Matti', 'Karttunen', '90-224 8555', 'Keskuskatu 45', 'Helsinki', 'Finland'),
(30, 'Rachel', 'Ashworth', '(171) 555-1555', 'Fauntleroy Circus', 'Manchester', 'UK'),
(31, 'Dean', 'Cassidy', '+353 1862 1555', '25 Maiden Lane', 'Dublin', 'Ireland'),
(32, 'Leslie', 'Taylor', '6175558428', '16780 Pompton St.', 'Brickhaven', 'USA'),
(33, 'Elizabeth', 'Devon', '(171) 555-2282', '12, Berkeley Gardens Blvd', 'Liverpool', 'UK'),
(34, 'Yoshi ', 'Tamuri', '(604) 555-3392', '1900 Oak St.', 'Vancouver', 'Canada'),
(35, 'Miguel', 'Barajas', '6175557555', '7635 Spinnaker Dr.', 'Brickhaven', 'USA'),
(36, 'Julie', 'Young', '6265557265', '78934 Hillside Dr.', 'Pasadena', 'USA'),
(37, 'Brydey', 'Walker', '+612 9411 1555', 'Suntec Tower Three', 'Singapore', 'Singapore'),
(38, 'Frédérique ', 'Citeaux', '88.60.1555', '24, place Kléber', 'Strasbourg', 'France'),
(39, 'Mike', 'Gao', '+852 2251 1555', 'Bank of China Tower', 'Central Hong Kong', 'Hong Kong'),
(40, 'Eduardo ', 'Saavedra', '(93) 203 4555', 'Rambla de Cataluña, 23', 'Barcelona', 'Spain'),
(41, 'Mary', 'Young', '3105552373', '4097 Douglas Av.', 'Glendale', 'USA'),
(42, 'Horst ', 'Kloss', '0372-555188', 'Taucherstraße 10', 'Cunewalde', 'Germany'),
(43, 'Palle', 'Ibsen', '86 21 3555', 'Smagsloget 45', 'Århus', 'Denmark'),
(44, 'Jean ', 'Fresnière', '(514) 555-8054', '43 rue St. Laurent', 'Montréal', 'Canada'),
(45, 'Alejandra ', 'Camino', '(91) 745 6555', 'Gran Vía, 1', 'Madrid', 'Spain'),
(46, 'Valarie', 'Thompson', '7605558146', '361 Furth Circle', 'San Diego', 'USA'),
(47, 'Helen ', 'Bennett', '(198) 555-8888', 'Garden House', 'Cowes', 'UK'),
(48, 'Annette ', 'Roulet', '61.77.6555', '1 rue Alsace-Lorraine', 'Toulouse', 'France'),
(49, 'Renate ', 'Messner', '069-0555984', 'Magazinweg 7', 'Frankfurt', 'Germany'),
(50, 'Paolo ', 'Accorti', '011-4988555', 'Via Monte Bianco 34', 'Torino', 'Italy'),
(51, 'Daniel', 'Da Silva', '+33 1 46 62 7555', '27 rue du Colonel Pierre Avia', 'Paris', 'France'),
(52, 'Daniel ', 'Tonini', '30.59.8555', '67, avenue de l\'Europe', 'Versailles', 'France'),
(53, 'Henriette ', 'Pfalzheim', '0221-5554327', 'Mehrheimerstr. 369', 'Köln', 'Germany'),
(54, 'Elizabeth ', 'Lincoln', '(604) 555-4555', '23 Tsawassen Blvd.', 'Tsawassen', 'Canada'),
(55, 'Peter ', 'Franken', '089-0877555', 'Berliner Platz 43', 'München', 'Germany'),
(56, 'Anna', 'O\'Hara', '02 9936 8555', '201 Miller Street', 'North Sydney', 'Australia'),
(57, 'Giovanni ', 'Rovelli', '035-640555', 'Via Ludovico il Moro 22', 'Bergamo', 'Italy'),
(58, 'Adrian', 'Huxley', '+61 2 9495 8555', 'Monitor Money Building', 'Chatswood', 'Australia'),
(59, 'Marta', 'Hernandez', '6175558555', '39323 Spinnaker Dr.', 'Cambridge', 'USA'),
(60, 'Ed', 'Harrison', '+41 26 425 50 01', 'Rte des Arsenaux 41 ', 'Fribourg', 'Switzerland'),
(61, 'Mihael', 'Holz', '0897-034555', 'Grenzacherweg 237', 'Genève', 'Switzerland'),
(62, 'Jan', 'Klaeboe', '+47 2212 1555', 'Drammensveien 126A', 'Oslo', 'Norway  '),
(63, 'Bradley', 'Schuyler', '+31 20 491 9555', 'Kingsfordweg 151', 'Amsterdam', 'Netherlands'),
(64, 'Mel', 'Andersen', '030-0074555', 'Obere Str. 57', 'Berlin', 'Germany'),
(65, 'Pirkko', 'Koskitalo', '981-443655', 'Torikatu 38', 'Oulu', 'Finland'),
(66, 'Catherine ', 'Dewey', '(02) 5554 67', 'Rue Joseph-Bens 532', 'Bruxelles', 'Belgium'),
(67, 'Steve', 'Frick', '9145554562', '3758 North Pendale Street', 'White Plains', 'USA'),
(68, 'Wing', 'Huang', '5085559555', '4575 Hillside Dr.', 'New Bedford', 'USA'),
(69, 'Julie', 'Brown', '6505551386', '7734 Strong St.', 'San Francisco', 'USA'),
(70, 'Mike', 'Graham', '+64 9 312 5555', '162-164 Grafton Road', 'Auckland  ', 'New Zealand'),
(71, 'Ann ', 'Brown', '(171) 555-0297', '35 King George', 'London', 'UK'),
(72, 'William', 'Brown', '2015559350', '7476 Moss Rd.', 'Newark', 'USA'),
(73, 'Ben', 'Calaghan', '61-7-3844-6555', '31 Duncan St. West End', 'South Brisbane', 'Australia'),
(74, 'Kalle', 'Suominen', '+358 9 8045 555', 'Software Engineering Center', 'Espoo', 'Finland'),
(75, 'Philip ', 'Cramer', '0555-09555', 'Maubelstr. 90', 'Brandenburg', 'Germany'),
(76, 'Francisca', 'Cervantes', '2155554695', '782 First Street', 'Philadelphia', 'USA'),
(77, 'Jesus', 'Fernandez', '+34 913 728 555', 'Merchants House', 'Madrid', 'Spain'),
(78, 'Brian', 'Chandler', '2155554369', '6047 Douglas Av.', 'Los Angeles', 'USA'),
(79, 'Patricia ', 'McKenna', '2967 555', '8 Johnstown Road', 'Cork', 'Ireland'),
(80, 'Laurence ', 'Lebihan', '91.24.4555', '12, rue des Bouchers', 'Marseille', 'France'),
(81, 'Paul ', 'Henriot', '26.47.1555', '59 rue de l\'Abbaye', 'Reims', 'France'),
(82, 'Armand', 'Kuger', '+27 21 550 3555', '1250 Pretorius Street', 'Hatfield', 'South Africa'),
(83, 'Wales', 'MacKinlay', '64-9-3763555', '199 Great North Road', 'Auckland', 'New Zealand'),
(84, 'Karin', 'Josephs', '0251-555259', 'Luisenstr. 48', 'Münster', 'Germany'),
(85, 'Juri', 'Yoshido', '6175559555', '8616 Spinnaker Dr.', 'Boston', 'USA'),
(86, 'Dorothy', 'Young', '6035558647', '2304 Long Airport Avenue', 'Nashua', 'USA'),
(87, 'Lino ', 'Rodriguez', '(1) 354-2555', 'Jardim das rosas n. 32', 'Lisboa', 'Portugal'),
(88, 'Braun', 'Urs', '0452-076555', 'Hauptstr. 29', 'Bern', 'Switzerland'),
(89, 'Allen', 'Nelson', '6175558555', '7825 Douglas Av.', 'Brickhaven', 'USA'),
(90, 'Pascale ', 'Cartrain', '(071) 23 67 2555', 'Boulevard Tirou, 255', 'Charleroi', 'Belgium'),
(91, 'Georg ', 'Pipps', '6562-9555', 'Geislweg 14', 'Salzburg', 'Austria'),
(92, 'Arnold', 'Cruz', '+63 2 555 3587', '15 McCallum Street', 'Makati City', 'Philippines'),
(93, 'Maurizio ', 'Moroni', '0522-556555', 'Strada Provinciale 124', 'Reggio Emilia', 'Italy'),
(94, 'Akiko', 'Shimamura', '+81 3 3584 0555', '2-2-8 Roppongi', 'Minato-ku', 'Japan'),
(95, 'Dominique', 'Perrier', '(1) 47.55.6555', '25, rue Lauriston', 'Paris', 'France'),
(96, 'Rita ', 'Müller', '0711-555361', 'Adenauerallee 900', 'Stuttgart', 'Germany'),
(97, 'Sarah', 'McRoy', '04 499 9555', '101 Lambton Quay', 'Wellington', 'New Zealand'),
(98, 'Michael', 'Donnermeyer', ' +49 89 61 08 9555', 'Hansastr. 15', 'Munich', 'Germany'),
(99, 'Maria', 'Hernandez', '2125558493', '5905 Pompton St.', 'NYC', 'USA'),
(100, 'Alexander ', 'Feuer', '0342-555176', 'Heerstr. 22', 'Leipzig', 'Germany'),
(101, 'Dan', 'Lewis', '2035554407', '2440 Pompton St.', 'Glendale', 'USA'),
(102, 'Martha', 'Larsson', '0695-34 6555', 'Åkergatan 24', 'Bräcke', 'Sweden'),
(103, 'Sue', 'Frick', '4085553659', '3086 Ingle Ln.', 'San Jose', 'USA'),
(104, 'Roland ', 'Mendel', '7675-3555', 'Kirchgasse 6', 'Graz', 'Austria'),
(105, 'Leslie', 'Murphy', '2035559545', '567 North Pendale Street', 'New Haven', 'USA'),
(106, 'Yu', 'Choi', '2125551957', '5290 North Pendale Street', 'NYC', 'USA'),
(107, 'Martín ', 'Sommer', '(91) 555 22 82', 'C/ Araquil, 67', 'Madrid', 'Spain'),
(108, 'Sven ', 'Ottlieb', '0241-039123', 'Walserweg 21', 'Aachen', 'Germany'),
(109, 'Violeta', 'Benitez', '5085552555', '1785 First Street', 'New Bedford', 'USA'),
(110, 'Carmen', 'Anton', '+34 913 728555', 'c/ Gobelas, 19-1 Urb. La Florida', 'Madrid', 'Spain'),
(111, 'Sean', 'Clenahan', '61-9-3844-6555', '7 Allen Street', 'Glen Waverly', 'Australia'),
(112, 'Franco', 'Ricotti', '+39 022515555', '20093 Cologno Monzese', 'Milan', 'Italy'),
(113, 'Steve', 'Thompson', '3105553722', '3675 Furth Circle', 'Burbank', 'USA'),
(114, 'Hanna ', 'Moos', '0621-08555', 'Forsterstr. 57', 'Mannheim', 'Germany'),
(115, 'Alexander ', 'Semenov', '+7 812 293 0521', '2 Pobedy Square', 'Saint Petersburg', 'Russia'),
(116, 'Raanan', 'Altagar,G M', '+ 972 9 959 8555', '3 Hagalim Blv.', 'Herzlia', 'Israel'),
(117, 'José Pedro ', 'Roel', '(95) 555 82 82', 'C/ Romero, 33', 'Sevilla', 'Spain'),
(118, 'Rosa', 'Salazar', '2155559857', '11328 Douglas Av.', 'Philadelphia', 'USA'),
(119, 'Sue', 'Taylor', '4155554312', '2793 Furth Circle', 'Brisbane', 'USA'),
(120, 'Thomas ', 'Smith', '(171) 555-7555', '120 Hanover Sq.', 'London', 'UK'),
(121, 'Valarie', 'Franco', '6175552555', '6251 Ingle Ln.', 'Boston', 'USA'),
(122, 'Tony', 'Snowden', '+64 9 5555500', 'Arenales 1938 3\'A\'', 'Auckland  ', 'New Zealand');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(10) UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_orig_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `request_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_type` enum('RFS','TOR','ISR') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grouprole`
--

CREATE TABLE `grouprole` (
  `id` int(8) UNSIGNED NOT NULL,
  `group_id` int(10) NOT NULL,
  `user_id` int(8) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grouprole`
--

INSERT INTO `grouprole` (`id`, `group_id`, `user_id`, `status`) VALUES
(1, 1, 1, 'Active'),
(2, 1, 2, 'Active'),
(3, 3, 3, 'Active'),
(4, 21, 4, 'Active'),
(5, 2, 5, 'Active'),
(6, 1, 6, 'Active'),
(7, 3, 7, 'Active'),
(8, 3, 8, 'Active'),
(9, 5, 9, 'Active'),
(10, 2, 10, 'Active'),
(11, 1, 11, 'Active'),
(12, 1, 12, 'Active'),
(13, 1, 13, 'Active'),
(22, 3, 13, 'Active'),
(23, 2, 13, 'Inactive'),
(24, 1, 14, 'Active'),
(25, 3, 15, 'Active'),
(26, 3, 16, 'Active'),
(27, 0, 17, 'Active'),
(28, 1, 15, 'Active'),
(29, 1, 18, 'Active'),
(30, 3, 18, 'Active'),
(31, 7, 18, 'Inactive'),
(32, 6, 18, 'Inactive'),
(33, 5, 18, 'Inactive'),
(34, 2, 18, 'Active'),
(35, 4, 18, 'Inactive'),
(36, 3, 1, 'Active'),
(37, 2, 1, 'Active'),
(38, 2, 15, 'Active'),
(39, 1, 19, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `requestmode`
--

CREATE TABLE `requestmode` (
  `id` int(10) UNSIGNED NOT NULL,
  `themode` text NOT NULL,
  `fortype` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requestmode`
--

INSERT INTO `requestmode` (`id`, `themode`, `fortype`) VALUES
(1, 'Add', 0),
(2, 'Delete', 0),
(3, 'Edit', 0),
(4, 'Add New System', 7),
(5, 'Add New Module', 7),
(6, 'Modify Existing Module', 7),
(7, 'Add New Report', 7),
(8, 'Modify Existing Report', 7),
(9, 'Generate', 15),
(10, 'Installation', 7);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `companyname` varchar(100) NOT NULL,
  `buid` int(10) NOT NULL,
  `businessunit` varchar(100) NOT NULL,
  `contactno` varchar(15) DEFAULT NULL,
  `datetoday` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fromgroup` int(10) UNSIGNED NOT NULL,
  `togroup` int(10) UNSIGNED NOT NULL,
  `requestmode` int(10) UNSIGNED DEFAULT NULL,
  `userid` int(10) UNSIGNED NOT NULL,
  `executedby` varchar(255) NOT NULL,
  `approvedby` varchar(255) NOT NULL,
  `reviewedby` varchar(255) NOT NULL,
  `verifiedby` varchar(255) NOT NULL,
  `buheadid` int(10) UNSIGNED DEFAULT NULL,
  `cancelledby` varchar(255) NOT NULL,
  `typeofrequest` enum('RFS','TOR','ISR') NOT NULL,
  `rfstype` int(10) UNSIGNED DEFAULT NULL,
  `tortypes` int(10) UNSIGNED DEFAULT NULL,
  `purpose` varchar(300) NOT NULL,
  `details` varchar(300) DEFAULT NULL,
  `status` text NOT NULL,
  `requestnumber` int(10) UNSIGNED NOT NULL,
  `iadstatus` int(10) UNSIGNED DEFAULT NULL,
  `remarks` text,
  `generals` text,
  `security` text,
  `output` text,
  `typeofsystem` enum('NAV','IHS') DEFAULT NULL,
  `iscompleted` enum('Yes','No') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `companyname`, `buid`, `businessunit`, `contactno`, `datetoday`, `fromgroup`, `togroup`, `requestmode`, `userid`, `executedby`, `approvedby`, `reviewedby`, `verifiedby`, `buheadid`, `cancelledby`, `typeofrequest`, `rfstype`, `tortypes`, `purpose`, `details`, `status`, `requestnumber`, `iadstatus`, `remarks`, `generals`, `security`, `output`, `typeofsystem`, `iscompleted`) VALUES
(1, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-25 02:46:25', 3, 1, 3, 16, '', 'Andrew Wiggiñs', '', '', NULL, '', 'RFS', 1, 0, ' test', 'qweqwe', 'Pending', 1, NULL, NULL, '', '', '', NULL, 'No'),
(2, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-25 02:43:51', 3, 1, 2, 16, '', '', '', '', NULL, 'Jordan Poole', 'RFS', 1, 0, ' test', 'asdasd', 'Cancelled', 2, NULL, NULL, '', '', '', NULL, 'No'),
(3, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-25 00:16:02', 3, 1, 3, 16, 'Draymond Green', 'Andrew Wiggiñs', '', '', NULL, '', 'RFS', 1, 0, ' test ', 'wtfs', 'Pending', 3, NULL, NULL, 'test', ' test', 'test', NULL, 'No'),
(4, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-24 06:49:56', 3, 2, 3, 16, '', '', '', '', NULL, 'Jordan Poole', 'RFS', 3, NULL, 'test2', 'test', 'Cancelled', 4, NULL, NULL, NULL, NULL, NULL, NULL, 'No'),
(5, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-24 02:37:17', 3, 1, NULL, 16, '', '', '', '', NULL, '', 'TOR', NULL, 1, 'qwerty', 'qwerty', 'Pending', 1, NULL, NULL, NULL, NULL, NULL, NULL, 'No'),
(6, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-25 07:15:57', 3, 1, NULL, 16, 'Draymond Green', 'Andrew Wiggiñs', '', '', NULL, '', 'TOR', NULL, 1, 'test', 'test', 'Pending', 2, NULL, NULL, NULL, NULL, NULL, NULL, 'No'),
(7, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-22 05:47:17', 3, 1, NULL, 16, '', '', '', '', NULL, '', 'ISR', 28, 0, ' test', NULL, 'Pending', 1, NULL, NULL, 'test', ' test', 'test', '', 'No'),
(8, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-22 05:47:17', 3, 1, NULL, 16, '', '', '', '', NULL, '', 'ISR', 26, 0, ' test', NULL, 'Pending', 2, NULL, NULL, 'test', ' test', 'test', 'NAV', 'No'),
(9, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-22 05:47:17', 3, 1, NULL, 16, '', '', '', '', NULL, '', 'ISR', 30, 0, ' test      ', NULL, 'Pending', 3, NULL, NULL, 'wtf', ' test', 'test', 'NAV', 'No'),
(10, 'AGC', 1, 'HEAD OFFICE', '1234', '2022-11-23 05:37:06', 3, 3, NULL, 16, '', '', '', '', NULL, '', 'ISR', 26, NULL, ' test', NULL, 'Pending', 4, NULL, NULL, 'test', ' test', 'test', 'NAV', 'No'),
(11, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-24 03:02:40', 3, 2, NULL, 16, '', '', '', '', NULL, '', 'ISR', 27, NULL, ' test  ', NULL, 'Pending', 5, NULL, NULL, 'test', ' test', 'test', 'NAV', 'No'),
(12, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-24 03:02:40', 3, 3, NULL, 16, '', '', '', '', NULL, '', 'ISR', 26, NULL, ' test 2', NULL, 'Pending', 6, NULL, NULL, 'test2', ' test2', 'test2', 'IHS', 'No'),
(13, 'AGC', 1, 'HEAD OFFICE', '1234', '2022-11-24 05:05:23', 1, 1, 3, 1, 'Draymond Green', 'Andrew Wiggiñs', '', '', NULL, '', 'RFS', 1, NULL, 'dsdsad', 'asdasd', 'Approved', 5, NULL, NULL, NULL, NULL, NULL, NULL, 'Yes'),
(14, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-24 03:02:40', 3, 1, NULL, 16, '', '', '', '', NULL, '', 'ISR', 26, NULL, ' dedsdad', NULL, 'Pending', 7, NULL, NULL, 'adasda', ' asdasd', 'asdasd', 'NAV', 'No'),
(15, 'AGC', 5, 'GROUP 4 - FARMS', '1234', '2022-11-24 03:44:55', 3, 1, NULL, 16, 'Draymond Green', 'Andrew Wiggiñs', '', '', NULL, '', 'ISR', 27, NULL, ' sdsadasd', NULL, 'Approved', 8, NULL, NULL, 'asdasd', ' asdasd', 'asdasd', 'IHS', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `rfstypes`
--

CREATE TABLE `rfstypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `requesttype` text NOT NULL,
  `thecolumns` text NOT NULL,
  `usersgroup` int(10) UNSIGNED NOT NULL,
  `isr` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rfstypes`
--

INSERT INTO `rfstypes` (`id`, `requesttype`, `thecolumns`, `usersgroup`, `isr`) VALUES
(1, 'Price/s', 'Item Name,New Price', 0, 0),
(2, 'Customer/s', '', 0, 0),
(3, 'Item/s', '', 0, 0),
(4, 'UOM', '', 0, 0),
(5, 'Vendor/s', '', 0, 0),
(6, 'Other/s Please Specify', '', 0, 0),
(7, 'Software/System', '', 1, 0),
(8, 'Authorized Approver', '', 1, 0),
(9, 'FAD Users', '', 1, 0),
(10, 'Location/Subsidiary', '', 1, 0),
(11, 'Department', '', 1, 0),
(12, 'Item/s', 'Item Name,UOM', 1, 0),
(13, 'Position', '', 0, 0),
(14, 'Chart of Accounts', '', 0, 0),
(15, 'Reports/Docs.', '', 2, 0),
(16, 'Duplication of Entries', '', 0, 0),
(17, 'Uploaded Files', '', 0, 0),
(18, 'Blacklisted Entries', '', 0, 0),
(19, 'SIL', '', 0, 0),
(20, 'Dimension/s', '', 0, 0),
(21, 'Location Slot', '', 0, 0),
(22, 'Lessee Category', '', 0, 0),
(23, 'Lessee Type', '', 0, 0),
(24, 'Charges Setup', '', 0, 0),
(25, 'Bank Setup', '', 0, 0),
(26, 'New System/Program/Module Revision', '', 0, 1),
(27, 'As Enhancement/Improvement/Additional Output', '', 0, 1),
(28, 'To correct Errors/Erroneous Process/Incorrect Formula/Incorrect Data Output Report Format', '', 0, 1),
(29, 'Process Review', '', 0, 1),
(30, 'Others/Please Specify', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `taskrole`
--

CREATE TABLE `taskrole` (
  `id` int(10) NOT NULL,
  `usertype_id` int(10) NOT NULL,
  `user_id` int(8) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskrole`
--

INSERT INTO `taskrole` (`id`, `usertype_id`, `user_id`, `status`) VALUES
(1, 1, 1, 'Active'),
(2, 1, 2, 'Active'),
(3, 6, 3, 'Active'),
(4, 5, 4, 'Active'),
(5, 4, 5, 'Inactive'),
(6, 6, 6, 'Active'),
(7, 1, 7, 'Active'),
(8, 3, 8, 'Active'),
(9, 2, 9, 'Active'),
(10, 4, 10, 'Active'),
(11, 1, 11, 'Active'),
(12, 1, 12, 'Active'),
(13, 5, 13, 'Active'),
(105, 1, 0, 'Inactive'),
(106, 1, 13, 'Inactive'),
(107, 3, 13, 'Inactive'),
(108, 2, 13, 'Inactive'),
(109, 4, 13, 'Inactive'),
(110, 6, 13, 'Inactive'),
(111, 4, 14, 'Inactive'),
(112, 4, 15, 'Active'),
(113, 2, 16, 'Active'),
(114, 1, 16, 'Inactive'),
(115, 4, 16, 'Inactive'),
(116, 6, 16, 'Inactive'),
(117, 2, 15, 'Inactive'),
(118, 0, 17, 'Active'),
(119, 1, 18, 'Inactive'),
(120, 2, 14, 'Inactive'),
(121, 1, 5, 'Active'),
(122, 1, 14, 'Active'),
(123, 6, 18, 'Inactive'),
(124, 2, 18, 'Active'),
(125, 3, 18, 'Active'),
(126, 4, 18, 'Active'),
(127, 2, 1, 'Inactive'),
(128, 3, 1, 'Inactive'),
(129, 5, 18, 'Active'),
(130, 4, 1, 'Inactive'),
(131, 1, 19, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tortypes`
--

CREATE TABLE `tortypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `tortype` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tortypes`
--

INSERT INTO `tortypes` (`id`, `tortype`) VALUES
(1, 'Adjustment'),
(2, 'Authority to Re-Print'),
(3, 'Authority to Cancel');

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `group_id` int(10) UNSIGNED NOT NULL,
  `groupname` text NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`group_id`, `groupname`, `active`) VALUES
(1, 'FARMS', 1),
(2, 'FAD', 1),
(3, 'HRMS', 1),
(4, 'EBM', 1),
(5, 'RMS', 1),
(6, 'GO', 1),
(7, 'TK', 1),
(8, 'TMS', 1),
(9, 'BR', 1),
(10, 'GC', 1),
(11, 'VRS', 1),
(12, 'E-Loading', 1),
(13, 'Leasing', 1),
(14, 'TSMS', 1),
(15, 'Accounting', 1),
(16, 'ATP', 1),
(17, 'Process Audit', 1),
(18, 'ALTURUSH', 1),
(19, 'RMMS', 1),
(20, 'Navision', 1),
(21, 'MY NETGOSYO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userisrtypes`
--

CREATE TABLE `userisrtypes` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `isr_id` int(10) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userisrtypes`
--

INSERT INTO `userisrtypes` (`id`, `user_id`, `isr_id`, `status`) VALUES
(1, 16, 26, 'Active'),
(2, 16, 27, 'Active'),
(3, 16, 28, 'Active'),
(4, 16, 29, 'Active'),
(5, 16, 30, 'Active'),
(6, 18, 26, 'Active'),
(7, 18, 27, 'Active'),
(8, 18, 28, 'Active'),
(9, 18, 29, 'Active'),
(10, 18, 30, 'Active'),
(11, 15, 26, 'Active'),
(12, 15, 27, 'Active'),
(13, 15, 28, 'Active'),
(14, 15, 29, 'Active'),
(15, 15, 30, 'Active'),
(16, 13, 26, 'Active'),
(17, 13, 27, 'Active'),
(18, 13, 28, 'Active'),
(19, 13, 29, 'Active'),
(20, 13, 30, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `userrfstypes`
--

CREATE TABLE `userrfstypes` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `rfs_id` int(10) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userrfstypes`
--

INSERT INTO `userrfstypes` (`id`, `user_id`, `rfs_id`, `status`) VALUES
(1, 13, 1, 'Active'),
(2, 13, 2, 'Active'),
(3, 13, 3, 'Active'),
(4, 13, 4, 'Active'),
(5, 13, 5, 'Active'),
(6, 13, 19, 'Active'),
(7, 13, 20, 'Active'),
(8, 13, 24, 'Active'),
(9, 13, 33, 'Active'),
(10, 13, 32, 'Active'),
(11, 13, 6, 'Active'),
(12, 16, 1, 'Active'),
(13, 16, 2, 'Active'),
(14, 16, 3, 'Active'),
(15, 16, 4, 'Active'),
(16, 16, 5, 'Active'),
(17, 15, 1, 'Active'),
(18, 15, 2, 'Active'),
(19, 18, 1, 'Active'),
(20, 18, 2, 'Inactive'),
(21, 18, 3, 'Active'),
(22, 18, 4, 'Inactive'),
(23, 18, 5, 'Inactive'),
(24, 18, 6, 'Inactive'),
(25, 18, 7, 'Inactive'),
(26, 18, 8, 'Inactive'),
(27, 15, 3, 'Active'),
(28, 1, 1, 'Active'),
(29, 1, 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(8) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `position` varchar(50) NOT NULL,
  `allowcheck` int(10) DEFAULT NULL,
  `allowconcern` int(10) DEFAULT NULL,
  `allowisr` int(10) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `maintask` int(10) NOT NULL,
  `maingroup` int(10) NOT NULL,
  `mainbu` varchar(5) NOT NULL,
  `maincomp` varchar(3) NOT NULL,
  `superadmin` enum('Yes','No') NOT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fname`, `lname`, `position`, `allowcheck`, `allowconcern`, `allowisr`, `status`, `maintask`, `maingroup`, `mainbu`, `maincomp`, `superadmin`, `profile_pic`) VALUES
(1, 'chael', 'e10adc3949ba59abbe56e057f20f883e', 'Michael ', 'Malate', 'Programmer', 0, 1, 1, 'Active', 1, 1, '1', '01', 'Yes', 'default-pic.jpg'),
(2, 'danna05', 'e10adc3949ba59abbe56e057f20f883e', 'Danna', 'Banda', 'admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(3, 'amara01', 'e10adc3949ba59abbe56e057f20f883e', 'Amara', 'Banda', 'admin', 1, 0, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(4, 'leo05', 'e10adc3949ba59abbe56e057f20f883e', 'Leo', 'Malate', 'Admin', 1, 0, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(5, 'vj', 'e10adc3949ba59abbe56e057f20f883e', 'Vince', 'Malate', 'admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(6, 'merla1', 'e10adc3949ba59abbe56e057f20f883e', 'Merla', 'Malate', 'admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(7, 'chef', 'e10adc3949ba59abbe56e057f20f883e', 'Stephen', 'Curry', 'Admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(8, 'klay', 'e10adc3949ba59abbe56e057f20f883e', 'Klay', 'Thompson', 'Admin', 0, 0, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(9, 'mikeee', 'e10adc3949ba59abbe56e057f20f883e', 'John', 'Cruz', 'Admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(10, 'john', 'e10adc3949ba59abbe56e057f20f883e', 'Joel', 'Cruz', 'Admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(11, 'chael01', 'e10adc3949ba59abbe56e057f20f883e', 'Amara Brielle ', 'Malate', 'Admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(12, 'seth02', 'd41d8cd98f00b204e9800998ecf8427e', 'Seth', 'Curry', 'Admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'No', 'default-pic.jpg'),
(13, 'mike', 'e10adc3949ba59abbe56e057f20f883e', 'Michael', 'Jordan', 'Admin', 1, 0, 0, 'Active', 5, 3, '1', '01', 'No', 'default-pic.jpg'),
(14, 'klay01', 'e10adc3949ba59abbe56e057f20f883e', 'Klay', 'Thompson', 'System Programmer 1', 1, 1, 1, 'Active', 2, 2, '1', '01', 'No', 'default-pic.jpg'),
(15, 'dray01', 'e10adc3949ba59abbe56e057f20f883e', 'Draymond', 'Green', 'System Analyst 1', 1, 0, 1, 'Active', 4, 3, '1', '01', 'No', 'default-pic.jpg'),
(16, 'jp1', '83dc3c89e1abf7a58d35c87599f1b3bc', 'Jordan', 'Poole', 'System Programmer 1', 1, 0, 1, 'Active', 2, 3, '5', '01', 'No', '02723-20222022-08-01Profile18-34-16-PM.jpg'),
(17, '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 0, 0, 1, 'Active', 0, 0, '1', 'AGC', 'No', 'default-pic.jpg'),
(18, 'wiggs12', 'e10adc3949ba59abbe56e057f20f883e', 'Andrew', 'Wiggiñs', 'Supervisor', 1, 0, 1, 'Active', 3, 1, '1', '01', 'No', 'default-pic.jpg'),
(19, 'lbj1', '4c716cffd901f73bc882677d0884bc1e', 'Lebron', 'James', 'Admin', 1, 1, 1, 'Active', 1, 1, '1', '01', 'Yes', '');

-- --------------------------------------------------------

--
-- Table structure for table `usertortypes`
--

CREATE TABLE `usertortypes` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `tor_id` int(10) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertortypes`
--

INSERT INTO `usertortypes` (`id`, `user_id`, `tor_id`, `status`) VALUES
(1, 13, 1, 'Active'),
(2, 13, 2, 'Active'),
(3, 13, 3, 'Active'),
(4, 16, 1, 'Active'),
(5, 16, 2, 'Active'),
(6, 16, 3, 'Active'),
(7, 18, 1, 'Active'),
(8, 18, 2, 'Inactive'),
(9, 15, 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `usertype_id` int(8) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `taskcompletedrfs` varchar(30) NOT NULL,
  `taskcompletedtor` varchar(30) NOT NULL,
  `postion` varchar(100) NOT NULL,
  `theorder` int(2) NOT NULL,
  `taskrfs` varchar(20) NOT NULL,
  `tasktor` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`usertype_id`, `usertype`, `taskcompletedrfs`, `taskcompletedtor`, `postion`, `theorder`, `taskrfs`, `tasktor`) VALUES
(1, 'Admin', '', '', 'Administrator', 0, '', ''),
(2, 'Request', '', '', 'AP Clerk/AR Clerk/Bookeeper/Bu', 0, '', ''),
(3, 'Approve', 'Approved by', 'Approved by', 'Business Unit Head/Accounting ', 1, 'Approve', 'Approve'),
(4, 'Execute', 'Implemented by', 'Adjusted/Reprinted by', 'Programmer/MIS', 4, 'Implement', 'Adjust/Reprint'),
(5, 'Review', 'Reviewed by', 'Reviewed by', 'IAD Manager/Compliance Officer/Asst.Head Sys.Dev\'t', 2, 'Review', 'Review'),
(6, 'Verify', 'Verified by', 'Verified by', 'Supervisor/IAD', 3, 'Verify', 'Verify');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `burole`
--
ALTER TABLE `burole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_unit`
--
ALTER TABLE `business_unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `business_unit` (`business_unit`),
  ADD KEY `company_code` (`company_code`),
  ADD KEY `bunit_code` (`bunit_code`),
  ADD KEY `acroname` (`acroname`),
  ADD KEY `bcode` (`bcode`);

--
-- Indexes for table `butaskrole`
--
ALTER TABLE `butaskrole`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buid` (`buid`),
  ADD KEY `taskid` (`taskid`),
  ADD KEY `requesttype` (`requesttype`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_code`),
  ADD KEY `company` (`company`),
  ADD KEY `acroname` (`acroname`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `grouprole`
--
ALTER TABLE `grouprole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requestmode`
--
ALTER TABLE `requestmode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_2` (`fortype`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfstypes`
--
ALTER TABLE `rfstypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taskrole`
--
ALTER TABLE `taskrole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tortypes`
--
ALTER TABLE `tortypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`group_id`);
ALTER TABLE `usergroups` ADD FULLTEXT KEY `index_2` (`groupname`);

--
-- Indexes for table `userisrtypes`
--
ALTER TABLE `userisrtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userrfstypes`
--
ALTER TABLE `userrfstypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `usertortypes`
--
ALTER TABLE `usertortypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`usertype_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `burole`
--
ALTER TABLE `burole`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `business_unit`
--
ALTER TABLE `business_unit`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `butaskrole`
--
ALTER TABLE `butaskrole`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grouprole`
--
ALTER TABLE `grouprole`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `requestmode`
--
ALTER TABLE `requestmode`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rfstypes`
--
ALTER TABLE `rfstypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `taskrole`
--
ALTER TABLE `taskrole`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `tortypes`
--
ALTER TABLE `tortypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `group_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `userisrtypes`
--
ALTER TABLE `userisrtypes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `userrfstypes`
--
ALTER TABLE `userrfstypes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `usertortypes`
--
ALTER TABLE `usertortypes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `usertype_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
