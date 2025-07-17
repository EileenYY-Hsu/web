-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-06-12 15:27:27
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `tamkang confession version`
--

-- --------------------------------------------------------

--
-- 資料表結構 `account`
--

CREATE TABLE `account` (
  `StudentName` varchar(50) DEFAULT NULL,
  `Password` varchar(20) NOT NULL,
  `StudentID` int(20) NOT NULL,
  `Gender` tinyint(1) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `FacultID` int(11) DEFAULT NULL,
  `Anonymous` tinyint(1) DEFAULT NULL,
  `Introduce` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `account`
--

INSERT INTO `account` (`StudentName`, `Password`, `StudentID`, `Gender`, `Email`, `FacultID`, `Anonymous`, `Introduce`) VALUES
('林冠榕', '930523', 0, 0, 'linpoma@gmail.com', 20, 1, NULL),
('光頭強', '123', 123, 1, '123@gmail.com', 15, 0, '789'),
('光頭', '138', 138, 0, '138@gmail.com', 19, 0, NULL),
('讚', '666', 666, 0, 'good@gmail.com', 37, 0, NULL),
('778', '777', 777, 0, '10@gmail.com', 19, 1, '7777777777777777777'),
('789', '789', 789, 0, '789@gmail.com', 14, 1, '789789'),
('熊大', '999', 999, 0, '999@gmail.com', 18, 0, NULL),
('光頭不強', '1234', 1234, 0, '1234@gmail.com', 19, 1, NULL);

-- --------------------------------------------------------

--
-- 資料表結構 `articlecontent`
--

CREATE TABLE `articlecontent` (
  `PostID` int(20) NOT NULL,
  `StudentID` int(20) NOT NULL,
  `Content` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `articlecontent`
--

INSERT INTO `articlecontent` (`PostID`, `StudentID`, `Content`) VALUES
(1, 123, '34567'),
(2, 1234, '真不錯呀'),
(3, 123, '12\r\n3 4  5\r\n       6'),
(4, 123, '123456');

-- --------------------------------------------------------

--
-- 資料表結構 `comment`
--

CREATE TABLE `comment` (
  `PostID` int(100) NOT NULL,
  `CommentID` int(100) NOT NULL,
  `CommentContent` varchar(1500) NOT NULL,
  `StudentID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `comment`
--

INSERT INTO `comment` (`PostID`, `CommentID`, `CommentContent`, `StudentID`) VALUES
(4, 1, '認真看報告的不是帥哥就是美女', 123),
(4, 2, '認真看報告的不是美女就是帥哥', 777),
(3, 3, '早安各位', 777),
(4, 4, '123', 123),
(4, 5, 'O3生快', 0),
(4, 6, '祝大家每學期都歐趴~~~~~~~!', 123);

-- --------------------------------------------------------

--
-- 資料表結構 `facult`
--

CREATE TABLE `facult` (
  `FacultID` int(11) NOT NULL,
  `FacultName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 傾印資料表的資料 `facult`
--

INSERT INTO `facult` (`FacultID`, `FacultName`) VALUES
(1, 'Department of Chinese Literature'),
(2, 'Department of History'),
(3, 'Department of Information and Library Science'),
(4, 'Department of Mass Communication'),
(5, 'Department of Information and Communication'),
(6, 'Department of Mathematics'),
(7, 'Department of Physics'),
(8, 'Department of Chemistry'),
(9, 'Department of Architecture'),
(10, 'Department of Civil Engineering'),
(11, 'Department of Water Resources and Environmental Engineering'),
(12, 'Department of Mechanical and Electro-Mechanical Engineering'),
(13, 'Department of Chemical and Materials Engineering'),
(14, 'Department of Electrical and Computer Engineering'),
(15, 'Department of Computer Science and Information Engineering'),
(16, 'Department of Aerospace Engineering'),
(17, 'Department of International Business'),
(18, 'Department of Banking and Finance'),
(19, 'Department of Risk Management and Insurance'),
(20, 'Department of Industrial Economics'),
(21, 'Department of Economics'),
(22, 'Department of Business Administration'),
(23, 'Department of Accounting'),
(24, 'Department of Statistics'),
(25, 'Department of Information Management'),
(26, 'Department of Transportation Management'),
(27, 'Department of Public Administration'),
(28, 'Department of Management Sciences'),
(29, 'Department of English'),
(30, 'Department of Spanish'),
(31, 'Department of French'),
(32, 'Department of German'),
(33, 'Department of Japanese'),
(34, 'Department of Russian'),
(35, 'Department of Educational Technology'),
(36, 'Education and Futures Design'),
(37, 'Artificial Intelligence'),
(38, 'Department of Diplomacy and International Relations'),
(39, 'Department of International Tourism Management'),
(40, 'Department of Global Politics and Economics');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `UserNumber` (`StudentID`),
  ADD UNIQUE KEY `UserName` (`StudentName`);

--
-- 資料表索引 `articlecontent`
--
ALTER TABLE `articlecontent`
  ADD PRIMARY KEY (`PostID`);

--
-- 資料表索引 `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`CommentID`);

--
-- 資料表索引 `facult`
--
ALTER TABLE `facult`
  ADD PRIMARY KEY (`FacultID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `articlecontent`
--
ALTER TABLE `articlecontent`
  MODIFY `PostID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
