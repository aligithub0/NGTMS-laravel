-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 08:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngtms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `logs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`logs`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agent_purposes`
--

CREATE TABLE `agent_purposes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purpose_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agent_purposes`
--

INSERT INTO `agent_purposes` (`id`, `user_id`, `purpose_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-05-06 17:20:24', '2025-05-06 17:20:24');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `task_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_type` varchar(255) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_comp_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_group` enum('yes','no') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_code` varchar(255) DEFAULT NULL,
  `company_type_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `parent_comp_id`, `is_group`, `status`, `created_at`, `updated_at`, `company_code`, `company_type_id`) VALUES
(1, 'CWIT', NULL, 'yes', 1, '2025-05-07 22:13:06', '2025-05-07 23:10:22', '100', 1),
(2, 'MS TEL', NULL, 'no', 1, '2025-05-07 22:13:58', '2025-05-07 23:15:08', '200', 3);

-- --------------------------------------------------------

--
-- Table structure for table `company_types`
--

CREATE TABLE `company_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_types`
--

INSERT INTO `company_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AOP', 1, '2025-05-07 19:02:37', '2025-05-07 21:42:23'),
(2, 'PVT Limited', 1, '2025-05-07 21:42:45', '2025-05-07 21:42:45'),
(3, 'Sole Proprietor', 1, '2025-05-07 21:43:22', '2025-05-07 21:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `contact_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `preferred_contact_method` varchar(50) DEFAULT NULL,
  `contact_priority` varchar(50) DEFAULT NULL,
  `time_zone` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `picture_url` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `status`, `contact_type_id`, `designation_id`, `preferred_contact_method`, `contact_priority`, `time_zone`, `is_active`, `picture_url`, `country`, `created_at`, `updated_at`) VALUES
(1, 'Umut Haslak', 'mahmutalav0@gmail.com', 1, 1, 4, 'Phone', 'Normal', 'GMT-0', 1, 'https://via.placeholder.com/150', 'United Kingdom', '2025-05-17 18:07:42', '2025-05-21 05:49:06'),
(2, 'Hesam Bahrami', 'hesambahrami265@gmail.com', 1, 1, 2, 'SMS', 'Medium', 'GMT-0', 1, 'https://via.placeholder.com/150', 'United Kingdom', '2025-05-21 05:51:12', '2025-05-21 05:51:12'),
(3, 'Sukhwinder Singh', 'sukhsinghglasgow@gmail.com', 1, 1, 2, 'Email', 'High', 'GMT-0', 1, 'https://via.placeholder.com/150', 'United Kingdom', '2025-05-21 05:52:27', '2025-05-21 05:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `contacts_phone_numbers`
--

CREATE TABLE `contacts_phone_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `phone_type` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `is_whatsapp` tinyint(1) NOT NULL DEFAULT 0,
  `is_preferred` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts_phone_numbers`
--

INSERT INTO `contacts_phone_numbers` (`id`, `contact_id`, `phone_type`, `phone_number`, `is_whatsapp`, `is_preferred`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mobile', '03017653421', 1, 1, '2025-05-20 20:46:24', '2025-05-20 20:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `contacts_preferences`
--

CREATE TABLE `contacts_preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `whatsapp_pref` char(12) DEFAULT NULL,
  `mailing_address_pref` char(12) DEFAULT NULL,
  `language_pref` varchar(50) DEFAULT NULL,
  `email_opt_in` tinyint(1) NOT NULL DEFAULT 1,
  `whatsapp_opt_in` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts_preferences`
--

INSERT INTO `contacts_preferences` (`id`, `contact_id`, `whatsapp_pref`, `mailing_address_pref`, `language_pref`, `email_opt_in`, `whatsapp_opt_in`, `created_at`, `updated_at`) VALUES
(1, 1, 'Personal', 'Home', 'English', 1, 1, '2025-05-20 20:47:33', '2025-05-20 20:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `contacts_social_links`
--

CREATE TABLE `contacts_social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `handle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts_social_links`
--

INSERT INTO `contacts_social_links` (`id`, `contact_id`, `platform`, `handle`, `created_at`, `updated_at`) VALUES
(1, 1, 'LinkedIn', '1902321', '2025-05-20 20:47:53', '2025-05-20 20:47:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact_companies`
--

CREATE TABLE `contact_companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_comp_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_group` enum('yes','no') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_code` varchar(255) DEFAULT NULL,
  `company_type_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_companies`
--

INSERT INTO `contact_companies` (`id`, `name`, `parent_comp_id`, `is_group`, `status`, `created_at`, `updated_at`, `company_code`, `company_type_id`) VALUES
(1, 'CWIT', NULL, 'yes', 1, '2025-05-17 00:27:06', '2025-05-17 00:27:06', '1000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_segmentations`
--

CREATE TABLE `contact_segmentations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_segmentations`
--

INSERT INTO `contact_segmentations` (`id`, `name`, `description`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(2, 'A', '<p>&nbsp;A grade is for high-priority contacts with critical impact on business.&nbsp;</p>', 1, 1, '2025-05-20 20:44:06', '2025-05-20 20:48:17'),
(3, 'B', '<p>&nbsp;B grade is for important contacts with frequent support needs.&nbsp;</p>', 0, 1, '2025-05-20 20:44:18', '2025-05-20 20:44:18'),
(4, 'C', '<p>&nbsp;C grade is for standard contacts with regular ticket submissions.</p>', 0, 1, '2025-05-20 20:44:42', '2025-05-20 20:44:42'),
(5, 'D', '<p>&nbsp;D grade is for low-priority contacts or infrequent ticket raisers.</p>', 0, 1, '2025-05-20 20:44:54', '2025-05-20 20:44:54'),
(6, 'E', '<p>&nbsp;E grade is for inactive or archived contacts with no recent activity.&nbsp;</p>', 0, 1, '2025-05-20 20:45:08', '2025-05-20 20:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `contact_types`
--

CREATE TABLE `contact_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_types`
--

INSERT INTO `contact_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Employee', 1, '2025-05-16 19:20:48', '2025-05-16 19:20:48'),
(2, 'Employer', 1, '2025-05-21 05:53:21', '2025-05-21 05:53:21'),
(3, 'Office Manager', 1, '2025-05-21 05:54:48', '2025-05-21 05:54:48'),
(4, 'Accounts Manager', 1, '2025-05-21 05:55:07', '2025-05-21 05:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Support1', 1, '2025-05-06 23:37:10', '2025-05-24 23:46:48'),
(6, 'Support2', 1, '2025-05-24 23:47:12', '2025-05-24 23:47:12'),
(7, 'Support3', 1, '2025-05-24 23:47:17', '2025-05-24 23:47:17'),
(8, 'Support4', 1, '2025-05-24 23:47:21', '2025-05-24 23:47:21'),
(9, 'Finance', 1, '2025-05-24 23:47:36', '2025-05-24 23:47:36'),
(10, 'Sales', 1, '2025-05-24 23:47:41', '2025-05-24 23:47:41'),
(11, 'HR', 1, '2025-05-24 23:47:59', '2025-05-24 23:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Company Secretary', 1, '2025-05-06 19:10:57', '2025-05-06 19:10:57'),
(4, 'Managing Director', 1, '2025-05-07 18:42:10', '2025-05-07 18:42:10'),
(5, 'Landlord', 1, '2025-05-07 18:42:22', '2025-05-07 18:42:40'),
(6, 'Business Owner', 1, '2025-05-21 04:00:29', '2025-05-21 04:00:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `field_variables`
--

CREATE TABLE `field_variables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `field_variables`
--

INSERT INTO `field_variables` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, '{customer_name}', 'contacts_name', '2025-05-20 20:51:49', '2025-05-20 20:51:49'),
(2, '{ticket_id}', 'tickets_id', '2025-05-20 20:52:35', '2025-05-20 20:52:35'),
(3, '{company_name}', 'contact_companies_name', '2025-05-20 20:53:13', '2025-05-20 20:53:13');

-- --------------------------------------------------------

--
-- Table structure for table `meneuses`
--

CREATE TABLE `meneuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `page_path` text DEFAULT NULL,
  `encryption_salt` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meneuses`
--

INSERT INTO `meneuses` (`id`, `name`, `parent_id`, `status`, `created_at`, `updated_at`, `page_path`, `encryption_salt`) VALUES
(7, 'Tickets', NULL, 1, '2025-05-14 17:39:26', '2025-05-14 17:39:26', 'eyJpdiI6Im41SXlrdHpWd001aHVKdTVhQUFTTFE9PSIsInZhbHVlIjoiR3l4WWJXTWdhdWdFMk9wbWc2YlI2VzJlajBabHFkK05xbVliWmZmTnVSN1hyYjZqQWdqbkc4VktQU0t4UzZBQldVZjA4dW1Hakc4TzJXclE0em41SHc9PSIsIm1hYyI6IjE1NzZiZTZlMzMwMjgyZmRlNGJjODliMDgwMzExZWFjYzA1ZTEwMmFjMmY1MmNiOWQyNTQ5ZTNiNjQ2NWMyMjAiLCJ0YWciOiIifQ==', 'd4fb9951-a2e4-4508-b927-476c1b17f551'),
(8, 'Timesheet', NULL, 1, '2025-05-14 17:39:57', '2025-05-14 17:39:57', 'eyJpdiI6IjRJNjlHb1lZTThaejdmbDdMNHlEeGc9PSIsInZhbHVlIjoiS3RDajM4dUhKTGFIUi9TS2kzMVhJa1N6eGwzUmVCL3FLbnEwdCt2aEF5bC9tQlNwdCtoNVlKNSthZy9qRGRyVWJKb25Ka1JlZGNyOVoyUVFSOHR1eHc9PSIsIm1hYyI6IjlmNGEyNjRkMWM1OWM2YWIwM2JmNjQ5N2EzOWFkNDY4NDA3NzIwYTZhY2UwZDU4OTA4ODdiNTE3MjUyZTE1NzAiLCJ0YWciOiIifQ==', 'b0bc7441-8449-4879-adca-b1e96b25b395');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_05_05_171451_create_roles_table', 2),
(6, '2025_05_05_172100_create_roles_table', 3),
(7, '2025_05_05_172415_create_departments_table', 4),
(8, '2025_05_05_172631_create_departments_table', 5),
(9, '2025_05_05_173011_create_user__statuses_table', 6),
(10, '2025_05_05_173153_create_user__statuses_table', 7),
(11, '2025_05_05_174759_create_user_statuses_table', 8),
(12, '2025_05_05_175625_create_task_statuses_table', 9),
(13, '2025_05_05_175809_create_task_statuses_table', 10),
(14, '2025_05_05_180146_create_ticket_sources_table', 11),
(15, '2025_05_05_180410_create_ticket_statuses_table', 12),
(16, '2025_05_05_180651_create_notification_types_table', 13),
(17, '2025_05_05_181336_create_purposes_table', 14),
(18, '2025_05_05_184707_create_agent_purposes_table', 15),
(19, '2025_05_05_190745_create_meneuses_table', 16),
(20, '2025_05_05_191633_create_roles_meneuses_table', 17),
(21, '2025_05_06_100747_create_agent_purposes_table', 18),
(22, '2025_05_06_102548_create_roles_menus_table', 19),
(23, '2025_05_06_104249_create_designations_table', 20),
(24, '2025_05_06_121847_create_sla_configurations_table', 21),
(25, '2025_05_07_115854_create_company_types_table', 22),
(26, '2025_05_07_120420_create_project_types_table', 23),
(27, '2025_05_07_120936_create_timesheet_activities_table', 24),
(28, '2025_05_07_121455_create_timesheet_statuses_table', 25),
(29, '2025_05_07_133100_create_companies_table', 26),
(30, '2025_05_08_100117_create_projects_table', 27),
(31, '2025_05_08_120448_create_shift_types_table', 28),
(32, '2025_05_08_125802_create_timesheets_table', 29),
(33, '2025_05_09_115424_create_tickets_table', 30),
(34, '2025_05_10_120506_create_user_types_table', 30),
(35, '2025_05_10_171217_create_ticket_attachments_table', 31),
(36, '2025_05_12_094828_create_ticket_attachments_table', 32),
(37, '2025_05_12_102859_create_tasks_table', 33),
(38, '2025_05_13_133824_create_role_menu_permissions_table', 34),
(39, '2025_05_13_135018_create_role_menu_permissions_table', 35),
(40, '2025_05_14_103129_create_priorities_table', 36),
(41, '2025_05_14_105736_create_ticket_replies_table', 37),
(42, '2025_05_12_122439_create_sessions_table', 38),
(43, '2025_05_14_104333_create_notifications_table', 38),
(44, '2025_05_14_161648_create_task_attachments_table', 39),
(45, '2025_05_14_165111_create_comments_table', 40),
(46, '2025_05_14_165729_create_ticket_journeys_table', 41),
(47, '2025_05_16_121022_create_contact_types_table', 42),
(48, '2025_05_16_122213_create_contact_companies_table', 43),
(49, '2025_05_16_125016_create_contacts_table', 44),
(50, '2025_05_16_134734_create_contacts_table', 45),
(51, '2025_05_16_140907_create_contacts_phone_numbers_table', 46),
(52, '2025_05_16_141549_create_contacts_social_links_table', 47),
(53, '2025_05_16_145537_create_contacts_preferences_table', 48),
(54, '2025_05_17_111241_create_activity_logs_table', 49),
(55, '2025_05_17_111427_create_response_templates_table', 50),
(56, '2025_05_17_121617_create_contacts_preferences_table', 51),
(57, '2025_05_17_140102_create_contact_segmentations_table', 51),
(58, '2025_05_19_100637_create_field_variables_table', 51),
(59, '2025_05_23_102317_create_status_workflows_table', 52);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE `notification_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`, `status`, `created_at`, `updated_at`, `is_default`) VALUES
(2, 'Email', 1, '2025-05-07 01:06:22', '2025-05-07 01:06:22', 1),
(3, 'WhatsApp', 1, '2025-05-07 01:06:35', '2025-05-07 01:06:35', 0),
(5, 'SMS', 1, '2025-05-07 01:07:08', '2025-05-16 23:25:13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `is_default`) VALUES
(1, 'Normal', 'Default priority, used if not specified\n', 1, '2025-05-14 17:45:36', '2025-05-20 21:48:22', 1),
(2, 'Low', 'Low impact, minor inconvenience or enhancement\n', 1, '2025-05-14 17:45:44', '2025-05-14 17:45:44', 0),
(3, 'Medium', 'Moderate impact, can be scheduled\n', 1, '2025-05-14 17:45:50', '2025-05-14 17:45:50', 0),
(4, 'High', 'High impact issue, needs to be addressed quickly\n', 1, '2025-05-14 17:45:56', '2025-05-14 17:45:56', 0),
(5, 'Critical', 'Business-critical, immediate action needed\n', 1, '2025-05-14 17:46:01', '2025-05-16 23:25:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `project_type_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `project_owner_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `status`, `project_type_id`, `company_id`, `start_date`, `end_date`, `project_owner_id`, `created_at`, `updated_at`) VALUES
(1, 'CMS Project', 1, 1, 1, '2025-05-09', '2025-05-10', 4, '2025-05-08 18:53:05', '2025-05-08 18:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Crud Project', 1, '2025-05-07 19:08:08', '2025-05-07 19:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `purposes`
--

CREATE TABLE `purposes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sla_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purposes`
--

INSERT INTO `purposes` (`id`, `name`, `description`, `parent_id`, `sla_id`, `status`, `created_at`, `updated_at`, `is_default`) VALUES
(1, 'Customer Service\n', 'For processing new electricity connection requests\n', NULL, 5, 1, '2025-05-06 01:20:29', '2025-05-23 00:23:34', 0),
(3, 'Technical Operations\n', 'Reporting breakdowns or blackouts\n', NULL, 6, 1, '2025-05-10 23:03:19', '2025-05-10 23:03:19', 0),
(4, 'Billing and Payments', 'Wrong billing or overcharging\n', NULL, 5, 1, '2025-05-20 21:55:08', '2025-05-20 21:55:08', 0),
(5, 'Inspection and Vigilance', 'Report of illegal activity or theft\n', NULL, 7, 1, '2025-05-20 21:55:20', '2025-05-20 21:55:20', 0),
(6, 'Infrastructure Maintenance', 'Planned outages or infrastructure upgrades\n', NULL, 7, 1, '2025-05-20 21:55:29', '2025-05-20 21:55:29', 0),
(7, 'Legal or Regulatory', 'Info required for audits or compliance\n', NULL, 6, 1, '2025-05-20 21:55:48', '2025-05-20 21:55:48', 0),
(8, 'Complaint Registration', 'General complaints: billing, supply, service\n', 1, 7, 1, '2025-05-20 21:56:15', '2025-05-20 21:56:15', 0),
(9, 'Update Consumer Details', 'Change of address, contact number, etc.\n', 1, 5, 1, '2025-05-20 21:56:24', '2025-05-20 21:56:24', 0),
(10, 'Meter Reading Dispute', 'Correction of erroneous readings\n', 1, 7, 1, '2025-05-20 21:56:37', '2025-05-20 21:56:37', 0),
(11, 'Transformer Failure', 'Issues related to transformer equipment\n', 3, 7, 1, '2025-05-20 21:56:49', '2025-05-20 21:56:49', 0),
(12, 'Line Fault', 'Transmission/distribution line issues\n', 3, 7, 1, '2025-05-20 21:57:09', '2025-05-20 21:57:09', 0),
(13, 'Voltage Fluctuation', 'Low/high voltage complaints\n', 3, 6, 1, '2025-05-20 21:57:32', '2025-05-20 21:57:32', 0),
(14, 'Payment Not Reflected', 'Paid bill not updated in system\n', 4, 7, 1, '2025-05-20 21:57:45', '2025-05-20 21:57:45', 0),
(15, 'Installment Request', 'Request to pay large bills in installments\n', 4, 5, 1, '2025-05-20 21:57:57', '2025-05-20 21:57:57', 0),
(16, 'Advance Payment Adjustment', 'Adjustment of advance paid bills\n', 4, 7, 1, '2025-05-20 21:58:07', '2025-05-20 21:58:07', 0),
(17, 'Unauthorized Connection', 'Non-registered usage or bypassing meter\n', 5, 7, 1, '2025-05-20 21:58:23', '2025-05-20 21:58:23', 0),
(18, 'Streetlight Fault', 'Reporting public lighting problems\n', 6, 6, 1, '2025-05-20 21:58:37', '2025-05-20 21:58:37', 0),
(19, 'Consumer Dispute Escalation', 'Legal escalation of a dispute\n', 7, 7, 1, '2025-05-20 21:58:49', '2025-05-20 21:58:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `response_templates`
--

CREATE TABLE `response_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `response_templates`
--

INSERT INTO `response_templates` (`id`, `title`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to Our Platform!', '<h2><strong>Hi {{customer_name}},</strong></h2><p>Welcome to {{company_name}}! We\'re thrilled to have you on board. If you have any questions, feel free to reach out to our support team.<br><br>Best regards,&nbsp; <br><strong>{{company_name}} Team</strong><br><br></p>', '2025-05-20 20:58:01', '2025-05-20 21:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, '2025-05-06 00:22:35', '2025-05-07 20:27:07'),
(2, 'Manager', 1, '2025-05-07 20:27:16', '2025-05-07 20:27:16'),
(3, 'Agent', 1, '2025-05-21 00:09:23', '2025-05-21 00:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `roles_menus`
--

CREATE TABLE `roles_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`menu_id`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles_menus`
--

INSERT INTO `roles_menus` (`id`, `menu_id`, `status`, `created_at`, `updated_at`, `role_id`) VALUES
(7, '\"[1,2]\"', 1, '2025-05-10 23:59:49', '2025-05-11 00:11:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_menu_permissions`
--

CREATE TABLE `role_menu_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `objects` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`objects`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_menu_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_menu_permissions`
--

INSERT INTO `role_menu_permissions` (`id`, `objects`, `status`, `created_at`, `updated_at`, `role_id`, `role_menu_id`) VALUES
(2, '[\"edit\",\"history\",\"view\"]', 1, '2025-05-13 23:10:14', '2025-05-13 23:10:14', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4cAxSTBvmgLl54IG4rS0tXIjZ2K6xCUpakJh80o1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoicmY5OXhZWncyMk9wc3lER2RqeGt0d1FlcXYxSGVtbU56dnF6TWs3aCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90aWNrZXRzLzE0NC9yZXBseSI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkUnBCUEhHMHpTOUhwdm9WTS5kdUduLk83MXlUd0d2MWRQRlgyclZJa2lHMkd5dWF1ZTZyMnEiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1748451192),
('8gma6v2UZ6CUrEmwTnp8S2eJ89hNBfRtRm6s0ZZD', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiSXVxa2x6OUdmb2pRY1BwZmtSdTNpMnVtbmI1ZWJBMktnMTBBV3p3SiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vdGlja2V0cy8xNDQvcmVwbHkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkdWVDSG44Q1AzOXRudi8vSU1kakVDdWVnT2pDOE14VjNjT092c0ZEZ0JvdFdBMy45eUptL20iO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1748451054);

-- --------------------------------------------------------

--
-- Table structure for table `shift_types`
--

CREATE TABLE `shift_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shift_types`
--

INSERT INTO `shift_types` (`id`, `name`, `from_time`, `to_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Evening Shift', '14:00:00', '22:00:00', 1, '2025-05-08 19:19:31', '2025-05-08 19:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `sla_configurations`
--

CREATE TABLE `sla_configurations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `response_time` varchar(256) NOT NULL,
  `resolution_time` varchar(256) DEFAULT NULL,
  `escalated_to_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sla_configurations`
--

INSERT INTO `sla_configurations` (`id`, `name`, `description`, `department_id`, `response_time`, `resolution_time`, `escalated_to_user_id`, `created_at`, `updated_at`, `is_default`) VALUES
(5, 'High\n', 'Local Power Outage (Single Connection)\n', 5, '00:10:00', '4:00:00', 3, '2025-05-07 01:08:39', '2025-05-21 00:03:00', 1),
(6, 'Medium\n', 'Voltage Fluctuation\n', 5, '00:10:00', '24:00:00', 3, '2025-05-07 01:09:47', '2025-05-21 00:06:12', 0),
(7, 'Low\n', 'New Connection Request\n', 5, '00:10:00', '72:00:00', 3, '2025-05-07 01:13:34', '2025-05-21 00:05:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `status_workflows`
--

CREATE TABLE `status_workflows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_status_id` bigint(20) UNSIGNED NOT NULL,
  `to_status_id` bigint(20) UNSIGNED NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_workflows`
--

INSERT INTO `status_workflows` (`id`, `from_status_id`, `to_status_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 1, '2025-05-23 17:43:20', '2025-05-23 17:43:46'),
(2, 3, 4, 0, '2025-05-23 17:44:02', '2025-05-23 17:44:02'),
(3, 4, 5, 0, '2025-05-23 17:44:06', '2025-05-23 17:44:06'),
(4, 6, 7, 0, '2025-05-23 17:44:12', '2025-05-23 17:44:12'),
(5, 7, 8, 0, '2025-05-23 17:44:19', '2025-05-23 17:44:19');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_attachments`
--

CREATE TABLE `task_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `task_id` bigint(20) UNSIGNED NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_statuses`
--

CREATE TABLE `task_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `task_statuses`
--

INSERT INTO `task_statuses` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Active', 1, '2025-05-09 22:04:11', '2025-05-09 22:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `ticket_status_id` bigint(20) UNSIGNED NOT NULL,
  `created_by_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_to_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_source_id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_ref_no` varchar(255) DEFAULT NULL,
  `purpose_type_id` int(11) NOT NULL,
  `SLA` bigint(20) UNSIGNED NOT NULL,
  `notification_type_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`notification_type_id`)),
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `reminder_flag` tinyint(1) NOT NULL DEFAULT 0,
  `reminder_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `internal_note` text DEFAULT NULL,
  `external_note` text DEFAULT NULL,
  `response_time` time DEFAULT NULL,
  `resolution_time` time DEFAULT NULL,
  `response_time_id` bigint(20) UNSIGNED DEFAULT NULL,
  `resolution_time_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `requested_email` varchar(255) DEFAULT NULL,
  `to_recipients` text DEFAULT NULL,
  `cc_recipients` text DEFAULT NULL,
  `activity_log` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `linked_ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `linked_message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `Schedule_On` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_id`, `title`, `ticket_status_id`, `created_by_id`, `assigned_to_id`, `ticket_source_id`, `contact_id`, `contact_ref_no`, `purpose_type_id`, `SLA`, `notification_type_id`, `company_id`, `reminder_flag`, `reminder_datetime`, `created_at`, `updated_at`, `internal_note`, `external_note`, `response_time`, `resolution_time`, `response_time_id`, `resolution_time_id`, `priority_id`, `message`, `requested_email`, `to_recipients`, `cc_recipients`, `activity_log`, `is_read`, `linked_ticket_id`, `linked_message_id`, `Schedule_On`) VALUES
(136, 'TKT-6832149B4817C', 'Website down', 2, 3, 5, 3, 1, NULL, 1, 5, '\"[\\\"2\\\"]\"', 1, 0, '2025-05-24 11:46:42', '2025-05-25 01:48:59', '2025-05-28 07:31:34', 'Initial ticket created', 'Initial ticket created', '00:10:00', '04:00:00', 5, 5, 1, '<p>Website is not loading for users ashflk\njsadhfkjhsaflklkasflkasjflkjsadflk askljdflkjasflkjsd kasjdfkljaslkfdj kasjdnflk;jasdflk;jas lk;ajsdflkjasdlkfj \n  asdlkfjlkasjdflkasdklflsak  lkasdjfdlkjasdflkjas klajsdflkjasdflkj lkajsdflkjalskdfklf lkjasdflkjaslkdfj</p>', 'user1@example.com', '[\"user25@example.com\"]', '[\"user1@example.com\"]', NULL, 1, NULL, NULL, NULL),
(137, 'TKT-683215461E4BD', 'Password reset issue', 2, 3, 7, 3, 2, NULL, 1, 6, '\"[\\\"2\\\"]\"', 1, 0, '2025-05-24 11:51:26', '2025-05-25 01:51:50', '2025-05-27 12:11:31', 'Password reset requested', 'Password reset email sent', '00:10:00', '24:00:00', 6, 6, 2, '<p>&nbsp;Unable to reset password for user account&nbsp;</p>', 'user2@example.com', '[\"user10@example.com\"]', '[\"support@example.com\"]', NULL, 0, NULL, NULL, NULL),
(138, 'TKT-683215C34A3B0', 'Email not syncing', 4, 4, 13, 3, 1, NULL, 4, 7, '\"[\\\"2\\\"]\"', 1, 0, '2025-05-24 11:53:23', '2025-05-25 01:53:55', '2025-05-27 12:09:42', 'Check mail server', 'User reported mail issues', '00:10:00', '72:00:00', 6, 7, 3, '<p>&nbsp;Email syncing delayed or stopped&nbsp;</p>', 'user3@example.com', '[\"user15@example.com\"]', '[\"it@example.com\"]', NULL, 0, NULL, NULL, NULL),
(139, 'TKT-6832164A45E81', 'Network slow', 5, 4, 14, 5, 3, NULL, 3, 5, '\"[\\\"2\\\"]\"', 2, 0, '2025-05-24 11:55:33', '2025-05-25 01:56:10', '2025-05-28 04:53:09', 'Check router and ISP', 'User complaints received', '00:10:00', '04:00:00', 6, 5, 4, '<p>&nbsp;Network speed very slow in office&nbsp;</p>', 'user4@example.com', '[\"admin@example.com\"]', '[\"network@example.com\"]', NULL, 1, NULL, NULL, NULL),
(140, 'TKT-683216B34C576', 'Printer not working', 6, 3, 15, 6, 3, NULL, 3, 5, '\"[\\\"3\\\"]\"', 2, 0, '2025-05-26 11:57:27', '2025-05-25 01:57:55', '2025-05-28 04:52:14', 'Printer hardware check', 'Printer service scheduled', '00:10:00', '04:00:00', 6, 5, 5, '<p>&nbsp;Unable to print any documents&nbsp;</p>', 'user5@example.com', '[\"user18@example.com\"]', '[\"support@example.com\"]', NULL, 1, NULL, NULL, NULL),
(141, 'TKT-6832171D5210E', 'VPN connection failed', 4, 4, 5, 5, 1, NULL, 5, 6, '\"[\\\"5\\\"]\"', 2, 0, '2025-05-28 11:59:16', '2025-05-25 01:59:41', '2025-05-27 12:21:45', 'Escalated to network team', 'User advised workaround', '00:10:00', '24:00:00', 6, 6, 3, '<p>&nbsp;VPN client unable to establish connection&nbsp;</p>', 'user6@example.com', '[\"user20@example.com\"]', '[\"it@example.com\"]', NULL, 1, NULL, NULL, NULL),
(142, 'TKT-683217CD7F258', 'Data backup required', 7, 4, 5, 4, 2, NULL, 1, 5, '\"[\\\"3\\\"]\"', 2, 0, '2025-05-13 12:02:12', '2025-05-25 02:02:37', '2025-05-28 07:25:40', 'Backup in progress', 'User notified on completion', '00:10:00', '04:00:00', 5, 5, 5, '<p>&nbsp;Backup of database needed urgently&nbsp;</p>', 'user8@example.com', '[\"admin@example.com\"]', '[\"backup@example.com\"]', NULL, 1, NULL, NULL, NULL),
(143, 'TKT-6832185745A80', 'Software installation', 4, 4, 13, 6, 1, NULL, 3, 5, '\"[\\\"3\\\",\\\"5\\\"]\"', 2, 0, '2025-05-16 12:03:15', '2025-05-25 02:04:55', '2025-05-28 10:10:55', ' License verified', 'Installation scheduled', '00:10:00', '72:00:00', 6, 7, 3, '<p>&nbsp;Install requested software on PC&nbsp;</p>', 'user8@example.com', '[\"user22@example.com\"]', '[\"support@example.com\"]', NULL, 1, NULL, NULL, NULL),
(144, 'TKT-683218C239DD4', 'Account locked', 3, 3, 5, 3, 1, NULL, 9, 5, '\"[\\\"5\\\",\\\"3\\\"]\"', 1, 0, '2025-05-21 12:06:35', '2025-05-25 02:06:42', '2025-05-28 10:11:39', ' Security notified', 'User advised', '00:10:00', '04:00:00', 6, 5, 4, '<p>&nbsp;Unlock user account urgently&nbsp;</p>', 'user9@example.com', '[\"admin@example.com\"]', '[\"security@example.com\"]', NULL, 1, NULL, NULL, NULL),
(145, 'TKT-68321933ECA23', 'Projector issue new', 5, 4, 14, 5, 1, NULL, 1, 6, '\"[\\\"2\\\"]\"', 1, 0, '2025-05-22 12:08:20', '2025-05-25 02:08:35', '2025-05-28 07:40:45', 'Reported to facilities', 'Technician assigned', '00:10:00', '24:00:00', 5, 6, 4, '<p>&nbsp;Projector fails to power on&nbsp;</p>', 'user10@example.com', '[\"admin@example.com\"]', '[\"facilities@example.com\"]', NULL, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_attachments`
--

CREATE TABLE `ticket_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `uploaded_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_journeys`
--

CREATE TABLE `ticket_journeys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `from_agent` bigint(20) UNSIGNED DEFAULT NULL,
  `to_agent` bigint(20) UNSIGNED DEFAULT NULL,
  `from_status` varchar(50) DEFAULT NULL,
  `to_status` varchar(50) DEFAULT NULL,
  `actioned_by` bigint(20) UNSIGNED NOT NULL,
  `logged_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_time_diff` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_journeys`
--

INSERT INTO `ticket_journeys` (`id`, `ticket_id`, `from_agent`, `to_agent`, `from_status`, `to_status`, `actioned_by`, `logged_time`, `total_time_diff`, `created_at`, `updated_at`) VALUES
(10, 136, NULL, 5, NULL, '2', 1, '2025-05-25 01:48:59', 2147483647, '2025-05-25 01:48:59', '2025-05-25 01:48:59'),
(11, 137, NULL, 7, NULL, '2', 1, '2025-05-25 01:51:50', 2147483647, '2025-05-25 01:51:50', '2025-05-25 01:51:50'),
(12, 138, NULL, 13, NULL, '4', 1, '2025-05-25 01:53:55', 2147483647, '2025-05-25 01:53:55', '2025-05-25 01:53:55'),
(13, 139, NULL, 14, NULL, '5', 1, '2025-05-25 01:56:10', 2147483647, '2025-05-25 01:56:10', '2025-05-25 01:56:10'),
(14, 140, NULL, 15, NULL, '6', 1, '2025-05-25 01:57:55', 2147483647, '2025-05-25 01:57:55', '2025-05-25 01:57:55'),
(15, 141, NULL, 5, NULL, '4', 1, '2025-05-25 01:59:41', 2147483647, '2025-05-25 01:59:41', '2025-05-25 01:59:41'),
(16, 142, NULL, 5, NULL, '7', 1, '2025-05-25 02:02:37', 2147483647, '2025-05-25 02:02:37', '2025-05-25 02:02:37'),
(17, 143, NULL, 13, NULL, '4', 1, '2025-05-25 02:04:55', 2147483647, '2025-05-25 02:04:55', '2025-05-25 02:04:55'),
(18, 144, NULL, 5, NULL, '3', 1, '2025-05-25 02:06:42', 2147483647, '2025-05-25 02:06:42', '2025-05-25 02:06:42'),
(19, 145, NULL, 7, NULL, '2', 1, '2025-05-25 02:08:35', 2147483647, '2025-05-25 02:08:35', '2025-05-25 02:08:35'),
(20, 145, 7, 7, '2', '6', 3, '2025-05-27 14:17:45', 216550, '2025-05-27 14:17:45', '2025-05-27 14:17:45'),
(21, 145, 7, 7, '6', '7', 3, '2025-05-27 14:17:56', 11, '2025-05-27 14:17:56', '2025-05-27 14:17:56'),
(22, 145, 7, 7, '7', '9', 3, '2025-05-27 14:18:20', 24, '2025-05-27 14:18:20', '2025-05-27 14:18:20'),
(23, 145, 7, 20, '9', '9', 3, '2025-05-27 14:20:17', 117, '2025-05-27 14:20:17', '2025-05-27 14:20:17'),
(24, 145, 20, 20, '9', '10', 3, '2025-05-27 14:21:13', 56, '2025-05-27 14:21:13', '2025-05-27 14:21:13'),
(25, 145, 20, 20, '10', '9', 3, '2025-05-27 14:21:26', 13, '2025-05-27 14:21:26', '2025-05-27 14:21:26'),
(26, 145, 20, 14, '9', '9', 3, '2025-05-27 14:21:49', 23, '2025-05-27 14:21:49', '2025-05-27 14:21:49'),
(27, 145, 14, 14, '9', '5', 1, '2025-05-28 04:54:26', 52357, '2025-05-28 04:54:26', '2025-05-28 04:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_reply_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `replied_by_user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `parent_message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reply_type` bigint(20) UNSIGNED DEFAULT NULL,
  `attachment_path` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachment_path`)),
  `internal_notes` text DEFAULT NULL,
  `external_notes` text DEFAULT NULL,
  `is_desc_send_to_contact` tinyint(1) NOT NULL DEFAULT 0,
  `status_after_reply` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_id` varchar(255) DEFAULT NULL,
  `contact_ref_no` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `to_recipients` text DEFAULT NULL,
  `cc_recipients` text DEFAULT NULL,
  `bcc` text DEFAULT NULL,
  `is_reply_from_contact` tinyint(1) NOT NULL DEFAULT 0,
  `is_contact_notify` tinyint(1) NOT NULL DEFAULT 1,
  `activity_log` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `Schedule_On` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_replies`
--

INSERT INTO `ticket_replies` (`id`, `parent_reply_id`, `ticket_id`, `replied_by_user_id`, `subject`, `message`, `parent_message_id`, `message_id`, `priority_type_id`, `reply_type`, `attachment_path`, `internal_notes`, `external_notes`, `is_desc_send_to_contact`, `status_after_reply`, `contact_id`, `contact_ref_no`, `contact_email`, `to_recipients`, `cc_recipients`, `bcc`, `is_reply_from_contact`, `is_contact_notify`, `activity_log`, `created_at`, `updated_at`, `is_read`, `Schedule_On`) VALUES
(2, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>sgsdggf</p>', NULL, NULL, NULL, NULL, NULL, 'sdfgdgs', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 06:10:28', '2025-05-26 06:10:28', 0, NULL),
(3, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>fdhd</p>', NULL, NULL, NULL, NULL, NULL, 'hdfhh', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 06:30:33', '2025-05-26 06:30:33', 0, NULL),
(4, NULL, 145, 5, 'Re: Meeting room projector issue', '<p>fssdfsf</p>', NULL, NULL, NULL, NULL, NULL, 'fsfss', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 06:53:17', '2025-05-26 06:53:17', 0, NULL),
(5, NULL, 145, 5, 'Re: Meeting room projector issue', '<p>csdffsf</p>', NULL, NULL, NULL, NULL, NULL, 'sffsdfsf', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 06:56:10', '2025-05-26 06:56:10', 0, NULL),
(6, NULL, 145, 5, 'Re: Meeting room projector issue', '<p>fgdg</p>', NULL, NULL, NULL, NULL, NULL, 'dggdg', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 07:05:16', '2025-05-26 07:05:16', 0, NULL),
(7, NULL, 142, 5, 'Re: Data backup required', '<p>fsdfssf</p>', NULL, NULL, NULL, NULL, NULL, 'fssdsdf', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 07:09:49', '2025-05-26 07:09:49', 0, NULL),
(8, NULL, 142, 5, 'Re:dgsdf ', '<p>fsdfssfsg</p>', NULL, NULL, NULL, NULL, NULL, 'dfsgdgdg', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 07:10:16', '2025-05-26 07:10:16', 0, NULL),
(9, NULL, 143, 1, 'Re: Software installation', '<p>,skda;kad</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 10:13:31', '2025-05-26 10:13:31', 0, NULL),
(14, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>kllklksnf</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 11:32:58', '2025-05-26 11:32:58', 0, NULL),
(15, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>;ksdfsffslksf</p>', NULL, NULL, NULL, NULL, NULL, 'lkslfklsf', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 11:35:20', '2025-05-26 11:35:20', 0, NULL),
(16, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>l;dl;mflkasf</p>', NULL, NULL, NULL, NULL, NULL, 'klmskldfksa', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 11:42:03', '2025-05-26 11:42:03', 0, NULL),
(17, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>;lajksldkla</p>', NULL, NULL, NULL, NULL, NULL, 'lkaskdna', NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', NULL, NULL, 0, 1, NULL, '2025-05-26 11:43:18', '2025-05-26 11:43:18', 0, NULL),
(18, NULL, 145, 1, 'Re: ', '<p>dsadad</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"m@gmail.com\"', '\"m@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 11:45:09', '2025-05-26 11:45:09', 0, NULL),
(19, NULL, 143, 1, 'Re: Software installation', '<p>,mlwfmksxz</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 11:51:13', '2025-05-26 11:51:13', 0, NULL),
(20, NULL, 143, 1, 'Re: kmsklfs', '<p>daadadda</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"m2@gmail.com\"', '\"m2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 11:51:47', '2025-05-26 11:51:47', 0, NULL),
(21, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>sadkjahjkdhad</p>', NULL, NULL, NULL, NULL, '\"ticket-attachments\\/Screenshot 2025-03-22 031319.png\"', NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', NULL, NULL, 0, 1, NULL, '2025-05-26 12:05:03', '2025-05-26 12:05:03', 0, NULL),
(22, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>;l,sl;ladm;adm</p>', NULL, NULL, NULL, NULL, '\"[\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 211753.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 212018.png\\\"]\"', NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', '\"manager2@gmail.com\"', NULL, 0, 1, NULL, '2025-05-26 12:12:21', '2025-05-26 12:12:21', 0, NULL),
(23, NULL, 145, 1, 'Re: Meeting room projector issue', '<p>asdadads</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '\"manager2@gmail.com\"', NULL, NULL, 0, 1, NULL, '2025-05-26 12:29:09', '2025-05-26 12:29:09', 0, NULL),
(24, NULL, 145, 1, 'Meeting room projector issue - Re: Meeting room projector issue', '<p>hmgfjfgj</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-26 13:23:45', '2025-05-26 13:23:45', 0, NULL),
(25, NULL, 145, 1, 'TKT-68321933ECA23 - Re: Meeting room projector issue', '<p>dsfasfsaf</p>', NULL, NULL, NULL, NULL, NULL, 'sadfsfd', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-26 13:26:02', '2025-05-26 13:26:02', 0, NULL),
(26, NULL, 145, 1, 'TKT-68321933ECA23 - Re: Meeting room projector issue', '<p>gfsdgs</p>', NULL, NULL, NULL, NULL, NULL, 'dfgsdg', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-26 13:29:44', '2025-05-26 13:29:44', 0, NULL),
(27, NULL, 145, 1, 'TKT-68321933ECA23 - Re: Meeting room projector issue', '<p><strong>Paragraph 1:</strong></p><p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.</p><p><strong>Paragraph 2:</strong></p><p> Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor.</p>', NULL, NULL, NULL, NULL, '\"[\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 031319.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 211753.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 212018.png\\\"]\"', 'Paragraph 2:', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-26 13:46:22', '2025-05-26 13:46:22', 0, NULL),
(28, NULL, 145, 1, 'TKT-68321933ECA23 - Re: Meeting room projector issue', '<p>kshdkjfhkjs</p>', NULL, NULL, NULL, NULL, '\"[\\\"ticket-attachments\\\\\\/Screenshot 2025-04-04 023259.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-04-04 023331.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-04-04 023357.png\\\"]\"', 'sajfkksjfkjfsh', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-27 05:16:35', '2025-05-27 05:16:35', 0, NULL),
(29, NULL, 145, 1, 'TKT-68321933ECA23 - Re: Meeting room projector issue', '<p>,s,a,d</p>', NULL, NULL, NULL, NULL, '\"[\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 031319.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 211753.png\\\",\\\"ticket-attachments\\\\\\/Screenshot 2025-03-22 212018.png\\\"]\"', 'klmsad;ma', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-27 08:06:44', '2025-05-27 08:06:44', 0, NULL),
(30, NULL, 142, 5, 'TKT-683217CD7F258 - Re: Data backup required', '<p>rggsd</p>', NULL, NULL, NULL, NULL, NULL, 'dsgsdsg', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-28 07:25:40', '2025-05-28 07:25:40', 0, NULL),
(31, NULL, 145, 1, 'TKT-68321933ECA23 - Re: Meeting room projector issue', '<p>daadsad</p>', NULL, NULL, NULL, NULL, NULL, 'asdad', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-28 07:40:45', '2025-05-28 07:40:45', 0, NULL),
(32, NULL, 143, 3, 'TKT-6832185745A80 - Re: Software installation', '<p>Hey there resolve my this issue its desturbing me from a very long time </p><p><br></p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-28 10:10:55', '2025-05-28 10:10:55', 0, NULL),
(33, NULL, 144, 3, 'TKT-683218C239DD4 - Re: Account locked', '<p>Hey there resolve my this issue its desturbing me from a very long time </p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-05-28 10:11:39', '2025-05-28 10:11:39', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_sources`
--

CREATE TABLE `ticket_sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_sources`
--

INSERT INTO `ticket_sources` (`id`, `name`, `status`, `created_at`, `updated_at`, `is_default`) VALUES
(3, 'Chat', 1, '2025-05-09 20:18:39', '2025-05-09 20:18:39', 0),
(4, 'WhatsApp', 1, '2025-05-09 22:51:10', '2025-05-09 22:51:10', 0),
(5, 'Email', 1, '2025-05-09 22:51:30', '2025-05-09 22:51:30', 1),
(6, 'Google', 1, '2025-05-09 22:51:43', '2025-05-16 23:26:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_statuses`
--

CREATE TABLE `ticket_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_statuses`
--

INSERT INTO `ticket_statuses` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `is_default`) VALUES
(2, 'New', 'Ticket is created but not yet acknowledged or assigned\n', 1, '2025-05-09 20:00:07', '2025-05-09 22:59:17', 0),
(3, 'Assigned', 'Ticket has been assigned and is being worked on\n', 1, '2025-05-09 20:00:22', '2025-05-09 22:59:32', 1),
(4, 'In Progress\n', 'Active troubleshooting or resolution is ongoing\n', 1, '2025-05-09 22:59:46', '2025-05-09 22:59:46', 0),
(5, 'On Hold\n', 'Awaiting confirmation, dependency, or approval\n', 1, '2025-05-09 23:00:00', '2025-05-09 23:00:00', 0),
(6, 'Escalated\n', 'Ticket has been raised to a higher support level due to urgency or SLA risk\n', 1, '2025-05-09 23:00:05', '2025-05-09 23:00:05', 0),
(7, 'Resolved\n', 'Solution provided, pending user confirmation\n', 1, '2025-05-09 23:00:14', '2025-05-16 23:25:54', 0),
(8, 'Closed', 'Issue is resolved and confirmed, ticket is finalized\n', 1, '2025-05-20 21:43:39', '2025-05-20 21:43:39', 0),
(9, 'Reopened', 'Issue reappeared or solution was not satisfactory\n', 1, '2025-05-20 21:43:49', '2025-05-20 21:43:49', 0),
(10, 'Cancelled', 'Ticket was invalid or withdrawn\n', 1, '2025-05-20 21:43:55', '2025-05-20 21:43:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ts_activity_id` bigint(20) UNSIGNED NOT NULL,
  `activity_description` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `shift_type_id` bigint(20) UNSIGNED NOT NULL,
  `ts_status_id` bigint(20) UNSIGNED NOT NULL,
  `approved_by_id` bigint(20) UNSIGNED NOT NULL,
  `approved_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `from_time` time DEFAULT NULL,
  `to_time` time DEFAULT NULL,
  `total_time_consumed` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheets`
--

INSERT INTO `timesheets` (`id`, `ts_activity_id`, `activity_description`, `user_id`, `project_id`, `shift_type_id`, `ts_status_id`, `approved_by_id`, `approved_date`, `created_at`, `updated_at`, `from_time`, `to_time`, `total_time_consumed`) VALUES
(1, 1, 'Making Crud ', 4, 1, 1, 1, 4, '2025-05-09', '2025-05-08 20:59:31', '2025-05-08 23:25:20', '09:53:43', '11:57:45', '02:04');

-- --------------------------------------------------------

--
-- Table structure for table `timesheet_activities`
--

CREATE TABLE `timesheet_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheet_activities`
--

INSERT INTO `timesheet_activities` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'User Login', 1, '2025-05-07 19:12:13', '2025-05-07 19:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `timesheet_statuses`
--

CREATE TABLE `timesheet_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timesheet_statuses`
--

INSERT INTO `timesheet_statuses` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Initiated', 1, '2025-05-07 19:17:21', '2025-05-08 21:54:39'),
(2, 'Pending for Approval', 1, '2025-05-08 21:55:00', '2025-05-08 21:55:00'),
(3, 'Approved', 1, '2025-05-08 21:55:08', '2025-05-08 21:55:08'),
(4, 'Rejected', 1, '2025-05-08 21:55:14', '2025-05-08 21:55:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `max_ticket_threshold` int(11) NOT NULL DEFAULT 0,
  `emp_ref_no` varchar(255) DEFAULT NULL,
  `company_id` bigint(10) DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coa_no` varchar(255) DEFAULT NULL,
  `emp_no` varchar(256) DEFAULT NULL,
  `user_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_first_time` tinyint(1) DEFAULT 1,
  `assigned_to_others` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `picture`, `status_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `department_id`, `manager_id`, `max_ticket_threshold`, `emp_ref_no`, `company_id`, `designation_id`, `project_id`, `shift_id`, `coa_no`, `emp_no`, `user_type_id`, `is_first_time`, `assigned_to_others`) VALUES
(1, 'admin', 'admin@gmail.com', 'images/profile-pic.jpg', 2, NULL, '$2y$12$RpBPHG0zS9HpvoVM.duGn.O71yTwGv1dPFX2rVIkiG2Gyuaue6r2q', '1ytJDxmi0CIZq0abRT46GhhLmZsZqGcayMrMys8iEu5qjBJTnlZ7D8tTRCDH', '2025-05-06 00:03:17', '2025-05-21 06:58:06', 1, 5, NULL, 543555, '2', 2, 5, NULL, NULL, NULL, '200-2', 1, 1, 0),
(3, 'Manager1', 'manager1@gmail.com', 'images/profile-pic-1.jpg', 2, NULL, '$2y$12$ueCHn8CP39tnv//IMdjECuegOjC8MxV3cOOvsFDgBotWA3.9yJm/m', 'LY0F298lLKfa5Q7wBrq3sUXqeSnl1lWik9Dmlf4u8BnKRU9xvFS2Sc6sliGb', '2025-05-06 23:39:59', '2025-05-24 23:49:30', 2, 5, 1, 5464646, '4', 2, 4, NULL, NULL, NULL, '200-4', 1, 1, 1),
(4, 'Manager2', 'manager2@gmail.com', 'images/profile-pic-2.png', 2, NULL, '$2y$12$gieBgvTdSlwoLcbFvmwrBeznsjnidVgbLuXNhaUhtKmhB6OasKWKS', NULL, '2025-05-07 18:31:35', '2025-05-24 23:50:51', 2, 6, 1, 43543, '6', 1, 2, NULL, NULL, NULL, '100-6', 1, 1, 1),
(5, 'Agent1', 'agent1@gmail.com', 'images/profile-pic-2.png', 2, NULL, '$2y$12$DkkCr814D6iujDdgcm6tDuzigh3En80sH8AcXqMgbw2yN9jqNgtEi', NULL, '2025-05-07 18:38:35', '2025-05-24 23:53:22', 3, 5, 3, 436543, '1000', 1, 5, NULL, NULL, NULL, '100-1000', 1, 1, 0),
(7, 'Agent2', 'agent2@gmail.com', 'images/profile-pic.jpg', 2, NULL, '$2y$12$1muAqLC8eU.vK1VCFrtWr.Y/wwFwIiAsC0gABOmt/WvlWmBffg.BO$2y$12$DkkCr814D6iujDdgcm6tDuzigh3En80sH8AcXqMgbw2yN9jqNgtEi', NULL, '2025-05-08 23:34:10', '2025-05-10 20:33:35', 3, 5, 3, 3424, '100', 1, 2, NULL, NULL, NULL, '100-100', 1, 1, 0),
(13, 'Agent3', 'agent3@gmail.com', 'images/profile-pic-5.jpg', 2, NULL, '$2y$12$KlsZOSW7wLEY0UHAvlwfsuqCQBwfmRIe43Hrd2smez2goKkzDBlTG', NULL, '2025-05-10 17:17:50', '2025-05-10 21:53:43', 3, 5, 3, 54646, '123411', 2, 2, NULL, NULL, NULL, '200-123411', 1, 1, 0),
(14, 'Agent4', 'agent4@gmail.com', 'images/profile-pic-5.jpg', 2, NULL, '$2y$12$pqrJTwKm4YFK8sWPD/Ob2e7IZKNOhVrrhxTRnqbsqXmTvGzltC6pq', NULL, '2025-05-25 00:02:27', '2025-05-25 00:02:27', 3, 6, 4, 65436346, '1020', 2, 5, NULL, NULL, NULL, '200-1020', 1, 1, 0),
(15, 'Agent5', 'agent5@gmail.com', 'images/profile-pic.jpg', 2, NULL, '$2y$12$s9IHngVgKSIfHdyxUbZMGebD9iVQn4yyT73dx9CoC.S1iENP98V9i', NULL, '2025-05-25 00:05:09', '2025-05-25 00:05:09', 3, 7, 4, 2424234, '10320', 2, 6, NULL, NULL, NULL, '200-10320', 1, 1, 0),
(16, 'Agent6', 'agent6@gmail.com', 'images/profile-pic.jpg', 2, NULL, '$2y$12$mQjr8VAofowTEOx/9KS3z.PUaKaNr1kqsYdrzfFJgaFKi4BJ3z4fu', NULL, '2025-05-25 00:06:15', '2025-05-25 00:06:15', 3, 9, 4, 2342, '11211', 2, 6, NULL, NULL, NULL, '200-11211', 1, 1, 0),
(20, 'Agent7', 'agent7@gmail.com', 'images/profile-pic-5.jpg', 2, NULL, '$2y$12$x76wTYHyC8lXYTx8RxotbuFb6m9bH979z6iMi8/qD5VhErbFsqO2a', NULL, '2025-05-25 00:19:35', '2025-05-25 00:19:35', 3, 10, 3, 102131, '103320', 1, 5, NULL, NULL, NULL, '100-103320', 1, 1, 0),
(21, 'Agent8', 'agent8@gmail.com', 'images/profile-pic-2.png', 2, NULL, '$2y$12$CbzfGGoOFuhk1ioboDM/k.cYOJY7KZBVI/Bzi.ailpA1DA.WEZE2e', NULL, '2025-05-25 00:22:11', '2025-05-25 00:22:11', 3, 11, 3, 2341231, '13210', 1, 6, NULL, NULL, NULL, '100-13210', 1, 1, 0),
(22, 'Agent9', 'agent9@gmail.com', 'images/profile-pic.jpg', 2, NULL, '$2y$12$O0YT9BiPNp4zjbE1FV2sFepW8u984NYdiSMud.7g8tTniuac18lH2', NULL, '2025-05-25 00:23:27', '2025-05-25 00:23:27', 3, 10, 3, 321311, '32121', 2, 5, NULL, NULL, NULL, '200-32121', 1, 1, 0),
(23, 'Agent10', 'agent10@gmail.com', 'images/profile-pic-5.jpg', 2, NULL, '$2y$12$cogTLzVBjW.v6esaEFWDu.WxcbStN5QiUXDxp3zYbi4ePozDPUCJ6', NULL, '2025-05-25 00:24:37', '2025-05-25 00:24:37', 3, 5, 4, 4324324, '21321', 1, 5, NULL, NULL, NULL, '100-21321', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_statuses`
--

CREATE TABLE `user_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_statuses`
--

INSERT INTO `user_statuses` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Active', 1, '2025-05-06 23:37:32', '2025-05-06 23:37:32'),
(3, 'Inactive', 1, '2025-05-07 18:45:20', '2025-05-07 18:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Employee', 1, '2025-05-10 20:19:53', '2025-05-10 20:19:53'),
(2, 'Guest User', 1, '2025-05-10 20:19:59', '2025-05-10 20:19:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `agent_purposes`
--
ALTER TABLE `agent_purposes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_purposes_purpose_id_foreign` (`purpose_id`),
  ADD KEY `agent_purposes_user_id_foreign` (`user_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `comments_task_id_foreign` (`task_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_parent_comp_id_foreign` (`parent_comp_id`),
  ADD KEY `company_type_foreign` (`company_type_id`);

--
-- Indexes for table `company_types`
--
ALTER TABLE `company_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contacts_email_unique` (`email`),
  ADD KEY `contacts_contact_type_id_foreign` (`contact_type_id`),
  ADD KEY `contacts_designation_id_foreign` (`designation_id`);

--
-- Indexes for table `contacts_phone_numbers`
--
ALTER TABLE `contacts_phone_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_phone_numbers_contact_id_foreign` (`contact_id`);

--
-- Indexes for table `contacts_preferences`
--
ALTER TABLE `contacts_preferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_preferences_contact_id_foreign` (`contact_id`);

--
-- Indexes for table `contacts_social_links`
--
ALTER TABLE `contacts_social_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_social_links_contact_id_foreign` (`contact_id`);

--
-- Indexes for table `contact_companies`
--
ALTER TABLE `contact_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_companies_parent_comp_id_foreign` (`parent_comp_id`),
  ADD KEY `contact_company_type_foreign` (`company_type_id`);

--
-- Indexes for table `contact_segmentations`
--
ALTER TABLE `contact_segmentations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_types`
--
ALTER TABLE `contact_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `field_variables`
--
ALTER TABLE `field_variables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `field_variables_name_unique` (`name`);

--
-- Indexes for table `meneuses`
--
ALTER TABLE `meneuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `encryption_salt` (`encryption_salt`),
  ADD KEY `meneuses_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_project_type_id_foreign` (`project_type_id`),
  ADD KEY `projects_company_id_foreign` (`company_id`),
  ADD KEY `projects_project_owner_id_foreign` (`project_owner_id`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purposes`
--
ALTER TABLE `purposes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purposes_parent_id_foreign` (`parent_id`),
  ADD KEY `purposes_sla_id_foreign` (`sla_id`);

--
-- Indexes for table `response_templates`
--
ALTER TABLE `response_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_menus`
--
ALTER TABLE `roles_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_menus_menu_id_foreign` (`menu_id`(768)),
  ADD KEY `fk_parent_role_id` (`role_id`);

--
-- Indexes for table `role_menu_permissions`
--
ALTER TABLE `role_menu_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_id` (`role_id`),
  ADD KEY `fk_role_menu_id` (`role_menu_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shift_types`
--
ALTER TABLE `shift_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sla_configurations`
--
ALTER TABLE `sla_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sla_configurations_department_id_foreign` (`department_id`),
  ADD KEY `sla_configurations_escalated_to_user_id_foreign` (`escalated_to_user_id`);

--
-- Indexes for table `status_workflows`
--
ALTER TABLE `status_workflows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_workflows_from_status_id_foreign` (`from_status_id`),
  ADD KEY `status_workflows_to_status_id_foreign` (`to_status_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_project_id_foreign` (`project_id`),
  ADD KEY `tasks_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tasks_ticket_id_foreign` (`ticket_id`);

--
-- Indexes for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_attachments_task_id_foreign` (`task_id`),
  ADD KEY `task_attachments_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `task_statuses`
--
ALTER TABLE `task_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_id` (`ticket_id`),
  ADD KEY `tickets_ticket_status_id_foreign` (`ticket_status_id`),
  ADD KEY `tickets_created_by_id_foreign` (`created_by_id`),
  ADD KEY `tickets_ticket_source_id_foreign` (`ticket_source_id`),
  ADD KEY `tickets_purpose_type_id_foreign` (`purpose_type_id`),
  ADD KEY `tickets_sla_foreign` (`SLA`),
  ADD KEY `tickets_notification_type_id_foreign` (`notification_type_id`(768)),
  ADD KEY `tickets_company_id_foreign` (`company_id`),
  ADD KEY `tickets_resolution_time_id_foreign` (`resolution_time_id`),
  ADD KEY `tickets_response_time_id_foreign` (`response_time_id`),
  ADD KEY `tickets_assigned_to_id_foreign` (`assigned_to_id`),
  ADD KEY `fk_priority_id` (`priority_id`);

--
-- Indexes for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_attachments_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_attachments_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `ticket_journeys`
--
ALTER TABLE `ticket_journeys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_journeys_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_journeys_from_agent_foreign` (`from_agent`),
  ADD KEY `ticket_journeys_to_agent_foreign` (`to_agent`),
  ADD KEY `ticket_journeys_actioned_by_foreign` (`actioned_by`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_replies_replied_by_user_id_foreign` (`replied_by_user_id`),
  ADD KEY `ticket_replies_priority_type_id_foreign` (`priority_type_id`),
  ADD KEY `ticket_replies_type_id_foreign` (`reply_type`),
  ADD KEY `ticket_replies_status_type_id_foreign` (`status_after_reply`);

--
-- Indexes for table `ticket_sources`
--
ALTER TABLE `ticket_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timesheets_ts_activity_id_foreign` (`ts_activity_id`),
  ADD KEY `timesheets_user_id_foreign` (`user_id`),
  ADD KEY `timesheets_project_id_foreign` (`project_id`),
  ADD KEY `timesheets_shift_type_id_foreign` (`shift_type_id`),
  ADD KEY `timesheets_ts_status_id_foreign` (`ts_status_id`),
  ADD KEY `timesheets_approved_by_id_foreign` (`approved_by_id`);

--
-- Indexes for table `timesheet_activities`
--
ALTER TABLE `timesheet_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheet_statuses`
--
ALTER TABLE `timesheet_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `emp_ref_no` (`emp_ref_no`),
  ADD KEY `fk_users_designation` (`designation_id`),
  ADD KEY `fk_users_project` (`project_id`),
  ADD KEY `fk_users_shift` (`shift_id`),
  ADD KEY `fk_user_type` (`user_type_id`);

--
-- Indexes for table `user_statuses`
--
ALTER TABLE `user_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agent_purposes`
--
ALTER TABLE `agent_purposes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_types`
--
ALTER TABLE `company_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts_phone_numbers`
--
ALTER TABLE `contacts_phone_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts_preferences`
--
ALTER TABLE `contacts_preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts_social_links`
--
ALTER TABLE `contacts_social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_companies`
--
ALTER TABLE `contact_companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_segmentations`
--
ALTER TABLE `contact_segmentations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_types`
--
ALTER TABLE `contact_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `field_variables`
--
ALTER TABLE `field_variables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meneuses`
--
ALTER TABLE `meneuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purposes`
--
ALTER TABLE `purposes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `response_templates`
--
ALTER TABLE `response_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles_menus`
--
ALTER TABLE `roles_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `role_menu_permissions`
--
ALTER TABLE `role_menu_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shift_types`
--
ALTER TABLE `shift_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sla_configurations`
--
ALTER TABLE `sla_configurations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status_workflows`
--
ALTER TABLE `status_workflows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task_attachments`
--
ALTER TABLE `task_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `task_statuses`
--
ALTER TABLE `task_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_journeys`
--
ALTER TABLE `ticket_journeys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ticket_sources`
--
ALTER TABLE `ticket_sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_statuses`
--
ALTER TABLE `ticket_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timesheet_activities`
--
ALTER TABLE `timesheet_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `timesheet_statuses`
--
ALTER TABLE `timesheet_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_statuses`
--
ALTER TABLE `user_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`);

--
-- Constraints for table `agent_purposes`
--
ALTER TABLE `agent_purposes`
  ADD CONSTRAINT `agent_purposes_purpose_id_foreign` FOREIGN KEY (`purpose_id`) REFERENCES `purposes` (`id`),
  ADD CONSTRAINT `agent_purposes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_parent_comp_id_foreign` FOREIGN KEY (`parent_comp_id`) REFERENCES `companies` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `company_type_foreign` FOREIGN KEY (`company_type_id`) REFERENCES `company_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_contact_type_id_foreign` FOREIGN KEY (`contact_type_id`) REFERENCES `contact_types` (`id`),
  ADD CONSTRAINT `contacts_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`);

--
-- Constraints for table `contacts_phone_numbers`
--
ALTER TABLE `contacts_phone_numbers`
  ADD CONSTRAINT `contacts_phone_numbers_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`);

--
-- Constraints for table `contacts_preferences`
--
ALTER TABLE `contacts_preferences`
  ADD CONSTRAINT `contacts_preferences_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`);

--
-- Constraints for table `contacts_social_links`
--
ALTER TABLE `contacts_social_links`
  ADD CONSTRAINT `contacts_social_links_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`);

--
-- Constraints for table `contact_companies`
--
ALTER TABLE `contact_companies`
  ADD CONSTRAINT `contact_companies_parent_comp_id_foreign` FOREIGN KEY (`parent_comp_id`) REFERENCES `contact_companies` (`id`),
  ADD CONSTRAINT `contact_company_type_foreign` FOREIGN KEY (`company_type_id`) REFERENCES `contact_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `meneuses`
--
ALTER TABLE `meneuses`
  ADD CONSTRAINT `meneuses_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `meneuses` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `projects_project_owner_id_foreign` FOREIGN KEY (`project_owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_project_type_id_foreign` FOREIGN KEY (`project_type_id`) REFERENCES `project_types` (`id`);

--
-- Constraints for table `purposes`
--
ALTER TABLE `purposes`
  ADD CONSTRAINT `purposes_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `purposes` (`id`),
  ADD CONSTRAINT `purposes_sla_id_foreign` FOREIGN KEY (`sla_id`) REFERENCES `sla_configurations` (`id`);

--
-- Constraints for table `roles_menus`
--
ALTER TABLE `roles_menus`
  ADD CONSTRAINT `fk_parent_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_menu_permissions`
--
ALTER TABLE `role_menu_permissions`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_role_menu_id` FOREIGN KEY (`role_menu_id`) REFERENCES `meneuses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sla_configurations`
--
ALTER TABLE `sla_configurations`
  ADD CONSTRAINT `sla_configurations_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `sla_configurations_escalated_to_user_id_foreign` FOREIGN KEY (`escalated_to_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `status_workflows`
--
ALTER TABLE `status_workflows`
  ADD CONSTRAINT `status_workflows_from_status_id_foreign` FOREIGN KEY (`from_status_id`) REFERENCES `ticket_statuses` (`id`),
  ADD CONSTRAINT `status_workflows_to_status_id_foreign` FOREIGN KEY (`to_status_id`) REFERENCES `ticket_statuses` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tasks_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `tasks_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `task_attachments`
--
ALTER TABLE `task_attachments`
  ADD CONSTRAINT `task_attachments_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_attachments_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_priority_id` FOREIGN KEY (`priority_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_assigned_to_id_foreign` FOREIGN KEY (`assigned_to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_created_by_id_foreign` FOREIGN KEY (`created_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_resolution_time_id_foreign` FOREIGN KEY (`resolution_time_id`) REFERENCES `sla_configurations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_response_time_id_foreign` FOREIGN KEY (`response_time_id`) REFERENCES `sla_configurations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_sla_foreign` FOREIGN KEY (`SLA`) REFERENCES `sla_configurations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ticket_source_id_foreign` FOREIGN KEY (`ticket_source_id`) REFERENCES `ticket_sources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ticket_status_id_foreign` FOREIGN KEY (`ticket_status_id`) REFERENCES `ticket_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_attachments`
--
ALTER TABLE `ticket_attachments`
  ADD CONSTRAINT `ticket_attachments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_attachments_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_journeys`
--
ALTER TABLE `ticket_journeys`
  ADD CONSTRAINT `ticket_journeys_actioned_by_foreign` FOREIGN KEY (`actioned_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_journeys_from_agent_foreign` FOREIGN KEY (`from_agent`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ticket_journeys_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_journeys_to_agent_foreign` FOREIGN KEY (`to_agent`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_priority_type_id_foreign` FOREIGN KEY (`priority_type_id`) REFERENCES `priorities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_replied_by_user_id_foreign` FOREIGN KEY (`replied_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_status_type_id_foreign` FOREIGN KEY (`status_after_reply`) REFERENCES `ticket_statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_replies_type_id_foreign` FOREIGN KEY (`reply_type`) REFERENCES `ticket_sources` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `timesheets_approved_by_id_foreign` FOREIGN KEY (`approved_by_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `timesheets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `timesheets_shift_type_id_foreign` FOREIGN KEY (`shift_type_id`) REFERENCES `shift_types` (`id`),
  ADD CONSTRAINT `timesheets_ts_activity_id_foreign` FOREIGN KEY (`ts_activity_id`) REFERENCES `timesheet_activities` (`id`),
  ADD CONSTRAINT `timesheets_ts_status_id_foreign` FOREIGN KEY (`ts_status_id`) REFERENCES `timesheet_statuses` (`id`),
  ADD CONSTRAINT `timesheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_designation` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_users_shift` FOREIGN KEY (`shift_id`) REFERENCES `shift_types` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
