-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2023 at 12:53 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_parent` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `id_parent`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Normalab France-sas', NULL, 1, NULL, NULL),
(2, 'Spectro, GmbH', NULL, 1, NULL, NULL),
(3, 'ECH, GmbH', NULL, 1, NULL, NULL),
(4, 'Paragon Scientific, U.K.', NULL, 1, NULL, NULL),
(5, 'FLAMMABILITY', 1, 1, NULL, NULL),
(6, 'VOLATILITY', 1, 1, NULL, NULL),
(7, 'CLOSED CUP', 5, 1, NULL, NULL),
(8, 'OPEN CUP', 5, 1, NULL, NULL),
(9, 'CLOD FLOW PROPERTIES', 1, 1, NULL, NULL),
(10, 'CLEANLINESS', 1, 1, NULL, NULL),
(11, 'OXIDATION', 10, 1, NULL, NULL),
(12, 'FUEL CHARACTERISTICS', 10, 1, NULL, NULL),
(13, 'COLOUR', 10, 1, NULL, NULL),
(14, 'CARBON & SEDIMENT', 10, 1, NULL, NULL),
(15, 'LUBRICANTS', 1, 1, NULL, NULL),
(16, 'BITUMEN, WAXES & GREASE', 1, 1, NULL, NULL),
(17, 'VISCOSITY', 1, 1, NULL, NULL),
(18, 'GLLASSWARE', 1, 1, NULL, NULL),
(19, 'GENERAL CATELOG', 1, 1, NULL, NULL),
(20, 'ICP-OES Spectrometers', 2, 1, NULL, NULL),
(21, 'XRF Spectrometers', 2, 1, NULL, NULL),
(22, 'General Spectrometers', 2, 1, NULL, NULL),
(23, 'Karl Fischer Titrators', 3, 1, NULL, NULL),
(24, 'H2S Analyzer', 3, 1, NULL, NULL),
(25, 'OnlineH2S', 3, 1, NULL, NULL),
(26, 'S-Online', 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`id`, `name`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'IGST', '18', '1', '2023-07-12 01:36:10', '2023-07-12 02:24:46'),
(2, 'FREIGHTCHARGE', '2000', '1', '2023-07-12 01:37:30', '2023-07-12 01:37:30'),
(3, 'INSTALLATION', '1000', '1', '2023-07-12 01:39:43', '2023-07-12 01:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `po_no` int(11) DEFAULT NULL,
  `freight` double DEFAULT NULL,
  `installation` float DEFAULT NULL,
  `type` tinyint(1) DEFAULT 0,
  `id_invoice` int(50) DEFAULT NULL,
  `pan_no` int(50) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `quote_id`, `invoice_no`, `po_no`, `freight`, `installation`, `type`, `id_invoice`, `pan_no`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 14, 'SSS/INV.1./FY 23 - 24', 3, 500, NULL, 0, NULL, NULL, '1', 1, '2023-09-16 03:32:00', '2023-09-16 03:32:00'),
(4, 14, 'SSS/PI.4./FY 23 - 24', 3, 500, NULL, 1, 3, NULL, '1', 1, '2023-09-16 03:32:00', '2023-09-16 03:32:00'),
(5, 16, 'SSS/INV.4./23 - 24', 5, 500, 660, 0, NULL, NULL, '1', 1, '2023-10-02 03:48:15', '2023-10-02 03:48:15'),
(6, 16, 'SSS/PI.6./23 - 24', 5, 500, 660, 1, 5, NULL, '1', 1, '2023-10-02 03:48:15', '2023-10-02 03:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_26_184936_create_categories_table', 1),
(6, '2023_04_26_190228_create_products_table', 1),
(7, '2023_04_27_170339_create_roles_table', 1),
(8, '2023_04_27_184712_create_quotes_table', 1),
(9, '2023_05_02_193620_create_product_cart_items_table', 1),
(10, '2023_06_23_153913_create_purchase_orders_table', 1),
(11, '2023_06_23_184752_create_invoices_table', 1),
(12, '2023_06_23_210338_create_purchase_order_products_table', 1),
(13, '2023_06_24_084140_create_configs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_category` bigint(20) UNSIGNED DEFAULT NULL,
  `sr_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pn_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hsn_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `type` int(5) DEFAULT 0,
  `sale_price` int(11) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_reusable` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `id_category`, `sr_no`, `pn_no`, `hsn_no`, `sku`, `name`, `slug`, `short_description`, `description`, `features`, `status`, `type`, `sale_price`, `is_featured`, `is_reusable`, `created_at`, `updated_at`) VALUES
(1, 7, NULL, 'PN_NO1', 'HSN_NO1', 'SSS_1', 'NPM 450 - PMCC - Automated', 'npm-450-pmcc-automated', '450 Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', 1, 0, 6787, 0, 0, NULL, NULL),
(2, 7, NULL, 'PN_NO2', 'HSN_NO2', 'SSS_2', 'NPV Tech - GO / NO GO - Automated', 'npv-tech-go-no-go-automated', 'NPV Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '1', 1, 0, 12466, 0, 0, NULL, NULL),
(3, 7, '3', 'PN_NO3', 'HSN_NO3', 'SSS_3', 'NAB 440 - Abel - Automated', 'nab-440-abel-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 8594, 0, 0, NULL, NULL),
(4, 7, '4', 'PN_NO4', 'HSN_NO4', 'SSS_4', 'NAB 110 - Abel - Manual', 'nab-110-abel-manual', 'Short Desciption ', 'Description', NULL, 1, 0, 14041, 0, 0, NULL, NULL),
(5, 7, '5', 'PN_NO5', 'HSN_NO5', 'SSS_5', 'NPM 131 - PMCC - Manual', 'npm-131-pmcc-manual', 'Short Desciption ', 'Description', NULL, 1, 0, 9792, 0, 0, NULL, NULL),
(6, 7, '6', 'PN_NO6', 'HSN_NO6', 'SSS_6', 'NTA 440 - Tag - Automated', 'nta-440-tag-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 11293, 0, 0, NULL, NULL),
(7, 7, '7', 'PN_NO7', 'HSN_NO7', 'SSS_7', 'NAB TECH - Half Automated', 'nab-tech-half-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 9566, 0, 0, NULL, NULL),
(8, 7, '8', 'PN_NO8', 'HSN_NO8', 'SSS_8', 'NPM TECH - PMCC - Half Automated', 'npm-tech-pmcc-half-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 9835, 0, 0, NULL, NULL),
(9, 7, '9', 'PN_NO9', 'HSN_NO9', 'SSS_9', 'NPM TECH - PMCC_8', 'npm-tech-pmcc_8', 'Short Desciption ', 'Description', NULL, 1, 0, 13012, 0, 0, NULL, NULL),
(10, 8, '10', 'PN_NO10', 'HSN_NO10', 'SSS_10', 'NCL 120 - Clevelannd - Manual', 'ncl-120-clevelannd-manual', 'Short Desciption ', 'Description', NULL, 1, 0, 7302, 0, 0, NULL, NULL),
(11, 8, '11', 'PN_NO11', 'HSN_NO11', 'SSS_11', 'NCL 440 - Cleveland - Automated', 'ncl-440-cleveland-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 5494, 0, 0, NULL, NULL),
(12, 6, '12', 'PN_NO12', 'HSN_NO12', 'SSS_12', 'CWB Classic - Reid Vapour Pressure', 'cwb-classic-reid-vapour-pressure', 'Short Desciption ', 'Description', NULL, 1, 0, 12138, 0, 0, NULL, NULL),
(13, 6, '13', 'PN_NO13', 'HSN_NO13', 'SSS_13', 'NDI 450 - Atmospheric Distillation - Automated', 'ndi-450-atmospheric-distillation-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 6116, 0, 0, NULL, NULL),
(14, 6, '14', 'PN_NO14', 'HSN_NO14', 'SSS_14', 'NDI Classic - Atmospheric Distillation - Half Automated', 'ndi-classic-atmospheric-distillation-half-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 8915, 0, 0, NULL, NULL),
(15, 6, '15', 'PN_NO15', 'HSN_NO15', 'SSS_15', 'NDI Basic - Atmospheric Distillation - Manual', 'ndi-basic-atmospheric-distillation-manual', 'Short Desciption ', 'Description', NULL, 1, 0, 14496, 0, 0, NULL, NULL),
(16, 9, '16', 'PN_NO16', 'HSN_NO16', 'SSS_16', 'CPP Classic - Cloud and Pour Point - Cabinet', 'cpp-classic-cloud-and-pour-point-cabinet', 'Short Desciption ', 'Description', NULL, 1, 0, 11548, 0, 0, NULL, NULL),
(17, 11, '17', 'PN_NO17', 'HSN_NO17', 'SSS_17', 'NGT Classic - Air / Steam Jet', 'ngt-classic-air-steam-jet', 'Short Desciption ', 'Description', NULL, 1, 0, 11764, 0, 0, NULL, NULL),
(18, 11, '18', 'PN_NO18', 'HSN_NO18', 'SSS_18', 'NPI 442 - Induction Period and Potential Gums', 'npi-442-induction-period-and-potential-gums', 'Short Desciption ', 'Description', NULL, 1, 0, 5642, 0, 0, NULL, NULL),
(19, 11, '19', 'PN_NO19', 'HSN_NO19', 'SSS_19', 'TOST Classic - Oxidation Characteristics', 'tost-classic-oxidation-characteristics', 'Short Desciption ', 'Description', NULL, 1, 0, 7014, 0, 0, NULL, NULL),
(20, 12, '20', 'PN_NO20', 'HSN_NO20', 'SSS_20', 'NTB Classic - Copper Corrosion', 'ntb-classic-copper-corrosion', 'Short Desciption ', 'Description', NULL, 1, 0, 9846, 0, 0, NULL, NULL),
(21, 12, '21', 'PN_NO21', 'HSN_NO21', 'SSS_21', 'NAE 440 - Aniline Point - Automated', 'nae-440-aniline-point-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 5532, 0, 0, NULL, NULL),
(22, 12, '22', 'PN_NO22', 'HSN_NO22', 'SSS_22', 'NABLEND - Blender - Automated', 'nablend-blender-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 5805, 0, 0, NULL, NULL),
(23, 13, '23', 'PN_NO23', 'HSN_NO23', 'SSS_23', 'AF 650 - ASTM Colour', 'af-650-astm-colour', 'Short Desciption ', 'Description', NULL, 1, 0, 9648, 0, 0, NULL, NULL),
(24, 13, '24', 'PN_NO24', 'HSN_NO24', 'SSS_24', 'SC Classic - Saybolt Chromometer', 'sc-classic-saybolt-chromometer', 'Short Desciption ', 'Description', NULL, 1, 0, 14131, 0, 0, NULL, NULL),
(25, 14, '25', 'PN_NO25', 'HSN_NO25', 'SSS_25', 'ARCOS', 'arcos', 'Short Desciption ', 'Description', NULL, 1, 0, 5487, 0, 0, NULL, NULL),
(26, 14, '26', 'PN_NO26', 'HSN_NO26', 'SSS_26', 'SPECTRO GENESIS', 'spectro-genesis', 'Short Desciption ', 'Description', NULL, 1, 0, 5108, 0, 0, NULL, NULL),
(27, 14, '27', 'PN_NO27', 'HSN_NO27', 'SSS_27', 'SPECTRO BLUE', 'spectro-blue', 'Short Desciption ', 'Description', NULL, 1, 0, 7435, 0, 0, NULL, NULL),
(28, 14, '28', 'PN_NO28', 'HSN_NO28', 'SSS_28', 'SPECTRO GREEN', 'spectro-green', 'Short Desciption ', 'Description', NULL, 1, 0, 7726, 0, 0, NULL, NULL),
(29, 15, '29', 'PN_NO29', 'HSN_NO29', 'SSS_29', 'DEM Classic - Water / Oil Separator', 'dem-classic-water-oil-separator', 'Short Desciption ', 'Description', NULL, 1, 0, 12703, 0, 0, NULL, NULL),
(30, 15, '30', 'PN_NO30', 'HSN_NO30', 'SSS_30', 'ARV Tech - Air Release Value', 'arv-tech-air-release-value', 'Short Desciption ', 'Description', NULL, 1, 0, 11718, 0, 0, NULL, NULL),
(31, 15, '31', 'PN_NO31', 'HSN_NO31', 'SSS_31', 'FOAM2 Classic - Double Bath Version', 'foam2-classic-double-bath-version', 'Short Desciption ', 'Description', NULL, 1, 0, 5019, 0, 0, NULL, NULL),
(32, 15, '32', 'PN_NO32', 'HSN_NO32', 'SSS_32', 'FOAM HT Classic - High Temperatures', 'foam-ht-classic-high-temperatures', 'Short Desciption ', 'Description', NULL, 1, 0, 12048, 0, 0, NULL, NULL),
(33, 16, '33', 'PN_NO33', 'HSN_NO33', 'SSS_33', 'GWM Classic - Grease Worker - Automated', 'gwm-classic-grease-worker-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 7612, 0, 0, NULL, NULL),
(34, 16, '34', 'PN_NO34', 'HSN_NO34', 'SSS_34', 'RTFOT Classic - RTFOT Ageing Oven', 'rtfot-classic-rtfot-ageing-oven', 'Short Desciption ', 'Description', NULL, 1, 0, 5217, 0, 0, NULL, NULL),
(35, 16, '35', 'PN_NO35', 'HSN_NO35', 'SSS_35', 'NBA Classic - Softening Point - Automated', 'nba-classic-softening-point-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 14602, 0, 0, NULL, NULL),
(36, 16, '36', 'PN_NO36', 'HSN_NO36', 'SSS_36', 'Penetrometer - Manual', 'penetrometer-manual', 'Short Desciption ', 'Description', NULL, 1, 0, 7850, 0, 0, NULL, NULL),
(37, 16, '37', 'PN_NO37', 'HSN_NO37', 'SSS_37', 'NPN Tech - Penetrometer - Automated', 'npn-tech-penetrometer-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 14556, 0, 0, NULL, NULL),
(38, 17, '38', 'PN_NO38', 'HSN_NO38', 'SSS_38', 'CHRONOTECH - Automatic Chronometer', 'chronotech-automatic-chronometer', 'Short Desciption ', 'Description', NULL, 1, 0, 14276, 0, 0, NULL, NULL),
(39, 17, '39', 'PN_NO39', 'HSN_NO39', 'SSS_39', 'VTW Classic - Viscometer Washer - Automated', 'vtw-classic-viscometer-washer-automated', 'Short Desciption ', 'Description', NULL, 1, 0, 8093, 0, 0, NULL, NULL),
(40, 17, '40', 'PN_NO40', 'HSN_NO40', 'SSS_40', 'NVB Classic - Viscosity Bath', 'nvb-classic-viscosity-bath', 'Short Desciption ', 'Description', NULL, 1, 0, 5845, 0, 0, NULL, NULL),
(41, 18, '41', 'PN_NO41', 'HSN_NO41', 'SSS_41', 'Centrifuge glassware', 'centrifuge-glassware', 'Short Desciption ', 'Description', NULL, 1, 0, 9444, 0, 0, NULL, NULL),
(42, 18, '42', 'PN_NO42', 'HSN_NO42', 'SSS_42', 'Distillation glassware', 'distillation-glassware', 'Short Desciption ', 'Description', NULL, 1, 0, 10106, 0, 0, NULL, NULL),
(43, 18, '43', 'PN_NO43', 'HSN_NO43', 'SSS_43', 'Houillon glassware', 'houillon-glassware', 'Short Desciption ', 'Description', NULL, 1, 0, 12149, 0, 0, NULL, NULL),
(44, 18, '44', 'PN_NO44', 'HSN_NO44', 'SSS_44', 'Normalab Petroleum Glassware 2020HD', 'normalab-petroleum-glassware-2020hd', 'Short Desciption ', 'Description', NULL, 1, 0, 6258, 0, 0, NULL, NULL),
(45, 19, '45', 'PN_NO45', 'HSN_NO45', 'SSS_45', 'GENERAL CATELOG', 'general-catelog', 'Short Desciption ', 'Description', NULL, 1, 0, 13587, 0, 0, NULL, NULL),
(46, 20, '46', 'PN_NO46', 'HSN_NO46', 'SSS_46', 'ARCOS_25', 'arcos_25', 'Short Desciption ', 'Description', NULL, 1, 0, 8064, 0, 0, NULL, NULL),
(47, 20, '47', 'PN_NO47', 'HSN_NO47', 'SSS_47', 'SPECTRO GENESIS_26', 'spectro-genesis_26', 'Short Desciption ', 'Description', NULL, 1, 0, 14262, 0, 0, NULL, NULL),
(48, 20, '48', 'PN_NO48', 'HSN_NO48', 'SSS_48', 'SPECTRO BLUE_27', 'spectro-blue_27', 'Short Desciption ', 'Description', NULL, 1, 0, 9990, 0, 0, NULL, NULL),
(49, 20, '49', 'PN_NO49', 'HSN_NO49', 'SSS_49', 'SPECTRO GREEN_28', 'spectro-green_28', 'Short Desciption ', 'Description', NULL, 1, 0, 13350, 0, 0, NULL, NULL),
(50, 21, '50', 'PN_NO50', 'HSN_NO50', 'SSS_50', 'SPECTRO CUBE', 'spectro-cube', 'Short Desciption ', 'Description', NULL, 1, 0, 7618, 0, 0, NULL, NULL),
(51, 21, '51', 'PN_NO51', 'HSN_NO51', 'SSS_51', 'SPECTRO XEPOS', 'spectro-xepos', 'Short Desciption ', 'Description', NULL, 1, 0, 9748, 0, 0, NULL, NULL),
(52, 22, '52', 'PN_NO52', 'HSN_NO52', 'SSS_52', 'GENERAL SPECTRO', 'general-spectro', 'Short Desciption ', 'Description', NULL, 1, 0, 14625, 0, 0, NULL, NULL),
(53, 23, '53', 'PN_NO53', 'HSN_NO53', 'SSS_53', 'Aquamax KF Plus', 'aquamax-kf-plus', 'Short Desciption ', 'Description', NULL, 1, 0, 7009, 0, 0, NULL, NULL),
(54, 23, '54', 'PN_NO54', 'HSN_NO54', 'SSS_54', 'Aquamax KF Portable', 'aquamax-kf-portable', 'Short Desciption ', 'Description', NULL, 1, 0, 12908, 0, 0, NULL, NULL),
(55, 23, '55', 'PN_NO55', 'HSN_NO55', 'SSS_55', 'Aquamax KF PRO LPG', 'aquamax-kf-pro-lpg', 'Short Desciption ', 'Description', NULL, 1, 0, 9936, 0, 0, NULL, NULL),
(56, 23, '56', 'PN_NO56', 'HSN_NO56', 'SSS_56', 'Aquamax KF PRO Oil', 'aquamax-kf-pro-oil', 'Short Desciption ', 'Description', NULL, 1, 0, 10826, 0, 0, NULL, NULL),
(57, 23, '57', 'PN_NO57', 'HSN_NO57', 'SSS_57', 'AQUA 40.00 Basic Module', 'aqua-4000-basic-module', 'Short Desciption ', 'Description', NULL, 1, 0, 11284, 0, 0, NULL, NULL),
(58, 23, '58', 'PN_NO58', 'HSN_NO58', 'SSS_58', 'AQUA 40.00 Vario Headspace', 'aqua-4000-vario-headspace', 'Short Desciption ', 'Description', NULL, 1, 0, 14874, 0, 0, NULL, NULL),
(59, 23, '59', 'PN_NO59', 'HSN_NO59', 'SSS_59', 'AQUA 40.00 with HT 1300', 'aqua-4000-with-ht-1300', 'Short Desciption ', 'Description', NULL, 1, 0, 11746, 0, 0, NULL, NULL),
(60, 23, '60', 'PN_NO60', 'HSN_NO60', 'SSS_60', 'OnlineH2O', 'onlineh2o', 'Short Desciption ', 'Description', NULL, 1, 0, 8788, 0, 0, NULL, NULL),
(61, 24, '61', 'PN_NO61', 'HSN_NO61', 'SSS_61', 'H2S ANALYZER Lab', 'h2s-analyzer-lab', 'Short Desciption ', 'Description', NULL, 1, 0, 14400, 0, 0, NULL, NULL),
(62, 24, '62', 'PN_NO62', 'HSN_NO62', 'SSS_62', 'H2S ANALYZER Cubi', 'h2s-analyzer-cubi', 'Short Desciption ', 'Description', NULL, 1, 0, 13341, 0, 0, NULL, NULL),
(63, 24, '63', 'PN_NO63', 'HSN_NO63', 'SSS_63', 'Headspace Module', 'headspace-module', 'Short Desciption ', 'Description', NULL, 1, 0, 14761, 0, 0, NULL, NULL),
(64, 25, '64', 'PN_NO64', 'HSN_NO64', 'SSS_64', 'Online H2S', 'online-h2s', 'Short Desciption ', 'Description', NULL, 1, 0, 7740, 0, 0, NULL, NULL),
(65, 26, '65', 'PN_NO65', 'HSN_NO65', 'SSS_65', 'S Online', 's-online', 'Short Desciption ', 'Description', NULL, 1, 0, 10240, 0, 0, NULL, NULL),
(66, 4, '66', 'PN_NO66', 'HSN_NO66', 'SSS_66', 'Paragon Scientific Ltd Products & Service', 'paragon-scientific-ltd-products-service', 'Short Desciption ', 'Description', NULL, 1, 0, 9281, 0, 0, NULL, NULL),
(67, 1, NULL, 'PN001', 'HSN001', 'T001', 'Test', 'test', 'short Description', 'long description', '1', 1, 0, 500, 1, 0, NULL, NULL),
(68, 1, NULL, 'PN01', 'HSN01', 'demo1', 'Demo', 'demo', 'short desc', 'long desc', '1', 2, 0, 7000, 1, 0, NULL, NULL),
(70, 1, NULL, 'pn001', 'HSN001', 'dd', 'dd', 'dd', 'short', 'long', '1', 1, 0, 200, 1, 0, NULL, NULL),
(71, 1, NULL, 'PN007', 'HSN007', 'ss', 'SS', 'ss', 'shor', 'long', '1', 1, 0, 9000, 1, 0, NULL, NULL),
(72, 1, NULL, 'PN008', 'HSN008', 'ss', '88', '88', 'short', 'long', '1', 1, 0, 9000, 1, 0, NULL, NULL),
(73, 7, NULL, 'accc01', 'hsn001', 'acc', 'Acces', NULL, 'desc', 'desc', '1', 1, 1, 2000, 1, 0, NULL, NULL),
(74, NULL, NULL, 'acc2', 'hsn2', 'acc2', 'Acc2', NULL, 'short description', 'long description', '1', 1, 1, 500, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_cart_items`
--

CREATE TABLE `product_cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `original_asset_value` decimal(10,2) NOT NULL,
  `asset_value` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_id` int(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_cart_items`
--

INSERT INTO `product_cart_items` (`id`, `quote_id`, `product_id`, `original_asset_value`, `asset_value`, `quantity`, `item_id`, `created_at`, `updated_at`) VALUES
(2, 1, 4, '236.00', '15000.00', 1, NULL, NULL, NULL),
(4, 2, 3, '8594.00', '8594.00', 1, NULL, NULL, NULL),
(5, 2, 9, '13012.00', '13012.00', 1, NULL, NULL, NULL),
(6, 2, 8, '9835.00', '10000.00', 1, NULL, NULL, NULL),
(7, 6, 1, '6787.00', '50000.00', 1, NULL, NULL, NULL),
(8, 6, 22, '5805.00', '40000.00', 1, NULL, NULL, NULL),
(9, 11, 32, '12048.00', '12048.00', 1, NULL, NULL, NULL),
(10, 11, 31, '5019.00', '5019.00', 5, NULL, NULL, NULL),
(11, 12, 1, '6787.00', '6787.00', 1, NULL, NULL, NULL),
(12, 12, 2, '12466.00', '12466.00', 1, NULL, NULL, NULL),
(13, 13, 1, '6787.00', '10000.00', 1, NULL, NULL, NULL),
(14, 13, 2, '12466.00', '12466.00', 1, NULL, NULL, NULL),
(15, 14, 1, '6787.00', '7000.00', 1, NULL, NULL, NULL),
(16, 14, 2, '12466.00', '15000.00', 1, NULL, NULL, NULL),
(18, 15, 1, '6787.00', '6787.00', 1, NULL, NULL, NULL),
(19, 15, 2, '12466.00', '12466.00', 1, NULL, NULL, NULL),
(20, 1, 1, '6787.00', '1000.00', 1, NULL, NULL, NULL),
(21, 16, 1, '6787.00', '8000.00', 1, NULL, NULL, NULL),
(24, 16, 74, '2000.00', '500.00', 1, 21, NULL, NULL),
(26, 16, 73, '2000.00', '2000.00', 1, 22, NULL, NULL),
(27, 16, 74, '2000.00', '500.00', 1, 22, NULL, NULL),
(28, 16, 2, '12466.00', '12466.00', 1, NULL, NULL, NULL),
(29, 16, 74, '12466.00', '1500.00', 1, 28, NULL, NULL),
(30, 16, 73, '12466.00', '2500.00', 1, 28, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(50) NOT NULL,
  `id_product` int(50) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `id_product`, `image_name`, `is_default`) VALUES
(6, 1, '1693598248_ASTM_D93_Pensky-Martens_Flash_point_NPM_450.png', 0),
(7, 2, '1693598301_ASTM_D3828_Flash-Point_NPV-Tech.png', 0),
(8, 72, '1693641193_IP_170_Abel_Flash_Point_NAB_440.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `po_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendor_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attn_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_no`, `vendor_id`, `attn_no`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SSS/P.O.1./FY 23 - 24', '9', 'ATTT', '1', NULL, NULL),
(2, 'SSS/P.O.2./FY 23 - 24', '10', '200', '1', NULL, NULL),
(3, 'SSS/P.O.2./FY 23 - 24', '11', 'ATTN001', '1', NULL, NULL),
(4, 'SSS/P.O.4./FY 23 - 24', '11', 'ATTN', '1', NULL, NULL),
(5, 'SSS/P.O.5./FY 23 - 24', '11', 'ATTN001', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_products`
--

CREATE TABLE `purchase_order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_order_id` bigint(20) UNSIGNED NOT NULL,
  `id_product` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_products`
--

INSERT INTO `purchase_order_products` (`id`, `purchase_order_id`, `id_product`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2023-07-03 06:34:59', '2023-07-03 06:34:59'),
(2, 1, 1, '2023-07-03 06:34:59', '2023-07-03 06:34:59'),
(5, 3, 1, '2023-09-08 01:48:28', '2023-09-08 01:48:28'),
(6, 3, 2, '2023-09-08 01:48:28', '2023-09-08 01:48:28'),
(7, 4, 1, '2023-09-17 01:53:20', '2023-09-17 01:53:20'),
(8, 2, 8, '2023-09-17 01:53:50', '2023-09-17 01:53:50'),
(9, 2, 19, '2023-09-17 01:53:50', '2023-09-17 01:53:50'),
(10, 5, 1, '2023-09-17 05:59:08', '2023-09-17 05:59:08'),
(11, 5, 2, '2023-09-17 05:59:08', '2023-09-17 05:59:08');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quote_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cust_id` int(11) DEFAULT NULL,
  `order_type` int(11) DEFAULT NULL,
  `gst_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tendor_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `due_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apt_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_option` int(11) NOT NULL DEFAULT 0,
  `billing_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_apt_no` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_zipcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_from` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_agency` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_enquired` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `i_gst` int(10) DEFAULT NULL,
  `c_gst` int(10) DEFAULT NULL,
  `s_gst` int(10) DEFAULT NULL,
  `freight` float DEFAULT NULL,
  `freight_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `freight_percentage` int(50) DEFAULT 0,
  `installation` float DEFAULT NULL,
  `installation_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `installation_percentage` int(50) DEFAULT 0,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `action_type` int(11) DEFAULT NULL,
  `action_by` int(11) DEFAULT NULL,
  `action_at` int(11) DEFAULT NULL,
  `action_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amended_on` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `quote_no`, `phone_number`, `email`, `token`, `reference`, `cust_id`, `order_type`, `gst_no`, `tendor_no`, `due_date`, `address`, `apt_no`, `zipcode`, `city`, `state`, `billing_option`, `billing_address`, `billing_apt_no`, `billing_zipcode`, `billing_city`, `billing_state`, `relation`, `reference_from`, `referral`, `referral_agency`, `is_enquired`, `currency_type`, `discount`, `i_gst`, `c_gst`, `s_gst`, `freight`, `freight_type`, `freight_percentage`, `installation`, `installation_type`, `installation_percentage`, `notes`, `status`, `action_type`, `action_by`, `action_at`, `action_note`, `amended_on`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Quote-1688368944-1', NULL, NULL, NULL, NULL, 4, 1, NULL, NULL, NULL, 'Vasai', '50', '401203', 'Mumbai', '1', 1, 'Vasai', '50', '401203', 'Mumbai', 'MH', NULL, 'Friend', 'Pandey', NULL, 'No', 'INR', 2000, 15, 0, 0, 5000, '0', 0, 5000, '0', 0, 'Testing note', 1, 2, 1, 1688369138, 'Approved by Ram', NULL, 1, '2023-07-03 06:22:24', NULL),
(2, 'Quote-1692426785-2', NULL, NULL, NULL, NULL, 10, 1, NULL, NULL, NULL, '114 Ram krishna', '5', '401203', 'Mumbai', '1', 1, '114 Ram krishna', '5', '401203', 'Mumbai', 'MH', NULL, 'Partner', 'ABC Pvt ltd', NULL, 'No', 'USD', 10000, NULL, NULL, NULL, NULL, '0', 0, NULL, '0', 0, 'This is testing note', 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-08-19 01:03:04', NULL),
(3, 'Quote-1692427438-3', NULL, NULL, NULL, NULL, 9, 0, NULL, NULL, NULL, 'Shop No. 3 Wadala', '20', '404203', 'Mumbai', '1', 1, 'Shop No. 3 Wadala', '20', '401203', 'Mumbai', 'MH', NULL, 'Online', NULL, NULL, 'No', 'USD', NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, '0', 0, 'Added for testing purpose', 1, NULL, NULL, NULL, NULL, NULL, 8, '2023-08-19 01:13:58', NULL),
(6, 'Quote-1693046776-6', NULL, NULL, NULL, NULL, 2, 1, NULL, 'TD001', '2023-09-09', 'Ram Krishna sadan', '114', '401304', 'Mumbai', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Friend', 'Friend', NULL, 'No', 'EURO', 5000, NULL, NULL, NULL, NULL, '0', 0, NULL, '0', 0, 'added for testing purpose', 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-08-26 05:16:16', NULL),
(10, 'Quote-1693508644-10', '+1-586-906-5289', 'dortha64@example.com', NULL, NULL, 9, 1, NULL, 'TN001', '2023-10-07', 'Vasai', '201', '400155', 'Mumbai', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Sociol', 'Ram Verma', NULL, 'No', 'EURO', NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, '0', 0, 'test for note', 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-08-31 01:34:04', NULL),
(11, 'Quote-1693508843-11', '+1-586-906-5289', 'dortha64@example.com', NULL, NULL, 9, 1, NULL, 'TN001', '2023-09-28', 'Vasai', '201', '401203', 'Mumbai', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EURO', NULL, 15, NULL, NULL, 500, '0', 0, NULL, '0', 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-08-31 01:37:23', NULL),
(12, 'Quote-1693598634-12', '+1-586-906-5289', 'dortha64@example.com', NULL, NULL, 9, 1, NULL, 'TN001', '2023-10-08', 'Vasai', '502', '401304', 'Mumbai', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'Friend', 'Vishal Pandey', NULL, 'No', 'EURO', 5000, 15, 0, 0, 5000, '0', 0, NULL, '0', 0, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-09-01 02:33:54', NULL),
(13, 'Quote-1693641294-13', '+1-724-930-3465', 'jennie35@example.net', NULL, NULL, 3, 1, NULL, 'TN001', '2023-09-30', 'Vasai', '20', '401203', 'Mumbai', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'EURO', 2000, 15, 0, 0, 6000, '0', 0, 2500, '0', 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-09-02 02:24:53', NULL),
(14, 'Quote-1694200943-14', '+1-724-930-3465', 'jennie35@example.net', NULL, NULL, 3, 1, NULL, 'TN0001', '2023-09-09', 'Mumbai', '201', '401304', 'Mumbai', '1', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GBP', NULL, NULL, NULL, NULL, NULL, '0', 0, NULL, '0', 0, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-09-08 01:52:22', NULL),
(15, 'Quote-1694718321-15', '8846130125', 'rakesh@gmail.com', NULL, NULL, 14, 1, 'GST00123', 'TN0145', '2023-09-29', 'S1', '2001', '401203', 'Mumbai', '1', 1, 'S1', '2001', '401203', 'Mumbai', 'MH', NULL, 'Online', 'Friend', NULL, 'No', 'EURO', NULL, 15, 0, 0, 2000, '0', 15, 3851, '%', 20, 'Test', 1, NULL, NULL, NULL, NULL, NULL, 1, '2023-09-14 01:35:21', NULL),
(16, 'SSS/Quote/16/23-24', '8846130125', 'rakesh@gmail.com', NULL, NULL, 14, 0, 'GST00123', '', '', 'Test', '200', '401203', 'Mumbai', '1', 1, 'Test', '200', '401203', 'Mumbai', 'MH', NULL, NULL, NULL, NULL, NULL, 'EURO', NULL, 10, 10, 10, 2700, '%', 15, 2700, '%', 15, 'test', 1, NULL, NULL, NULL, NULL, '2023-11-03', 1, '2023-10-01 02:16:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '2023-08-20 03:49:27', '2023-08-20 03:49:27'),
(2, 'Business Head', 1, '2023-08-20 03:49:44', '2023-08-20 03:49:44'),
(3, 'Executive', 1, '2023-08-20 03:50:00', '2023-08-20 03:50:00'),
(4, 'Customer', 1, '2023-08-20 03:50:17', '2023-08-20 03:50:17'),
(5, 'Vendors', 1, '2023-08-20 03:57:25', '2023-08-20 03:57:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gst_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `id_manager` int(50) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `gst_no`, `email_verified_at`, `phone_number`, `role_id`, `id_manager`, `status`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sonu', 'Verma', 'sonu@gmail.com', NULL, '2023-07-01 18:59:23', '9545577850', 1, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'DJ8MZxffXZ1S5EMC7k2zOKW02ha123xPhFXyxtApQTaXfiBEKBWyVVQDuj5E', '2023-07-01 18:59:23', '2023-07-07 13:14:24'),
(2, 'Adalberto', 'Casper', 'gparisian@example.net', NULL, '2023-07-01 18:59:23', '+19474797297', 3, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5Xf9rUPL2x', '2023-07-01 18:59:23', '2023-07-01 18:59:23'),
(3, 'Natalia', 'Schoen', 'jennie35@example.net', NULL, '2023-07-01 18:59:23', '+1-724-930-3465', 2, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EiuHt5QJX3', '2023-07-01 18:59:23', '2023-07-01 18:59:23'),
(4, 'Robert', 'Leannon', 'shields.suzanne@example.net', NULL, '2023-07-01 18:59:23', '(442) 206-2984', 1, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Bu6vr7lRTw', '2023-07-01 18:59:23', '2023-07-01 18:59:23'),
(5, 'Emeryy', 'Leannon', 'larkin.asa@example.com', NULL, '2023-07-01 18:59:23', '919-274-5167', 5, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '7z18hkzM0o', '2023-07-01 18:59:24', '2023-08-20 05:17:14'),
(6, 'Leonie', 'Conroy', 'rita.kuhn@example.net', NULL, '2023-07-01 18:59:23', '704.624.5329', 3, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'YwgtNoejaX', '2023-07-01 18:59:24', '2023-07-01 18:59:24'),
(7, 'Charity', 'Hauck', 'monique.kub@example.net', NULL, '2023-07-01 18:59:23', '864-237-8809', 5, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'NVO4cGeS3I', '2023-07-01 18:59:24', '2023-08-20 04:08:32'),
(8, 'Lillie', 'Schimmel', 'omills@example.org', NULL, '2023-07-01 18:59:23', '781-581-9756', 2, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'A49uNkOvXz', '2023-07-01 18:59:24', '2023-07-01 18:59:24'),
(9, 'Jillian', 'Thiel', 'dortha64@example.com', NULL, '2023-07-01 18:59:23', '+1-586-906-5289', 4, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'R0giV1FdGg', '2023-07-01 18:59:24', '2023-07-01 18:59:24'),
(10, 'Enos', 'Pfannerstill', 'fleta49@example.com', 'ABC123', '2023-07-01 18:59:23', '+1 (838) 691-7677', 4, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'KoybRBGJ4y', '2023-07-01 18:59:24', '2023-07-05 00:47:56'),
(11, 'Vendor 1', 'V', 'vendor@gmail.com', 'GSTNO', NULL, '7946132121', 5, NULL, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-08-20 05:46:44', '2023-08-20 05:46:44'),
(12, 'Mohit', 'shah', 'mohit@gmail.com', NULL, NULL, '8946546466', 3, 3, '1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2023-09-11 13:32:59', '2023-09-11 13:32:59'),
(13, 'Sagar', 'singh', 'sagar@gmail.com', NULL, NULL, '7945613225', 3, 8, '1', '$2y$10$4MehxgQdWVDjXHoAGS7Ov.moFLeA13hu2Ul3f.PkLt7d2EXSNT/NW', NULL, '2023-09-11 13:34:14', '2023-09-15 14:56:03'),
(14, 'Rakesh', 'Pandey', 'rakesh@gmail.com', 'GST00123', NULL, '8846130125', 4, NULL, '1', NULL, NULL, '2023-09-29 02:19:03', '2023-09-29 03:10:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `product_cart_items`
--
ALTER TABLE `product_cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_number_unique` (`phone_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `product_cart_items`
--
ALTER TABLE `product_cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_order_products`
--
ALTER TABLE `purchase_order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
