-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2026 at 11:07 AM
-- Server version: 10.6.25-MariaDB
-- PHP Version: 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `signlwzv_emiltonweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password_hash`, `created_at`, `last_login`, `is_active`) VALUES
(1, 'admin', 'admin@hotel.local', '$2y$10$dnjjDg220LHdaF7VCZ5TluIGbBoc1TNKhGKsVoUTl12M6rlwk8luO', '2026-01-05 01:22:28', '2026-04-06 22:09:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL COMMENT 'Size in bytes',
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `filename`, `original_name`, `file_path`, `file_type`, `file_size`, `uploaded_by`, `uploaded_at`) VALUES
(16, 'img_695c5f71903794.73531479.png', 'wite BG logo.png', 'assets/uploads/img_695c5f71903794.73531479.png', 'image/png', 99965, 1, '2026-01-06 01:03:45'),
(17, 'img_695c5f85883ea1.15057654.jpeg', 'logo jpeg.jpeg', 'assets/uploads/img_695c5f85883ea1.15057654.jpeg', 'image/jpeg', 20616, 1, '2026-01-06 01:04:05'),
(18, 'img_695c66aa3b8b61.26752756.jpg', 'IMG_0686 copy.jpg', 'assets/uploads/img_695c66aa3b8b61.26752756.jpg', 'image/jpeg', 370588, 1, '2026-01-06 01:34:34'),
(19, 'img_695c67133228e9.55273035.jpg', 'IMG_0839 copy.jpg', 'assets/uploads/img_695c67133228e9.55273035.jpg', 'image/jpeg', 222995, 1, '2026-01-06 01:36:19'),
(20, 'img_695c68f4f0ad38.14052665.jpg', 'IMG_0701 copy.jpg', 'assets/uploads/img_695c68f4f0ad38.14052665.jpg', 'image/jpeg', 287817, 1, '2026-01-06 01:44:20'),
(21, 'img_695c69102bf0d6.34338251.jpg', 'IMG_0705 copy.jpg', 'assets/uploads/img_695c69102bf0d6.34338251.jpg', 'image/jpeg', 289397, 1, '2026-01-06 01:44:48'),
(22, 'img_695c6945231539.82149696.jpg', 'IMG_0882 copy.jpg', 'assets/uploads/img_695c6945231539.82149696.jpg', 'image/jpeg', 235921, 1, '2026-01-06 01:45:41'),
(23, 'img_695c72dfa46f15.56561757.jpg', 'IMG_0740 copy.jpg', 'assets/uploads/img_695c72dfa46f15.56561757.jpg', 'image/jpeg', 237120, 1, '2026-01-06 02:26:39'),
(24, 'img_695c7311d4db85.79487230.jpg', 'IMG_0894 copy.jpg', 'assets/uploads/img_695c7311d4db85.79487230.jpg', 'image/jpeg', 209542, 1, '2026-01-06 02:27:29'),
(25, 'img_695c7522c00d71.66275734.jpg', 'IMG_0867 copy.jpg', 'assets/uploads/img_695c7522c00d71.66275734.jpg', 'image/jpeg', 257570, 1, '2026-01-06 02:36:18'),
(26, 'img_695c753403e6b8.84462032.jpg', 'IMG_0694 copy.jpg', 'assets/uploads/img_695c753403e6b8.84462032.jpg', 'image/jpeg', 327572, 1, '2026-01-06 02:36:36'),
(27, 'img_695c7547b49938.04631276.jpg', 'IMG_4299 copy.jpg', 'assets/uploads/img_695c7547b49938.04631276.jpg', 'image/jpeg', 294736, 1, '2026-01-06 02:36:55'),
(28, 'img_695c76a4052017.98890485.jpg', 'IMG_0897 (1) copy.jpg', 'assets/uploads/img_695c76a4052017.98890485.jpg', 'image/jpeg', 128320, 1, '2026-01-06 02:42:44'),
(29, 'img_695c7729bcfd07.07880916.jpg', 'IMG_0882 copy.jpg', 'assets/uploads/img_695c7729bcfd07.07880916.jpg', 'image/jpeg', 235921, 1, '2026-01-06 02:44:57'),
(30, 'img_695c77f66d1b03.96759492.jpg', 'IMG_0839 copy.jpg', 'assets/uploads/img_695c77f66d1b03.96759492.jpg', 'image/jpeg', 222995, 1, '2026-01-06 02:48:22'),
(31, 'img_695c7975c99576.98612253.jpg', 'IMG_0855 copy.jpg', 'assets/uploads/img_695c7975c99576.98612253.jpg', 'image/jpeg', 223065, 1, '2026-01-06 02:54:45'),
(32, 'img_695c7a2d25af10.85941541.jpg', 'IMG_0831 copy.jpg', 'assets/uploads/img_695c7a2d25af10.85941541.jpg', 'image/jpeg', 231608, 1, '2026-01-06 02:57:49'),
(33, 'img_695c7ac0d94716.98409645.jpg', 'IMG_0758 copy.jpg', 'assets/uploads/img_695c7ac0d94716.98409645.jpg', 'image/jpeg', 210808, 1, '2026-01-06 03:00:16'),
(34, 'img_695dcbf2916f96.56060741.jpg', 'IMG_0883 copy.jpg', 'assets/uploads/img_695dcbf2916f96.56060741.jpg', 'image/jpeg', 205679, 1, '2026-01-07 02:58:58'),
(35, 'img_695e50bd80c242.04325320.jpg', 'IMG_0713 copy.jpg', 'assets/uploads/img_695e50bd80c242.04325320.jpg', 'image/jpeg', 328455, 1, '2026-01-07 12:25:33'),
(36, 'img_695e50bf04f7b5.68065164.jpg', 'IMG_0715 copy.jpg', 'assets/uploads/img_695e50bf04f7b5.68065164.jpg', 'image/jpeg', 359798, 1, '2026-01-07 12:25:35'),
(37, 'img_695e50c05bf460.49407093.jpg', 'IMG_0717 copy.jpg', 'assets/uploads/img_695e50c05bf460.49407093.jpg', 'image/jpeg', 243835, 1, '2026-01-07 12:25:36'),
(38, 'img_695e50c19a0d50.66025954.jpg', 'IMG_0719 copy.jpg', 'assets/uploads/img_695e50c19a0d50.66025954.jpg', 'image/jpeg', 247150, 1, '2026-01-07 12:25:37'),
(39, 'img_695e50c266f668.67075185.jpg', 'IMG_0722 copy.jpg', 'assets/uploads/img_695e50c266f668.67075185.jpg', 'image/jpeg', 207045, 1, '2026-01-07 12:25:38'),
(40, 'img_695e50c34f68f0.92888224.jpg', 'IMG_0725 copy.jpg', 'assets/uploads/img_695e50c34f68f0.92888224.jpg', 'image/jpeg', 299447, 1, '2026-01-07 12:25:39'),
(41, 'img_695e9d11a52a78.19364390.jpg', 'IMG_0716 copy.jpg', 'assets/uploads/img_695e9d11a52a78.19364390.jpg', 'image/jpeg', 252751, 1, '2026-01-07 17:51:13'),
(42, 'img_695e9d125bc014.91497744.jpg', 'IMG_0716 copy3.jpg', 'assets/uploads/img_695e9d125bc014.91497744.jpg', 'image/jpeg', 306697, 1, '2026-01-07 17:51:14'),
(43, 'img_695efd4f251679.21339464.jpg', 'IMG_0730 copy.jpg', 'assets/uploads/img_695efd4f251679.21339464.jpg', 'image/jpeg', 255255, 1, '2026-01-08 00:41:51'),
(44, 'img_695efd50b15f71.27547252.jpg', 'IMG_0731 copy.jpg', 'assets/uploads/img_695efd50b15f71.27547252.jpg', 'image/jpeg', 238547, 1, '2026-01-08 00:41:52'),
(45, 'img_695efd5307cab2.54933336.jpg', 'IMG_0732 copy.jpg', 'assets/uploads/img_695efd5307cab2.54933336.jpg', 'image/jpeg', 251120, 1, '2026-01-08 00:41:55'),
(46, 'img_695efd54b7b116.16258976.jpg', 'IMG_0736 copy.jpg', 'assets/uploads/img_695efd54b7b116.16258976.jpg', 'image/jpeg', 217763, 1, '2026-01-08 00:41:56'),
(47, 'img_695efd565d9247.56369513.jpg', 'IMG_0741 copy.jpg', 'assets/uploads/img_695efd565d9247.56369513.jpg', 'image/jpeg', 231337, 1, '2026-01-08 00:41:58'),
(48, 'img_695efd58082f71.38971316.jpg', 'IMG_0742 copy.jpg', 'assets/uploads/img_695efd58082f71.38971316.jpg', 'image/jpeg', 261853, 1, '2026-01-08 00:42:00'),
(49, 'img_695f429eed59b1.34185429.jpg', 'IMG_4293 copy.jpg', 'assets/uploads/img_695f429eed59b1.34185429.jpg', 'image/jpeg', 215382, 1, '2026-01-08 05:37:35'),
(50, 'img_695f42a0ad4d89.36661937.jpg', 'IMG_4296 copy.jpg', 'assets/uploads/img_695f42a0ad4d89.36661937.jpg', 'image/jpeg', 233994, 1, '2026-01-08 05:37:36'),
(51, 'img_695f42a276e4d4.21056530.jpg', 'IMG_4300 copy.jpg', 'assets/uploads/img_695f42a276e4d4.21056530.jpg', 'image/jpeg', 278266, 1, '2026-01-08 05:37:38'),
(52, 'img_695f42a47d8db8.71497806.jpg', 'IMG_4302 copy.jpg', 'assets/uploads/img_695f42a47d8db8.71497806.jpg', 'image/jpeg', 348046, 1, '2026-01-08 05:37:40'),
(53, 'img_695f42a63e0a02.46187191.jpg', 'IMG_4306 copy.jpg', 'assets/uploads/img_695f42a63e0a02.46187191.jpg', 'image/jpeg', 271577, 1, '2026-01-08 05:37:42'),
(54, 'img_695f484eda20e9.10966506.jpg', 'IMG_0695 copy.jpg', 'assets/uploads/img_695f484eda20e9.10966506.jpg', 'image/jpeg', 262061, 1, '2026-01-08 06:01:50'),
(55, 'img_695f4851d39f64.64449972.jpg', 'IMG_0868 copy.jpg', 'assets/uploads/img_695f4851d39f64.64449972.jpg', 'image/jpeg', 229599, 1, '2026-01-08 06:01:53'),
(56, 'img_695f48540ee647.34509344.jpg', 'IMG_0871 copy.jpg', 'assets/uploads/img_695f48540ee647.34509344.jpg', 'image/jpeg', 171303, 1, '2026-01-08 06:01:56'),
(57, 'img_695f48595f6af7.43110538.jpg', 'IMG_4302 copy.jpg', 'assets/uploads/img_695f48595f6af7.43110538.jpg', 'image/jpeg', 348046, 1, '2026-01-08 06:02:01'),
(58, 'img_695f485c968b78.06310492.jpg', 'IMG_4309 copy.jpg', 'assets/uploads/img_695f485c968b78.06310492.jpg', 'image/jpeg', 252766, 1, '2026-01-08 06:02:04'),
(59, 'img_6960f7e1ce0fd7.97076263.jpg', 'IMG_0747 copy.jpg', 'assets/uploads/img_6960f7e1ce0fd7.97076263.jpg', 'image/jpeg', 244700, 1, '2026-01-09 12:43:13'),
(60, 'img_6960f7e5cd3867.99660715.jpg', 'IMG_0751 copy.jpg', 'assets/uploads/img_6960f7e5cd3867.99660715.jpg', 'image/jpeg', 246510, 1, '2026-01-09 12:43:17'),
(61, 'img_6960f7e65134b9.88639330.jpg', 'IMG_0752 copy.jpg', 'assets/uploads/img_6960f7e65134b9.88639330.jpg', 'image/jpeg', 214010, 1, '2026-01-09 12:43:18'),
(62, 'img_6960f7e6d4dc08.26616096.jpg', 'IMG_0762 copy.jpg', 'assets/uploads/img_6960f7e6d4dc08.26616096.jpg', 'image/jpeg', 261088, 1, '2026-01-09 12:43:18'),
(63, 'img_6960f7e7e6db45.63148278.jpg', 'IMG_0763 copy.jpg', 'assets/uploads/img_6960f7e7e6db45.63148278.jpg', 'image/jpeg', 283579, 1, '2026-01-09 12:43:19'),
(64, 'img_6960f7e87cc890.71671670.jpg', 'IMG_0765 copy.jpg', 'assets/uploads/img_6960f7e87cc890.71671670.jpg', 'image/jpeg', 248637, 1, '2026-01-09 12:43:20'),
(65, 'img_6960f7e92ec438.72539233.jpg', 'IMG_0767 copy.jpg', 'assets/uploads/img_6960f7e92ec438.72539233.jpg', 'image/jpeg', 223168, 1, '2026-01-09 12:43:21'),
(66, 'img_6960f7e9b277e5.09424827.jpg', 'IMG_0783 copy.jpg', 'assets/uploads/img_6960f7e9b277e5.09424827.jpg', 'image/jpeg', 205748, 1, '2026-01-09 12:43:21'),
(67, 'img_6960f7ea253570.91250373.jpg', 'IMG_0785 copy.jpg', 'assets/uploads/img_6960f7ea253570.91250373.jpg', 'image/jpeg', 200398, 1, '2026-01-09 12:43:22'),
(68, 'img_69612f69428b05.06185844.png', 'favicon blue.png', 'assets/uploads/img_69612f69428b05.06185844.png', 'image/png', 10971, 1, '2026-01-09 16:40:09'),
(69, 'img_6961341c10cf82.70641978.jpg', 'IMG_0851 copy.jpg', 'assets/uploads/img_6961341c10cf82.70641978.jpg', 'image/jpeg', 257895, 1, '2026-01-09 17:00:12'),
(70, 'img_6961341c8eccc5.26417651.jpg', 'IMG_0853 copy.jpg', 'assets/uploads/img_6961341c8eccc5.26417651.jpg', 'image/jpeg', 203224, 1, '2026-01-09 17:00:12'),
(71, 'img_6961341d08a090.22179981.jpg', 'IMG_0854 copy.jpg', 'assets/uploads/img_6961341d08a090.22179981.jpg', 'image/jpeg', 268879, 1, '2026-01-09 17:00:13'),
(72, 'img_6961358ff14cf6.14190811.jpg', 'IMG_0833 copy.jpg', 'assets/uploads/img_6961358ff14cf6.14190811.jpg', 'image/jpeg', 214173, 1, '2026-01-09 17:06:23'),
(73, 'img_69613d264585a1.54935689.jpg', 'IMG_0837 copy.jpg', 'assets/uploads/img_69613d264585a1.54935689.jpg', 'image/jpeg', 285287, 1, '2026-01-09 17:38:46'),
(74, 'img_69613d27601ae5.64164827.jpg', 'IMG_0841 copy.jpg', 'assets/uploads/img_69613d27601ae5.64164827.jpg', 'image/jpeg', 251962, 1, '2026-01-09 17:38:47'),
(75, 'img_69613d28ee0fd8.88213897.jpg', 'IMG_0842 copy.jpg', 'assets/uploads/img_69613d28ee0fd8.88213897.jpg', 'image/jpeg', 193486, 1, '2026-01-09 17:38:48'),
(76, 'img_69613efcc79391.54558552.jpg', 'IMG_0881 copy.jpg', 'assets/uploads/img_69613efcc79391.54558552.jpg', 'image/jpeg', 348834, 1, '2026-01-09 17:46:36'),
(77, 'img_69613efd371684.68369582.jpg', 'IMG_0883 copy.jpg', 'assets/uploads/img_69613efd371684.68369582.jpg', 'image/jpeg', 205679, 1, '2026-01-09 17:46:37'),
(78, 'img_69613efdc9f830.00507922.jpg', 'IMG_0884 copy.jpg', 'assets/uploads/img_69613efdc9f830.00507922.jpg', 'image/jpeg', 220883, 1, '2026-01-09 17:46:37'),
(79, 'img_69613efe608883.18495416.jpg', 'IMG_0888 copy.jpg', 'assets/uploads/img_69613efe608883.18495416.jpg', 'image/jpeg', 223988, 1, '2026-01-09 17:46:38'),
(80, 'img_69613efeeda421.61698944.jpg', 'IMG_0890 copy.jpg', 'assets/uploads/img_69613efeeda421.61698944.jpg', 'image/jpeg', 192855, 1, '2026-01-09 17:46:38'),
(81, 'img_69613f001c5984.72588447.jpg', 'IMG_0891 copy.jpg', 'assets/uploads/img_69613f001c5984.72588447.jpg', 'image/jpeg', 267667, 1, '2026-01-09 17:46:40'),
(82, 'img_69613f014c0e20.09261379.jpg', 'IMG_0893 copy.jpg', 'assets/uploads/img_69613f014c0e20.09261379.jpg', 'image/jpeg', 334689, 1, '2026-01-09 17:46:41'),
(83, 'img_69613ff2c93cc6.34598787.jpg', 'IMG_0814 copy.jpg', 'assets/uploads/img_69613ff2c93cc6.34598787.jpg', 'image/jpeg', 226141, 1, '2026-01-09 17:50:42'),
(84, 'img_69613ff4374cf1.91069955.jpg', 'IMG_0815 (1) copy.jpg', 'assets/uploads/img_69613ff4374cf1.91069955.jpg', 'image/jpeg', 251163, 1, '2026-01-09 17:50:44'),
(85, 'img_69613ff4c93613.38339276.jpg', 'IMG_0816 copy.jpg', 'assets/uploads/img_69613ff4c93613.38339276.jpg', 'image/jpeg', 205147, 1, '2026-01-09 17:50:44'),
(86, 'img_69613ff5a24731.41132525.jpg', 'IMG_0817 copy.jpg', 'assets/uploads/img_69613ff5a24731.41132525.jpg', 'image/jpeg', 248605, 1, '2026-01-09 17:50:45'),
(87, 'img_696140d9ef9482.27615727.jpg', 'IMG_0794 copy.jpg', 'assets/uploads/img_696140d9ef9482.27615727.jpg', 'image/jpeg', 222960, 1, '2026-01-09 17:54:33'),
(88, 'img_696140daecb922.78249875.jpg', 'IMG_0795 copy.jpg', 'assets/uploads/img_696140daecb922.78249875.jpg', 'image/jpeg', 290660, 1, '2026-01-09 17:54:34'),
(89, 'img_696140dbd7ce86.67752892.jpg', 'IMG_0796 copy.jpg', 'assets/uploads/img_696140dbd7ce86.67752892.jpg', 'image/jpeg', 213942, 1, '2026-01-09 17:54:35'),
(90, 'img_696140de175974.01675329.jpg', 'IMG_0797 copy.jpg', 'assets/uploads/img_696140de175974.01675329.jpg', 'image/jpeg', 224091, 1, '2026-01-09 17:54:38'),
(91, 'img_696140e02b1fc7.49741294.jpg', 'IMG_0800 copy.jpg', 'assets/uploads/img_696140e02b1fc7.49741294.jpg', 'image/jpeg', 272899, 1, '2026-01-09 17:54:40'),
(92, 'img_696140e1e03023.51947423.jpg', 'IMG_0801 copy.jpg', 'assets/uploads/img_696140e1e03023.51947423.jpg', 'image/jpeg', 280920, 1, '2026-01-09 17:54:41'),
(93, 'img_69ca832811d7b5.71341867.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26 (6).jpeg', 'assets/uploads/img_69ca832811d7b5.71341867.jpeg', 'image/jpeg', 71588, 1, '2026-03-30 14:05:28'),
(94, 'img_69ca83292d82e5.82092489.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26 (5).jpeg', 'assets/uploads/img_69ca83292d82e5.82092489.jpeg', 'image/jpeg', 87189, 1, '2026-03-30 14:05:29'),
(95, 'img_69ca8329e65266.11802634.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26 (4).jpeg', 'assets/uploads/img_69ca8329e65266.11802634.jpeg', 'image/jpeg', 82294, 1, '2026-03-30 14:05:29'),
(96, 'img_69ca832b2b2cc6.84474534.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26 (3).jpeg', 'assets/uploads/img_69ca832b2b2cc6.84474534.jpeg', 'image/jpeg', 92433, 1, '2026-03-30 14:05:31'),
(97, 'img_69ca832bd91a24.92073065.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26 (2).jpeg', 'assets/uploads/img_69ca832bd91a24.92073065.jpeg', 'image/jpeg', 87930, 1, '2026-03-30 14:05:31'),
(98, 'img_69ca832c87cd58.78183974.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26 (1).jpeg', 'assets/uploads/img_69ca832c87cd58.78183974.jpeg', 'image/jpeg', 100377, 1, '2026-03-30 14:05:32'),
(99, 'img_69ca832d2a5058.15831368.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.26.jpeg', 'assets/uploads/img_69ca832d2a5058.15831368.jpeg', 'image/jpeg', 81933, 1, '2026-03-30 14:05:33'),
(100, 'img_69ca832e2f26a6.12021276.jpeg', 'WhatsApp Image 2026-03-30 at 15.00.25.jpeg', 'assets/uploads/img_69ca832e2f26a6.12021276.jpeg', 'image/jpeg', 96519, 1, '2026-03-30 14:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menu`
--

CREATE TABLE `navigation_menu` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `url` varchar(500) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_sections`
--

CREATE TABLE `page_sections` (
  `id` int(11) NOT NULL,
  `page` varchar(50) NOT NULL,
  `section_key` varchar(100) NOT NULL,
  `content_type` enum('text','html','image','json') DEFAULT 'text',
  `content` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_sections`
--

INSERT INTO `page_sections` (`id`, `page`, `section_key`, `content_type`, `content`, `updated_at`) VALUES
(1, 'index', 'hero_title', 'html', 'Emilton Hotel', '2026-01-13 19:13:53'),
(2, 'index', 'hero_background', 'json', '[\"assets\\/uploads\\/img_695c67133228e9.55273035.jpg\",\"assets\\/uploads\\/img_695f4851d39f64.64449972.jpg\",\"assets\\/uploads\\/img_695c66aa3b8b61.26752756.jpg\",\"assets\\/uploads\\/img_695c69102bf0d6.34338251.jpg\",\"assets\\/uploads\\/img_695c7522c00d71.66275734.jpg\"]', '2026-01-13 19:13:53'),
(3, 'index', 'hero_cta_text', 'html', 'Book Now', '2026-01-13 19:13:53'),
(4, 'index', 'hero_cta_link', 'html', 'gallery.html', '2026-01-13 19:13:53'),
(5, 'index', 'about_title', 'html', 'Refined comfort. Timeless elegance. Exceptional hospitality. - 36 Awoniyi Elemo street.Ajao Estate off airportroad.Ikeja, <span class=\"cs_accent_color cs_ternary_font\"> Lagos.</span>', '2026-01-13 19:13:53'),
(6, 'index', 'about_description', 'html', 'At Emilton Hotel & Suites, every detail is thoughtfully curated to deliver an unforgettable stay. With 35 exquisitely furnished rooms across 7 room categories, modern facilities, fine dining, a stylish bar, and a serene swimming pool, we redefine urban hospitality in Ikeja.', '2026-01-13 19:13:53'),
(7, 'index', 'about_image', 'image', 'assets/uploads/img_695c66aa3b8b61.26752756.jpg', '2026-01-13 19:13:53'),
(8, 'index', 'featured_rooms_title', 'html', 'Our commitment is simple: to provide world-class comfort, personalized service, and a peaceful escape within the city.', '2026-01-13 19:13:54'),
(9, 'index', 'rooms_section_subtitle', 'html', 'From cozy rooms to expansive suites', '2026-01-13 19:13:54'),
(10, 'index', 'rooms_section_title', 'html', 'Thoughtfully Designed for Every Stay', '2026-01-13 19:13:54'),
(11, 'index', 'rooms_section_description', 'html', 'Every room at Emilton Hotel & Suites is crafted with attention to detail, combining elegant interiors with functional design. Soft lighting, premium bedding, and carefully selected furnishings create a calm and inviting environment that supports rest and productivity.', '2026-01-13 19:13:54'),
(12, 'index', 'why_choose_title', 'html', 'Why Choose Emilton Hotel & Suites?', '2026-01-13 19:13:54'),
(13, 'index', 'why_choose_description', 'html', 'With a total of 35 rooms, our hotel caters to solo travelers, couples, families, corporate guests, and long-stay visitors. Each space is designed to offer tranquility, privacy, and a sense of home.', '2026-01-13 19:13:55'),
(14, 'index', 'awards_subtitle', 'html', 'Situated off Airport Road, Lagos', '2026-01-13 19:13:55'),
(15, 'index', 'awards_title', 'html', 'Enjoy luxury tailored just for you', '2026-01-13 19:13:55'),
(16, 'index', 'booking_cta_title', 'html', 'Emilton Hotel & Suites', '2026-01-13 19:13:56'),
(17, 'index', 'booking_cta_description', 'html', 'Book your stay at Emilton Hotel & Suites today and enjoy luxury tailored just for you.', '2026-01-13 19:13:56'),
(18, 'about', 'page_header_title', 'text', 'About Emilton Hotel & Suites', '2026-01-10 23:53:30'),
(19, 'about', 'page_header_image', 'image', 'assets/uploads/img_695c66aa3b8b61.26752756.jpg', '2026-01-10 23:53:30'),
(20, 'about', 'main_title', 'text', 'A welcoming and secure environment for every guest', '2026-01-10 23:53:30'),
(21, 'about', 'main_description', 'text', 'Emilton Hotel & Suites is a premium hospitality destination created to meet the needs of modern travelers who expect more from their stay. Situated off Airport Road, Lagos, we combine elegant design, contemporary comfort, and genuine Nigerian hospitality.', '2026-01-10 23:53:30'),
(22, 'about', 'counter_1_percentage', 'text', '100%', '2026-01-10 23:53:30'),
(23, 'about', 'counter_1_title', 'text', 'Excellence', '2026-01-10 23:53:30'),
(24, 'about', 'counter_2_percentage', 'text', '100%', '2026-01-10 23:53:30'),
(25, 'about', 'counter_2_title', 'text', 'Comfort', '2026-01-10 23:53:30'),
(26, 'about', 'counter_3_percentage', 'text', '100%', '2026-01-10 23:53:30'),
(27, 'about', 'counter_3_title', 'text', 'Hospitality', '2026-01-10 23:53:30'),
(28, 'about', 'why_choose_subtitle', 'text', 'Consistent luxury experience', '2026-01-10 23:53:30'),
(29, 'about', 'why_choose_title', 'text', 'Why Choose Emilton Hotel & Suites', '2026-01-10 23:53:30'),
(30, 'about', 'why_choose_description', 'text', 'Our strategic location off Airport Road makes Emilton Hotel & Suites ideal for travelers seeking quick airport access without compromising on luxury and comfort.', '2026-01-10 23:53:30'),
(65, 'restaurant', 'hero_title', 'html', '', '2026-01-07 17:52:02'),
(66, 'restaurant', 'hero_background', 'image', 'assets/uploads/img_695e50c266f668.67075185.jpg', '2026-01-07 17:52:02'),
(67, 'restaurant', 'feature_image', 'image', 'assets/uploads/img_695e50c266f668.67075185.jpg', '2026-01-07 17:52:05'),
(68, 'restaurant', 'content_title', 'html', '', '2026-01-06 00:32:45'),
(69, 'restaurant', 'content_image', 'image', '', '2026-01-06 00:32:45'),
(70, 'restaurant', 'content_description', 'html', '', '2026-01-06 00:32:45'),
(79, 'index', 'feature_box_1_image', 'image', 'assets/uploads/img_695c68f4f0ad38.14052665.jpg', '2026-01-13 19:13:54'),
(80, 'index', 'feature_box_1_title', 'html', 'Premium Facilities', '2026-01-13 19:13:53'),
(81, 'index', 'feature_box_1_description', 'html', 'Restaurant • Bar • Swimming Pool • Secure Parking • 24/7 Power & Security', '2026-01-13 19:13:53'),
(82, 'index', 'feature_box_2_image', 'image', 'assets/uploads/img_695c69102bf0d6.34338251.jpg', '2026-01-13 19:13:53'),
(83, 'index', 'feature_box_2_title', 'html', 'Exceptional Service', '2026-01-13 19:13:54'),
(84, 'index', 'feature_box_2_description', 'html', 'Our professionally trained team delivers warm, attentive, and discreet service at all times.', '2026-01-13 19:13:54'),
(85, 'index', 'feature_box_3_image', 'image', 'assets/uploads/img_695c6945231539.82149696.jpg', '2026-01-13 19:13:54'),
(86, 'index', 'feature_box_3_title', 'html', 'Luxury Rooms & Suites', '2026-01-13 19:13:54'),
(87, 'index', 'feature_box_3_description', 'html', 'Spacious, tastefully designed rooms equipped with modern amenities and premium finishes.', '2026-01-13 19:13:54'),
(380, 'index', 'why_choose_title_1', 'html', 'Relaxation & leisure', '2026-01-13 19:13:55'),
(381, 'index', 'why_choose_image_1', 'image', 'assets/uploads/img_695c7311d4db85.79487230.jpg', '2026-01-13 19:13:55'),
(382, 'index', 'why_choose_image_2', 'image', 'assets/uploads/img_695c72dfa46f15.56561757.jpg', '2026-01-13 19:13:55'),
(383, 'index', 'why_choose_title_2', 'html', 'Premium dining', '2026-01-13 19:13:55'),
(386, 'index', 'award_image_1', 'image', 'assets/uploads/img_695c7522c00d71.66275734.jpg', '2026-01-13 19:13:56'),
(387, 'index', 'award_image_2', 'image', 'assets/uploads/img_695c753403e6b8.84462032.jpg', '2026-01-13 19:13:55'),
(388, 'index', 'award_image_3', 'image', 'assets/uploads/img_695c7547b49938.04631276.jpg', '2026-01-13 19:13:56'),
(391, 'index', 'booking_cta_background', 'image', 'assets/uploads/img_695c76a4052017.98890485.jpg', '2026-01-13 19:13:56'),
(624, 'index', 'award_title_1', 'html', 'Ambience – Night Aesthetic', '2026-01-13 19:13:55'),
(626, 'index', 'award_title_2', 'html', 'Relaxation – Swimming Pool Area', '2026-01-13 19:13:55'),
(627, 'index', 'award_title_3', 'html', 'Exclusivity – Rooftop Area', '2026-01-13 19:13:55'),
(646, 'about', 'video_background', 'text', 'assets/uploads/img_695dcbf2916f96.56060741.jpg', '2026-01-10 23:53:30'),
(647, 'about', 'awards_subtitle', 'text', '', '2026-01-10 23:53:30'),
(648, 'about', 'awards_title', 'text', '', '2026-01-10 23:53:30'),
(649, 'about', 'award_title_1', 'text', 'Exceptional Guest Service', '2026-01-10 23:53:31'),
(650, 'about', 'award_image_2', 'image', 'assets/uploads/img_695c68f4f0ad38.14052665.jpg', '2026-01-10 23:53:31'),
(651, 'about', 'award_title_2', 'text', 'Premium Facilities', '2026-01-10 23:53:31'),
(652, 'about', 'award_image_1', 'image', 'assets/uploads/img_695c7ac0d94716.98409645.jpg', '2026-01-10 23:53:31'),
(653, 'about', 'award_title_3', 'text', 'Peaceful & Secure Environment', '2026-01-10 23:53:31'),
(654, 'about', 'award_image_3', 'image', 'assets/uploads/img_695c69102bf0d6.34338251.jpg', '2026-01-10 23:53:31'),
(655, 'about', 'testimonial_background', 'text', 'assets/uploads/img_69612f69428b05.06185844.png', '2026-01-10 23:53:31'),
(656, 'contact', 'hero_background', 'image', 'assets/uploads/img_695c66aa3b8b61.26752756.jpg', '2026-01-13 13:40:26'),
(657, 'contact', 'hero_subtitle', 'text', 'We’re here to help with bookings, questions, and special requests.', '2026-01-13 13:40:27'),
(658, 'contact', 'contact_intro_title', 'text', 'We’re here to help with bookings, questions, and special requests.', '2026-01-13 13:40:28'),
(659, 'contact', 'contact_intro_text', 'text', 'We’re here to help with bookings, questions, and special requests.', '2026-01-13 13:40:28'),
(660, 'contact', 'hero_title', 'text', 'Contact Us', '2026-01-13 13:40:26'),
(661, 'contact', 'contact_address', 'text', '36 Awoniyi Elemo street.Ajao Estate off airportroad.Ikeja.lagos', '2026-01-13 13:40:29'),
(662, 'contact', 'contact_phone', 'text', '07064907675', '2026-01-13 13:40:29'),
(663, 'contact', 'contact_email', 'text', 'reservations@emiltonhotels.com', '2026-01-13 13:40:29'),
(664, 'contact', 'contact_hotel_name', 'text', 'Emilton Hotels & Suites', '2026-01-13 13:40:29'),
(665, 'contact', 'contact_front_desk', 'text', '24 Hours / 7 Days', '2026-01-13 13:40:29'),
(666, 'contact', 'form_title', 'text', 'Send a message', '2026-01-13 13:40:29'),
(667, 'contact', 'form_subtitle', 'text', 'Fill the form and we’ll get back to you shortly.', '2026-01-13 13:40:30'),
(668, 'contact', 'map_address', 'text', '36 Awoniyi Elemo street.Ajao Estate off airportroad.Ikeja.lagos', '2026-01-13 13:40:30'),
(669, 'contact', 'map_embed_url', 'text', 'https://www.google.com/maps/place/Emilton+Hotel/@-4.3266715,15.296611,763m/data=!3m1!1e3!4m9!3m8!1s0x1a6a315bd6ee98dd:0x4addc2fe52c1254!5m2!4m1!1i2!8m2!3d-4.3266769!4d15.2991859!16s%2Fg%2F11g6xrcg3z?authuser=0&entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D', '2026-01-13 13:40:30'),
(698, 'gallery', 'hero_background', 'image', 'assets/uploads/img_695c69102bf0d6.34338251.jpg', '2026-01-09 13:10:59'),
(699, 'gallery', 'hero_description', 'html', '', '2026-01-09 13:10:59'),
(700, 'gallery', 'hero_title', 'html', 'Our Gallery', '2026-01-09 13:10:59'),
(701, 'gallery', 'gallery_images', 'json', '[{\"path\":\"assets\\/uploads\\/img_695dcbf2916f96.56060741.jpg\",\"title\":\"\",\"category\":\"rooms\"},{\"path\":\"assets\\/uploads\\/img_695c7ac0d94716.98409645.jpg\",\"title\":\"\",\"category\":\"rooms\"},{\"path\":\"assets\\/uploads\\/img_695c7a2d25af10.85941541.jpg\",\"title\":\"\",\"category\":\"rooms\"},{\"path\":\"assets\\/uploads\\/img_695c67133228e9.55273035.jpg\",\"title\":\"\",\"category\":\"rooms\"},{\"path\":\"assets\\/uploads\\/img_695c6945231539.82149696.jpg\",\"title\":\"\",\"category\":\"rooms\"},{\"path\":\"assets\\/uploads\\/img_695c69102bf0d6.34338251.jpg\",\"title\":\"\",\"category\":\"experiences\"},{\"path\":\"assets\\/uploads\\/img_695c7522c00d71.66275734.jpg\",\"title\":\"\",\"category\":\"wellness\"},{\"path\":\"assets\\/uploads\\/img_695c7547b49938.04631276.jpg\",\"title\":\"\",\"category\":\"wellness\"},{\"path\":\"assets\\/uploads\\/img_695c753403e6b8.84462032.jpg\",\"title\":\"\",\"category\":\"wellness\"},{\"path\":\"assets\\/uploads\\/img_695c68f4f0ad38.14052665.jpg\",\"title\":\"\",\"category\":\"all\"},{\"path\":\"assets\\/uploads\\/img_695c66aa3b8b61.26752756.jpg\",\"title\":\"\",\"category\":\"all\"},{\"path\":\"assets\\/uploads\\/img_695c77f66d1b03.96759492.jpg\",\"title\":\"\",\"category\":\"rooms\"},{\"path\":\"assets\\/uploads\\/img_695c76a4052017.98890485.jpg\",\"title\":\"\",\"category\":\"all\"},{\"path\":\"assets\\/uploads\\/img_695c72dfa46f15.56561757.jpg\",\"title\":\"\",\"category\":\"wellness\"},{\"path\":\"assets\\/uploads\\/img_6960f7ea253570.91250373.jpg\",\"title\":\"\",\"category\":\"all\"}]', '2026-01-09 13:10:59'),
(702, 'gallery', 'hero_subtitle', 'html', 'Visual Journey', '2026-01-09 13:10:59'),
(713, 'restaurant', 'hero_subtitle', 'html', 'Emilton Restaurant', '2026-01-07 17:52:02'),
(715, 'restaurant', 'hero_description', 'html', 'Experience the pinnacle of fine dining in the heart of the city, where tradition meets modern innovation.', '2026-01-07 17:52:02'),
(717, 'restaurant', 'hero_button_text', 'html', 'Reserve Your Table', '2026-01-07 17:52:03'),
(718, 'restaurant', 'philosophy_subtitle', 'html', 'Our Vision', '2026-01-07 17:52:03'),
(719, 'restaurant', 'philosophy_title', 'html', 'The Philosophy of Taste', '2026-01-07 17:52:03'),
(720, 'restaurant', 'philosophy_description', 'html', 'At Emilton Restaurant, our menu is thoughtfully curated to combine local Nigerian flavors with continental and international cuisine. Each dish is freshly prepared using high-quality ingredients and presented to reflect modern fine dining standards.', '2026-01-07 17:52:03'),
(721, 'restaurant', 'philosophy_quote', 'html', 'Every detail is designed to ensure guests dine in comfort and style.', '2026-01-07 17:52:03'),
(722, 'restaurant', 'philosophy_quote_author', 'html', '— Chef Henri Dubois', '2026-01-07 17:52:03'),
(723, 'restaurant', 'philosophy_button_text', 'html', 'Read Our Story', '2026-01-07 17:52:03'),
(724, 'restaurant', 'philosophy_image_1', 'image', 'assets/uploads/img_695e50bf04f7b5.68065164.jpg', '2026-01-07 17:52:03'),
(725, 'restaurant', 'philosophy_image_2', 'image', 'assets/uploads/img_695e50c19a0d50.66025954.jpg', '2026-01-07 17:52:03'),
(726, 'restaurant', 'feature_1_icon', 'html', 'eco', '2026-01-07 17:52:03'),
(727, 'restaurant', 'feature_1_title', 'html', 'Ambience & Setting', '2026-01-07 17:52:03'),
(728, 'restaurant', 'feature_1_description', 'html', 'The Emilton Restaurant features a tasteful interior that blends modern elegance with comfort.', '2026-01-07 17:52:03'),
(729, 'restaurant', 'feature_2_icon', 'html', 'palette', '2026-01-07 17:52:03'),
(730, 'restaurant', 'feature_2_title', 'html', 'Lunch & Dinner Dining', '2026-01-07 17:52:03'),
(731, 'restaurant', 'feature_2_description', 'html', 'Our lunch and dinner menus are crafted to suit a wide range of tastes', '2026-01-07 17:52:03'),
(732, 'restaurant', 'feature_3_icon', 'html', 'room_service', '2026-01-07 17:52:03'),
(733, 'restaurant', 'feature_3_title', 'html', 'Room Service Dining', '2026-01-07 17:52:03'),
(734, 'restaurant', 'feature_3_description', 'html', 'For guests who prefer privacy, Emilton Restaurant offers room service', '2026-01-07 17:52:03'),
(735, 'restaurant', 'menu_subtitle', 'html', 'Culinary Excellence', '2026-01-07 12:35:11'),
(736, 'restaurant', 'menu_title', 'html', 'Signature Creations', '2026-01-07 12:35:11'),
(737, 'restaurant', 'menu_button_text', 'html', 'View Full Menu', '2026-01-07 12:35:11'),
(738, 'restaurant', 'menu_items', 'json', '[]', '2026-01-07 12:35:11'),
(739, 'restaurant', 'ambience_title', 'html', 'An Oasis of Calm', '2026-01-07 17:52:04'),
(740, 'restaurant', 'ambience_subtitle', 'html', 'Design & Atmosphere', '2026-01-07 17:52:04'),
(741, 'restaurant', 'ambience_description_1', 'html', '', '2026-01-07 17:52:04'),
(742, 'restaurant', 'ambience_description_2', 'html', '', '2026-01-07 17:52:04'),
(743, 'restaurant', 'ambience_button_text', 'html', 'View Gallery', '2026-01-07 17:52:04'),
(744, 'restaurant', 'ambience_image_1', 'image', 'assets/uploads/img_695e50c34f68f0.92888224.jpg', '2026-01-07 17:52:05'),
(745, 'restaurant', 'ambience_image_2', 'image', 'assets/uploads/img_695e50bd80c242.04325320.jpg', '2026-01-07 17:52:05'),
(746, 'restaurant', 'ambience_image_3', 'image', 'assets/uploads/img_695c7547b49938.04631276.jpg', '2026-01-07 17:52:05'),
(747, 'restaurant', 'ambience_image_4', 'image', 'assets/uploads/img_695c7522c00d71.66275734.jpg', '2026-01-07 17:52:05'),
(748, 'restaurant', 'reservation_title', 'html', 'Secure Your Experience', '2026-01-07 12:35:10'),
(749, 'restaurant', 'reservation_description', 'html', '', '2026-01-07 12:35:10'),
(750, 'restaurant', 'reservation_button_text', 'html', 'Find Table', '2026-01-07 12:35:10'),
(852, 'restaurant', 'dining_title', 'html', 'A Refined Dining Experience at Emilton Restaurant', '2026-01-07 17:52:04'),
(853, 'restaurant', 'dining_intro', 'html', 'Discover a dining space where exceptional cuisine, elegant surroundings, and thoughtful design come together to create unforgettable moments.', '2026-01-07 17:52:04'),
(854, 'restaurant', 'dining_card_1_image', 'image', 'assets/uploads/img_695e9d125bc014.91497744.jpg', '2026-01-07 17:52:04'),
(855, 'restaurant', 'dining_description', 'html', 'At Emilton Restaurant, dining is more than a meal—it is an experience. From carefully crafted dishes to a warm and sophisticated atmosphere, every detail is designed to delight the senses and elevate your stay.', '2026-01-07 17:52:04'),
(856, 'restaurant', 'dining_card_1_icon', 'html', 'restaurant', '2026-01-07 17:52:04'),
(857, 'restaurant', 'dining_card_1_title', 'html', 'Exquisite Culinary Creations', '2026-01-07 17:52:04'),
(858, 'restaurant', 'dining_card_1_description', 'html', 'Our menu is a celebration of flavor, combining expertly prepared local Nigerian dishes with continental and international cuisine. Every meal is freshly prepared using quality ingredients, delivering rich taste, beautiful presentation, and consistent excellence with every bite.', '2026-01-07 17:52:04'),
(859, 'restaurant', 'dining_card_2_image', 'image', 'assets/uploads/img_695e9d11a52a78.19364390.jpg', '2026-01-07 17:52:04'),
(860, 'restaurant', 'dining_card_2_icon', 'html', 'wb_twilight', '2026-01-07 17:52:04'),
(861, 'restaurant', 'dining_card_2_title', 'html', 'Warm & Inviting Ambience', '2026-01-07 17:52:04'),
(862, 'restaurant', 'dining_card_3_image', 'image', 'assets/uploads/img_695e50c19a0d50.66025954.jpg', '2026-01-07 17:52:04'),
(863, 'restaurant', 'dining_card_2_description', 'html', 'The restaurant offers a calm and welcoming atmosphere designed for comfort and relaxation. Soft lighting, tasteful décor, and a serene setting create the perfect environment for breakfast meetings, relaxed lunches, and intimate dinners.', '2026-01-07 17:52:04'),
(864, 'restaurant', 'dining_card_3_icon', 'html', 'chair', '2026-01-07 17:52:04'),
(865, 'restaurant', 'dining_card_3_description', 'html', 'Designed with modern luxury in mind, Emilton Restaurant features stylish interiors that blend contemporary design with timeless elegance. The thoughtfully arranged seating and refined finishes provide a comfortable yet sophisticated dining environment for every guest.', '2026-01-07 17:52:04'),
(866, 'restaurant', 'dining_card_3_title', 'html', 'Elegant Restaurant Interior', '2026-01-07 17:52:04'),
(867, 'restaurant', 'dining_cta', 'html', 'Experience fine dining at its best.\nDine with us and enjoy exceptional food in an elegant setting.', '2026-01-07 17:52:04'),
(878, 'bar', 'hero_intro', 'html', 'Welcome to Emilton Bar & Lounge, a sophisticated relaxation space designed for guests who appreciate premium drinks, stylish surroundings, and a calm social atmosphere.', '2026-01-12 14:34:55'),
(879, 'bar', 'hero_title', 'html', 'Emilton Bar & Lounge', '2026-01-12 14:34:55'),
(880, 'bar', 'hero_subtitle', 'html', 'Bar & Lounge', '2026-01-12 14:34:52'),
(881, 'bar', 'drinks_description', 'html', 'At Emilton Bar, we offer an impressive selection of beverages crafted to suit refined tastes.', '2026-01-12 14:34:55'),
(882, 'bar', 'drinks_title', 'html', 'Carefully Curated Beverages', '2026-01-12 14:34:55'),
(883, 'bar', 'hero_background', 'image', 'assets/uploads/img_695efd50b15f71.27547252.jpg', '2026-01-12 14:34:55'),
(884, 'bar', 'drinks_image', 'image', 'assets/uploads/img_695efd565d9247.56369513.jpg', '2026-01-12 14:34:55'),
(885, 'bar', 'drinks_bullet_label', 'html', 'What we offer:', '2026-01-12 14:34:56'),
(886, 'bar', 'drinks_bullet_1', 'html', 'Signature cocktails', '2026-01-12 14:34:56'),
(887, 'bar', 'drinks_bullet_2', 'html', 'Premium wines & champagnes', '2026-01-12 14:34:56'),
(888, 'bar', 'drinks_bullet_3', 'html', 'Top-shelf spirits', '2026-01-12 14:34:56'),
(889, 'bar', 'ambience_title', 'html', 'Relaxed, Stylish & Inviting', '2026-01-12 14:34:56'),
(890, 'bar', 'drinks_bullet_4', 'html', 'Non-alcoholic beverages', '2026-01-12 14:34:56'),
(891, 'bar', 'drinks_footer', 'html', '', '2026-01-12 14:34:56'),
(892, 'bar', 'ambience_description', 'html', 'The Emilton Bar & Lounge features a warm and relaxed atmosphere enhanced by tasteful lighting, modern décor, and comfortable seating. Designed to encourage conversation and relaxation, the space is ideal for both quiet evenings and social moments. Whether you prefer a calm corner or a lively setting, our bar provides the right mood for every occasion.', '2026-01-12 14:34:56'),
(893, 'bar', 'ambience_image', 'image', 'assets/uploads/img_695efd4f251679.21339464.jpg', '2026-01-12 14:34:56'),
(894, 'bar', 'interior_image', 'image', 'assets/uploads/img_695efd58082f71.38971316.jpg', '2026-01-12 14:34:56'),
(895, 'bar', 'interior_title', 'html', 'Contemporary Bar Interior', '2026-01-12 14:34:56'),
(896, 'bar', 'why_choose_title', 'html', 'Why Choose Emilton Bar & Lounge', '2026-01-12 14:34:56'),
(897, 'bar', 'interior_description', 'html', 'Our bar interior reflects modern luxury, combining sleek finishes with elegant design elements. The thoughtfully arranged seating ensures comfort and privacy, making it suitable for individuals, couples, and small groups. The layout balances style and function, allowing guests to enjoy their drinks in a refined yet welcoming environment.', '2026-01-12 14:34:56'),
(898, 'bar', 'why_choose_card_1_icon', 'html', 'local_bar', '2026-01-12 14:34:56'),
(899, 'bar', 'why_choose_card_1_title', 'html', 'Premium drinks and cocktails', '2026-01-12 14:34:56'),
(900, 'bar', 'why_choose_card_1_description', 'html', 'Expertly crafted beverages using quality ingredients', '2026-01-12 14:34:56'),
(901, 'bar', 'why_choose_card_2_icon', 'html', 'spa', '2026-01-12 14:34:57'),
(902, 'bar', 'why_choose_card_2_title', 'html', 'Elegant and relaxed environment', '2026-01-12 14:34:57'),
(903, 'bar', 'why_choose_card_2_description', 'html', 'Tasteful décor and comfortable seating', '2026-01-12 14:34:57'),
(904, 'bar', 'why_choose_card_3_icon', 'html', 'room_service', '2026-01-12 14:34:57'),
(905, 'bar', 'why_choose_card_3_title', 'html', 'Professional and friendly service', '2026-01-12 14:34:57'),
(906, 'bar', 'why_choose_card_3_description', 'html', 'Attentive staff ensuring your comfort', '2026-01-12 14:34:57'),
(907, 'bar', 'why_choose_card_4_icon', 'html', 'location_on', '2026-01-12 14:34:57'),
(908, 'bar', 'why_choose_card_4_title', 'html', 'Conveniently located within Emilton Hotel & Suites', '2026-01-12 14:34:57'),
(909, 'bar', 'why_choose_card_4_description', 'html', 'Perfect for leisure, meetings, and evening relaxation', '2026-01-12 14:34:57'),
(910, 'bar', 'opening_hours_text', 'html', 'The Emilton Bar & Lounge is open daily.', '2026-01-08 00:47:31'),
(911, 'bar', 'cta_title', 'html', 'Unwind in Style', '2026-01-12 14:34:57'),
(912, 'bar', 'cta_description', 'html', 'Step into Emilton Bar & Lounge and enjoy premium drinks, refined ambience, and exceptional service—all designed to elevate your evening experience.', '2026-01-12 14:34:57'),
(913, 'bar', 'cta_tagline', 'html', 'Relax. Sip. Enjoy.', '2026-01-12 14:34:57'),
(914, 'bar', 'feature_image', 'image', 'assets/uploads/img_695efd5307cab2.54933336.jpg', '2026-01-12 14:34:57'),
(1135, 'bar', 'cta_background', 'image', 'assets/uploads/img_695efd5307cab2.54933336.jpg', '2026-01-12 14:34:57'),
(1174, 'swimming-pool', 'hero_subtitle', 'html', 'Pool & Leisure', '2026-01-08 06:03:33'),
(1175, 'swimming-pool', 'hero_title', 'html', 'Swimming Pool & Leisure', '2026-01-08 06:03:33'),
(1176, 'swimming-pool', 'hero_intro', 'html', 'A serene escape designed for relaxation, refreshment, and quiet enjoyment.', '2026-01-08 06:03:33'),
(1177, 'swimming-pool', 'pool_title', 'html', 'Swimming Pool & Leisure Experience', '2026-01-08 06:03:33'),
(1178, 'swimming-pool', 'pool_intro', 'html', 'Discover a tranquil pool area where relaxation, refreshment, and peaceful moments come together.', '2026-01-08 06:03:33'),
(1179, 'swimming-pool', 'hero_background', 'image', 'assets/uploads/img_695c753403e6b8.84462032.jpg', '2026-01-08 06:03:33'),
(1180, 'swimming-pool', 'pool_description', 'html', 'At Emilton Hotel & Suites, our swimming pool offers a serene escape from the everyday. From refreshing morning swims to relaxing evening dips, every moment is designed for comfort and tranquility.', '2026-01-08 06:03:33'),
(1181, 'swimming-pool', 'pool_card_1_image', 'image', 'assets/uploads/img_695f42a63e0a02.46187191.jpg', '2026-01-08 06:03:33'),
(1182, 'swimming-pool', 'pool_card_1_icon', 'html', 'pool', '2026-01-08 06:03:33'),
(1183, 'swimming-pool', 'pool_card_1_description', 'html', 'Enjoy a clean, well-maintained swimming pool designed for comfort and relaxation. Whether you\'re starting your day with a refreshing dip or unwinding in the evening, our pool offers a calm and inviting environment.', '2026-01-08 06:03:33'),
(1184, 'swimming-pool', 'pool_card_1_title', 'html', 'Refreshing Pool Experience', '2026-01-08 06:03:33'),
(1185, 'swimming-pool', 'pool_card_2_image', 'image', 'assets/uploads/img_695f42a276e4d4.21056530.jpg', '2026-01-08 06:03:33'),
(1186, 'swimming-pool', 'pool_card_2_icon', 'html', 'deck', '2026-01-08 06:03:34'),
(1187, 'swimming-pool', 'pool_card_2_description', 'html', 'Surrounded by a peaceful atmosphere, the pool area offers a relaxing setting where guests can unwind, lounge, and enjoy quiet moments away from the city\'s pace.', '2026-01-08 06:03:34'),
(1188, 'swimming-pool', 'pool_card_2_title', 'html', 'Calm Poolside Ambience', '2026-01-08 06:03:34'),
(1189, 'swimming-pool', 'pool_card_3_image', 'image', 'assets/uploads/img_695f42a0ad4d89.36661937.jpg', '2026-01-08 06:03:34'),
(1190, 'swimming-pool', 'pool_card_3_icon', 'html', 'chair', '2026-01-08 06:03:34'),
(1191, 'swimming-pool', 'pool_card_3_title', 'html', 'Comfort & Leisure', '2026-01-08 06:03:34'),
(1192, 'swimming-pool', 'pool_card_3_description', 'html', 'Thoughtfully arranged seating and a well-designed pool layout provide comfort, privacy, and ease, making the swimming pool ideal for leisure, relaxation, and light recreation.', '2026-01-08 06:03:34'),
(1193, 'swimming-pool', 'feature_image', 'image', 'assets/uploads/img_695f42a63e0a02.46187191.jpg', '2026-01-08 06:03:34'),
(1194, 'swimming-pool', 'slider_title', 'html', 'Pool Gallery', '2026-01-08 06:03:34'),
(1195, 'swimming-pool', 'slider_images', 'image', '[{\"url\":\"assets/uploads/img_695f485c968b78.06310492.jpg\",\"alt\":\"\"},{\"url\":\"assets/uploads/img_695f48595f6af7.43110538.jpg\",\"alt\":\"\"},{\"url\":\"assets/uploads/img_695f48540ee647.34509344.jpg\",\"alt\":\"\"},{\"url\":\"assets/uploads/img_695f484eda20e9.10966506.jpg\",\"alt\":\"\"},{\"url\":\"assets/uploads/img_695f42a63e0a02.46187191.jpg\",\"alt\":\"\"}]', '2026-01-08 06:03:34'),
(1196, 'swimming-pool', 'pool_cta', 'html', 'Relax. Refresh. Recharge.\n\nExperience calm and comfort at the Emilton Hotel & Suites swimming pool.', '2026-01-08 06:03:34'),
(1291, 'index', 'about_flower_image', 'image', 'assets/uploads/img_69612f69428b05.06185844.png', '2026-01-13 19:13:53'),
(1323, 'hotel-policy', 'main_content', 'html', '<style>\n.house-rules {\n    max-width: 800px;\n    margin: 40px auto;\n    padding: 30px;\n    background: #ffffff;\n    border-radius: 14px;\n    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);\n    font-family: system-ui, -apple-system, BlinkMacSystemFont, \"Segoe UI\", sans-serif;\n}\n\n.house-rules h3 {\n    margin-bottom: 24px;\n    font-size: 22px;\n    font-weight: 600;\n    color: #1f2937;\n    border-bottom: 1px solid #e5e7eb;\n    padding-bottom: 12px;\n}\n\n.rules-form {\n    display: flex;\n    flex-direction: column;\n    gap: 14px;\n}\n\n.rule-item {\n    display: flex;\n    align-items: flex-start;\n    gap: 14px;\n    padding: 14px 16px;\n    background: #f9fafb;\n    border: 1px solid #e5e7eb;\n    border-radius: 10px;\n    cursor: pointer;\n    transition: all 0.25s ease;\n}\n\n.rule-item:hover {\n    background: #f3f4f6;\n}\n\n.rule-item input[type=\"checkbox\"] {\n    margin-top: 4px;\n    width: 18px;\n    height: 18px;\n    accent-color: #0f766e;\n    cursor: pointer;\n}\n\n.rule-item span {\n    font-size: 15px;\n    line-height: 1.6;\n    color: #374151;\n}\n\n.rule-item strong {\n    color: #111827;\n}\n\n.rule-item.warning {\n    background: #fff5f5;\n    border-color: #fecaca;\n}\n\n.rule-item.warning strong {\n    color: #991b1b;\n}\n\n.rule-item.final {\n    background: #ecfdf5;\n    border-color: #6ee7b7;\n}\n\n.rule-item.final span {\n    font-size: 16px;\n}\n</style>\n\n<section class=\"house-rules\">\n    <h3>House Rules & Policies</h3>\n\n    <form class=\"rules-form\">\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>Check-in time is <strong>2:00 PM</strong>.</span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                Check-out time is <strong>12:00 noon</strong>. Late check-out attracts\n                <strong>50%</strong> charge until 6:00 PM and <strong>100%</strong> after 6:00 PM.\n            </span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>No extra charge for children under <strong>2 years</strong> staying with a parent.</span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                Complimentary breakfast for one guest.\n                Additional breakfast costs <strong>₦15,000</strong>.\n            </span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>Food and drinks from outside the hotel are not permitted.</span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>Unrestricted access to the swimming pools.</span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                No-show bookings will be charged the full room rate if not cancelled before\n                <strong>6:00 PM</strong> on the arrival date.\n            </span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>A deposit covering the estimated cost of your stay is required at check-in.</span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>Maximum occupancy is <strong>two (2) persons</strong> per room.</span>\n        </label>\n\n        <label class=\"rule-item warning\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>No smoking in rooms.</strong> Smoking is allowed only in designated areas.\n                Violation attracts a <strong>₦100,000 fine</strong>.\n            </span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>Breakfast is served from <strong>6:00 AM to 10:00 AM</strong> only.</span>\n        </label>\n\n        <label class=\"rule-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                Cancellations must be made at least <strong>24 hours</strong> before check-in.\n                No refunds thereafter.\n            </span>\n        </label>\n\n        <label class=\"rule-item final\">\n            <input type=\"checkbox\" required>\n            <span><strong>I have read and agree to all the house rules and policies.</strong></span>\n        </label>\n    </form>\n</section>\n', '2026-01-09 18:10:06'),
(1324, 'hotel-policy', 'hero_background', 'image', 'assets/uploads/img_69613f014c0e20.09261379.jpg', '2026-01-09 18:10:06'),
(1325, 'hotel-policy', 'hero_title', 'html', 'Hotel Policy', '2026-01-09 18:10:06'),
(1329, 'terms-of-use', 'hero_background', 'image', 'assets/uploads/img_695c76a4052017.98890485.jpg', '2026-01-09 18:16:14'),
(1330, 'terms-of-use', 'hero_title', 'html', 'Terms of Use', '2026-01-09 18:16:14'),
(1331, 'terms-of-use', 'main_content', 'html', '<style>\n.terms-section {\n    max-width: 900px;\n    margin: 40px auto;\n    padding: 32px;\n    background: #ffffff;\n    border-radius: 14px;\n    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.08);\n    font-family: system-ui, -apple-system, BlinkMacSystemFont, \"Segoe UI\", sans-serif;\n}\n\n.terms-section h2 {\n    font-size: 24px;\n    font-weight: 600;\n    color: #1f2937;\n    margin-bottom: 8px;\n}\n\n.terms-section .updated {\n    font-size: 14px;\n    color: #6b7280;\n    margin-bottom: 24px;\n}\n\n.terms-list {\n    display: flex;\n    flex-direction: column;\n    gap: 16px;\n}\n\n.term-item {\n    display: flex;\n    align-items: flex-start;\n    gap: 14px;\n    padding: 16px;\n    background: #f9fafb;\n    border: 1px solid #e5e7eb;\n    border-radius: 10px;\n    transition: background 0.25s ease;\n}\n\n.term-item:hover {\n    background: #f3f4f6;\n}\n\n.term-item input[type=\"checkbox\"] {\n    margin-top: 4px;\n    width: 18px;\n    height: 18px;\n    accent-color: #0f766e;\n    cursor: pointer;\n}\n\n.term-item span {\n    font-size: 15px;\n    line-height: 1.65;\n    color: #374151;\n}\n\n.term-item strong {\n    color: #111827;\n}\n\n.term-item ul {\n    margin: 8px 0 0 18px;\n    padding: 0;\n}\n\n.term-item ul li {\n    list-style: disc;\n    margin-bottom: 6px;\n    font-size: 14px;\n}\n\n.term-item.final {\n    background: #ecfdf5;\n    border-color: #6ee7b7;\n}\n\n.term-item.final span {\n    font-size: 16px;\n    font-weight: 600;\n}\n\n.contact-note {\n    margin-top: 24px;\n    font-size: 14px;\n    color: #4b5563;\n}\n</style>\n\n<section class=\"terms-section\">\n    <h2>Terms of Use</h2>\n    <p class=\"updated\">Last updated: January 9, 2026</p>\n\n    <form class=\"terms-list\">\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>1. Acceptance of Terms</strong><br>\n                By accessing and using this website, you agree to be bound by these Terms of Use.\n                If you do not agree, please do not use this service.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>2. Use License</strong><br>\n                Permission is granted to temporarily download one copy of the materials on this website\n                for personal, non-commercial viewing only. Under this license, you may not:\n                <ul>\n                    <li>Modify or copy the materials</li>\n                    <li>Use the materials for any commercial purpose or public display</li>\n                    <li>Attempt to decompile or reverse engineer any software on the website</li>\n                    <li>Remove copyright or proprietary notices</li>\n                </ul>\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>3. User Responsibilities</strong><br>\n                You are responsible for maintaining the confidentiality of your account and password\n                and for all activities that occur under your account.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>4. Booking and Reservations</strong><br>\n                You agree to provide accurate and complete booking information. All reservations are\n                subject to availability and confirmation. Please refer to our Hotel Policy for details.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>5. Intellectual Property</strong><br>\n                All website content, including text, graphics, logos, images, and software, is the\n                property of <strong>Emilton Hotels & Suites</strong> and protected by intellectual\n                property laws.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>6. Limitation of Liability</strong><br>\n                Emilton Hotels & Suites shall not be liable for any damages arising from the use or\n                inability to use the materials on this website.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>7. Accuracy of Materials</strong><br>\n                The materials on this website may contain errors. We do not warrant that any content\n                is accurate, complete, or current.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>8. Links to Third-Party Sites</strong><br>\n                We are not responsible for the content or privacy practices of third-party websites\n                linked from this site.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>9. Modifications</strong><br>\n                We may revise these Terms of Use at any time without notice. Continued use of the\n                website constitutes acceptance of the updated terms.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>10. Governing Law</strong><br>\n                These terms are governed by the laws of the <strong>Federal Republic of Nigeria</strong>,\n                and you submit to the exclusive jurisdiction of its courts.\n            </span>\n        </label>\n\n        <label class=\"term-item\">\n            <input type=\"checkbox\" required>\n            <span>\n                <strong>11. Contact Information</strong><br>\n                For questions regarding these Terms of Use, please contact us via our website\n                contact page.\n            </span>\n        </label>\n\n        <label class=\"term-item final\">\n            <input type=\"checkbox\" required>\n            <span>I have read, understood, and agree to these Terms of Use.</span>\n        </label>\n    </form>\n\n    <p class=\"contact-note\">\n        By proceeding, you confirm that you understand and accept the terms governing the use of\n        Emilton Hotels & Suites’ website and services.\n    </p>\n</section>\n', '2026-01-09 18:16:14'),
(1335, 'rooms', 'hero_title', 'html', 'All Rooms & Suites', '2026-01-09 18:17:42'),
(1336, 'rooms', 'hero_background', 'image', 'assets/uploads/img_696140daecb922.78249875.jpg', '2026-01-09 18:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `max_guests` int(11) DEFAULT NULL,
  `rating` int(1) DEFAULT 5 COMMENT 'Star rating (1-5)',
  `rating_score` decimal(3,1) DEFAULT NULL COMMENT 'Rating score (e.g., 9.8)',
  `location` varchar(255) DEFAULT NULL COMMENT 'Room location/wing (e.g., "Ocean Wing, 5th Floor")',
  `size` varchar(50) DEFAULT NULL COMMENT 'Room size (e.g., "55 m²")',
  `tags` text DEFAULT NULL COMMENT 'JSON array of tags (e.g., ["Sustainable", "Ocean Front", "Soundproof"])',
  `included_items` text DEFAULT NULL COMMENT 'JSON array of included items',
  `good_to_know` text DEFAULT NULL COMMENT 'JSON object with check-in/out, cancellation, pets, children policies',
  `book_url` varchar(500) DEFAULT NULL COMMENT 'Custom URL for Book Now button',
  `original_price` decimal(10,2) DEFAULT NULL COMMENT 'Original price for discount display',
  `urgency_message` varchar(255) DEFAULT NULL COMMENT 'Optional urgency message (e.g., "High demand! Only 2 rooms left.")',
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `gallery_images` text DEFAULT NULL COMMENT 'JSON array of image paths',
  `features` text DEFAULT NULL COMMENT 'JSON array of features',
  `amenities` text DEFAULT NULL COMMENT 'JSON array of amenities',
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `title`, `slug`, `price`, `room_type`, `max_guests`, `rating`, `rating_score`, `location`, `size`, `tags`, `included_items`, `good_to_know`, `book_url`, `original_price`, `urgency_message`, `description`, `short_description`, `main_image`, `gallery_images`, `features`, `amenities`, `is_featured`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(7, 'Emilton Suite', 'emilton-suite', 230000.00, '1 bed', 2, 5, 9.8, '', '75', '[]', '[\"Breakfast\"]', '{\"check_in\":\"2pm\",\"check_out\":\"11am\",\"pets\":\"No Pet allowed\"}', 'https://app.stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'The Emilton Suite offers a sophisticated living experience with separate spaces for relaxation and comfort. Designed for guests who desire privacy, space, and premium service.', 'assets/uploads/img_6960f7e92ec438.72539233.jpg', '[\"assets\\/uploads\\/img_6960f7ea253570.91250373.jpg\",\"assets\\/uploads\\/img_6960f7e1ce0fd7.97076263.jpg\",\"assets\\/uploads\\/img_6960f7e5cd3867.99660715.jpg\",\"assets\\/uploads\\/img_6960f7e9b277e5.09424827.jpg\",\"assets\\/uploads\\/img_6960f7e87cc890.71671670.jpg\",\"assets\\/uploads\\/img_6960f7e7e6db45.63148278.jpg\",\"assets\\/uploads\\/img_6960f7e65134b9.88639330.jpg\",\"assets\\/uploads\\/img_6960f7e6d4dc08.26616096.jpg\"]', '[\"Separate bedroom and living area\",\"Air conditioning\",\"Bathrobe & slippers\",\"Mini fridge\"]', '[{\"icon\":\"check_circle\",\"title\":\"Bathrobe & slippers\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Smart TVs\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"High-speed Wi-Fi\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Comfortable sofa seating\",\"description\":\"\"}]', 0, 1, 0, '2026-01-09 12:21:01', '2026-04-06 04:22:20'),
(9, 'Emilton Mini Classic', 'emilton-mini-classic', 75000.00, '1 bed', 2, 4, 9.9, '', '55', '[]', '[\"Free Laundry\"]', '{\"check_in\":\"2PM\",\"check_out\":\"12 noon\",\"pets\":\"Pets Not Allowed\"}', 'https://app-stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'The Emilton Mini Classic is a cozy yet refined room designed for short stays and solo travelers. It combines modern comfort with tasteful interiors, offering a peaceful space to relax after a long day.', 'assets/uploads/img_695c7975c99576.98612253.jpg', '[\"assets\\/uploads\\/img_6961341c10cf82.70641978.jpg\",\"assets\\/uploads\\/img_6961341c8eccc5.26417651.jpg\",\"assets\\/uploads\\/img_6961341d08a090.22179981.jpg\"]', '[\"Comfortable queen-size bed\",\"Air conditioning\",\"Smart TV\",\"High-speed Wi-Fi\",\"Work desk and chair\"]', '[{\"icon\":\"check_circle\",\"title\":\"Modern bathroom\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Premium toiletries\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Wardrobe space\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Daily housekeeping\",\"description\":\"\"}]', 0, 1, 0, '2026-01-09 17:03:41', '2026-01-13 19:16:35'),
(10, 'Emilton Classic', 'emilton-classic', 150000.00, '1 bed', 2, 5, 9.0, '', '75', '[]', '[]', '{\"check_in\":\"2pm\",\"check_out\":\"12 noon\",\"pets\":\"Pets Not Allowed\"}', 'https://app.stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'Designed for guests who desire added space and comfort, the Emilton Classic room offers elegant furnishings and a warm atmosphere, perfect for both business and leisure stays', 'assets/uploads/img_6960f7e6d4dc08.26616096.jpg', '[\"assets\\/uploads\\/img_695c7a2d25af10.85941541.jpg\",\"assets\\/uploads\\/img_6961358ff14cf6.14190811.jpg\"]', '[]', '[]', 0, 1, 0, '2026-01-09 17:34:45', '2026-04-06 04:22:10'),
(11, 'Emilton Executive', 'emilton-executive', 180000.00, '1 bed', 2, 5, 7.0, '', '75', '[]', '[\"Breakfast\"]', '{\"check_in\":\"2pm\",\"check_out\":\"12 noon\",\"pets\":\"Pets Not Allowed\"}', 'https://app.stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'The Emilton Executive room offers elevated comfort with stylish interiors and enhanced space. Designed for executives who appreciate privacy, elegance, and productivity.', 'assets/uploads/img_695c67133228e9.55273035.jpg', '[\"assets\\/uploads\\/img_69613d264585a1.54935689.jpg\",\"assets\\/uploads\\/img_69613d27601ae5.64164827.jpg\",\"assets\\/uploads\\/img_69613d28ee0fd8.88213897.jpg\"]', '[\"King-size luxury bed\",\"Air conditioning\",\"Smart TV\",\"High-speed Wi-Fi\",\"Executive work desk\",\"Comfortable seating\"]', '[{\"icon\":\"check_circle\",\"title\":\"Modern bathroom\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Bathrobe\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"slippers\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"In-room safe\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Daily housekeeping\",\"description\":\"\"}]', 0, 1, 0, '2026-01-09 17:41:11', '2026-04-06 04:22:00'),
(12, 'Emilton Kings', 'emilton-kings', 200000.00, '1 bed', 2, 5, 8.0, '', '75', '[]', '[\"Breakfast\"]', '{\"check_in\":\"2pm\",\"check_out\":\"12 noon\",\"pets\":\"\"}', 'https://app-stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'The Emilton Kings room delivers superior comfort with refined décor and a spacious layout. Every detail is crafted to ensure relaxation, luxury, and exclusivity.', 'assets/uploads/img_695c6945231539.82149696.jpg', '[\"assets\\/uploads\\/img_69613efcc79391.54558552.jpg\",\"assets\\/uploads\\/img_69613efd371684.68369582.jpg\",\"assets\\/uploads\\/img_69613efdc9f830.00507922.jpg\",\"assets\\/uploads\\/img_69613efe608883.18495416.jpg\",\"assets\\/uploads\\/img_69613efeeda421.61698944.jpg\",\"assets\\/uploads\\/img_69613f001c5984.72588447.jpg\",\"assets\\/uploads\\/img_69613f014c0e20.09261379.jpg\"]', '[\"King-size luxury bed\",\"Air conditioning\",\"Smart TV\",\"High-speed Wi-Fi\",\"Lounge seating area\"]', '[{\"icon\":\"check_circle\",\"title\":\"Modern bathroom\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Bathrobe\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"slippers\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"In-room safe\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Mini fridge\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Daily housekeeping\",\"description\":\"\"}]', 0, 1, 0, '2026-01-09 17:48:43', '2026-03-30 13:53:30'),
(13, 'Emilton Twin Room', 'emilton-twin-room', 280000.00, '2 bed', 3, 5, 10.0, '', '75', '[]', '[\"Breakfast\"]', '{\"check_in\":\"2pm\",\"check_out\":\"12 noon\",\"pets\":\"\"}', 'https://app.stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'he Emilton Twin Room is designed for guests who require space, comfort, and flexibility. Featuring two luxury beds within a well-appointed layout, this room is ideal for shared stays while maintaining comfort and privacy. The refined interiors and modern amenities ensure a relaxed and convenient stay.', 'assets/uploads/img_69613ff4374cf1.91069955.jpg', '[\"assets\\/uploads\\/img_69613ff5a24731.41132525.jpg\",\"assets\\/uploads\\/img_69613ff4374cf1.91069955.jpg\",\"assets\\/uploads\\/img_69613ff4c93613.38339276.jpg\",\"assets\\/uploads\\/img_69613ff2c93cc6.34598787.jpg\",\"assets\\/uploads\\/img_6961358ff14cf6.14190811.jpg\",\"assets\\/uploads\\/img_6960f7e6d4dc08.26616096.jpg\"]', '[\"Two luxury twin beds\",\"Air conditioning\",\"Smart TV\",\"High-speed Wi-Fi\",\"Work desk\"]', '[{\"icon\":\"check_circle\",\"title\":\"Modern bathroom\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Premium toiletries\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Daily housekeeping\",\"description\":\"\"}]', 0, 1, 0, '2026-01-09 17:52:57', '2026-04-06 04:21:47'),
(14, 'Emilton Duplex', 'emilton-duplex', 500000.00, '3 bed', 5, 5, 10.0, '', '350', '[]', '[\"Breakfast\"]', '{\"check_in\":\"2pm\",\"check_out\":\"12 noon\",\"pets\":\"\"}', 'https://app.stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'The Emilton Duplex represents the peak of luxury at Emilton Hotel &amp;amp;amp;amp; Suites. Spanning two levels, this exclusive accommodation offers expansive living spaces, privacy, and a premium lifestyle experience. Designed for elite guests, it delivers comfort, sophistication, and prestige in every detail.', 'assets/uploads/img_696140daecb922.78249875.jpg', '[\"assets\\/uploads\\/img_696140e1e03023.51947423.jpg\",\"assets\\/uploads\\/img_696140e02b1fc7.49741294.jpg\",\"assets\\/uploads\\/img_696140de175974.01675329.jpg\",\"assets\\/uploads\\/img_696140dbd7ce86.67752892.jpg\",\"assets\\/uploads\\/img_696140d9ef9482.27615727.jpg\"]', '[\"Two-level luxury accommodation\",\"Master bedroom\",\"King-size bed\",\"Spacious living\",\"Dining space\"]', '[{\"icon\":\"check_circle\",\"title\":\"Multiple Smart TVs\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"High-speed Wi-Fi\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Air conditioning\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Executive work area\",\"description\":\"\"},{\"icon\":\"check_circle\",\"title\":\"Guest restroom\",\"description\":\"\"}]', 0, 1, 0, '2026-01-09 17:56:32', '2026-04-06 04:21:29'),
(15, 'Emilton Special', 'emilton-special', 250000.00, '1 bed', 2, 5, NULL, '', '', '[]', '[]', '{\"check_in\":\"2pm\",\"check_out\":\"\",\"pets\":\"\"}', 'https://app.stayeazi.com/reservation/emilton-hotel', NULL, '', '', 'Free Wifi with complimentary breakfast', 'assets/uploads/img_69ca8329e65266.11802634.jpeg', '[\"assets\\/uploads\\/img_69ca832e2f26a6.12021276.jpeg\",\"assets\\/uploads\\/img_69ca832d2a5058.15831368.jpeg\",\"assets\\/uploads\\/img_69ca832c87cd58.78183974.jpeg\",\"assets\\/uploads\\/img_69ca832b2b2cc6.84474534.jpeg\",\"assets\\/uploads\\/img_69ca832bd91a24.92073065.jpeg\",\"assets\\/uploads\\/img_69ca83292d82e5.82092489.jpeg\"]', '[\"King-size luxury bed\",\"Free Wifi\",\"Complimentary Breakfast\"]', '[{\"icon\":\"check_circle\",\"title\":\"Modern bathroom\",\"description\":\"\"}]', 0, 1, 0, '2026-03-30 14:08:22', '2026-04-06 04:20:12');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_name', 'Emilton Hotels & Suites', '2026-01-26 02:47:28'),
(2, 'site_tagline', 'Home away from home', '2026-01-26 02:47:28'),
(3, 'site_logo', 'assets/uploads/img_695c5f71903794.73531479.png', '2026-01-26 02:47:28'),
(4, 'site_favicon', 'assets/uploads/img_695c5f85883ea1.15057654.jpeg', '2026-01-26 02:47:28'),
(5, 'footer_address', '36 Awoniyi Elemo street.Ajao Estate off airportroad.Ikeja, Lagos', '2026-01-26 02:47:28'),
(6, 'footer_phone', '07064907675', '2026-01-26 02:47:28'),
(7, 'footer_copyright', 'Emilton Hotel & Suites', '2026-01-26 02:47:28'),
(8, 'header_location', '11 Okpofe Street, Ajoa Estate, Off Int\'l Airport Road', '2026-01-06 01:04:20'),
(9, 'whatsapp_link', 'https://wa.me/2348134807718?text=Greetings%20TM%20Luxury%20Apartment', '2026-01-06 01:04:20'),
(10, 'developer_link', 'https://wa.me/2347068057873?text=Greetings%20Brilliant%20Developers', '2026-01-06 01:04:20'),
(11, 'developer_text', 'Brilliant Developers - 07068057873', '2026-01-06 01:04:20'),
(83, 'header_scripts', '<script src=\"https://app-stayeazi.com/bookingWidget/emilton.js\"></script>\n\n\n<!-- Google tag (gtag.js) -->\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-BWJV5R5PLY\"></script>\n<script>\n  window.dataLayer = window.dataLayer || [];\n  function gtag(){dataLayer.push(arguments);}\n  gtag(\'js\', new Date());\n\n  gtag(\'config\', \'G-BWJV5R5PLY\');\n</script>', '2026-01-26 02:47:28'),
(84, 'body_scripts', '', '2026-01-26 02:47:28'),
(85, 'footer_scripts', '', '2026-01-26 02:47:28'),
(109, 'whatsapp_number', '+2347064907675', '2026-01-26 02:47:28'),
(110, 'whatsapp_logo', '', '2026-01-13 20:10:22'),
(111, 'whatsapp_logo_url', '', '2026-01-13 20:10:22'),
(130, 'currency_symbol', '$', '2026-01-26 02:47:28'),
(135, 'footer_email', '', '2026-01-26 02:47:28'),
(137, 'contact_email', '', '2026-01-26 02:47:28'),
(139, 'smtp_host', '', '2026-01-26 02:47:28'),
(140, 'smtp_port', '587', '2026-01-26 02:47:28'),
(141, 'smtp_username', 'admin', '2026-01-26 02:47:28'),
(142, 'smtp_password', 'Admin@123', '2026-01-26 02:47:28'),
(143, 'smtp_encryption', '', '2026-01-26 02:47:28'),
(144, 'smtp_from_email', '', '2026-01-26 02:47:28'),
(145, 'smtp_from_name', 'Emilton Hotels & Suites', '2026-01-26 02:47:28'),
(146, 'social_media_json', '[]', '2026-01-26 02:47:28'),
(147, 'google_maps_api_key', '', '2026-01-26 02:47:28');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `quote` text NOT NULL,
  `rating` int(1) DEFAULT 5 CHECK (`rating` >= 1 and `rating` <= 5),
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_file_path` (`file_path`),
  ADD KEY `idx_uploaded_by` (`uploaded_by`);

--
-- Indexes for table `navigation_menu`
--
ALTER TABLE `navigation_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_page_section` (`page`,`section_key`),
  ADD KEY `idx_page` (`page`),
  ADD KEY `idx_section_key` (`section_key`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `idx_is_featured` (`is_featured`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_setting_key` (`setting_key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `idx_display_order` (`display_order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `navigation_menu`
--
ALTER TABLE `navigation_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_sections`
--
ALTER TABLE `page_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1792;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `navigation_menu`
--
ALTER TABLE `navigation_menu`
  ADD CONSTRAINT `navigation_menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `navigation_menu` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
