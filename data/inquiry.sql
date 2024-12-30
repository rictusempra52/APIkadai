-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-12-30 05:04:18
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
  `room_no` text NOT NULL,
  `inquiry` text NOT NULL,
  `deadline` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- テーブルのデータのダンプ `inquiry`
--

INSERT INTO `inquiry` (`id`, `room_no`, `inquiry`, `deadline`, `created_at`, `updated_at`) VALUES
(1, '103', '%E3%81%B5%E3%81%81%E3%81%86%E3%81%87', '2047-02-08', '2024-12-30 12:47:05', '2024-12-30 12:47:05'),
(2, '103', '%E3%81%B5%E3%81%81%E3%81%86%E3%81%87', '2047-02-08', '2024-12-30 12:48:32', '2024-12-30 12:48:32'),
(3, 'G-2', '%E5%8C%BA%E5%88%86%E6%89%80%E6%9C%89%E8%80%85%E5%A4%89%E6%9B%B4%E5%B1%8A%E3%82%92%E3%81%BB%E3%81%97%E3%81%84', '2024-12-30', '2024-12-30 12:59:16', '2024-12-30 12:59:16');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
