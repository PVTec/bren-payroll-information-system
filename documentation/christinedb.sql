-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 02:51 AM
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
-- Database: `christinedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `hours_worked` decimal(5,2) NOT NULL DEFAULT 0.00,
  `status` enum('present','absent','late','half_day','leave') NOT NULL DEFAULT 'present',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `time_out`, `hours_worked`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-04-11', '08:00:00', '17:00:00', 8.00, 'present', NULL, '2026-04-10 17:37:31', '2026-04-10 17:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deduction_settings`
--

CREATE TABLE `deduction_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('fixed','percentage','tiered') NOT NULL,
  `employee_share` decimal(8,4) DEFAULT NULL,
  `employer_share` decimal(8,4) DEFAULT NULL,
  `fixed_amount` decimal(12,2) DEFAULT NULL,
  `minimum_salary` decimal(12,2) DEFAULT NULL,
  `maximum_salary` decimal(12,2) DEFAULT NULL,
  `tier_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tier_data`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deduction_settings`
--

INSERT INTO `deduction_settings` (`id`, `name`, `type`, `employee_share`, `employer_share`, `fixed_amount`, `minimum_salary`, `maximum_salary`, `tier_data`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'SSS Contribution', 'tiered', NULL, NULL, NULL, NULL, NULL, '[{\"min\":0,\"max\":3250,\"employee_share\":135,\"employer_share\":270},{\"min\":3250,\"max\":3750,\"employee_share\":157.5,\"employer_share\":315},{\"min\":3750,\"max\":4250,\"employee_share\":180,\"employer_share\":360},{\"min\":4250,\"max\":4750,\"employee_share\":202.5,\"employer_share\":405},{\"min\":4750,\"max\":5250,\"employee_share\":225,\"employer_share\":450},{\"min\":5250,\"max\":5750,\"employee_share\":247.5,\"employer_share\":495},{\"min\":5750,\"max\":6250,\"employee_share\":270,\"employer_share\":540},{\"min\":6250,\"max\":6750,\"employee_share\":292.5,\"employer_share\":585},{\"min\":6750,\"max\":7250,\"employee_share\":315,\"employer_share\":630},{\"min\":7250,\"max\":7750,\"employee_share\":337.5,\"employer_share\":675},{\"min\":7750,\"max\":8250,\"employee_share\":360,\"employer_share\":720},{\"min\":8250,\"max\":8750,\"employee_share\":382.5,\"employer_share\":765},{\"min\":8750,\"max\":9250,\"employee_share\":405,\"employer_share\":810},{\"min\":9250,\"max\":9750,\"employee_share\":427.5,\"employer_share\":855},{\"min\":9750,\"max\":10250,\"employee_share\":450,\"employer_share\":900},{\"min\":10250,\"max\":10750,\"employee_share\":472.5,\"employer_share\":945},{\"min\":10750,\"max\":11250,\"employee_share\":495,\"employer_share\":990},{\"min\":11250,\"max\":11750,\"employee_share\":517.5,\"employer_share\":1035},{\"min\":11750,\"max\":12250,\"employee_share\":540,\"employer_share\":1080},{\"min\":12250,\"max\":12750,\"employee_share\":562.5,\"employer_share\":1125},{\"min\":12750,\"max\":13250,\"employee_share\":585,\"employer_share\":1170},{\"min\":13250,\"max\":13750,\"employee_share\":607.5,\"employer_share\":1215},{\"min\":13750,\"max\":14250,\"employee_share\":630,\"employer_share\":1260},{\"min\":14250,\"max\":14750,\"employee_share\":652.5,\"employer_share\":1305},{\"min\":14750,\"max\":15250,\"employee_share\":675,\"employer_share\":1350},{\"min\":15250,\"max\":15750,\"employee_share\":697.5,\"employer_share\":1395},{\"min\":15750,\"max\":16250,\"employee_share\":720,\"employer_share\":1440},{\"min\":16250,\"max\":16750,\"employee_share\":742.5,\"employer_share\":1485},{\"min\":16750,\"max\":17250,\"employee_share\":765,\"employer_share\":1530},{\"min\":17250,\"max\":17750,\"employee_share\":787.5,\"employer_share\":1575},{\"min\":17750,\"max\":18250,\"employee_share\":810,\"employer_share\":1620},{\"min\":18250,\"max\":18750,\"employee_share\":832.5,\"employer_share\":1665},{\"min\":18750,\"max\":19250,\"employee_share\":855,\"employer_share\":1710},{\"min\":19250,\"max\":19750,\"employee_share\":877.5,\"employer_share\":1755},{\"min\":19750,\"max\":20250,\"employee_share\":900,\"employer_share\":1800},{\"min\":20250,\"max\":20750,\"employee_share\":922.5,\"employer_share\":1845},{\"min\":20750,\"max\":21250,\"employee_share\":945,\"employer_share\":1890},{\"min\":21250,\"max\":21750,\"employee_share\":967.5,\"employer_share\":1935},{\"min\":21750,\"max\":22250,\"employee_share\":990,\"employer_share\":1980},{\"min\":22250,\"max\":22750,\"employee_share\":1012.5,\"employer_share\":2025},{\"min\":22750,\"max\":23250,\"employee_share\":1035,\"employer_share\":2070},{\"min\":23250,\"max\":23750,\"employee_share\":1057.5,\"employer_share\":2115},{\"min\":23750,\"max\":24250,\"employee_share\":1080,\"employer_share\":2160},{\"min\":24250,\"max\":24750,\"employee_share\":1102.5,\"employer_share\":2205},{\"min\":24750,\"max\":9223372036854775807,\"employee_share\":1125,\"employer_share\":2250}]', 1, '2026-04-10 03:39:03', '2026-04-10 03:39:03'),
(2, 'PhilHealth Contribution', 'percentage', 2.5000, 2.5000, NULL, NULL, NULL, NULL, 1, '2026-04-10 03:39:03', '2026-04-10 03:39:03'),
(3, 'Pag-IBIG Contribution', 'fixed', NULL, 100.0000, 100.00, NULL, NULL, NULL, 1, '2026-04-10 03:39:03', '2026-04-10 03:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Human Resources', 'HR', 'HR Department', '2026-04-10 03:39:03', '2026-04-10 03:39:03'),
(2, 'Finance', 'FIN', 'Finance and Accounting', '2026-04-10 03:39:03', '2026-04-10 03:39:03'),
(3, 'Information Technology', 'IT', 'IT Department', '2026-04-10 03:39:03', '2026-04-10 03:39:03'),
(4, 'Sales', 'SAL', 'Sales Department', '2026-04-10 03:39:03', '2026-04-10 03:39:03'),
(5, 'Operations', 'OPS', 'Operations Department', '2026-04-10 03:39:03', '2026-04-10 03:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `hire_date` date NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary_type` enum('monthly','daily','hourly') NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL,
  `status` enum('active','inactive','terminated') NOT NULL DEFAULT 'active',
  `sss_number` varchar(255) DEFAULT NULL,
  `philhealth_number` varchar(255) DEFAULT NULL,
  `pagibig_number` varchar(255) DEFAULT NULL,
  `tin_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `department_id`, `employee_id`, `first_name`, `last_name`, `middle_name`, `date_of_birth`, `gender`, `contact_number`, `email`, `address`, `hire_date`, `position`, `salary_type`, `basic_salary`, `status`, `sss_number`, `philhealth_number`, `pagibig_number`, `tin_number`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'EMP001', 'John', 'Employee', 'Doe', '1990-01-15', 'male', '09123456789', 'employee@payroll.com', '123 Sample Street, City', '2020-06-01', 'Staff', 'monthly', 25000.00, 'active', '1234567890', '9876543210', '1122334455', '000123456', '2026-04-10 03:39:03', '2026-04-10 03:39:03');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000001_create_departments_table', 1),
(5, '2024_01_01_000002_create_employees_table', 1),
(6, '2024_01_01_000003_create_attendance_table', 1),
(7, '2024_01_01_000004_create_payrolls_table', 1),
(8, '2024_01_01_000005_create_payroll_items_table', 1),
(9, '2024_01_01_000006_create_deduction_settings_table', 1);

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
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `payroll_period` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `payroll_type` enum('monthly','weekly','semi_monthly') NOT NULL DEFAULT 'monthly',
  `basic_pay` decimal(12,2) NOT NULL,
  `gross_pay` decimal(12,2) NOT NULL,
  `total_deductions` decimal(12,2) NOT NULL,
  `net_pay` decimal(12,2) NOT NULL,
  `status` enum('draft','processed','paid') NOT NULL DEFAULT 'draft',
  `processed_at` timestamp NULL DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `employee_id`, `payroll_period`, `start_date`, `end_date`, `payroll_type`, `basic_pay`, `gross_pay`, `total_deductions`, `net_pay`, `status`, `processed_at`, `processed_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'april 2026', '2026-04-11', '2026-04-28', 'monthly', 25000.00, 0.00, 235.00, -235.00, 'processed', '2026-04-10 17:37:58', 1, '2026-04-10 17:35:39', '2026-04-10 17:37:58');

-- --------------------------------------------------------

--
-- Table structure for table `payroll_items`
--

CREATE TABLE `payroll_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payroll_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('earning','deduction') NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payroll_items`
--

INSERT INTO `payroll_items` (`id`, `payroll_id`, `type`, `name`, `category`, `amount`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'earning', 'Basic Salary', 'basic_salary', 25000.00, NULL, '2026-04-10 17:35:39', '2026-04-10 17:35:39'),
(2, 1, 'deduction', 'SSS Contribution', 'sss', 135.00, NULL, '2026-04-10 17:35:39', '2026-04-10 17:35:39'),
(3, 1, 'deduction', 'Pag-IBIG Contribution', 'pagibig', 100.00, NULL, '2026-04-10 17:35:39', '2026-04-10 17:35:39');

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
('BuGlxnxDKy24UZM2EVforuQf11E9Jx4qfBPmqy3o', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 OPR/129.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidEdWUnFhUGE1ZTZ5UkZiSUMwYkIzT2JaRXFCQ0tiUkVKQ0UyZmJEQiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1775956921),
('CcvZ9HqpkHordHgQOQKYDCMPRMA03luaUsRbZD4y', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 OPR/129.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNXpyVjdrUUh6SlNrRHI4Q1pBaVFDZmMzb1U4b0RSa1NhNGVMdmp1eiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvaGVscCI7czo1OiJyb3V0ZSI7czoxMDoiaGVscC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775956988),
('cOXST6Tj8rU8FscnrlO2FyhJtIh11TcOyBRV9Z9v', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 OPR/129.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZnZzQjhlSXkwUDN6RDZjTnFaWk0yRnJGZ3k1cThiS1MycjB5WGVENCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775892166),
('oh4KUDBafwQycWUnWml29WxZZ6TUidvFZFdMGDoJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 OPR/129.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMkdPaklkcXNMMlc2bmtwMFdOU2tTU2V2b3RxRFF2c0RldXl0RzdhMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1775888283);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','employee') NOT NULL DEFAULT 'employee',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'HR Manager', 'admin@payroll.com', NULL, '$2y$12$Lf849FTHzl.eqDpbft9bv.y9uBfj4LT5fecR774ZZ35rJiM40.YYa', 'admin', NULL, '2026-04-10 03:39:01', '2026-04-10 03:39:01'),
(2, 'Payroll Officer', 'staff@payroll.com', NULL, '$2y$12$5nr574nXXob01lswK2R49e0cXUPtWh4jaVTL8Zw0krPM3FnKIoS12', 'staff', NULL, '2026-04-10 03:39:02', '2026-04-10 03:39:02'),
(3, 'John Employee', 'employee@payroll.com', NULL, '$2y$12$TfERnOPm740rIceUKb9IU.Mkd9PN2TvusquCf51lRuKiePgNe6G0i', 'employee', NULL, '2026-04-10 03:39:03', '2026-04-10 03:39:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_employee_id_date_unique` (`employee_id`,`date`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `deduction_settings`
--
ALTER TABLE `deduction_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_id_unique` (`employee_id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payrolls_employee_id_foreign` (`employee_id`),
  ADD KEY `payrolls_processed_by_foreign` (`processed_by`);

--
-- Indexes for table `payroll_items`
--
ALTER TABLE `payroll_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payroll_items_payroll_id_foreign` (`payroll_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deduction_settings`
--
ALTER TABLE `deduction_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payroll_items`
--
ALTER TABLE `payroll_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payrolls_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payroll_items`
--
ALTER TABLE `payroll_items`
  ADD CONSTRAINT `payroll_items_payroll_id_foreign` FOREIGN KEY (`payroll_id`) REFERENCES `payrolls` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
