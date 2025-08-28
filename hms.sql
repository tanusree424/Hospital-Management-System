-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2025 at 01:30 PM
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
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `profile_picture`, `phone`, `created_at`, `updated_at`) VALUES
(1, 1, 'profile_images/uQtj5Sjfa4zJVHvRGTkK4wUYFWJSYYaWj1QyjwjO.jpg', '9332819707', '2025-07-15 08:46:27', '2025-07-15 08:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `ward_id` bigint(20) UNSIGNED NOT NULL,
  `bed_id` bigint(20) UNSIGNED NOT NULL,
  `admission_date` date NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discharge` tinyint(1) NOT NULL DEFAULT 0,
  `amount` decimal(10,2) NOT NULL DEFAULT 1500.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`id`, `patient_id`, `ward_id`, `bed_id`, `admission_date`, `reason`, `created_at`, `updated_at`, `discharge`, `amount`) VALUES
(36, 1, 11, 25, '2025-08-13', 'Cardiac Arrest', '2025-08-12 10:57:59', '2025-08-13 02:56:16', 0, 1500.00),
(37, 2, 3, 5, '2025-08-14', 'Serious condition', '2025-08-12 11:00:28', '2025-08-13 04:00:47', 1, 1500.00),
(38, 7, 12, 10, '2025-08-13', 'Neurological Problem', '2025-08-12 11:31:05', '2025-08-13 04:43:03', 1, 1500.00),
(39, 3, 1, 3, '2025-08-10', 'Highly Fever', '2025-08-12 22:55:58', '2025-08-24 04:43:11', 1, 1500.00),
(40, 8, 1, 3, '2025-08-24', 'High Fever', '2025-08-24 04:01:17', '2025-08-24 04:01:17', 0, 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'Patient',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('approved','pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cancelled_by` varchar(255) DEFAULT NULL,
  `appointment_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `patient_id`, `user_type`, `name`, `email`, `department_id`, `appointment_date`, `appointment_time`, `status`, `created_at`, `updated_at`, `cancelled_by`, `appointment_number`) VALUES
(10, 1, 1, 'Patient', NULL, NULL, 1, '2025-08-08', '12:07:00', 'approved', '2025-08-08 01:08:04', '2025-08-13 00:53:03', NULL, 'APT-CH3U9M'),
(11, 1, 2, 'Patient', NULL, NULL, 1, '2025-08-08', '12:18:00', 'cancelled', '2025-08-08 01:18:24', '2025-08-13 00:55:36', 'Doctor', 'APT-25MUIX'),
(12, 4, 3, 'Patient', NULL, NULL, 6, '2025-08-08', '12:30:00', 'cancelled', '2025-08-08 01:30:45', '2025-08-08 02:08:19', 'Admin', 'APT-QGTL8Z'),
(13, 1, 4, 'Patient', NULL, NULL, 1, '2025-08-08', '18:31:00', 'cancelled', '2025-08-08 02:27:03', '2025-08-13 00:53:16', 'Admin', 'APT-1GAD7A'),
(16, 2, NULL, 'Guest', 'Shahid Kapoor', 'shahidkapoor@gmail.com', 7, '2025-08-11', '19:44:00', 'completed', '2025-08-10 11:18:18', '2025-08-23 08:07:18', NULL, NULL),
(17, 4, NULL, 'Guest', 'Shahid Kapoor', 'shahidkapoor@gmail.com', 6, '2025-08-11', '18:25:00', 'completed', '2025-08-10 11:23:24', '2025-08-13 02:18:30', NULL, NULL),
(18, 4, NULL, 'Guest', 'Shahid Kapoor', 'shahidkapoor@gmail.com', 6, '2025-08-11', '22:25:00', 'pending', '2025-08-10 11:25:53', '2025-08-10 11:25:53', NULL, NULL),
(19, 1, NULL, 'Guest', 'Karan Singh Grover', 'karansinghgrover@gmail.com', 1, '2025-08-11', '22:28:00', 'pending', '2025-08-10 11:28:20', '2025-08-10 11:28:20', NULL, NULL),
(20, 4, NULL, 'Guest', 'Shahid Kapoor', 'shahidkapoor@gmail.com', 6, '2025-08-11', '19:44:00', 'pending', '2025-08-10 11:31:04', '2025-08-10 11:31:04', NULL, NULL),
(21, 1, NULL, 'Guest', 'Shahid Kapoor', 'shahidkapoor@gmail.com', 1, '2025-08-11', '18:25:00', 'pending', '2025-08-10 11:32:35', '2025-08-10 11:32:35', NULL, NULL),
(22, 1, NULL, 'Guest', 'Pratap Singh', 'pratapsingh@gmail.com', 1, '2025-08-13', '12:25:00', 'pending', '2025-08-12 01:25:24', '2025-08-12 01:25:24', NULL, NULL),
(24, 1, 7, 'Patient', NULL, NULL, 1, '2025-08-14', '22:33:00', 'pending', '2025-08-13 10:32:39', '2025-08-13 10:32:39', NULL, NULL),
(25, 1, 7, 'Patient', NULL, NULL, 1, '2025-08-14', '22:33:00', 'pending', '2025-08-13 10:33:38', '2025-08-13 10:33:38', NULL, NULL),
(26, 4, 8, 'Guest', NULL, NULL, 6, '2025-08-14', '12:15:00', 'cancelled', '2025-08-13 10:34:49', '2025-08-13 10:41:30', 'Patient', NULL),
(27, 4, 8, 'Patient', NULL, NULL, 6, '2025-08-14', '05:00:00', 'cancelled', '2025-08-13 10:42:14', '2025-08-13 10:43:52', 'Patient', NULL),
(28, 4, 8, 'Patient', NULL, NULL, 6, '2025-08-14', '05:00:00', 'pending', '2025-08-13 10:42:49', '2025-08-13 10:42:49', NULL, NULL),
(29, 4, NULL, 'Guest', 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 6, '2025-08-15', '10:00:00', 'pending', '2025-08-14 23:12:47', '2025-08-14 23:12:47', NULL, NULL),
(30, 8, NULL, 'Guest', 'Kareena Kapoor', 'kareenakapoor@gmail.com', 11, '2025-08-20', '10:00:00', 'pending', '2025-08-18 22:47:26', '2025-08-18 22:47:26', NULL, NULL),
(31, 1, NULL, 'Guest', 'Syed Nausad Ali', 'syednausadali@gmail.com', 1, '2025-08-20', '11:00:00', 'pending', '2025-08-19 00:08:52', '2025-08-19 00:08:52', NULL, NULL),
(32, 4, NULL, 'Guest', 'Karan Rajput', 'karanrajput@gmail.com', 6, '2025-08-20', '18:25:00', 'pending', '2025-08-19 00:28:50', '2025-08-19 00:28:50', NULL, NULL),
(33, 1, 8, 'Patient', NULL, NULL, 1, '2025-08-24', '14:46:00', 'pending', '2025-08-23 03:46:09', '2025-08-23 03:46:09', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ward_id` bigint(20) UNSIGNED NOT NULL,
  `bed_number` varchar(255) NOT NULL,
  `status` enum('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `ward_id`, `bed_number`, `status`, `description`, `created_at`, `updated_at`) VALUES
(3, 1, 'G-101', 'available', 'General Ward Bed near entrance', '2025-07-29 10:01:16', '2025-08-24 04:43:11'),
(4, 1, 'G-102', 'available', 'General Ward Bed beside window', '2025-07-29 10:02:51', '2025-08-05 01:42:38'),
(5, 3, 'ICU-201', 'available', 'ICU Bed with ventilator support', '2025-07-29 10:06:35', '2025-08-13 02:37:21'),
(6, 3, 'ICU-202', 'maintenance', 'Ventilator under maintenance', '2025-07-29 10:14:25', '2025-07-29 10:14:25'),
(7, 4, 'P-301', 'occupied', 'Pediatric Bed with side rails', '2025-07-29 10:15:24', '2025-08-05 11:22:29'),
(8, 4, 'P-302', 'available', 'Infant crib with monitoring system', '2025-07-29 10:16:29', '2025-07-29 10:16:29'),
(9, 1, 'G-103', 'occupied', 'General Ward Bed middle', '2025-07-31 01:18:14', '2025-08-05 09:46:45'),
(10, 12, 'NU-902', 'available', 'Nostrum officiis qui et quia.', '2025-07-31 01:55:45', '2025-08-12 22:53:04'),
(11, 16, 'CO-263', 'available', 'Laudantium ipsa porro eius blanditiis et ab consequatur.', '2025-07-31 01:55:45', '2025-07-31 03:03:40'),
(12, 7, 'EM-265', 'available', 'Aut dolorem voluptas omnis aut dignissimos.', '2025-07-31 01:55:45', '2025-08-01 11:42:45'),
(13, 4, 'P-989', 'available', 'Ea repellat et libero consequatur neque quis reiciendis.', '2025-07-31 01:55:45', '2025-07-31 02:00:12'),
(14, 8, 'Psy-137', 'available', 'Ea veniam consequatur eligendi ipsam.', '2025-07-31 01:55:45', '2025-08-04 11:24:39'),
(15, 15, 'Oth-103', 'available', 'Molestiae asperiores est voluptatem fuga nesciunt dolor qui.', '2025-07-31 01:55:45', '2025-07-31 02:01:19'),
(16, 12, 'NU-440', 'available', 'Sint eum adipisci quasi qui voluptas iure.', '2025-07-31 01:55:45', '2025-08-04 10:39:42'),
(17, 8, 'Psy-776', 'available', 'Officia qui cum sint eos facere optio.', '2025-07-31 01:55:45', '2025-07-31 02:02:31'),
(18, 18, 'Ger-735', 'available', 'Quidem aliquam quod quia deserunt saepe ullam alias.', '2025-07-31 01:55:45', '2025-08-04 23:36:43'),
(19, 17, 'CO-618', 'available', 'Rerum consequuntur cupiditate aut praesentium enim est.', '2025-07-31 01:55:45', '2025-07-31 02:03:15'),
(20, 1, 'Gen-489', 'occupied', 'Libero enim sapiente doloribus.', '2025-07-31 01:57:22', '2025-08-05 23:42:03'),
(21, 13, 'Onc-602', 'occupied', 'Totam ullam molestias accusantium possimus magnam qui autem.', '2025-07-31 01:57:22', '2025-08-05 23:55:57'),
(22, 6, 'Sur-152', 'available', 'Quis libero quisquam id labore esse voluptas.', '2025-07-31 01:57:22', '2025-07-31 02:05:04'),
(23, 17, 'CO-644', 'available', 'Quibusdam velit excepturi odit repellendus quia a et.', '2025-07-31 01:57:22', '2025-07-31 02:06:22'),
(24, 12, 'NU-579', 'available', 'Est sit corrupti reprehenderit quia.', '2025-07-31 01:57:22', '2025-07-31 02:06:46'),
(25, 11, 'Card-638', 'available', 'Rem et magni laudantium blanditiis doloremque provident.', '2025-07-31 01:57:22', '2025-08-13 02:36:07'),
(26, 13, 'Onc-182', 'available', 'Molestiae quibusdam id consequatur excepturi.', '2025-07-31 01:57:22', '2025-07-31 02:07:36'),
(27, 19, 'Post-998', 'available', 'Itaque enim repellat placeat dignissimos magnam rerum.', '2025-07-31 01:57:22', '2025-07-31 02:07:54'),
(28, 16, 'CO-911', 'available', 'Ut maiores tempora ducimus eaque.', '2025-07-31 01:57:22', '2025-07-31 02:05:32'),
(29, 14, 'Dal-258', 'occupied', 'Animi dolor qui excepturi commodi.', '2025-07-31 01:57:22', '2025-08-06 00:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_type` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `comments` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `author_id`, `author_type`, `title`, `slug`, `description`, `image`, `views`, `comments`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'The Importance of Regular Health Checkups', 'importance-regular-health-checkups', 'Regular health checkups help in early detection of diseases and improve overall well-being.', 'blog_image/laPgB4uRZvOREBUFt4wGnccpDRsztLYIQ5greNHx.jpg', 1, 0, '2025-08-17 01:52:46', '2025-08-18 00:44:07'),
(2, 1, 'doctor', 'How to Maintain a Healthy Heart', 'maintain-healthy-heart', 'A healthy lifestyle, balanced diet, and regular exercise can keep your heart strong.', 'blog_image/eXSv56m2ufXLllEa8rq297QFoxQ0ggMg9yaxWlvo.jpg', 35, 4, '2025-08-17 02:01:22', '2025-08-18 00:13:59'),
(3, 5, 'doctor', 'The Role of Technology in Modern Hospitals', 'technology-modern-hospitals', 'A healthy lifestyle, balanced diet, and regular exercise can keep your heart strong.', 'blog_image/UhVTCQaeGsTLnxlDKaFyoenfSa6DBbnoRgSIHxrn.jpg', 0, 0, '2025-08-17 02:02:56', '2025-08-17 02:02:56'),
(4, 6, 'doctor', 'Tips for a Speedy Recovery After Surgery', 'speedy-recovery-after-surgery', 'Follow your doctor’s advice, eat nutritious food, and rest well to recover faster.', 'blog_image/R8TOTTT8IBMCoUOzS0bMA9wIXrGIsbfiYvyQLLdg.jpg', 0, 0, '2025-08-17 02:05:05', '2025-08-17 02:05:05'),
(5, 6, 'doctor', 'Child Healthcare: What Every Parent Should Know', 'child-healthcare-tips', 'Immunization, balanced diet, and routine checkups are crucial for child health.', 'blog_image/gDseWCSwhidJDWrWNhrYWMMNQe2LZbNuSE1HXj2o.jpg', 0, 0, '2025-08-17 02:06:27', '2025-08-17 02:06:27'),
(7, 1, 'doctor', 'Understanding Diabetes: Causes, Symptoms, and Prevention', 'understanding-diabetes', 'Diabetes is becoming more common. Here’s what you should know about prevention and management.', 'blog_image/ocLTM4fkg5A9I2oGiHW5cl2bnk2CcPV3gqhtCfv5.jpg', 4, 0, '2025-08-17 02:49:21', '2025-08-18 00:38:50'),
(8, 7, 'doctor', 'Emergency Room vs Urgent Care: Where Should You Go?', 'er-vs-urgent-care', 'Knowing when to visit the ER and when urgent care is sufficient can save lives', 'blog_image/j2GcHoDsG0mKmPzny6XhrMPEv9mUeaEXJHtvdGTi.jpg', 1, 0, '2025-08-17 02:51:48', '2025-08-18 00:32:53'),
(9, 2, 'doctor', 'Top 5 Benefits of Yoga for Hospital Patients', 'benefits-yoga-hospital-patients', 'Yoga helps in faster recovery, reduces stress, and improves patient well-being.', 'blog_image/ebdSofEascJXQh1TE81zulFVPSgmajzPNbB2K0kx.jpg', 5, 0, '2025-08-17 02:54:01', '2025-08-20 08:58:48'),
(10, 2, 'doctor', 'Healthy Diet Plans for Post-Surgery Recovery', 'diet-plan-post-surgery', 'Nutrition plays a key role in recovery. Here are meal plans recommended by doctors.', 'blog_image/TJnvh1hLrmhISTx3uKO4nkDfAPGuAODu4VOLYSmS.png', 1, 0, '2025-08-17 02:56:54', '2025-08-20 08:54:05'),
(11, 7, 'doctor', 'The Future of Telemedicine in Hospitals', 'future-telemedicine-hospitals', 'Telemedicine is bridging the gap between patients and doctors. Here’s what’s next.', 'blog_image/TaWEJTZl6qiMU8dm1AJk0TUbgJ3MloiHnlt5vBCe.jpg', 0, 0, '2025-08-17 03:02:26', '2025-08-17 03:02:26'),
(12, 7, 'doctor', 'How Nurses Contribute to Better Patient Care', 'nurses-role-patient-care', 'Nurses are the backbone of hospital systems. This blog explores their critical role.', 'blog_image/ZP3OnlwHrWkaGFOlRkC6Nv8q2dUKx5omRdURGCTO.jpg', 0, 0, '2025-08-17 03:25:49', '2025-08-17 03:25:49'),
(13, 2, 'doctor', 'Mental Health Awareness in Hospitals', 'mental-health-awareness', 'Hospitals are now focusing more on mental health support for patients and families.', 'blog_image/qgi6LvK6CEbqEtSLUfZeLji99GN5cUeiz0MPABYG.png', 1, 0, '2025-08-17 04:29:00', '2025-08-20 05:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `blog_id`, `user_id`, `content`, `name`, `email`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'Nice Post', 'Anonymous', NULL, '2025-08-17 22:36:59', '2025-08-17 22:36:59'),
(2, 1, 4, 'Nice Post..', NULL, NULL, '2025-08-17 22:51:28', '2025-08-17 22:51:28'),
(3, 2, NULL, 'Nice Post', 'Anonymous', NULL, '2025-08-18 00:13:39', '2025-08-18 00:13:39'),
(4, 2, NULL, 'Nice Post', 'Anonymous', NULL, '2025-08-18 00:13:59', '2025-08-18 00:13:59'),
(5, 9, NULL, 'Good to know About the post', 'Riya Das', 'mailtosweetriya@gmail.com', '2025-08-18 00:48:44', '2025-08-18 00:48:44');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 'I want to know do you have any any in ICU ?', 'public function store(Request $request)\r\n{\r\n    // Block bots (honeypot)\r\n    if ($request->filled(\'website\')) {\r\n        return back()->withErrors([\'Spam detected.\'])->withInput();\r\n    }\r\n\r\n    $data = $request->validate([\r\n        \'name\'    => [\'required\',\'string\',\'max:100\'],\r\n        \'email\'   => [\'required\',\'email\',\'max:150\'],\r\n        \'subject\' => [\'required\',\'string\',\'max:150\'],\r\n        \'message\' => [\'required\',\'string\',\'max:2000\'],\r\n    ], [\r\n        \'name.required\'    => \'Please enter your name.\',\r\n        \'email.required\'   => \'Please enter your email.\',\r\n        \'email.email\'      => \'Please enter a valid email address.\',\r\n        \'subject.required\' => \'Please enter a subject.\',\r\n        \'message.required\' => \'Please write your message.\',\r\n    ]);\r\n\r\n    try {\r\n        // (Optional) Save to DB\r\n        Contact::create([\r\n            \"name\"=>$request->name,\r\n            \"email\"=>$request->email,\r\n            \"subject\"=>$request->subject,\r\n            \"message\"=>$request->message\r\n        ]);\r\n\r\n        // Send email to site admin (change address)\r\n        // In app/Http/Controllers/Contact/ContactController.php (around line 40)\r\n        Mail::send(\'emails.contact\', [\r\n            \'name\'    => $request->name,\r\n            \'email\'   => $request->email,\r\n            \'subject\' => $request->subject,\r\n            \'message\' => $request->message\r\n        ], function($message) use ($request) {\r\n            $message->to(\'avijitpaul033@gmail.com\');\r\n            $message->subject($request->subject);\r\n        });\r\n\r\n        return back()->with(\'success\', \'Thanks! Your message has been sent.\');\r\n    } catch (Throwable $e) {\r\n        \\Log::info($e);\r\n        report($e);\r\n        return back()\r\n            ->withErrors([\'Something went wrong while sending your message. Please try again.\'])\r\n            ->withInput();\r\n    }\r\n}', '2025-08-20 10:41:44', '2025-08-20 10:41:44'),
(2, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 'I want to know do you have any any in ICU ?', 'axksmcldvg', '2025-08-20 10:44:40', '2025-08-20 10:44:40'),
(3, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 'I want to know do you have any any in ICU ?', 'lkmm;l,\'lpip', '2025-08-20 10:47:29', '2025-08-20 10:47:29'),
(4, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 'I want to know do you have any any in ICU ?', 'b,nklmlm;ghfhy', '2025-08-20 10:55:54', '2025-08-20 10:55:54'),
(5, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', ',,ml.,klhuj', 'chgjhb', '2025-08-20 10:56:45', '2025-08-20 10:56:45'),
(6, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 'I want to know do you have any any in ICU ?', 'bfghhjjikl', '2025-08-20 10:58:21', '2025-08-20 10:58:21'),
(7, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', 'I want to know do you have any any in ICU ?', 'I wanna admit one patient to your hospital', '2025-08-20 11:02:55', '2025-08-20 11:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `department_image` varchar(255) DEFAULT NULL,
  `pricing` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`, `department_image`, `pricing`) VALUES
(1, 'Cardiology', '🫀 Cardiology Department – Description\r\nThe Cardiology Department is dedicated to the comprehensive care of patients with heart and vascular conditions. Staffed by expert cardiologists, technicians, and nursing professionals, the department offers a wide range of diagnostic, preventive, interventional, and rehabilitative services tailored to both acute and chronic cardiovascular diseases.\r\n\r\nWe are equipped with state-of-the-art technology to ensure accurate diagnosis and effective treatment. From managing high blood pressure and cholesterol to performing life-saving procedures like angioplasty and pacemaker implantation, our goal is to provide holistic, patient-centered cardiac care.\r\n\r\nThe department also runs preventive cardiology programs, focusing on lifestyle modification, early risk detection, and patient education to reduce the incidence of heart diseases in the community.\r\n\r\nWhether it\'s a routine check-up or emergency care, the Cardiology Department ensures compassionate, round-the-clock service to help patients live healthier, heart-strong lives.', '2025-07-04 02:10:01', '2025-08-14 01:58:23', NULL, 'department_image/VZYGuTt41MS3Xj07gDRvkozC3n8NuoXHhvzxJWJD.jpg', 123.45),
(2, 'Neurology', '🧠 Neurology Department – Description\r\nThe Neurology Department specializes in the diagnosis, treatment, and management of disorders affecting the brain, spinal cord, nerves, and muscles. Our expert team of neurologists, neurophysiologists, and support staff is committed to providing comprehensive care to patients with both acute and chronic neurological conditions.\r\n\r\nEquipped with cutting-edge diagnostic tools and a multidisciplinary approach, the department handles a wide range of cases including stroke, epilepsy, Parkinson’s disease, multiple sclerosis, migraines, neuropathies, and more.\r\n\r\nWe also focus on long-term management and rehabilitation of neurological disorders to improve quality of life and restore functional independence. Specialized clinics for epilepsy, stroke, memory disorders, and movement disorders ensure focused care for complex conditions.\r\n\r\nThe department works in close collaboration with neurosurgery, radiology, critical care, and rehabilitation units to offer holistic neurological care from diagnosis through recovery.\r\n\r\n✅ Highlights:\r\nAdvanced neuroimaging (MRI, CT, EEG, EMG)\r\n\r\nEmergency stroke care and thrombolysis\r\n\r\nEpilepsy monitoring and management\r\n\r\nHeadache and migraine clinics\r\n\r\nMemory and dementia evaluations\r\n\r\nNeuromuscular and movement disorder treatments\r\n\r\nNeuro-rehabilitation programs\r\n\r\nOur mission is to provide compassionate, evidence-based care to patients suffering from neurological disorders, empowering them with knowledge and therapies that promote recovery, function, and dignity.', '2025-07-04 02:11:59', '2025-08-14 01:53:01', NULL, 'department_image/zVwzTODFmNsYZRTEO1xHPAqSsvMyMsn72esLPzo5.jpg', 123.45),
(3, 'Radiology', '🩻 Radiology Department – Description\r\nThe Radiology Department serves as a critical diagnostic and interventional unit of the hospital, providing comprehensive imaging services to aid in accurate diagnosis, treatment planning, and patient monitoring. Staffed by highly skilled radiologists, technologists, and imaging specialists, the department ensures high-precision diagnostics with a focus on patient comfort and safety.\r\n\r\nEquipped with advanced imaging technologies such as X-ray, Ultrasound, CT Scan, MRI, Mammography, and Interventional Radiology, we support nearly every other department with timely, high-quality imaging results. Our digital imaging systems allow for efficient image storage, retrieval, and sharing for multidisciplinary consultations.\r\n\r\nIn addition to diagnostic imaging, the department offers image-guided interventional procedures such as biopsies, drain placements, and vascular interventions, minimizing the need for invasive surgery and reducing recovery times.\r\n\r\nThe Radiology Department operates under strict safety protocols, using the lowest possible radiation dose and adhering to international best practices for quality and precision.\r\n\r\n✅ Highlights:\r\nDigital X-ray and portable radiography\r\n\r\nHigh-resolution Ultrasound with Doppler\r\n\r\n64/128-slice CT scanning\r\n\r\n1.5T/3T MRI for advanced neuro and body imaging\r\n\r\nMammography for early breast cancer detection\r\n\r\nInterventional Radiology (biopsies, drainages, angioplasty)\r\n\r\nPACS (Picture Archiving and Communication System) for seamless reporting\r\n\r\nWith 24/7 availability for emergency imaging and a commitment to innovation and accuracy, the Radiology Department plays an essential role in patient care across all specialties.', '2025-07-04 02:12:28', '2025-08-14 01:50:44', NULL, 'department_image/FO4MBsaiDSre0xh4RsuyonovzhJJAM0tuRiZM0w1.jpg', 3000.45),
(4, 'Orthopedics', '🦴 Orthopedics Department – Description\r\nThe Orthopedics Department is dedicated to the diagnosis, treatment, and rehabilitation of conditions involving the bones, joints, muscles, ligaments, tendons, and spine. Our team of skilled orthopedic surgeons, physiotherapists, and support staff work together to restore mobility, relieve pain, and improve the quality of life for patients of all ages.\r\n\r\nFrom common injuries like fractures and sprains to complex joint replacements and spine surgeries, we offer a full spectrum of orthopedic services. Using both surgical and non-surgical methods, the department treats trauma cases, sports injuries, arthritis, congenital conditions, and degenerative disorders.\r\n\r\nThe department also emphasizes post-operative rehabilitation, ensuring a full and functional recovery through physiotherapy and personalized care plans. With modern operation theaters, arthroscopy units, and digital imaging support, we deliver precision-driven orthopedic care that meets international standards.\r\n\r\n✅ Highlights:\r\nEmergency trauma care for fractures and dislocations\r\n\r\nTotal hip and knee replacement surgeries\r\n\r\nMinimally invasive arthroscopic procedures\r\n\r\nPediatric orthopedics for congenital and growth disorders\r\n\r\nSpine care and deformity correction surgeries\r\n\r\nSports injury treatment and rehabilitation\r\n\r\nPhysiotherapy and post-operative recovery programs\r\n\r\nOur mission is to keep you moving pain-free and confidently. Whether you\'re recovering from an injury or seeking treatment for a long-term condition, the Orthopedics Department provides compassionate, evidence-based care for all your musculoskeletal needs.', '2025-07-04 02:12:56', '2025-08-14 01:48:46', NULL, 'department_image/MfWWSov6NiBywk5RsQ15ZdVULWtSCMAAoYppChhG.jpg', 1250.45),
(5, 'Gastroenterology', '🍽️ Gastroenterology Department – Description\r\nThe Gastroenterology Department focuses on the prevention, diagnosis, and treatment of diseases related to the digestive system, including the esophagus, stomach, intestines, liver, gallbladder, and pancreas. Our team of experienced gastroenterologists and endoscopy specialists provides expert care for a wide range of digestive and hepatic conditions.\r\n\r\nUsing advanced diagnostic tools such as endoscopy, colonoscopy, ERCP, and liver function tests, the department offers accurate assessment and minimally invasive treatment of conditions like acid reflux, ulcers, irritable bowel syndrome (IBS), hepatitis, and gastrointestinal bleeding.\r\n\r\nThe department also has specialized clinics for liver diseases, inflammatory bowel disease (IBD), pancreatic disorders, and nutritional counseling. Patients receive personalized care plans that combine medical therapy, lifestyle management, and dietary guidance.\r\n\r\nWorking in close collaboration with surgery, radiology, oncology, and critical care units, the Gastroenterology Department ensures a co', '2025-07-04 02:14:43', '2025-08-14 01:46:56', NULL, 'department_image/imJqcuZ2e9tq2zH8tOOoMvkF4uxWKAtoIjG6tAaz.jpg', 123.45),
(6, 'Nephrology', '🧪 Nephrology Department – Description\r\nThe Nephrology Department specializes in the diagnosis and management of kidney-related diseases and disorders. The kidneys play a critical role in filtering waste, regulating blood pressure, and maintaining fluid and electrolyte balance. Our expert nephrologists provide comprehensive care for patients with both acute and chronic kidney conditions.\r\n\r\nThe department manages a wide spectrum of renal disorders, including chronic kidney disease (CKD), acute kidney injury (AKI), glomerulonephritis, nephrotic syndrome, hypertension-related kidney damage, and diabetic nephropathy. Patients are evaluated through detailed lab investigations, imaging, and kidney biopsies where necessary.\r\n\r\nA major focus is on dialysis services — both hemodialysis and peritoneal dialysis — for patients with end-stage renal disease. The department also provides pre- and post-kidney transplant care, working in collaboration with transplant surgeons and immunology experts.\r\n\r\nIn addition to treatment, the department emphasizes kidney disease prevention, early detection, and patient education to reduce the burden of renal failure in the community.\r\n\r\n✅ Highlights:\r\nManagement of chronic and acute kidney disease\r\n\r\nDiabetic and hypertensive kidney disease treatment\r\n\r\nHemodialysis and peritoneal dialysis units\r\n\r\nKidney biopsy and immunologic testing\r\n\r\nElectrolyte and acid-base imbalance correction\r\n\r\nRenal transplant evaluation and follow-up\r\n\r\n24/7 nephrology support for ICU and critical care units\r\n\r\nPreventive nephrology and lifestyle counseling\r\n\r\nWith advanced diagnostics, compassionate care, and a multidisciplinary approach, the Nephrology Department is committed to preserving kidney function and improving patient outcomes across all stages of kidney disease.', '2025-07-04 02:15:59', '2025-08-14 01:42:49', NULL, 'department_image/sCTzmYEuDVBhRvxcQva1yBKFjZhWersZ2j5HEwWR.jpg', 2500.45),
(7, 'General Physician', '🩺 General Physician Department – Description\r\nThe General Physician Department serves as the first point of contact for patients seeking medical care for a wide range of general health concerns. Staffed by experienced general physicians (also known as internal medicine specialists), the department provides comprehensive evaluation, diagnosis, and treatment of common illnesses and chronic conditions.\r\n\r\nGeneral physicians are trained to manage multi-system diseases, detect early signs of serious health issues, and provide guidance on preventive care. They treat conditions such as fever, infections, respiratory problems, diabetes, hypertension, digestive issues, and fatigue, among many others.\r\n\r\nThis department plays a crucial role in routine health check-ups, long-term disease management, and referral coordination to specialized departments when advanced care is needed. With a strong focus on continuity of care, general physicians ensure that patients receive timely and appropriate treatment, follow-ups, and lifestyle advice.\r\n\r\n✅ Highlights:\r\nDiagnosis and treatment of general medical conditions\r\n\r\nManagement of chronic diseases like diabetes, hypertension, and asthma\r\n\r\nRoutine health screenings and physical exams\r\n\r\nPreventive healthcare and lifestyle counseling\r\n\r\nTreatment of infections, allergies, and seasonal illnesses\r\n\r\nPatient education and wellness support\r\n\r\nCoordination with specialists for advanced care\r\n\r\n24/7 OPD and inpatient care services\r\n\r\nThe General Physician Department is the foundation of patient-centered care, ensuring early intervention, health maintenance, and coordinated treatment across all age groups.', '2025-07-04 02:16:36', '2025-08-14 01:40:30', NULL, 'department_image/nfTRE41XLf1jdHzIlOR6w9QY3qcMoSxPyELbA80I.jpg', 1500.45),
(8, 'General Medicine', '🩺 General Medicine Department – Description\r\nThe General Medicine Department, also known as Internal Medicine, is the cornerstone of adult healthcare, specializing in the diagnosis, treatment, and management of a wide range of non-surgical medical conditions. Staffed by experienced physicians (commonly called General Physicians or Internal Medicine Specialists), this department plays a key role in preventive care, acute illness management, and chronic disease control.\r\n\r\nPatients often consult the General Medicine Department for symptoms such as fever, fatigue, infections, breathing difficulty, headaches, chest pain, digestive issues, and more. It also manages long-term conditions like diabetes, hypertension, thyroid disorders, anemia, and autoimmune diseases.\r\n\r\nGeneral physicians take a holistic and systemic approach, addressing multiple organ systems and coordinating care with other specialties when necessary. The department also provides health check-ups, vaccination advice, lifestyle counseling, and early disease detection to promote long-term wellness.\r\n\r\n✅ Highlights:\r\nManagement of fever, infections, and seasonal illnesses\r\n\r\nTreatment of chronic diseases: diabetes, hypertension, thyroid, etc.\r\n\r\nEvaluation of unexplained symptoms (fatigue, weight loss, breathlessness)\r\n\r\nPreventive health screenings and general check-ups\r\n\r\nInpatient and outpatient care for non-surgical medical conditions\r\n\r\nCoordination with specialists (e.g., cardiologists, nephrologists) as needed\r\n\r\nPre-operative medical evaluations\r\n\r\nLifestyle and diet counseling for disease prevention\r\n\r\nWith a focus on comprehensive, continuous, and compassionate care, the General Medicine Department is often the first step in the patient’s healthcare journey, ensuring accurate diagnosis and timely treatment across a wide range of conditions.', '2025-07-04 02:18:11', '2025-08-14 01:38:44', NULL, 'department_image/AiANXN9hSef60qiQSa7WIyBoDmrIp9LTMAStUbjC.jpg', 1500.45),
(9, 'Oncology Department', '🎗️ Oncology Department – Description\r\nThe Oncology Department specializes in the diagnosis, treatment, and management of cancer. Our multidisciplinary team of medical oncologists, surgical oncologists, radiation oncologists, pathologists, and palliative care specialists work together to provide comprehensive, compassionate, and cutting-edge cancer care.\r\n\r\nThe department treats all types of cancer, including breast, lung, colon, prostate, cervical, blood cancers (like leukemia and lymphoma), and rare tumors. Each patient receives a personalized treatment plan that may include chemotherapy, radiation therapy, immunotherapy, targeted therapy, or surgery.\r\n\r\nIn addition to treatment, the department offers early detection screenings, cancer risk assessments, pain and symptom management, nutritional support, and counseling services to support patients and their families through every stage of their journey.\r\n\r\nThe Oncology Department also plays a crucial role in cancer prevention education, awareness programs, and survivorship care.\r\n\r\n✅ Highlights:\r\nComprehensive cancer diagnosis and staging\r\n\r\nChemotherapy and targeted therapy administration\r\n\r\nRadiation therapy (external beam, IMRT, brachytherapy)\r\n\r\nCancer surgery and tumor removal\r\n\r\nCancer screening and awareness programs\r\n\r\nBone marrow and stem cell transplant (in advanced centers)\r\n\r\nSupportive and palliative care services\r\n\r\nNutritional, psychological, and survivorship support\r\n\r\nOur mission is to fight cancer with compassion and precision, combining clinical expertise with emotional support to help patients lead healthier, fuller lives during and after treatment.', '2025-07-04 02:19:08', '2025-08-14 01:20:57', NULL, 'department_image/zD3ZsteoqwvsldM96GnWmuDqZKOXwjQx94ap3YnY.jpg', 2500.45),
(10, 'Dental', 'Our Dental Department is dedicated to providing comprehensive oral health care for patients of all ages. We offer a full range of dental services, including preventive care, restorative treatments, cosmetic dentistry, and oral surgery. Our experienced dentists use advanced equipment and modern techniques to ensure comfortable, safe, and effective treatment. From routine check-ups and cleanings to complex procedures like root canal therapy, crowns, and implants, we focus on maintaining healthy smiles and improving overall oral health.\r\n\r\nSample Pricing:\r\n\r\nGeneral Dental Consultation: ₹500\r\n\r\nTeeth Cleaning & Polishing: ₹1,200\r\n\r\nTooth Filling (per tooth): ₹800 – ₹1,500\r\n\r\nRoot Canal Treatment: ₹4,000 – ₹6,500\r\n\r\nDental Crown (per tooth): ₹6,000 – ₹12,000\r\n\r\nTooth Extraction: ₹800 – ₹2,000\r\n\r\nDental Implants: ₹25,000 – ₹45,000', '2025-08-14 00:53:00', '2025-08-14 00:53:00', NULL, 'department_image/dAJ2eR4A30QOieskwqYBlHIiJH8b5v7ZjY6D86l8.jpg', 500.00),
(11, 'Gynocologist', 'Our Gynecology Department provides specialized care for women’s health, focusing on the diagnosis, treatment, and prevention of disorders affecting the female reproductive system. We offer comprehensive services including routine gynecological check-ups, prenatal and postnatal care, menstrual disorder management, infertility consultation, menopause management, and minimally invasive gynecological surgeries. Our team of experienced gynecologists and obstetricians is committed to ensuring compassionate, confidential, and personalized care for women of all ages.', '2025-08-14 01:44:57', '2025-08-14 01:44:57', NULL, 'department_image/3G7ShLXAYMNX3FswUOpK7DSxJS9NsNLGFCUFraf8.jpg', 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `discharges`
--

CREATE TABLE `discharges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` bigint(20) UNSIGNED NOT NULL,
  `discharge_date` date NOT NULL,
  `discharge_summary` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discharges`
--

INSERT INTO `discharges` (`id`, `admission_id`, `discharge_date`, `discharge_summary`, `created_at`, `updated_at`) VALUES
(1, 37, '2025-08-13', 'Fully Recovered', '2025-08-13 03:38:10', '2025-08-13 03:38:10'),
(2, 37, '2025-08-13', 'Fully Recovered', '2025-08-13 04:00:47', '2025-08-13 04:00:47'),
(3, 38, '2025-08-13', 'Nice Service', '2025-08-13 04:43:03', '2025-08-13 04:43:03'),
(4, 39, '2025-08-25', 'Fully recovered', '2025-08-24 04:43:11', '2025-08-24 04:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `qualifications` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `qualifications`, `phone`, `department_id`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 4, 'MBBS, MD, PHD', '9830440684', 1, 'doctor_profiles/0AGS3hMkCqbR4lgiVLuz69NN9s2Ka6Dll3x5PLt0.jpg', '2025-07-04 08:06:05', '2025-07-04 08:06:05'),
(2, 5, 'MBBS', '7585041939', 7, 'doctor_profiles/AkmF0PafTDb7amxxSIah3IM462RfB5Bx3ba7E4DU.jpg', '2025-07-04 08:11:50', '2025-07-04 08:11:50'),
(3, 6, 'MD Oncologist', '8001507802', 9, 'doctor_profiles/46UbD1hkENGBV640pqWJgbk7Yb5sxhxFUEDOjVek.png', '2025-07-04 08:14:01', '2025-07-04 08:14:01'),
(4, 7, 'MBBS MD PHPD', '9803245602', 6, 'doctor_profiles/wY6nYjsAkIFOdeKSfX40muaFFYKAepKeRZbz657a.png', '2025-07-04 08:16:13', '2025-07-04 08:16:13'),
(6, 19, 'MD, MBBS', '9732045613', 6, 'doctor_profiles/veVPbEtCHo7cg58MbAcvmbvJSrDEdRyeM5NxTxry.jpg', '2025-08-15 00:45:16', '2025-08-15 00:45:16'),
(7, 20, 'MBBS', '9904561270', 10, 'doctor_profiles/nonDgzz4YVvQ2Cge9bUmDjJKPCYlsktU4gwHE1cv.jpg', '2025-08-15 00:48:17', '2025-08-15 00:48:17'),
(8, 21, 'MS , MBBS', '9532045600', 11, 'doctor_profiles/ZJkwMyyb9R603MVLhxYm8YQc3v2npZCi6Yj7PUaW.jpg', '2025-08-15 00:51:18', '2025-08-15 00:51:18');

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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `patient_id`, `rating`, `message`, `created_at`, `updated_at`) VALUES
(1, 3, 5, 'Nice Services', '2025-08-13 03:38:39', '2025-08-13 03:38:39'),
(2, 2, 1, 'not satisfied', '2025-08-13 04:01:18', '2025-08-13 04:01:18'),
(3, 7, 4, 'nice Service', '2025-08-13 04:43:22', '2025-08-13 04:43:22'),
(4, 3, 5, 'Nice service', '2025-08-24 04:49:53', '2025-08-24 04:49:53');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `diagnosis` text NOT NULL,
  `prescription` text DEFAULT NULL,
  `test_file` varchar(255) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `diagnosis`, `prescription`, `test_file`, `file_type`, `created_at`, `updated_at`, `appointment_id`, `patient_id`, `doctor_id`) VALUES
(6, 'Acute Upper Respiratory Tract Infection (URTI)\r\n\r\nMild Fever with Cough & Sore Throat', 'Paracetamol 500 mg – 1 tablet every 6 hours (for fever & pain relief)\r\n\r\nAzithromycin 500 mg – 1 tablet daily after lunch (for 3 days)\r\n\r\nCough Syrup (Ambroxol + Terbutaline + Guaifenesin) – 10 ml twice daily\r\n\r\nVitamin C Tablets – 1 tablet daily for 10 days', 'medical_record/ghaV86JFIW9mjtEJagwGfHkVEDZA7NUga2NM7po6.pdf', 'pdf', '2025-08-23 08:28:22', '2025-08-23 08:32:52', 16, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `dosage` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `category`, `stock`, `manufacturer`, `dosage`, `expiry_date`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Perasitamal', 'fever', 25, '20/05/2025', 3, '2028-05-23', 'For Any fever', '2025-07-23 01:54:55', '2025-07-23 01:54:55'),
(3, 'placeat', 'Capsule', 418, 'Feest-Considine', 710, '2027-06-03', 'Cumque eligendi cum officiis perspiciatis ab vitae facilis at.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(4, 'ut', 'Capsule', 12, 'Parker-Crist', 950, '2027-02-25', 'Enim ut aliquid architecto ex perspiciatis non id deleniti et.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(5, 'vitae', 'Tablet', 231, 'Reilly, Rosenbaum and Goldner', 154, '2026-11-26', 'Perspiciatis vero voluptatibus sit expedita omnis provident tempore.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(6, 'atque', 'Capsule', 260, 'Romaguera, Wunsch and Daugherty', 487, '2026-12-24', 'Iste nobis qui sequi ut corrupti aut.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(7, 'qui', 'Tablet', 74, 'Gleichner, Hansen and Gislason', 355, '2026-12-05', 'Et eos rerum nihil accusamus commodi pariatur.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(8, 'rem', 'Syrup', 258, 'Heller Ltd', 351, '2026-12-23', 'Voluptate iste inventore ipsam suscipit voluptatem ut sunt.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(9, 'aut', 'Tablet', 278, 'Casper-Gulgowski', 970, '2026-10-20', 'Quia quisquam libero laudantium praesentium ut assumenda odio ipsa.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(10, 'in', 'Capsule', 367, 'Bartoletti-Conroy', 123, '2027-04-04', 'Laborum temporibus quibusdam laboriosam voluptatibus unde itaque explicabo.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(11, 'blanditiis', 'Injection', 397, 'Kshlerin-Schoen', 507, '2026-06-29', 'Corporis recusandae accusantium fugit id ut ut.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(12, 'dolor', 'Capsule', 449, 'Goyette, Keeling and Sauer', 414, '2026-07-11', 'Perferendis est vel modi vitae ullam quis dolores.', '2025-07-31 02:14:43', '2025-07-31 02:14:43'),
(13, 'aut', 'Injection', 78, 'Simonis Ltd', 240, '2027-07-30', 'Adipisci maiores sit qui unde possimus quas accusantium occaecati reiciendis.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(14, 'excepturi', 'Capsule', 327, 'Cole, Glover and Tremblay', 910, '2026-08-10', 'Consectetur sapiente aliquam est cumque ea aliquid ut.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(15, 'dolores', 'Capsule', 119, 'Langworth Inc', 244, '2026-08-11', 'Quis incidunt repellendus sit dicta.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(16, 'consequatur', 'Tablet', 413, 'Larson, Schuppe and Jerde', 926, '2027-01-31', 'Deserunt nemo quae aut soluta iusto est vel ut.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(17, 'est', 'Capsule', 150, 'Johnston-Toy', 288, '2026-05-31', 'Incidunt consequuntur assumenda quo maiores et animi.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(18, 'natus', 'Injection', 219, 'Tromp PLC', 995, '2026-09-30', 'At nostrum expedita tenetur blanditiis explicabo dolores.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(19, 'qui', 'Syrup', 166, 'Cremin, Luettgen and King', 212, '2027-06-01', 'Sed aliquam dicta ipsa qui laborum sunt et vero sed esse.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(20, 'aliquid', 'Syrup', 64, 'Jerde-Abshire', 405, '2026-07-08', 'Quo voluptatum possimus nam numquam ea id temporibus.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(21, 'recusandae', 'Tablet', 71, 'Schmitt, Wiegand and Harvey', 813, '2026-04-10', 'Eaque dolores magnam officia et totam et sed.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(22, 'unde', 'Injection', 316, 'Emmerich PLC', 578, '2026-05-29', 'Dolorem corporis dignissimos voluptatum nihil repellat molestiae nisi.', '2025-07-31 02:16:40', '2025-07-31 02:16:40'),
(23, 'voluptatem', 'Capsule', 410, 'Hickle Ltd', 416, '2026-03-21', 'Consequatur ipsa quaerat cupiditate ullam ut corporis exercitationem eos.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(24, 'reiciendis', 'Injection', 124, 'Bailey PLC', 664, '2027-03-25', 'Perferendis harum optio et quaerat dignissimos.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(25, 'quia', 'Capsule', 88, 'Crist-Rippin', 445, '2027-02-27', 'Sed hic minus quia cupiditate aspernatur dolores quibusdam expedita.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(26, 'autem', 'Tablet', 101, 'Dooley, Toy and Ferry', 212, '2026-08-15', 'Dolore corrupti ullam est facere ea dolorem ea impedit est.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(27, 'incidunt', 'Syrup', 329, 'Mante, Reichel and Green', 995, '2026-10-11', 'Voluptas velit ratione nemo explicabo est enim.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(28, 'et', 'Tablet', 142, 'Mayer PLC', 353, '2026-09-02', 'Esse sed veritatis voluptatem facilis cupiditate maxime aut architecto non at.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(29, 'voluptas', 'Syrup', 180, 'Mertz-Botsford', 894, '2027-03-27', 'Voluptas quaerat nesciunt accusamus quidem atque quia necessitatibus ipsum voluptatem.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(30, 'ut', 'Syrup', 448, 'Ferry, Schuppe and Torp', 826, '2027-02-17', 'Ut repellendus accusantium sit quia quos.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(31, 'eum', 'Injection', 365, 'Wehner, Deckow and Gutmann', 743, '2026-04-15', 'Et quis velit et et omnis qui ut.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(32, 'animi', 'Injection', 276, 'Oberbrunner-Altenwerth', 852, '2026-10-11', 'Officiis vel exercitationem impedit et illo reprehenderit maxime voluptatem exercitationem totam.', '2025-07-31 02:16:44', '2025-07-31 02:16:44'),
(33, 'aut', 'Injection', 487, 'Farrell PLC', 560, '2027-06-18', 'Assumenda praesentium ex vero veniam.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(34, 'tempore', 'Tablet', 466, 'Pfeffer, White and Barrows', 551, '2026-04-16', 'Quia debitis sunt non quae modi commodi voluptas possimus autem.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(35, 'voluptatem', 'Tablet', 241, 'Schamberger, Dietrich and Price', 248, '2027-06-15', 'Voluptatem nihil vel et odio perspiciatis rerum.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(36, 'voluptatum', 'Capsule', 437, 'Ankunding, Strosin and Hyatt', 252, '2027-02-21', 'Consequuntur omnis nam dolores harum ullam nemo quos laborum nisi.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(37, 'tempora', 'Capsule', 293, 'Douglas, Armstrong and O\'Conner', 820, '2026-12-31', 'Id mollitia beatae dicta consequatur tempora eos sed consequatur.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(38, 'nemo', 'Capsule', 382, 'Marks-Boyle', 176, '2026-07-26', 'Doloribus eveniet minus saepe veniam et ullam praesentium repudiandae non quas.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(39, 'et', 'Syrup', 193, 'Lebsack PLC', 134, '2026-09-19', 'Aut repellendus voluptatem quidem aut tempore atque totam.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(40, 'in', 'Tablet', 363, 'Harris LLC', 938, '2027-06-27', 'Rerum et blanditiis sint ea voluptas perspiciatis velit enim.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(41, 'voluptate', 'Capsule', 219, 'Walsh, Gleason and Pagac', 461, '2027-01-11', 'Est nesciunt officia eveniet modi error.', '2025-07-31 02:16:45', '2025-07-31 02:16:45'),
(42, 'consequatur', 'Tablet', 101, 'Walker-Doyle', 187, '2026-09-29', 'Quasi voluptatem hic nisi maiores cupiditate autem expedita debitis voluptatem.', '2025-07-31 02:16:45', '2025-07-31 02:16:45');

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
(14, '2014_10_12_000000_create_users_table', 1),
(15, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(18, '2025_06_28_094443_create_departments_table', 1),
(19, '2025_06_28_130139_create_permission_tables', 1),
(20, '2025_06_28_163110_add_deleted_at_to_departments_table', 1),
(21, '2025_06_29_054852_create_doctors_table', 1),
(22, '2025_06_29_151512_create_patients_table', 1),
(23, '2025_06_30_142337_add_deleted_at_to_patients_table', 1),
(24, '2025_06_30_145803_create_appointments_table', 1),
(25, '2025_07_04_063457_add_permission_slug_to_permission_table', 1),
(26, '2025_07_04_125625_create_medical_records_table', 2),
(27, '2025_07_06_073122_create_admissions_table', 3),
(28, '2025_07_06_073137_create_discharges_table', 3),
(29, '2025_07_07_064823_add_discharge_column_to_admissions_table', 4),
(30, '2025_07_14_074828_add_cancelled_by_to_appointments_table', 5),
(31, '2025_07_15_103210_create_admins_table', 6),
(32, '2025_07_19_064940_create_wards_table', 7),
(33, '2025_07_19_065346_create_beds_table', 8),
(34, '2025_07_20_053450_create_medicines_table', 9),
(35, '2025_08_01_093559_create_feedback_table', 10),
(36, '2025_08_02_042750_create_payments_table', 11),
(37, '2025_08_02_061856_add_column_amount_to_admissions_table', 12),
(38, '2025_08_02_082853_payments_table', 13),
(39, '2025_08_04_044953_add_column_appointment_number_to_appointments_table', 14),
(40, '2025_08_10_061634_add_status_column_to_patients_table', 15),
(41, '2025_08_10_062717_alter_patient_id_column_in_appointments_table', 16),
(42, '2025_08_10_063447_add_booked_by_column_to_appointments_table', 17),
(43, '2025_08_10_063958_add_name_and_email_to_appointments_table', 18),
(44, '2025_08_13_162355_add_column_department_image_and_price_to_department_table', 19),
(45, '2025_08_14_064957_change_pricing_column_in_departments_table', 20),
(46, '2025_08_15_073327_create_services_table', 21),
(47, '2025_08_15_080511_add_column_price_and_status_to_services_table', 22),
(48, '2025_08_16_103307_create_blogs_table', 23),
(49, '2025_08_16_164824_add_author_foreign_to_blogs_table', 24),
(50, '2025_08_17_062607_rename_author_to_author_id_in_blogs_table', 25),
(51, '2025_08_17_101843_add_author_fields_to_blogs_table', 26),
(52, '2025_08_17_154044_create_comments_table', 27),
(53, '2025_08_18_040027_add_fields_name_and_email_to_comments_table', 28),
(54, '2025_08_20_153130_create_contacts_table', 29);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('tanubasuchoudhury1997@gmail.com', '$2y$10$mA4ROuV9ydumPZ8akcKOqultAsiU7v54MCbJU3aFIkgbQzUImumcm', '2025-08-25 03:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `DOB` varchar(255) NOT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `post_office` varchar(50) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `patient_image` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `status` enum('active','deactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `DOB`, `pincode`, `city`, `state`, `post_office`, `country`, `gender`, `phone`, `patient_image`, `address`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, '1935-02-18', '732101', 'Malda', 'West Bengal', 'Rabindra Avenue', 'India', 'female', '9046540802', 'patient_image/1753936625-jpg', 'No.1 Govt.colony Rabindra Avenue PIN:732101', 'active', '2025-07-04 02:34:23', '2025-07-31 00:20:15', NULL),
(2, 8, '2025-07-07', NULL, NULL, NULL, NULL, NULL, 'male', '8074016203', 'patientimage/1751786349-jpg', 'Bandra Mumbai', 'active', '2025-07-06 01:49:09', '2025-07-06 01:49:09', NULL),
(3, 9, '1982-09-21', NULL, NULL, NULL, NULL, NULL, 'female', '9851045620', 'patientimage/1751986525-jpeg', 'Bandra Mumbai', 'active', '2025-07-08 09:25:25', '2025-07-08 09:25:25', NULL),
(4, 12, '1985-09-16', NULL, NULL, NULL, NULL, NULL, 'female', '9820045023', 'patientimage/1753687941-jpeg', 'Mumbai Bandra', 'active', '2025-07-28 02:02:21', '2025-07-28 02:02:21', NULL),
(6, 14, '2025-07-30', '400050', NULL, 'Maharashtra', NULL, 'India', 'female', '9800456123', 'patientimage/1753864529-jpeg', 'Bandra Mumbai', 'active', '2025-07-30 03:05:29', '2025-07-30 03:05:29', NULL),
(7, 17, '1997-08-12', '732101', 'Malda', 'West Bengal', 'Baluchar', 'India', 'male', '7008524560', 'patient_image/1lewqiqZ95RqGmK1laeSCRTaehbKu9taSEa7sAR2.jpg', 'Allahabad Uttar Pradesh', 'active', '2025-08-12 07:28:32', '2025-08-13 09:56:13', NULL),
(8, 18, '1976-12-15', '400050', 'Mumbai', 'Maharashtra', 'Bandra West', 'India', 'male', '8540456013', 'patient_image/U6HioVHVsa5Vv9BW4AAFcmmMKNS8lGYWsFRcGfks.jpg', 'Bandra Mumbai', 'active', '2025-08-12 07:34:29', '2025-08-14 00:08:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 1500.00,
  `payment_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'Online',
  `transaction_id` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `appointment_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `patient_id`, `admission_id`, `amount`, `payment_status`, `payment_method`, `transaction_id`, `paid_at`, `notes`, `created_at`, `updated_at`, `appointment_id`) VALUES
(6, 3, NULL, 1500.00, 'Paid', 'Online', 'pay_R2ib9AVHJqpHxc', '2025-08-07 23:34:53', NULL, '2025-08-07 23:27:49', '2025-08-07 23:34:53', 9),
(7, 1, NULL, 1500.00, 'Paid', 'Online', 'pay_R2kCIuJtDbGETk', '2025-08-08 01:08:45', NULL, '2025-08-08 01:08:20', '2025-08-08 01:08:45', 10),
(8, 2, NULL, 1500.00, 'Pending', 'Razorpay', 'order_R2kMyRn8nbHRfr', '2025-08-08 01:18:35', NULL, '2025-08-08 01:18:35', '2025-08-08 01:18:35', 11),
(9, 3, NULL, 1500.00, 'Paid', 'Online', 'pay_R2kagJSPROFiZL', '2025-08-08 01:31:49', NULL, '2025-08-08 01:30:56', '2025-08-08 01:31:49', 12),
(10, 3, NULL, 1500.00, 'Pending', 'Razorpay', 'order_R2kaY0vlaD4DSH', NULL, NULL, '2025-08-08 01:31:26', '2025-08-08 01:31:26', 12),
(12, NULL, NULL, 1500.00, 'Paid', 'Online', 'pay_R3hu2DSEMryvkz', '2025-08-10 11:33:05', NULL, '2025-08-10 11:33:05', '2025-08-10 11:33:05', NULL),
(13, NULL, NULL, 1500.00, 'Paid', 'Online', 'pay_R4Kcz4StQ7apOY', '2025-08-12 01:25:59', NULL, '2025-08-12 01:25:59', '2025-08-12 01:25:59', NULL),
(14, 1, 36, 1500.00, 'Pending', 'Pay at Admission', NULL, NULL, NULL, '2025-08-12 10:58:08', '2025-08-12 10:58:08', NULL),
(15, 2, 37, 1500.00, 'Paid', 'Razorpay', 'pay_R4UQN9XfeC1P3M', '2025-08-12 11:00:58', NULL, '2025-08-12 11:00:58', '2025-08-12 11:00:58', NULL),
(16, 7, 38, 1500.00, 'Paid', 'Razorpay', 'pay_R4Uwl1xTHrkZEr', '2025-08-12 11:31:37', NULL, '2025-08-12 11:31:37', '2025-08-12 11:31:37', NULL),
(17, 3, 39, 1500.00, 'Paid', 'Razorpay', 'pay_R4gcGnjaweI3Ct', '2025-08-12 22:56:36', NULL, '2025-08-12 22:56:36', '2025-08-12 22:56:36', NULL),
(18, 8, NULL, 1500.00, 'Paid', 'Online', 'pay_R4sYim8aa0xTOw', '2025-08-13 10:37:32', NULL, '2025-08-13 10:37:08', '2025-08-13 10:37:32', 26),
(19, 8, NULL, 1500.00, 'Paid', 'Online', 'pay_R4sewKJWVcYpkQ', '2025-08-13 10:43:24', NULL, '2025-08-13 10:43:01', '2025-08-13 10:43:24', 28),
(20, NULL, NULL, 1500.00, 'Pending', 'Pay Later', NULL, NULL, NULL, '2025-08-18 23:33:47', '2025-08-18 23:33:47', 30),
(21, NULL, NULL, 1500.00, 'Pending', 'Pay Later', NULL, NULL, NULL, '2025-08-19 00:09:57', '2025-08-19 00:09:57', 31),
(22, NULL, NULL, 1500.00, 'Paid', 'Online', 'pay_R75PChALCdA2QB', '2025-08-19 00:29:32', NULL, '2025-08-19 00:29:32', '2025-08-19 00:29:32', NULL),
(23, NULL, NULL, 1500.00, 'Paid', 'Online', 'pay_R8o721nAk6FnXL', '2025-08-23 08:52:34', NULL, '2025-08-23 08:49:37', '2025-08-23 08:52:34', 17),
(24, 8, 40, 1500.00, 'Pending', 'Pay at Admission', NULL, NULL, NULL, '2025-08-24 04:38:50', '2025-08-24 04:38:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission_slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `permission_slug`) VALUES
(1, 'Show role', 'web', '2025-07-04 01:18:20', '2025-07-04 01:18:20', 'access_role'),
(2, 'Create Role', 'web', '2025-07-04 01:19:55', '2025-07-04 01:19:55', 'create_role'),
(3, 'Edit Role', 'web', '2025-07-04 01:20:18', '2025-07-04 01:20:18', 'edit_role'),
(4, 'Delete Role', 'web', '2025-07-04 01:27:05', '2025-07-04 01:27:05', 'delete_role'),
(5, 'Show Permission', 'web', '2025-07-04 01:30:35', '2025-07-04 01:30:35', 'access_permission'),
(6, 'Create Permission', 'web', '2025-07-04 01:34:55', '2025-07-04 01:34:55', 'create_permision'),
(7, 'Edit Permission', 'web', '2025-07-04 01:35:55', '2025-07-04 01:35:55', 'edit_permission'),
(8, 'Delete Permission', 'web', '2025-07-04 01:37:33', '2025-07-04 01:37:33', 'delete_permission'),
(9, 'Appointment Show', 'web', '2025-07-04 01:40:31', '2025-07-04 01:40:31', 'access_appointment'),
(10, 'Create Appointment', 'web', '2025-07-04 01:41:09', '2025-07-04 01:41:09', 'create_appointment'),
(11, 'Edit Appointment', 'web', '2025-07-04 01:42:08', '2025-07-04 01:42:08', 'edit_appointment'),
(12, 'Delete Appointment', 'web', '2025-07-04 01:43:17', '2025-07-04 01:43:17', 'delete_appointment'),
(13, 'Show User', 'web', '2025-07-04 01:43:56', '2025-07-04 01:43:56', 'access_user'),
(14, 'Create User', 'web', '2025-07-04 01:44:32', '2025-07-04 01:44:32', 'create_user'),
(15, 'Edit User', 'web', '2025-07-04 01:45:05', '2025-07-04 01:45:05', 'edit_user'),
(16, 'Delete User', 'web', '2025-07-04 01:45:51', '2025-07-04 01:50:22', 'delete_user'),
(17, 'Upload Medical Record', 'web', '2025-07-07 01:56:21', '2025-07-07 01:56:21', 'upload_medical_record'),
(18, 'View Patient', 'web', '2025-07-07 01:59:08', '2025-07-07 01:59:08', 'access_patient'),
(19, 'Update Permission', 'web', '2025-07-08 01:17:02', '2025-07-08 01:17:02', 'update_permission'),
(20, 'View Doctors', 'web', '2025-07-08 01:21:18', '2025-07-08 01:21:18', 'access_doctor'),
(21, 'Create Doctor', 'web', '2025-07-08 01:22:35', '2025-07-08 01:22:35', 'create_doctor'),
(22, 'Edit Doctor', 'web', '2025-07-08 01:25:59', '2025-07-08 01:25:59', 'edit_doctor'),
(24, 'View Department', 'web', '2025-07-08 01:40:37', '2025-07-08 01:40:37', 'access_department'),
(25, 'Create Department', 'web', '2025-07-08 01:44:20', '2025-07-08 01:44:20', 'create_department'),
(26, 'Edit Department', 'web', '2025-07-08 01:45:58', '2025-07-08 01:45:58', 'edit_department'),
(27, 'Download Medical Report', 'web', '2025-07-08 02:19:11', '2025-07-08 02:19:11', 'download_report'),
(28, 'Create Medial Report', 'web', '2025-07-09 02:40:20', '2025-07-09 02:40:20', 'create_medical_record'),
(29, 'view admission', 'web', '2025-07-14 08:31:58', '2025-07-14 08:31:58', 'view_admission'),
(30, 'create admission', 'web', '2025-07-14 08:32:29', '2025-07-14 08:32:29', 'create_admission'),
(31, 'Edit Admission', 'web', '2025-07-14 08:32:58', '2025-07-14 08:32:58', 'edit_admission'),
(32, 'Hospital Mangement', 'web', '2025-07-23 02:09:15', '2025-07-23 02:09:15', 'hospital_management'),
(33, 'Profile Setting_access', 'web', '2025-08-12 07:47:11', '2025-08-12 07:58:00', 'profile_setting_access'),
(34, 'access_hospital_management', 'web', '2025-08-12 08:27:57', '2025-08-12 08:27:57', 'access_hospital_management'),
(35, 'add_ward_access', 'web', '2025-08-12 08:33:38', '2025-08-12 08:42:21', 'add_ward_access'),
(36, 'edit_ward_access', 'web', '2025-08-12 08:42:00', '2025-08-12 08:42:00', 'edit_ward_access'),
(37, 'delete_ward_access', 'web', '2025-08-12 08:43:07', '2025-08-12 08:43:07', 'delete_ward_access'),
(38, 'add_bed_access', 'web', '2025-08-12 08:46:10', '2025-08-12 08:46:10', 'add_bed_access'),
(39, 'edit_bed_access', 'web', '2025-08-12 08:48:36', '2025-08-12 08:48:36', 'edit_bed_access'),
(40, 'delete_bed_access', 'web', '2025-08-12 08:49:00', '2025-08-12 08:49:00', 'delete_bed_access'),
(41, 'add_medicine_access', 'web', '2025-08-12 08:53:17', '2025-08-12 08:55:27', 'add_medicine_access'),
(42, 'edit_medicine_access', 'web', '2025-08-12 08:53:44', '2025-08-12 08:53:44', 'edit_medicine_access'),
(43, 'admission_discharge_access', 'web', '2025-08-12 11:34:42', '2025-08-12 11:34:42', 'admission_discharge_access'),
(44, 'add_admission_access', 'web', '2025-08-12 23:46:14', '2025-08-12 23:46:14', 'add_admission_access'),
(45, 'edit_admission_access', 'web', '2025-08-12 23:47:14', '2025-08-12 23:47:14', 'edit_admission_access'),
(46, 'See_total_patient', 'web', '2025-08-13 01:16:57', '2025-08-13 01:16:57', 'See_total_patient'),
(47, 'see_total_doctor', 'web', '2025-08-13 01:18:00', '2025-08-13 01:18:00', 'See_total_doctor'),
(48, 'see_total_appointment', 'web', '2025-08-13 01:18:59', '2025-08-13 01:18:59', 'See_total_patient'),
(49, 'see_total_bed', 'web', '2025-08-13 01:19:45', '2025-08-13 01:19:45', 'see_total_bed'),
(50, 'see_total_ward', 'web', '2025-08-13 01:20:40', '2025-08-13 01:20:40', 'see_total_ward'),
(51, 'see_total_department', 'web', '2025-08-13 01:23:04', '2025-08-13 01:23:04', 'see_total_department'),
(52, 'see_total_users', 'web', '2025-08-13 01:26:33', '2025-08-13 01:26:33', 'see_total_users'),
(53, 'see_total_roles', 'web', '2025-08-13 01:27:25', '2025-08-13 01:27:25', 'see_total_roles'),
(54, 'see_total_permission', 'web', '2025-08-13 01:28:23', '2025-08-13 01:28:23', 'see_total_permission'),
(55, 'access_service', 'web', '2025-08-16 09:39:53', '2025-08-16 09:39:53', 'access_service'),
(56, 'access_service_view', 'web', '2025-08-16 09:40:14', '2025-08-16 09:40:14', 'access_service_view'),
(57, 'access_edit_service', 'web', '2025-08-16 09:40:40', '2025-08-16 09:40:40', 'access_edit_service'),
(58, 'access_delete_service', 'web', '2025-08-16 09:41:07', '2025-08-16 09:41:07', 'access_delete_service'),
(59, 'access_blog', 'web', '2025-08-16 09:42:30', '2025-08-16 09:42:30', 'access_blog'),
(60, 'access_edit_blog', 'web', '2025-08-16 09:43:22', '2025-08-16 09:43:22', 'access_edit_blog'),
(61, 'access_view_blog', 'web', '2025-08-16 09:43:45', '2025-08-16 09:43:45', 'access_view_blog'),
(62, 'access_delete_blog', 'web', '2025-08-16 09:44:21', '2025-08-16 09:44:21', 'access_delete_blog'),
(63, 'blog_access', 'web', '2025-08-20 23:55:26', '2025-08-20 23:55:26', 'blog_access');

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
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-07-04 01:38:17', '2025-07-04 01:38:17'),
(2, 'Doctor', 'web', '2025-07-04 01:38:27', '2025-07-04 01:38:27'),
(3, 'Patient', 'web', '2025-07-04 02:33:25', '2025-07-04 02:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(6, 2),
(9, 2),
(9, 3),
(10, 3),
(11, 2),
(12, 2),
(15, 2),
(17, 2),
(18, 2),
(20, 2),
(20, 3),
(21, 2),
(24, 1),
(24, 3),
(27, 2),
(28, 2),
(33, 2),
(33, 3),
(34, 3),
(43, 3),
(46, 2),
(47, 3),
(48, 2),
(48, 3),
(49, 2),
(49, 3),
(50, 2),
(50, 3),
(51, 2),
(51, 3),
(59, 2),
(59, 3),
(60, 2),
(61, 2),
(62, 2);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 1000.00,
  `status` enum('active','deactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `icon`, `description`, `link`, `created_at`, `updated_at`, `price`, `status`) VALUES
(1, 'Emergency Care', 'fa-user-md', 'Quick and efficient emergency medical services.', NULL, '2025-08-15 03:51:37', '2025-08-16 02:00:23', 1000.00, 'active'),
(3, 'Operation & Surgery', 'fa-procedures', 'State-of-the-art surgical facilities.', NULL, '2025-08-16 02:22:32', '2025-08-16 02:22:59', 500000.00, 'active'),
(4, 'Outdoor Checkup', 'fa-stethoscope', 'Convenient outpatient checkups.', NULL, '2025-08-16 02:23:50', '2025-08-16 02:23:50', 800.00, 'deactive'),
(5, 'Ambulance Service', 'fa-ambulance', '24/7 ambulance service for emergencies.', NULL, '2025-08-16 02:25:16', '2025-08-16 02:25:16', 1000.00, 'active'),
(6, 'Laboratory Test', 'fa-vials', 'Accurate and quick pathology and diagnostic tests.', NULL, '2025-08-16 02:26:05', '2025-08-16 02:26:05', 1200.00, 'active'),
(7, 'Radiology & Imaging', 'fa-x-ray', 'dvanced imaging like X-ray, CT, MRI & Ultrasound.', NULL, '2025-08-16 02:30:28', '2025-08-16 02:30:28', 2500.00, 'active'),
(8, 'Maternity Care', 'fa-baby', 'Specialized care for pregnancy, childbirth & newborns.', NULL, '2025-08-16 02:31:21', '2025-08-16 02:31:21', 4000.00, 'active'),
(9, 'Dental Care', 'fa-tooth', 'Comprehensive dental treatments and oral care.', NULL, '2025-08-16 02:32:08', '2025-08-16 02:32:08', 1500.00, 'active'),
(10, 'Physiotherapy', 'fa-running', 'Professional physiotherapy and rehabilitation services.', NULL, '2025-08-16 02:32:48', '2025-08-16 02:32:48', 1000.00, 'active'),
(11, 'Neurology', 'fa-brain', 'Treatment for neurological disorders and brain care.', NULL, '2025-08-16 02:37:02', '2025-08-16 02:37:02', 3500.00, 'active'),
(12, 'Dermatology', 'fa-allergies', 'Skin, hair, and cosmetic dermatology treatments.', NULL, '2025-08-16 02:37:43', '2025-08-16 02:37:43', 1200.00, 'active'),
(13, 'ICU & Critical Care', 'fa-procedures', 'Advanced intensive care unit for critical patients.', NULL, '2025-08-16 02:38:55', '2025-08-16 02:38:55', 8000.00, 'active'),
(14, 'Nutrition & Diet', 'fa-apple-alt', 'Personalized nutrition and diet consultation.', NULL, '2025-08-16 02:39:44', '2025-08-16 02:39:44', 500.00, 'active');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tanusree Basu Choudhury', 'tanubasuchoudhury1997@gmail.com', NULL, '$2y$10$l18.OWdYaqdMHxLVGu1uf.26A9C0d/skT.AMbJ1a.mwrVaPnlyWeu', NULL, '2025-07-04 01:13:29', '2025-08-17 00:18:05'),
(3, 'Maya Rani Basu Choudhury', 'mayaranibasuchoudhury@gmail.com', NULL, '$2y$10$jZv13quMpeY7GUAxQ7Ch/eDUNxlNuDN9h32GLMW0suNK6toBJgKui', NULL, '2025-07-04 02:34:23', '2025-07-04 02:34:23'),
(4, 'Dr.Nimai Das', 'maamonoshaelectric1978@gmail.com', NULL, '$2y$10$QtHADJ3JcyezqOppGqC1UuRIjIvhOWZVeTaIQ3pMsBh48wHTMUTcO', NULL, '2025-07-04 08:06:05', '2025-07-04 08:14:23'),
(5, 'Dr.Souradyuti Majumder', 'sourodyutimajumder7@gmail.com', NULL, '$2y$10$piykEbdkAM032ZvO2iq.UuW1zWyxK67rm2eQDWgqgQDX//EuCAbsi', NULL, '2025-07-04 08:11:50', '2025-07-04 08:11:50'),
(6, 'Dr.Suresh Mehra', 'sureshmehra@gmail.com', NULL, '$2y$10$SqsTA/0Pmn/4bKubls8ifu01b1qnrt.O1cad2fr9BlHaWHfILQkma', NULL, '2025-07-04 08:14:00', '2025-08-17 08:24:36'),
(7, 'Karanveer Bohra', 'karanveer@gmail.com', NULL, '$2y$10$3yxNBJvC5bO3hqOFLZSewe6Ceklh1whD9tb9F9TYuR8bSC0Ll/K9a', NULL, '2025-07-04 08:16:13', '2025-07-04 08:16:13'),
(8, 'Rithik Roshan', 'rithikroshan1974@gmail.com', NULL, '$2y$10$NRh3e42s3IPNXHY1OQNz2.nlxI4C9PBIr/NcE1lh72ZNcwkklB/zO', NULL, '2025-07-06 01:49:09', '2025-07-06 01:49:09'),
(9, 'Kareena Kapoor', 'kareenakapoor@gmail.com', NULL, '$2y$10$IL8G8s8xMjoIsTmVCCx9o.dGtKGYVBRQq0wHIP4k6Vmr35JtfEAOu', NULL, '2025-07-08 09:25:25', '2025-07-08 09:25:25'),
(10, 'Krish Kapoor', 'krishkapoor@gmail.com', NULL, '$2y$10$TiHj3rEx83UEjSE2Iz0Zk.RWKsbPdRhLqwtE5AuUp/4VQbAzuEGsm', NULL, '2025-07-25 01:12:36', '2025-07-25 01:12:36'),
(12, 'Bipasa Basu', 'bipasabasu@gmail.com', NULL, '$2y$10$Bt7OGFVqei/1cLZAwhCGleOgOeh5.nmzeLgs4i/Gy1eQARCHKhMQu', NULL, '2025-07-28 02:02:21', '2025-07-28 02:02:21'),
(14, 'Riya Sen', 'riyasen1983@gmail.com', NULL, '$2y$10$CaVQvQlsxEUb4/MyOinq1u9rYZoAP8nfKxE2BnsJ7CBRrUnsHulNy', NULL, '2025-07-30 03:05:29', '2025-07-30 03:05:29'),
(17, 'Krishna Kumar', 'krishnakumar@gmail.com', NULL, '$2y$10$pMaD5NE0eRD4GxE.rRkSrOziWuetjrgFZYo4qr9YyJHQNb5mnNx0y', NULL, '2025-08-12 07:28:32', '2025-08-13 04:49:56'),
(18, 'Karan Virani', 'karanvirani@gmail.com', NULL, '$2y$10$bZcg6OUJ5KZKAvq1XRnYIOtNq9rMAuZfy/6ckfU9srv.JzGhiU96S', NULL, '2025-08-12 07:34:29', '2025-08-12 07:34:29'),
(19, 'Dr. Karan Sahrma', 'karansharma@gmail.com', NULL, '$2y$10$Kn40ONAuYoOdFnVXRjkaXOg5l2z0eIJ19JwcVz2AgwSJzfJ7L5Al.', NULL, '2025-08-15 00:45:16', '2025-08-15 00:45:16'),
(20, 'Dr. Ritesh Pandey', 'riteshpandey@gmail.com', NULL, '$2y$10$uZERiGCoi9S3QoteDxzkD.arwKGUl5DnrJoBHKF.8M3McKM8nEjXu', NULL, '2025-08-15 00:48:17', '2025-08-15 00:48:17'),
(21, 'Dr. Nilesh Deshmukh', 'nileshdeshmukh@gmail.com', NULL, '$2y$10$p0dpoXBRX1M6/A687uK6euc5HhNCKy.TXnaopTFQ9w1hzfZ61PNVe', NULL, '2025-08-15 00:51:18', '2025-08-15 00:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE `wards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id`, `name`, `capacity`, `description`, `created_at`, `updated_at`) VALUES
(1, 'General Ward', 30, 'This ward is for regular patients who don’t need special care', '2025-07-21 01:20:08', '2025-07-29 08:05:45'),
(3, 'ICU', 10, 'Intensive Care Unit for critical patients', '2025-07-29 08:06:56', '2025-07-29 08:06:56'),
(4, 'Pediatric Ward', 20, 'Ward for children and infants', '2025-07-29 08:52:45', '2025-07-29 08:52:45'),
(5, 'Maternity Ward', 25, 'For mothers before and after delivery', '2025-07-29 08:54:13', '2025-07-29 08:54:13'),
(6, 'Surgical Ward', 18, 'Post-surgery care and observation ward.', '2025-07-29 09:23:57', '2025-07-29 09:23:57'),
(7, 'Emergency Ward', 12, 'Used for patients with contagious diseases', '2025-07-29 09:26:04', '2025-07-29 09:26:04'),
(8, 'Psychiatric Ward', 10, 'For patients with mental health conditions', '2025-07-29 09:26:39', '2025-07-29 09:26:39'),
(9, 'Burn Unit', 8, 'Specialized ward for burn injury treatment', '2025-07-29 09:27:27', '2025-07-29 09:27:27'),
(10, 'Burn Unit', 8, 'Specialized ward for burn injury treatment', '2025-07-29 09:27:31', '2025-07-29 09:27:31'),
(11, 'Cardiology Ward', 20, 'For patients with heart-related conditions', '2025-07-29 09:28:15', '2025-07-29 09:28:15'),
(12, 'Neurology Ward', 16, 'For patients with neurological disorders', '2025-07-29 09:29:17', '2025-07-29 09:29:17'),
(13, 'Oncology Ward', 22, 'For cancer treatment and chemotherapy patients', '2025-07-29 09:30:04', '2025-07-29 09:30:04'),
(14, 'Dialysis Unit', 14, 'Ward for patients undergoing dialysis.', '2025-07-29 09:30:43', '2025-07-29 09:30:43'),
(15, 'Orthopedic Ward', 18, 'For bone, joint, and musculoskeletal injuries', '2025-07-29 09:31:25', '2025-07-29 09:31:25'),
(16, 'COVID-19 Isolation Ward', 20, 'Special ward for COVID-19 positive patients', '2025-07-29 09:32:38', '2025-07-29 09:32:38'),
(17, 'COVID-19 Isolation Ward', 20, 'Special ward for COVID-19 positive patients', '2025-07-29 09:32:39', '2025-07-29 09:32:39'),
(18, 'Geriatric Ward\'', 15, 'For elderly patients with age-related conditions.', '2025-07-29 09:33:24', '2025-07-29 09:33:24'),
(19, 'Postnatal Ward', 10, 'For mothers after childbirth', '2025-07-29 09:34:37', '2025-07-29 09:34:37'),
(20, 'Preoperative Ward', 10, 'For patients before surgical procedures', '2025-07-29 09:35:19', '2025-07-29 09:35:19'),
(21, 'Rehabilitation Ward', 10, 'Physical therapy and rehabilitation services', '2025-07-29 09:36:06', '2025-07-29 09:36:06'),
(22, 'ENT Ward', 8, 'For ear, nose, and throat related treatments', '2025-07-29 09:36:43', '2025-07-29 09:36:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_user_id_foreign` (`user_id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admissions_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_department_id_foreign` (`department_id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beds_ward_id_foreign` (`ward_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_blog_id_foreign` (`blog_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `discharges`
--
ALTER TABLE `discharges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discharges_admission_id_foreign` (`admission_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`),
  ADD KEY `doctors_department_id_foreign` (`department_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medical_records_appointment_id_foreign` (`appointment_id`),
  ADD KEY `medical_records_patient_id_foreign` (`patient_id`),
  ADD KEY `medical_records_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_patient_id_foreign` (`patient_id`),
  ADD KEY `payments_admission_id_foreign` (`admission_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `discharges`
--
ALTER TABLE `discharges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `wards`
--
ALTER TABLE `wards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_blog_id_foreign` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discharges`
--
ALTER TABLE `discharges`
  ADD CONSTRAINT `discharges_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `medical_records_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
