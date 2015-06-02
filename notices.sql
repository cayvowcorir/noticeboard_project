-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2015 at 11:08 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `notice`
--

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
`notice_no` int(11) NOT NULL,
  `noticeboard_no` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `file_ext` varchar(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `desc` text NOT NULL,
  `date_expiry` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`notice_no`, `noticeboard_no`, `type`, `file_ext`, `title`, `desc`, `date_expiry`, `date_added`, `date_updated`) VALUES
(1, 1, 1, '', 'kevin1-1', 'Kevin 1-1 desc', '2015-02-04 00:00:00', '2015-01-06 16:22:51', '2015-01-06 16:22:51'),
(2, 1, 1, '', 'Kevin5', 'Kevin5- ycy gv yvivyvuytvh', '2015-02-02 00:00:00', '2015-01-06 19:10:18', '2015-01-06 19:10:18'),
(3, 1, 1, '', 'Kevin', 'hk cuyt yvygiiygoh', '2015-02-10 00:00:00', '2015-01-06 21:42:04', '2015-01-06 21:42:04'),
(4, 1, 1, '', 'Kevinhkjh', 'Khjhkjjy t tutc', '2015-02-10 00:00:00', '2015-01-06 21:44:11', '2015-01-06 21:44:11'),
(5, 1, 1, '', 'hkjhkjhjk', 'gjhghggggggg', '2015-02-12 00:00:00', '2015-01-06 22:09:47', '2015-01-06 22:09:47'),
(6, 1, 1, '', 'KKK', 'kevinnnmgfjh', '2015-02-13 00:00:00', '2015-01-07 07:16:40', '2015-01-07 07:16:40'),
(7, 1, 1, '', 'Starttt', 'Kevinnn', '2015-02-13 00:00:00', '2015-01-07 07:17:27', '2015-01-07 07:17:27'),
(8, 1, 1, '', 'jkjkjklj', 'jkjkjkljjk jkjkljjk  ', '2015-02-13 00:00:00', '2015-01-07 07:17:54', '2015-01-07 07:17:54'),
(9, 1, 1, '', 'kjhkjhjk', 'hjhkjj', '2015-02-09 00:00:00', '2015-01-07 07:18:24', '2015-01-07 07:18:24'),
(10, 1, 1, '', 'Kevin', 'this is a description', '2015-02-11 00:00:00', '2015-01-07 09:53:08', '2015-01-07 09:53:08'),
(11, 1, 1, '', 'kevin11', 'jkljkjj', '2015-02-04 00:00:00', '2015-01-07 13:36:42', '2015-01-07 13:36:42'),
(13, 1, 1, 'jpg', 'KEvin 2', 'Desc 2 blah blah blah', '2015-02-04 00:00:00', '2015-01-14 04:50:06', '2015-01-14 04:50:06'),
(12, 1, 1, 'jpg', 'Kev image', 'Kevin Notice image', '2015-02-11 00:00:00', '2015-01-13 18:14:52', '2015-01-13 18:14:52'),
(14, 1, 1, 'jpg', 'Kevin 3', 'hhjkhkj', '2015-03-01 00:00:00', '2015-01-14 04:54:39', '2015-01-14 04:54:39'),
(15, 1, 1, 'jpg', 'Kevin 4', 'kevv', '2015-03-01 00:00:00', '2015-01-14 04:55:25', '2015-01-14 04:55:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
 ADD PRIMARY KEY (`notice_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
MODIFY `notice_no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
