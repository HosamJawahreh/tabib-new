-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2026 at 02:22 PM
-- Server version: 8.0.44-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabib`
--

-- --------------------------------------------------------

--
-- Table structure for table `ec_product_categories`
--

CREATE TABLE `ec_product_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `order` int UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ec_product_categories`
--

INSERT INTO `ec_product_categories` (`id`, `name`, `parent_id`, `description`, `status`, `order`, `image`, `is_featured`, `created_at`, `updated_at`) VALUES
(84, 'خالي جلوتين', 0, NULL, 'published', 11, 'news/logo-new/gluten-free-logo.jpg', 1, '2023-07-28 18:24:10', '2024-01-27 10:58:22'),
(85, 'خالي سكر', 0, NULL, 'published', 10, 'news/logo-new/sugar-free-logo.jpg', 1, '2023-07-28 18:27:04', '2024-01-27 10:58:36'),
(86, 'كيتو', 0, NULL, 'published', 9, 'news/logo-new/keto-logo.jpg', 1, '2023-07-28 18:27:25', '2024-01-27 10:58:57'),
(87, 'سوبر فود', 0, NULL, 'published', 6, 'news/logo-new/super-food-logo.jpg', 1, '2023-07-28 18:28:21', '2024-01-28 09:38:00'),
(88, 'أغذية رياضيين', 0, NULL, 'published', 8, 'news/logo-new/fitness-logo.jpg', 1, '2023-07-28 18:28:48', '2024-01-28 09:37:16'),
(89, 'خالي لاكتوز', 0, NULL, 'published', 7, 'news/logo-new/lactose-logo.jpg', 1, '2023-07-28 18:29:11', '2024-01-28 09:37:43'),
(90, 'نباتي', 0, NULL, 'published', 5, 'news/logo-new/vegan-logo.jpg', 1, '2023-07-28 20:04:23', '2024-01-27 11:01:12'),
(91, 'قليل البروتين', 0, NULL, 'published', 4, 'news/logo-new/low-protein-logo.jpg', 1, '2023-07-28 20:04:48', '2024-01-27 11:07:10'),
(95, 'أغذية عضوية', 0, NULL, 'published', 3, 'news/logo-new/organic-logo.jpg', 1, '2023-08-13 16:53:28', '2024-01-27 11:07:26'),
(96, 'عروض', 0, NULL, 'published', 1, 'news/logo-new/offer-logo.jpg', 1, '2023-08-13 16:54:56', '2023-09-23 18:26:47'),
(97, 'كورن فلكس / شوفان', 84, NULL, 'published', 1, 'subcatugery/korn-flks.jpg', 0, '2023-08-13 16:57:41', '2023-08-23 13:07:20'),
(98, 'بسكوت / ويفر', 84, NULL, 'published', 2, 'subcatugery/bskot.jpg', 0, '2023-08-13 16:59:51', '2023-08-23 13:07:46'),
(99, 'شيبس/ سوس/ مارشملو', 84, NULL, 'published', 3, 'subcatugery/shybs.jpg', 0, '2023-08-13 17:03:34', '2023-08-23 13:08:15'),
(100, 'شكولاتة', 84, NULL, 'published', 4, 'subcatugery/shkolat.jpg', 0, '2023-08-13 17:05:08', '2023-08-23 13:08:34'),
(101, 'مخبوزات', 84, NULL, 'published', 5, 'subcatugery/mkhbozat.jpg', 0, '2023-08-13 17:06:27', '2023-08-23 13:09:08'),
(102, 'طحين / خليط كيك', 84, NULL, 'published', 6, 'subcatugery/thyn.jpg', 0, '2023-08-13 17:09:27', '2023-08-23 13:09:35'),
(103, 'معكرونة', 84, NULL, 'published', 7, 'subcatugery/maakron.jpg', 0, '2023-08-13 17:11:00', '2023-08-23 13:09:54'),
(104, 'طعام / صوصات', 84, NULL, 'published', 8, 'subcatugery/taaam.jpg', 0, '2023-08-13 17:13:04', '2023-08-23 13:10:10'),
(105, 'بهارات/ حبوب/ ماجي', 84, NULL, 'published', 9, 'subcatugery/bhar.jpg', 0, '2023-08-13 17:17:58', '2023-08-23 13:10:35'),
(106, 'خالي سكر مضاف', 84, NULL, 'published', 10, 'subcatugery/khaly-skr.jpg', 0, '2023-08-13 17:21:18', '2023-08-23 13:10:56'),
(107, 'محليات', 85, NULL, 'published', 1, 'subcatugery/mhly.jpg', 0, '2023-08-13 17:23:10', '2023-08-23 13:11:38'),
(108, 'محليات طبيعية', 85, NULL, 'published', 2, 'subcatugery/mhly-tbyaay.jpg', 0, '2023-08-13 17:25:04', '2023-08-23 13:14:54'),
(109, 'بسكوت / ويفر', 85, NULL, 'published', 3, 'subcatugery/bskot.jpg', 0, '2023-08-13 17:27:09', '2023-08-23 13:15:11'),
(110, 'شكولاتة / حلوى', 85, NULL, 'published', 4, 'subcatugery/shkolat.jpg', 0, '2023-08-13 17:29:30', '2023-08-23 13:15:31'),
(111, 'مشروبات', 85, NULL, 'published', 5, 'subcatugery/mshrobat.jpg', 0, '2023-08-13 17:31:00', '2023-08-23 13:16:07'),
(112, 'رايس كيك /شوفان', 85, NULL, 'published', 6, 'subcatugery/rays-kyk.jpg', 0, '2023-08-13 17:32:51', '2024-05-30 14:37:11'),
(113, 'متنوع', 85, NULL, 'published', 7, 'subcatugery/mtnoaa.jpg', 0, '2023-08-13 17:37:11', '2023-08-23 13:17:14'),
(114, 'أرز/ ملح/ زيت رش', 85, NULL, 'published', 8, 'subcatugery/rz.jpg', 0, '2023-08-13 17:39:08', '2023-08-23 13:17:29'),
(115, 'خل/ زيوت', 86, NULL, 'published', 1, 'subcatugery/khl.jpg', 0, '2023-08-13 17:40:36', '2023-08-23 13:18:03'),
(116, 'محليات طبيعية', 86, NULL, 'published', 2, 'subcatugery/mhly-tbyaay.jpg', 0, '2023-08-13 17:42:22', '2023-08-23 13:18:19'),
(117, 'طحين / خليط كيك', 86, NULL, 'published', 3, 'subcatugery/thyn.jpg', 0, '2023-08-13 17:44:04', '2023-08-23 13:18:57'),
(118, 'مشروبات', 86, NULL, 'published', 4, 'subcatugery/mshrobat.jpg', 0, '2023-08-13 17:45:32', '2023-08-23 13:20:00'),
(119, 'متنوع', 86, NULL, 'published', 5, 'subcatugery/mtnoaa.jpg', 0, '2023-08-13 17:46:56', '2023-08-23 13:20:46'),
(120, 'حليب', 89, NULL, 'published', 1, 'subcatugery/hlyb.jpg', 0, '2023-08-13 17:48:57', '2023-08-23 13:13:16'),
(121, 'أجبان', 89, NULL, 'published', 2, 'subcatugery/agban.jpg', 0, '2023-08-13 17:50:23', '2023-08-23 13:13:05'),
(122, 'متنوع', 89, NULL, 'published', 3, 'subcatugery/mtnoaa.jpg', 0, '2023-08-13 17:51:31', '2023-08-23 13:12:51'),
(123, 'سناكات', 88, NULL, 'published', 7, 'news/shkolat.jpg', 0, '2023-09-30 14:47:20', '2024-01-31 06:34:02'),
(124, 'رايس كيك /شوفان', 88, NULL, 'published', 8, 'news/rays-kyk.jpg', 0, '2023-09-30 14:49:25', '2024-01-31 06:34:15'),
(125, 'مشروبات', 88, NULL, 'published', 9, 'news/mshrobat.jpg', 0, '2023-09-30 14:52:44', '2024-01-31 06:34:28'),
(126, 'متنوع', 88, NULL, 'published', 10, 'news/taaam.jpg', 0, '2023-09-30 14:54:53', '2024-01-31 06:34:40'),
(127, 'مكملات', 88, NULL, 'published', 0, NULL, 0, '2024-01-27 10:56:32', '2024-02-06 07:16:02'),
(130, 'واي بروتين', 127, NULL, 'published', 2, NULL, 0, '2024-10-17 00:05:57', '2024-10-21 18:20:24'),
(131, 'ايزو بروتين', 127, NULL, 'published', 4, NULL, 0, '2024-10-17 00:06:25', '2024-10-21 18:20:35'),
(132, 'حوارق دهون', 127, NULL, 'published', 12, NULL, 0, '2024-10-17 00:06:47', '2024-10-21 18:46:50'),
(133, 'بيف بروتين', 127, NULL, 'published', 7, NULL, 0, '2024-10-17 00:07:18', '2024-10-21 18:21:31'),
(134, 'كرياتين', 127, NULL, 'published', 10, NULL, 0, '2024-10-17 00:07:35', '2024-10-21 18:22:20'),
(135, 'ماس', 127, NULL, 'published', 6, NULL, 0, '2024-10-17 00:08:07', '2024-10-21 18:21:14'),
(136, 'بري ورك اوت', 127, NULL, 'published', 11, NULL, 0, '2024-10-17 00:08:34', '2024-10-21 18:22:32'),
(137, 'هيدرو بروتين', 127, NULL, 'published', 5, NULL, 0, '2024-10-21 18:14:35', '2024-10-21 18:20:58'),
(138, 'نباتي بروتين', 127, NULL, 'published', 8, NULL, 0, '2024-10-21 18:17:10', '2024-10-21 18:35:12'),
(139, 'كارب', 127, NULL, 'published', 10, NULL, 0, '2024-10-21 18:35:59', '2024-10-21 18:35:59'),
(140, 'احماض امينية', 127, NULL, 'published', 13, NULL, 0, '2024-10-21 18:47:47', '2024-10-21 18:50:00'),
(141, 'كولاجين& فيتامين', 127, NULL, 'published', 14, NULL, 0, '2024-10-21 18:51:25', '2024-10-21 18:51:25'),
(142, 'عروض', 127, NULL, 'published', 15, NULL, 0, '2024-12-21 19:06:03', '2024-12-21 19:06:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ec_product_categories`
--
ALTER TABLE `ec_product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ec_product_categories_parent_id_status_created_at_index` (`parent_id`,`status`,`created_at`),
  ADD KEY `ec_product_categories_parent_id_status_index` (`parent_id`,`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ec_product_categories`
--
ALTER TABLE `ec_product_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
