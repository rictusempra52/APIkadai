-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-01-28 01:38:02
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mskanriapp`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_no` text NOT NULL,
  `inquiry` text NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `inquiry`
--

INSERT INTO `inquiry` (`id`, `user_id`, `room_no`, `inquiry`, `deadline`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, '103', '%E3%81%B5%E3%81%81%E3%81%86%E3%81%87', '2047-02-08', '2024-12-30 12:47:05', '2024-12-30 12:47:05', '2025-01-12 11:31:33'),
(2, 0, '103', '%E3%81%B5%E3%81%81%E3%81%86%E3%81%87', '2047-02-08', '2024-12-30 12:48:32', '2024-12-30 12:48:32', '2025-01-12 18:08:59'),
(3, 0, 'G-2', '%E5%8C%BA%E5%88%86%E6%89%80%E6%9C%89%E8%80%85%E5%A4%89%E6%9B%B4%E5%B1%8A%E3%82%92%E3%81%BB%E3%81%97%E3%81%84', '2024-12-30', '2024-12-30 12:59:16', '2024-12-30 12:59:16', '2025-01-14 23:53:25'),
(4, 0, '104', '%E3%81%95%E3%81%B5%E3%81%81%EF%BD%86++++++++++++++++++++++++++++++++++++++++++++', '1111-02-03', '2025-01-01 14:21:08', '2025-01-01 14:21:08', '2025-01-15 23:06:49'),
(5, 0, '104', '%E3%81%A8%E3%81%84%E3%81%82was', '2025-01-17', '2025-01-01 14:33:54', '2025-01-15 23:51:07', '2025-01-15 23:53:55'),
(6, 0, '104', '%E3%81%95', '2058-02-03', '2025-01-01 14:35:15', '2025-01-18 10:48:35', '2025-01-18 10:50:01'),
(7, 0, '104', '%E3%81%95%E3%81%B5%E3%81%81%EF%BD%86++++++++++++++++++++++++++++++++++++++++++++', '1111-02-03', '2025-01-01 14:47:53', '2025-01-01 14:47:53', '2025-01-18 10:50:02'),
(8, 0, '201', '%E3%81%93%E3%82%93%E3%81%AB%E3%81%AF', '2025-05-14', '2025-01-01 18:38:43', '2025-01-15 23:53:51', '2025-01-18 10:50:04'),
(9, 0, '104', '%E3%81%95%E3%81%B5%E3%81%81%EF%BD%86', '2025-02-03', '2025-01-04 15:04:58', '2025-01-04 15:04:58', '2025-01-18 10:50:07'),
(10, 0, '103', 'fawe', '2047-02-08', '2025-01-04 15:28:57', '2025-01-04 15:28:57', '2025-01-18 10:57:25'),
(11, 0, 'さ', '%E3%81%A0%EF%BD%86', '2047-01-08', '2025-01-11 12:18:38', '2025-01-11 12:18:38', '2025-01-18 10:52:02'),
(12, 0, 'G-2', '%E5%8C%BA%E5%88%86%E6%89%80%E6%9C%89%E8%80%85%E5%A4%89%E6%9B%B4%E5%B1%8A%E3%82%92%E3%81%BB%E3%81%84', '2045-12-30', '2025-01-14 23:53:11', '2025-01-18 15:07:09', NULL),
(13, 0, '104', '%E3%81%95%E3%81%B5%E3%81%81%EF%BD%86', '2025-01-29', '2025-01-14 23:53:32', '2025-01-14 23:53:32', '2025-01-23 02:08:11'),
(14, 0, '104', 'konnnitiha', '2025-10-22', '2025-01-14 23:54:03', '2025-01-15 23:20:12', NULL),
(15, 0, '１９８７５', '%E3%81%82%EF%BD%86%E3%81%82', '2025-01-16', '2025-01-15 00:09:37', '2025-01-15 23:14:00', NULL),
(16, 0, '104', '%E3%81%82%E3%81%B0%E3%81%B0%E3%81%B0%E3%81%A3%E3%81%B0%E3%81%B0%E3%81%B0%E3%81%A3%E3%81%B0%E3%81%B0', '2025-01-17', '2025-01-15 00:10:03', '2025-01-15 00:52:33', '2025-01-18 15:15:50'),
(17, 0, '103', 'asf', '2033-07-23', '2025-01-18 15:07:22', '2025-01-18 15:07:22', '2025-01-18 15:07:27');

-- --------------------------------------------------------

--
-- テーブルの構造 `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` varchar(128) NOT NULL,
  `building_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `building_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '101', 1, '2025-01-27 23:46:08', '2025-01-27 23:46:08', NULL),
(2, '102', 1, '2025-01-27 23:49:17', '2025-01-27 23:49:51', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `user_type` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'rictusempra52@gmail.com', 'lssm4833', 0, '2025-01-20 14:56:05', '2025-01-20 14:56:05', NULL),
(2, 'r@r', '$2y$10$pICqHJekQjtwRy3RQ0cSqOvhhrprL9wGnhMQ5VZolH7F2mzAb5TAC', 0, '2025-01-20 23:40:11', '2025-01-20 23:40:11', NULL),
(3, 'r-p8sakamoto@dln.jp', '$2y$10$YUcnezHZp9fO08x1VqZ.cuzFBXzFBJWzFEWPi71AwKFciCrI/q/G6', 0, '2025-01-28 08:05:24', '2025-01-28 08:05:24', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `user_rooms`
--

CREATE TABLE `user_rooms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_type` (`user_type`);

--
-- テーブルのインデックス `user_rooms`
--
ALTER TABLE `user_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- テーブルの AUTO_INCREMENT `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- テーブルの AUTO_INCREMENT `user_rooms`
--
ALTER TABLE `user_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `user_rooms`
--
ALTER TABLE `user_rooms`
  ADD CONSTRAINT `user_rooms_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `user_rooms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
