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
(1, '中國文學學系'),
(2, '歷史學系'),
(3, '資訊與圖書館學系'),
(4, '大眾傳播學系'),
(5, '資訊傳播學系'),
(6, '數學學系'),
(7, '物理學系'),
(8, '化學學系'),
(9, '建築學系'),
(10, '土木工程學系'),
(11, '水資源及環境工程學系'),
(12, '機械與機電工程學系'),
(13, '化學工程與材料工程學系'),
(14, '電機工程學系'),
(15, '資訊工程學系'),
(16, '航空太空工程學系'),
(17, '國際企業學系'),
(18, '財務金融學系'),
(19, '風險管理與保險學系'),
(20, '產業經濟學系'),
(21, '經濟學系'),
(22, '企業管理學系'),
(23, '會計學系'),
(24, '統計學系'),
(25, '資訊管理學系'),
(26, '運輸管理學系'),
(27, '公共行政學系'),
(28, '管理科學學系'),
(29, '英文學系'),
(30, '西班牙語文學系'),
(31, '法國語文學系'),
(32, '德國語文學系'),
(33, '日本語文學系'),
(34, '俄國語文學系'),
(35, '教育科技學系'),
(36, '教育與未來設計學系'),
(37, '人工智慧學系'),
(38, '外交與國際關係學系'),
(39, '國際觀光管理學系'),
(40, '全球政治經濟學系');

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
