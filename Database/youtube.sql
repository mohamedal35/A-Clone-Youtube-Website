-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2020 at 09:39 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `youtube`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Sports'),
(2, 'Music'),
(3, 'Favorites/Best'),
(4, 'Gaming'),
(5, 'Vlogs'),
(6, 'Comedy/Skit'),
(7, 'Film & Animation'),
(8, 'Autos & Vehicles'),
(9, 'Pets & Animals'),
(10, 'Travel & Events'),
(11, 'People & Blogs'),
(12, 'Education'),
(13, 'Science & Technology');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postedBy` varchar(255) NOT NULL,
  `videoId` int(11) NOT NULL,
  `responseTo` int(11) NOT NULL,
  `body` text NOT NULL,
  `datePosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postedBy`, `videoId`, `responseTo`, `body`, `datePosted`) VALUES
(1, 'moali', 3, 0, 'Thanks For This Greate Tutorial :)', '2020-03-25 09:19:19'),
(2, 'moali', 2, 0, 'I Hope You Like Video :)', '2020-03-25 09:34:07'),
(3, 'moali', 1, 0, '225 Views WOOOW!!!!', '2020-03-25 09:36:32'),
(4, 'ah2020', 3, 1, 'Not Much', '2020-03-25 09:42:56'),
(5, 'moali', 3, 4, 'OK', '2020-03-25 10:11:04'),
(6, 'moali', 3, 1, 'OK', '2020-03-25 10:14:57'),
(7, 'moali', 3, 4, 'asdasd', '2020-03-25 10:23:58'),
(8, 'moali', 3, 7, 'asdasd', '2020-03-25 10:24:05'),
(9, 'moali', 3, 8, 'vv', '2020-03-25 10:27:58'),
(10, 'moali', 3, 9, 'asd', '2020-03-25 10:31:02'),
(11, 'moali', 3, 9, 'bvxbxcv', '2020-03-25 10:31:13'),
(12, 'moali', 3, 11, 'asdasd', '2020-03-25 10:31:53'),
(13, 'moali', 3, 12, 'ÙŠØ§Ø±Ø¨', '2020-03-25 10:32:41'),
(14, 'moali', 3, 13, 'finally', '2020-03-25 10:33:45'),
(15, 'moali', 5, 0, 'Hope You Like It', '2020-03-27 06:48:16'),
(16, 'ah2020', 5, 15, 'Thanks For This Great Job :)', '2020-03-27 06:49:05'),
(17, 'moali', 6, 0, 'Greate!!', '2020-03-27 08:39:09'),
(18, 'moali', 3, 0, 'alert(&#34;Hacked!!!&#34;);', '2020-03-30 01:48:56'),
(19, 'ra2020', 2, 2, 'Good Video :)', '2020-04-01 18:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `commentId` int(11) NOT NULL,
  `videoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dislikes`
--

INSERT INTO `dislikes` (`id`, `username`, `commentId`, `videoId`) VALUES
(18, 'ah2020', 0, 1),
(19, 'am2020', 0, 6),
(20, 'ah2020', 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `commentId` int(11) NOT NULL,
  `videoId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `commentId`, `videoId`) VALUES
(2, 'am2020', 0, 5),
(3, 'moali', 18, 0),
(4, 'moali', 0, 3),
(5, 'ra2020', 0, 2),
(6, 'ra2020', 2, 0),
(7, 'ra2020', 19, 0),
(8, 'moali', 0, 5),
(9, 'moali', 16, 0),
(10, 'ma2020', 0, 6),
(11, 'ah2020', 0, 3),
(12, 'ah2020', 17, 0),
(13, 'moali', 0, 1),
(14, 'moali', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `userTo` varchar(255) NOT NULL,
  `userFrom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `userTo`, `userFrom`) VALUES
(9, 'moali', 'ah2020'),
(13, 'moali', 'am2020'),
(14, 'ah2020', 'am2020'),
(21, 'am2020', 'moali'),
(22, 'ah2020', 'moali'),
(23, 'moali', 'ra2020'),
(24, 'am2020', 'ma2020'),
(28, 'moali', 'ma2020'),
(29, 'am2020', 'ah2020');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnails`
--

CREATE TABLE `thumbnails` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `selected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thumbnails`
--

INSERT INTO `thumbnails` (`id`, `videoId`, `filePath`, `selected`) VALUES
(1, 1, 'uploads/thumbnails/1-5e3cef6c08818.jpg', 0),
(2, 1, 'uploads/thumbnails/1-5e3cef6c7d3ee.jpg', 0),
(3, 1, 'uploads/thumbnails/1-5e3cef6d10e39.jpg', 1),
(4, 2, 'uploads/thumbnails/2-5e3cf6c6611db.jpg', 1),
(5, 2, 'uploads/thumbnails/2-5e3cf6cdd8fba.jpg', 0),
(6, 2, 'uploads/thumbnails/2-5e3cf6dd024c4.jpg', 0),
(7, 3, 'uploads/thumbnails/3-5e790750ea89b.jpg', 1),
(8, 3, 'uploads/thumbnails/3-5e790754c227e.jpg', 0),
(9, 3, 'uploads/thumbnails/3-5e79075bc2891.jpg', 0),
(10, 5, 'uploads/thumbnails/5-5e7d83fb8fdc1.jpg', 0),
(11, 5, 'uploads/thumbnails/5-5e7d840339b87.jpg', 1),
(12, 5, 'uploads/thumbnails/5-5e7d8411c5359.jpg', 0),
(13, 6, 'uploads/thumbnails/6-5e7d9c36cdbd4.jpg', 1),
(14, 6, 'uploads/thumbnails/6-5e7d9c502f274.jpg', 0),
(15, 6, 'uploads/thumbnails/6-5e7d9c834b2d1.jpg', 0),
(16, 7, 'uploads/thumbnails/7-5e7def72681db.jpg', 0),
(17, 7, 'uploads/thumbnails/7-5e7def84c0006.jpg', 0),
(18, 7, 'uploads/thumbnails/7-5e7defa8cd325.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(26) NOT NULL,
  `lastName` varchar(26) NOT NULL,
  `username` varchar(26) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(260) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wasActived` varchar(8) NOT NULL,
  `activeCode` text NOT NULL,
  `profilePic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `email`, `password`, `signUpDate`, `wasActived`, `activeCode`, `profilePic`) VALUES
(2, 'Ahmed', 'Gamal', 'ah2020', 'ag@gmail.com', 'ca0bd55c8dad557aece1700af601b92f94bc77d900f68a951c474ce332d3a7b7aaa3c30a764b45af368eed3cca88f02b8a263dae33152035fd7ad8fa05de37cc', '2020-03-22 22:34:26', 'TRUE', '0', 'assets/images/profilepictures/default.png'),
(3, 'Amr', 'Muhammed', 'am2020', 'aamm@gmail.com', 'ca0bd55c8dad557aece1700af601b92f94bc77d900f68a951c474ce332d3a7b7aaa3c30a764b45af368eed3cca88f02b8a263dae33152035fd7ad8fa05de37cc', '2020-03-27 08:14:56', 'TRUE', '0', 'assets/images/profilepictures/default.png'),
(4, 'Rewan', 'Ali', 'ra2020', 'ra@gmail.com', 'ca0bd55c8dad557aece1700af601b92f94bc77d900f68a951c474ce332d3a7b7aaa3c30a764b45af368eed3cca88f02b8a263dae33152035fd7ad8fa05de37cc', '2020-04-01 17:30:23', 'TRUE', '5e84b38f2b111_moali_5e84b38f2b156', 'assets/images/profilepictures/default.png'),
(7, 'Mohamed', 'Ali', 'moali', 't.hacking88@gmail.com', 'ca0bd55c8dad557aece1700af601b92f94bc77d900f68a951c474ce332d3a7b7aaa3c30a764b45af368eed3cca88f02b8a263dae33152035fd7ad8fa05de37cc', '2020-04-01 18:32:41', 'TRUE', '5e84c20e6de86moali5e84c20e6dec7', 'assets/images/profilepictures/default.png'),
(8, 'Mohamed', 'Ansaf', 'ma2020', 'hamo_ali_2018@mail.ru', 'ca0bd55c8dad557aece1700af601b92f94bc77d900f68a951c474ce332d3a7b7aaa3c30a764b45af368eed3cca88f02b8a263dae33152035fd7ad8fa05de37cc', '2020-04-02 08:37:10', 'TRUE', '5e85880a5c106ma20205e85880a5c3ed', 'assets/images/profilepictures/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `uploaded_by` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `privacy` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) NOT NULL DEFAULT '0',
  `duration` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `uploaded_by`, `title`, `description`, `privacy`, `filePath`, `category`, `uploadDate`, `views`, `duration`) VALUES
(1, 'moali', 'Race (human categorization) ', 'A race is a grouping of humans based on shared physical or social qualities into categories generally viewed as distinct by society. The term was first used to refer to speakers of a common language and then to denote national affiliations. By the 17th century the term began to refer to physical traits', 1, 'uploads/videos/5e3cef620020a.mp4', 1, '2020-02-07 07:02:26', 255, '00:17'),
(2, 'moali', 'Moving The Navbar code to another file (PHP Course)', 'This Is A Piece Of Our Course Which Explain : Moving The Navbar code to another file (PHP Course)', 1, 'uploads/videos/5e3cf63413bbe.mp4', 13, '2020-02-07 07:31:32', 240, '03:26'),
(3, 'ah2020', 'Ethical Hacking Course Introduction', 'This Is The Introduction Of Ethical Course Hacking', 1, 'uploads/videos/5e7906fd1d9a0.mp4', 13, '2020-03-23 20:59:09', 176, '05:34'),
(5, 'moali', 'IELTS Course Intro', 'This Is The Introduction Of IELTS And Download It''s Materials', 1, 'uploads/videos/5e7d838726958.mp4', 12, '2020-03-27 06:39:35', 10, '04:08'),
(6, 'am2020', 'CRUD With Python [PostgreSQL]', 'This Is A Video Of My Course Which I Explain How To Select , insert , delete and update records [PostgreSQL]', 1, 'uploads/videos/5e7d9a5f647dd.mp4', 12, '2020-03-27 08:17:03', 10, '12:51'),
(7, 'moali', 'Advanced Dictionaries', 'From Python Course Explaining Dictionaries', 1, 'uploads/videos/5e7dee057a1a8.mp4', 12, '2020-03-27 14:13:57', 8, '05:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
