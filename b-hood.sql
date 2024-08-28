-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2024 at 02:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b-hood`
--

-- --------------------------------------------------------

--
-- Table structure for table `atm`
--

CREATE TABLE `atm` (
  `ID` int(11) NOT NULL,
  `X` float NOT NULL,
  `Y` float NOT NULL,
  `Z` float NOT NULL,
  `R` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `atm`
--

INSERT INTO `atm` (`ID`, `X`, `Y`, `Z`, `R`) VALUES
(1, 2216.57, 1675.92, 1007.97, 98.9999),
(2, 2255.2, 1678.34, 1007.97, -81.1);

-- --------------------------------------------------------

--
-- Table structure for table `banlog`
--

CREATE TABLE `banlog` (
  `ID` int(11) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `player` varchar(25) NOT NULL,
  `admin` varchar(25) NOT NULL,
  `reason` varchar(60) NOT NULL,
  `day` int(11) NOT NULL DEFAULT 0,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bans`
--

CREATE TABLE `bans` (
  `ID` int(11) NOT NULL,
  `PlayerName` varchar(30) NOT NULL,
  `AdminName` varchar(30) NOT NULL,
  `Reason` varchar(128) NOT NULL,
  `IP` varchar(16) NOT NULL DEFAULT 'NULL',
  `Days` int(11) NOT NULL,
  `Time` int(15) NOT NULL DEFAULT -1,
  `Active` int(11) NOT NULL,
  `Date` varchar(60) NOT NULL DEFAULT '1999-1-1 10:00',
  `Userid` int(11) NOT NULL,
  `ByUserid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bizz`
--

CREATE TABLE `bizz` (
  `ID` int(11) NOT NULL,
  `Owned` int(11) NOT NULL,
  `Owner` varchar(25) NOT NULL DEFAULT 'The State',
  `Type` int(11) NOT NULL,
  `Message` varchar(50) NOT NULL,
  `EntranceX` float NOT NULL,
  `EntranceY` float NOT NULL,
  `EntranceZ` float NOT NULL,
  `ExitX` float NOT NULL,
  `ExitY` float NOT NULL,
  `ExitZ` float NOT NULL,
  `LevelNeeded` int(11) NOT NULL,
  `BuyPrice` int(11) NOT NULL,
  `EntranceCost` int(11) NOT NULL DEFAULT 5000,
  `Till` int(11) NOT NULL,
  `Locked` int(11) NOT NULL,
  `Interior` int(11) NOT NULL,
  `Virtual` int(11) NOT NULL,
  `Radio` int(11) NOT NULL DEFAULT -1,
  `Static` int(11) NOT NULL,
  `Gas` int(11) NOT NULL,
  `Products` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bizz`
--

INSERT INTO `bizz` (`ID`, `Owned`, `Owner`, `Type`, `Message`, `EntranceX`, `EntranceY`, `EntranceZ`, `ExitX`, `ExitY`, `ExitZ`, `LevelNeeded`, `BuyPrice`, `EntranceCost`, `Till`, `Locked`, `Interior`, `Virtual`, `Radio`, `Static`, `Gas`, `Products`) VALUES
(1, 1, 'The State', 6, '24/7', 2063.08, 2308.88, 10.8203, -25.9517, -187.761, 1003.55, 7, 0, 2000, 58500, 0, 17, 1, -1, 0, 0, 0),
(2, 1, 'The State', 7, 'Binco', 2102.14, 2257.42, 11.0234, 207.655, -110.479, 1005.13, 7, 0, 2000, 36000, 0, 15, 2, -1, 0, 0, 0),
(3, 1, 'The State', 9, 'Casino', 1290.96, -1161.12, 23.961, 2234.07, 1714.11, 1012.35, 7, 0, 2000, 32000, 0, 1, 6, -1, 0, 0, 0),
(4, 1, 'Madalin31', 1, 'Banca', 1462.35, -1011.23, 26.8438, 2305.07, -15.9066, 26.7422, 7, 0, 2000, 2000, 0, 0, 4, 1, 0, 0, 0),
(5, 1, 'The State', 1, 'Banca', 2196.58, 1677.17, 12.3672, 2305.07, -15.9066, 26.7422, 7, 0, 2000, 2000, 0, 0, 5, -1, 0, 0, 0),
(6, 1, 'The State', 9, 'Casino', 2017.04, 1916.5, 12.3424, 2234.07, 1714.11, 1012.35, 7, 0, 2000, 6000, 0, 1, 6, -1, 0, 0, 0),
(7, 1, 'The State', 5, 'Sex Shop', 2085.12, 2074.01, 11.0547, -100.354, -25.0326, 1000.72, 7, 0, 2000, 3000, 0, 3, 7, -1, 0, 0, 0),
(8, 1, 'The State', 16, 'Gas Station', 2187.95, 2469.64, 11.2422, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 8, -1, 1, 0, 0),
(9, 1, 'The State', 10, 'CNN', 2868.99, 2438.48, 11.069, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 9, -1, 1, 0, 0),
(10, 1, 'The State', 4, 'Restaurant', 2014.9, 1150.44, 10.8203, -794.96, 489.431, 1376.2, 7, 0, 2000, 2000, 0, 1, 10, -1, 0, 0, 0),
(11, 1, 'The State', 15, 'Paintball', 2186.65, 1113.42, 12.6484, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 11, -1, 1, 0, 0),
(12, 1, 'The State', 2, 'Gun Shop', 2596.12, 1089.14, 10.8222, 285.676, -86.3199, 1001.52, 7, 0, 2000, 2000, 0, 4, 12, -1, 0, 0, 0),
(13, 1, 'The State', 6, '24/7', 2637.19, 1129.51, 11.1797, -25.9517, -187.761, 1003.55, 7, 0, 2000, 17750, 0, 17, 13, -1, 0, 0, 0),
(14, 1, 'The State', 16, 'Gas Station', 2123.88, 914.969, 10.8203, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 14, -1, 1, 0, 0),
(15, 1, 'The State', 6, '24/7', 2194.94, 1990.99, 12.2969, -25.9517, -187.761, 1003.55, 7, 0, 2000, 2000, 0, 17, 15, -1, 0, 0, 0),
(16, 1, 'The State', 8, 'Burger', 1872.25, 2071.86, 11.0625, 363.04, -75.3009, 1001.51, 7, 0, 2000, 2000, 0, 10, 16, -1, 0, 0, 0),
(17, 1, 'The State', 18, 'PNS', 1966.14, 2162.65, 10.8203, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 17, -1, 1, 0, 0),
(18, 1, 'The State', 19, 'Pizza', 2764.23, 2469.39, 11.0625, 372.286, -133.524, 1001.49, 7, 0, 2000, 2000, 0, 5, 18, -1, 0, 0, 0),
(19, 1, 'The State', 7, 'Binco', 2779.65, 2453.67, 11.0625, 207.655, -110.479, 1005.13, 7, 0, 2000, 2000, 0, 15, 19, -1, 0, 0, 0),
(20, 1, 'The State', 2, 'Gun Shop', 2556.99, 2065.36, 11.0995, 285.676, -86.3199, 1001.52, 7, 0, 2000, 2000, 0, 4, 20, -1, 0, 0, 0),
(21, 1, 'The State', 8, 'Burger', 2472.84, 2034.26, 11.0625, 363.04, -75.3009, 1001.51, 7, 0, 2000, 2000, 0, 10, 21, -1, 0, 0, 0),
(22, 1, 'The State', 16, 'Gas Station', 2639.46, 1065.67, 10.8203, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 22, -1, 1, 0, 0),
(23, 1, 'The State', 11, 'Rent Moto', 2200.86, 1394.81, 11.0625, 0, 0, 0, 7, 0, 2000, 122000, 0, 0, 23, -1, 1, 0, 0),
(24, 1, 'The State', 12, 'Rent Car', 2227.35, 1398.33, 11.0625, 0, 0, 0, 7, 0, 2000, 31400, 0, 0, 24, -1, 1, 0, 0),
(25, 1, 'The State', 6, '24/7', 1833.76, -1842.51, 13.5781, -25.9517, -187.761, 1003.55, 7, 0, 2000, 4000, 0, 17, 25, -1, 0, 0, 0),
(26, 1, 'The State', 17, 'Race Arena', 1099.66, 1601.43, 12.5469, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 26, -1, 1, 1, 0),
(27, 1, 'The State', 3, 'Club', 1837.02, -1682.32, 13.3236, 493.397, -24.8437, 1000.68, 7, 0, 2000, 4000, 0, 17, 27, -1, 0, 0, 0),
(28, 1, 'The State', 16, 'Gas Station', 1928.58, -1776.24, 13.5469, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 28, -1, 1, 0, 0),
(29, 1, 'The State', 18, 'PNS', 488.377, -1733.41, 11.1841, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 29, -1, 1, 0, 0),
(30, 1, 'The State', 18, 'PNS', 2073.61, -1831.61, 13.5469, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 30, -1, 1, 0, 0),
(31, 1, 'The State', 19, 'Pizza', 2105.33, -1806.58, 13.5547, 372.286, -133.524, 1001.49, 7, 0, 2000, 2000, 0, 5, 31, -1, 0, 0, 0),
(32, 1, 'The State', 10, 'CNN', 649.291, -1357.32, 13.5672, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 32, -1, 1, 0, 0),
(33, 1, 'The State', 13, 'GYM', 2229.82, -1721.38, 13.5624, 772.302, -4.8968, 1000.73, 7, 0, 2000, 2000, 0, 5, 33, -1, 0, 0, 0),
(34, 1, 'The State', 10, 'CNN', -1782.32, 573.38, 35.1641, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 34, -1, 1, 0, 0),
(35, 1, 'The State', 7, 'Binco', 1456.55, -1137.76, 23.9572, 207.655, -110.479, 1005.13, 7, 0, 2000, 4000, 0, 15, 35, -1, 0, 0, 0),
(36, 1, 'The State', 18, 'PNS', -1904.66, 276.029, 41.0469, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 36, -1, 1, 0, 0),
(37, 1, 'The State', 18, 'PNS', 1024.82, -1031.38, 31.9847, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 37, -1, 1, 0, 0),
(38, 1, 'The State', 20, 'Tunning', 1034.55, -1028.3, 32.1016, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 38, -1, 1, 0, 0),
(39, 1, 'The State', 20, 'Tunning', -1942.84, 238.277, 34.1251, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 39, -1, 1, 0, 0),
(40, 1, 'The State', 14, 'Car Color', 1616.44, -1498.45, 14.2309, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 40, -1, 1, 0, 0),
(41, 1, 'The State', 6, '24/7', 1000.42, -919.976, 42.3281, -25.9517, -187.761, 1003.55, 7, 0, 2000, 4000, 0, 17, 41, -1, 0, 0, 0),
(42, 1, 'The State', 16, 'Gas Station', 1006.22, -930.103, 42.3281, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 42, -1, 1, 0, 0),
(43, 1, 'The State', 16, 'Gas Station', -2410.9, 964.916, 45.4609, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 43, -1, 1, 0, 0),
(44, 1, 'The State', 6, '24/7', -2420.16, 969.855, 45.2969, -25.9517, -187.761, 1003.55, 7, 0, 2000, 4000, 0, 17, 44, -1, 0, 0, 0),
(45, 1, 'The State', 18, 'PNS', -2425.46, 1029.79, 50.3906, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 45, -1, 1, 0, 0),
(46, 1, 'The State', 6, '24/7', -2442.65, 755.418, 35.1719, -25.9517, -187.761, 1003.55, 7, 0, 2000, 10000, 0, 17, 46, -1, 0, 0, 0),
(47, 1, 'The State', 8, 'Burger', -2336.87, -166.736, 35.5547, 363.04, -75.3009, 1001.51, 7, 0, 2000, 2000, 0, 10, 47, -1, 0, 0, 0),
(48, 1, 'The State', 8, 'Burger', -2672.34, 257.94, 4.63281, 363.04, -75.3009, 1001.51, 7, 0, 2000, 2000, 0, 10, 48, -1, 0, 0, 0),
(49, 1, 'The State', 8, 'Burger', -326.047, 821.71, 14.2697, 363.04, -75.3009, 1001.51, 7, 0, 2000, 4000, 0, 10, 49, -1, 0, 0, 0),
(50, 1, 'The State', 7, 'Binco', 1656.85, 1733.25, 10.8281, 207.655, -110.479, 1005.13, 7, 0, 2000, 10500, 0, 15, 50, -1, 0, 0, 0),
(51, 1, 'The State', 5, 'Sex Shop', 1087.64, -922.48, 43.3906, -100.354, -25.0326, 1000.72, 7, 0, 2000, 4000, 0, 3, 51, -1, 0, 0, 0),
(52, 1, 'The State', 2, 'Gun Shop', 1368.84, -1279.85, 13.5469, 285.676, -86.3199, 1001.52, 7, 0, 2000, 340000, 0, 4, 52, -1, 0, 0, 0),
(53, 1, 'The State', 6, '24/7', 1352.35, -1759.25, 13.5078, -25.9517, -187.761, 1003.55, 7, 0, 2000, 2000, 0, 17, 53, -1, 0, 0, 0),
(54, 1, 'The State', 16, 'Gas Station', -2034.87, 148.606, 28.8359, 0, 0, 0, 7, 0, 2000, 2000, 0, 0, 54, -1, 1, 0, 0),
(55, 0, 'The State', 1, 'Banca', -2766.55, 375.614, 6.33468, 2305.07, -15.9066, 26.7422, 7, 0, 2000, 4000, 0, 0, 55, -1, 0, 0, 0),
(56, 1, 'The State', 1, 'Banca', -1492.13, 920.147, 7.1875, 2305.07, -15.9066, 26.7422, 7, 0, 2000, 2000, 0, 0, 56, -1, 0, 0, 0),
(57, 1, 'The State', 19, 'Pizza', 1367.56, 248.225, 19.5669, 372.286, -133.524, 1001.49, 7, 0, 2000, 2000, 0, 5, 57, -1, 0, 0, 0),
(58, 1, 'The State', 6, '24/7', 1642.27, -2334.86, 13.5469, -25.9517, -187.761, 1003.55, 7, 0, 2000, 2000, 0, 17, 58, -1, 0, 0, 0),
(59, 0, 'The State', 7, 'Binco', 1685.62, -2335.07, 13.5469, 207.655, -110.479, 1005.13, 7, 0, 2000, 2000, 0, 15, 59, -1, 0, 0, 0),
(60, 1, 'The State', 21, 'Biliard', 1498.66, -1580.94, 13.5498, 501.981, -69.1501, 998.758, 7, 0, 2000, 10000, 0, 11, 0, -1, 0, 0, 0),
(61, 1, 'The State', 21, 'Biliard', 2089.97, 1514.59, 10.8203, 501.981, -69.1501, 998.758, 7, 0, 2000, 2000, 0, 11, 0, -1, 0, 0, 0),
(62, 1, 'The State', 18, 'PNS', 719.921, -464.703, 16.3359, 0, 0, 0, 7, 0, 5000, 2000, 0, 0, 62, -1, 1, 0, 0),
(63, 0, 'The State', 7, 'Binco', -2178.54, -42.4316, 35.3203, 207.655, -110.479, 1005.13, 4, 1, 5000, 32000, 0, 15, 63, -1, 0, 0, 0),
(64, 0, 'The State', 6, '24/7', -2156.29, 337.305, 35.3203, -25.9517, -187.761, 1003.55, 5, 1, 5000, 16250, 0, 17, 64, -1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `blacklist`
--

CREATE TABLE `blacklist` (
  `ID` int(10) NOT NULL,
  `Userid` int(10) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Faction` int(10) NOT NULL,
  `Reason` int(10) NOT NULL,
  `Added` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `ID` int(11) NOT NULL,
  `Model` int(11) NOT NULL,
  `Locationx` float NOT NULL,
  `Locationy` float NOT NULL,
  `Locationz` float NOT NULL,
  `Angle` float NOT NULL,
  `ColorOne` int(11) NOT NULL,
  `ColorTwo` int(11) NOT NULL,
  `Owner` varchar(25) NOT NULL DEFAULT 'Dealership',
  `Value` int(11) NOT NULL,
  `License` varchar(15) NOT NULL DEFAULT 'LS-01-RGM',
  `Alarm` int(11) NOT NULL,
  `Lockk` int(11) NOT NULL,
  `paintjob` int(11) NOT NULL DEFAULT 3,
  `KM` float NOT NULL,
  `Userid` int(11) NOT NULL DEFAULT 0,
  `Confiscated` int(2) NOT NULL,
  `Points` int(10) NOT NULL DEFAULT 5,
  `Tax` int(10) NOT NULL DEFAULT 50,
  `Fuel` int(10) NOT NULL DEFAULT 100,
  `Neon` int(10) NOT NULL,
  `Text` varchar(256) NOT NULL DEFAULT '-',
  `ColorText` int(11) NOT NULL,
  `Virtual` int(11) NOT NULL,
  `RainBow` int(11) NOT NULL,
  `Stage` int(11) NOT NULL,
  `MaxSpeed` int(11) NOT NULL,
  `Days` int(11) NOT NULL,
  `Temporar` int(11) NOT NULL,
  `TemporarTime` int(11) NOT NULL,
  `VIP` int(11) NOT NULL,
  `Cordonate` varchar(50) NOT NULL DEFAULT '0.0|0.0|0.0|0.0|0.0|0.0',
  `Components` varchar(50) NOT NULL DEFAULT '0|0|0|0',
  `TimeGoto` int(11) NOT NULL,
  `Mods` varchar(50) NOT NULL DEFAULT '0|0|0|0|0|0|0|0|0|0|0|0|0|0',
  `Premium` tinyint(1) NOT NULL,
  `Garage` int(11) NOT NULL DEFAULT -1,
  `NeonObj` varchar(32) NOT NULL DEFAULT '-1|-1',
  `PFuel` tinyint(1) NOT NULL,
  `SNeon` int(11) NOT NULL,
  `Special` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clanhq`
--

CREATE TABLE `clanhq` (
  `ID` int(11) NOT NULL,
  `PosX` float NOT NULL,
  `PosY` float NOT NULL,
  `PosZ` float NOT NULL,
  `EnterX` float NOT NULL,
  `EnterY` float NOT NULL,
  `EnterZ` float NOT NULL,
  `VirtualWorld` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Clan` int(11) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clans`
--

CREATE TABLE `clans` (
  `ID` int(10) NOT NULL,
  `Owner` varchar(64) NOT NULL,
  `OwnerSQL` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Motd` varchar(256) NOT NULL DEFAULT 'Nu este setat.',
  `Tag` varchar(32) NOT NULL,
  `RankName1` varchar(64) NOT NULL DEFAULT 'Rank 1',
  `RankName2` varchar(64) NOT NULL DEFAULT 'Rank 2',
  `RankName3` varchar(64) NOT NULL DEFAULT 'Rank 3',
  `RankName4` varchar(64) NOT NULL DEFAULT 'Rank 4',
  `RankName5` varchar(64) NOT NULL DEFAULT 'Rank 5',
  `RankName6` varchar(64) NOT NULL DEFAULT 'Rank 6',
  `Color` varchar(10) NOT NULL DEFAULT 'FFFFFF',
  `Slots` int(10) NOT NULL,
  `RegisterDate` varchar(64) NOT NULL,
  `Days` int(10) NOT NULL DEFAULT 60,
  `TagType` int(11) NOT NULL,
  `HQ` int(11) NOT NULL,
  `PremiumPoints` int(11) NOT NULL,
  `RankName7` varchar(32) NOT NULL DEFAULT 'Rank 7',
  `Safebox` int(11) NOT NULL,
  `Bonus` int(11) NOT NULL DEFAULT 1,
  `Premium` int(11) NOT NULL,
  `VIP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clanvehicle`
--

CREATE TABLE `clanvehicle` (
  `ID` int(11) NOT NULL,
  `Locationx` float NOT NULL,
  `Locationy` float NOT NULL,
  `Locationz` float NOT NULL,
  `Angle` float NOT NULL,
  `ColorOne` int(11) NOT NULL,
  `ColorTwo` int(11) NOT NULL,
  `Value` int(11) NOT NULL,
  `paintjob` int(11) NOT NULL,
  `Fuel` int(11) NOT NULL DEFAULT 100,
  `RainBow` int(11) NOT NULL,
  `Stage` int(11) NOT NULL,
  `Mods` varchar(50) NOT NULL DEFAULT '0|0|0|0|0|0|0|0|0|0|0|0|0|0',
  `ClanID` int(11) NOT NULL,
  `Rank` int(11) NOT NULL,
  `Model` int(11) NOT NULL DEFAULT 400,
  `VIP` int(11) NOT NULL,
  `TimeGoto` int(11) NOT NULL,
  `Neon` int(11) NOT NULL,
  `NeonObj` varchar(33) NOT NULL DEFAULT '-1 -1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE `commands` (
  `ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dsveh`
--

CREATE TABLE `dsveh` (
  `ID` int(10) NOT NULL,
  `Model` int(11) NOT NULL,
  `Price` int(11) NOT NULL DEFAULT 1,
  `Stock` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `dsveh`
--

INSERT INTO `dsveh` (`ID`, `Model`, `Price`, `Stock`) VALUES
(1, 509, 1250000, 100),
(2, 510, 2500000, 100),
(3, 404, 3350000, 100),
(4, 600, 3900000, 100),
(5, 413, 4200000, 100),
(6, 543, 4720000, 100),
(7, 478, 5550000, 100),
(8, 422, 6050000, 100),
(9, 401, 6325000, 100),
(10, 466, 6100000, 100),
(11, 474, 5000000, 100),
(12, 471, 6900690, 100),
(13, 546, 7000500, 100),
(14, 436, 7230000, 100),
(15, 526, 9000000, 100),
(16, 517, 8000000, 100),
(17, 550, 7800000, 100),
(18, 458, 7770000, 100),
(19, 500, 5750000, 100),
(20, 551, 13300000, 100),
(21, 400, 8500000, 100),
(22, 542, 9520000, 100),
(23, 549, 9700000, 100),
(24, 439, 10000500, 100),
(25, 496, 13250000, 100),
(26, 561, 10000500, 100),
(27, 507, 14300000, 100),
(28, 567, 17600000, 100),
(29, 535, 16000000, 100),
(30, 554, 18350000, 100),
(31, 405, 19805000, 100),
(32, 555, 20000000, 100),
(33, 534, 20000000, 100),
(34, 489, 21500000, 100),
(35, 426, 23550000, 100),
(36, 589, 24000000, 100),
(37, 603, 27102000, 100),
(38, 475, 28700020, 100),
(39, 533, 29999996, 100),
(40, 587, 32000000, 100),
(41, 602, 35250000, 100),
(42, 565, 30250000, 100),
(43, 579, 39870230, 100),
(44, 480, 43220000, 100),
(45, 506, 57050000, 100),
(46, 402, 69999996, 100),
(47, 477, 77007007, 100),
(48, 495, 162000261, 100),
(49, 562, 61000069, 100),
(50, 415, 66000066, 100),
(51, 429, 196000000, 100),
(52, 451, 285000000, 100),
(53, 560, 390000000, 100),
(54, 541, 430000000, 100),
(55, 411, 555555555, 100),
(56, 522, 475000000, 100),
(57, 463, 10000000, 100),
(58, 462, 3000000, 100),
(59, 461, 25000000, 100);

-- --------------------------------------------------------

--
-- Table structure for table `eat_stand`
--

CREATE TABLE `eat_stand` (
  `ID` int(11) NOT NULL,
  `X` float NOT NULL,
  `Y` float NOT NULL,
  `Z` float NOT NULL,
  `Rot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `eat_stand`
--

INSERT INTO `eat_stand` (`ID`, `X`, `Y`, `Z`, `Rot`) VALUES
(1, 2086.27, 2038.88, 10.8103, 0),
(2, 2620.54, 1727.37, 10.7503, -177.5),
(3, 1014.76, 1397.79, 10.6719, -177.8),
(4, 1120.14, 1820.4, 10.8019, -91.4),
(5, 2411.88, 1682.21, 10.7903, 0),
(6, 1908.55, 2077.14, 10.8125, 179.8),
(7, 2022.81, 1701.09, 10.7903, 89),
(8, 2198.73, 1523.89, 10.6719, 89.8),
(9, 2280.15, 955.818, 10.7519, 0),
(10, 2369.86, 640.741, 10.7719, 0),
(11, 2679.7, 759.676, 10.8319, 0),
(12, 2787.2, 890.217, 10.75, 0),
(13, 1577.23, 788.017, 11.1, 0),
(14, 1333.09, -915.631, 36.3597, -104.2),
(15, 1233.28, -922.005, 42.7049, -80),
(16, 976.57, -912.87, 45.7656, -167.3),
(17, 754.387, -1043.24, 23.6672, -59.6),
(18, 665.521, -1761.45, 13.5705, 73.7),
(19, 644.743, -1497.6, 14.8223, -178.9),
(20, 613.024, -1307.09, 14.4883, 90.8),
(21, 1170.2, -1130.46, 23.7954, 0),
(22, 1335.55, -1121.22, 23.7914, 0),
(23, 1650.98, -1153.59, 24.0549, -91.7),
(24, 1195.23, -1704.68, 13.5469, -89.3),
(25, 1073.91, -1816.09, 13.6735, -179.3),
(26, 2165.59, 2355.22, 10.8203, -94.1);

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `ID` int(10) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Text` varchar(256) NOT NULL,
  `By` varchar(64) NOT NULL DEFAULT 'AdmBot',
  `Date` varchar(256) NOT NULL,
  `Read` int(10) NOT NULL,
  `Action` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factionlog`
--

CREATE TABLE `factionlog` (
  `ID` int(11) NOT NULL,
  `Faction` int(11) NOT NULL,
  `Text` varchar(256) NOT NULL,
  `Date` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `factions`
--

CREATE TABLE `factions` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `X` float NOT NULL,
  `Y` float NOT NULL,
  `Z` float NOT NULL,
  `IntX` float NOT NULL,
  `IntY` float NOT NULL,
  `IntZ` float NOT NULL,
  `Interior` int(11) NOT NULL,
  `VW` int(11) NOT NULL,
  `Anunt` varchar(128) NOT NULL DEFAULT 'None',
  `Name1` varchar(64) NOT NULL DEFAULT 'Rank 1',
  `Name2` varchar(64) NOT NULL DEFAULT 'Rank 2',
  `Name3` varchar(64) NOT NULL DEFAULT 'Rank 3',
  `Name4` varchar(64) NOT NULL DEFAULT 'Rank 4',
  `Name5` varchar(64) NOT NULL DEFAULT 'Rank 5',
  `Name6` varchar(64) NOT NULL DEFAULT 'Rank 6',
  `Name7` varchar(64) NOT NULL DEFAULT 'Rank 7',
  `App` int(10) NOT NULL DEFAULT 0,
  `Lock` int(11) NOT NULL DEFAULT 1,
  `MaxMembers` int(3) NOT NULL DEFAULT 0,
  `MinLevel` int(11) NOT NULL DEFAULT 7,
  `sX` float NOT NULL,
  `sY` float NOT NULL,
  `sZ` float NOT NULL,
  `RaportRank1` varchar(30) NOT NULL DEFAULT '0|0|0',
  `RaportRank2` varchar(30) NOT NULL DEFAULT '0|0|0',
  `RaportRank3` varchar(30) NOT NULL DEFAULT '0|0|0',
  `RaportRank4` varchar(30) NOT NULL DEFAULT '0|0|0',
  `RaportRank5` varchar(30) NOT NULL DEFAULT '0|0|0',
  `RaportRank6` varchar(30) NOT NULL DEFAULT '0|0|0',
  `RaportRank7` varchar(30) NOT NULL DEFAULT '0|0|0',
  `vX` float NOT NULL,
  `vY` float NOT NULL,
  `vZ` float NOT NULL,
  `eX` float NOT NULL,
  `eY` float NOT NULL,
  `eZ` float NOT NULL,
  `vRot` float NOT NULL,
  `eRot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `factions`
--

INSERT INTO `factions` (`ID`, `Name`, `X`, `Y`, `Z`, `IntX`, `IntY`, `IntZ`, `Interior`, `VW`, `Anunt`, `Name1`, `Name2`, `Name3`, `Name4`, `Name5`, `Name6`, `Name7`, `App`, `Lock`, `MaxMembers`, `MinLevel`, `sX`, `sY`, `sZ`, `RaportRank1`, `RaportRank2`, `RaportRank3`, `RaportRank4`, `RaportRank5`, `RaportRank6`, `RaportRank7`, `vX`, `vY`, `vZ`, `eX`, `eY`, `eZ`, `vRot`, `eRot`) VALUES
(1, 'Los Santos Police Department', 1555.1, -1675.62, 16.195, 246.78, 63.3446, 1003.64, 6, 1, 'Salut!', '[1] Officer', 'Sergent', '[3] Sergeant', '[4] Lieutenant', '[5] Captain', 'Chestor', 'Chestor General', 0, 0, 15, 10, 1559.64, -1634.72, 13.5494, '30 12 0', '25 10 8', '20 8 5', '15 5 5', '10 5 3', '0|0|0', '0|0|0', 1559.79, -1627.53, 13.1099, 1566.07, -1653.02, 28.5725, 91.1499, 90.7578),
(2, 'Federal Bureau of Investigation', 626.975, -571.419, 17.9207, 238.567, 139.299, 1003.02, 3, 2, 'sedinta duminica viitoare la ora 20:00', 'Detectiv', '[2] Special Agent', '[3] Charge', '[4] Supervisory', 'Chestor', 'Co-Lider', 'Lider', 0, 1, 15, 10, 620.227, -584.447, 17.233, '30 0 0', '25 0 4', '20 0 3', '15 0 2', '10 0 1', '0|0|0', '0|0|0', 627.231, -596.344, 16.3633, 661.407, -584.13, 16.5124, 274.63, 90.4194),
(3, 'National Guard', 154.818, 1903.26, 18.7252, 288.763, 167.704, 1007.17, 3, 3, 'Salut, sa ai o zi frumoasa! Nu uita de raport.', '[1] Private', '[2] Second Lieutenant', '[3] First Lieutenant', '[4] Captain', '[5] Major', '[6] Colonel', '[7] General', 0, 1, 15, 10, 201.372, 1918.61, 17.6406, '40 0 0', '35 0 0', '30 0 0', '25 0 0', '20 0 0', '0|0|0', '0|0|0', 211.357, 1918.64, 17.3677, 307.847, 1802.47, 17.8185, 178.666, 0.614579),
(4, 'Grove Street', 2495.22, -1690.91, 14.7656, 2544.49, -1304.77, 1054.64, 2, 4, 'Sedinta Duminica , ora 20:00.', '[1] Soldier', '[2] Supplier', '[3] Launderer', '[4] Chief Enforcer', '[5] Councilor', '[6] Advisor', '[7] Supreme Chief', 0, 0, 15, 10, 0, 0, 0, '150000 10000 0', '130000 10000 0', '110000 10000 0', '100000 5000 0', '80000 5000 0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'Los Aztecas', 1456.52, 2773.59, 10.8203, 2544.49, -1304.77, 1054.64, 2, 5, 'Los Aztecas - Cine nu este ONLINE la war-uri, are FW ! WARURILE SUNT OBLIGATORII !', '[1] Servant', '[2] Minion', '[3] Fighter', '[4] Gangster', '[5] War Gangster', '[6] Count', '[7] Lord', 0, 0, 15, 10, 1668.24, -1325.33, 17.4294, '150000 10000 0', '130000 10000 0', '110000 10000 0', '100000 5000 0', '80000 5000 0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'Los Vagos', 691.571, -1276.05, 13.5607, 2544.49, -1304.77, 1054.64, 2, 6, 'Sa fim numaru 1 in /top! Forta Los Vagos!', '[1] Recluta', '[2] Cholo', '[3] Solado', '[4] Pandillero', '[5] Vato del Jefe', '[6] Mano Derecha', '[7] El Jefe', 0, 0, 15, 10, 0, 0, 0, '150000 10000 0', '130000 10000 0', '110000 10000 0', '100000 5000 0', '80000 5000 0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'School Instructors LS', 476.902, -1498.75, 20.4789, 1494.49, 1304.18, 1093.29, 3, 7, 'Nimic', '[1] Trainee', '[2] Instructor', '[3] Senior Instructor', '[4] Supervisor', '[5] Manager', '[6] Under Boss', '[7] Boss', 0, 0, 15, 7, 491.229, -1499.22, 20.4507, '10 0 0', '8 0 0', '6 0 0', '4 0 0', '2 0 0', '0|0|0', '0|0|0', 484.348, -1498.86, 20.0216, 500.682, -1511.38, 39.3322, 355.388, 270.518),
(8, 'Tow Truck Company', 2451.17, -2120.77, 13.5469, 626.835, -12.0344, 1000.92, 1, 8, 'Salut raport-ul vostru este: 25 tractari, 20 refill, 15 repair.', '[1] Trainee', '[2] Mechanic', '[3] Senior Mechanic', '[4] Supervisor', '[5] Manager', '[6] Under Boss', '[7] Owner', 0, 0, 15, 7, 2446.15, -2112.53, 13.553, '20 15 15', '18 13 13', '15 10 10', '13 8 8', '10 5 5', '0|0|0', '0|0|0', 2454.55, -2089.32, 13.4194, 0, 0, 0, 88.9317, 0),
(9, 'News Reporters', -329.801, 1537.04, 76.612, -2026.96, -104.033, 1035.17, 3, 9, 'https://discord.gg/UEHskt5EBP -> Server-ul de discord, intrati pentru a lua CMD-ul.', '[1] Intern', '[2] Local Reporter', '[3] Local Editor', '[4] Network Anchor', '[5] Network Editor', '[6] Network Producer', '[7] Network Director', 0, 0, 15, 7, -312.921, 1538.11, 75.5625, '20 0 0', '18 10 0', '15 8 0', '13 5 0', '10 3 0', '0|0|0', '0|0|0', -317.872, 1514.77, 75.3828, -369.754, 1558.2, 75.7106, 0.202718, 214.531),
(10, 'The Ballas', 1455.48, 750.583, 11.023, 2544.49, -1304.77, 1054.64, 2, 10, 'Sedinta sambata la ora 17:00 cine nu se prezinta primeste UNINVITE ', '(1) Ragazzino -', '(2) Spacciatore -', '(3) Capodecina -', '6', '(5) Fattam -', 'cartoon123', '(7) Capo Di Tutti', 0, 0, 15, 10, 1081.06, -345.265, 73.9836, '150000 10000 0', '130000 10000 0', '110000 10000 0', '100000 5000 0', '80000 5000 0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(11, 'Hitman Agency', 1073.24, -345.586, 73.992, -2158.61, 642.401, 1052.38, 1, 11, 'bun venit', '[1] Freelancer', '[2] Marksman', '[3] Agent', '[4] Special Agent', '[5] Special Agent in Charge', '[6] Vice Director', '[7] Director', 0, 0, 15, 15, 1081.17, -345.285, 73.9786, '25 0 0', '20 0 0', '15 0 0', '10 0 0', '8 0 0', '0|0|0', '0|0|0', 1077.94, -309.984, 73.7193, 1038.64, -355.085, 74.2422, 177.426, 0.000002),
(12, 'Taxi Company', 1752.5, -1894.02, 13.557, 1701.24, -1668.03, 20.2188, 18, 12, 'Fare-ul este 1000$', '[1] Trainee', '[2] Taxi Rookie', '[3] Cabbie', '[4] Dispatcher', '[5] Shift Supervisor', '[6] Taxi Company Manager', '[7] Taxi Company Owner', 0, 0, 15, 7, 1759.92, -1900.19, 13.5634, '20 0 0', '15 0 0', '10 0 0', '10 0 0', '5 0 0', '0|0|0', '0|0|0', 1777.32, -1912.88, 13.1144, 1792.34, -1924.3, 13.6405, 269.663, 0.000073),
(13, 'Paramedic Departament', 1607.19, 1815.25, 10.8203, 1494.46, 1304.12, 1093.29, 3, 13, 'LUNI ORA 21 SEDINTA PE DISCORD', '[1] Candidate Paramedic', '[2] Paramedic', '[3] Paramedic in Charge', '[4] Paramedic Ambulance Commander', '[5] Paramedic Field Chief', '[6] Assistant Chief Paramedic', '[7] Chief Paramedic', 0, 0, 15, 7, 1623.84, 1817.94, 10.8203, '25 0 0', '20 0 0', '15 0 0', '10 0 0', '5 0 0', '0|0|0', '0|0|0', 1606.4, 1839.09, 10.5474, 1607.96, 1768.21, 38.0222, 358.253, 357.821),
(14, 'Las Venturas Police Department', 2287.19, 2431.38, 10.8203, 246.448, 108.555, 1003.22, 10, 14, 'cine nu face raportu are uninvite', '[1] Officer', '[2] Detective', '[3] Sergeant', '[4] Lieutenant', '[5] Captain', '[6] Assistant Chief', '[7] Chief', 0, 0, 15, 10, 2306.17, 2437.61, 10.8203, '30 12 0', '25 10 8', '20 8 5', '15 5 5', '10 5 3', '0|0|0', '20|0|0', 2305.68, 2436.92, 10.5474, 2284.09, 2440.85, 47.1543, 176.846, 180.687),
(15, 'Uber Company', 938.703, 1733.45, 8.852, 1701.24, -1668.03, 20.2188, 18, 15, 'Duminica sedinta , prezenta este obligatorie la ora 20:30 , cine nu vine are FW', '[1] Driver', '[2] Driver Advanced', '[3] Driver Expert', '[4] Supervisor', '[5] Manager', '# Vice-Director', '# Director', 0, 0, 15, 7, 947.677, 1719.29, 8.85543, '20 0 0', '15 0 0', '10 0 0', '10 0 0', '5 0 0', '0|0|0', '0|0|0', 945.808, 1711.35, 8.56875, 0, 0, 0, 270.757, 0),
(16, 'School Instructors LV', 2427.6, 1662.88, 10.8203, 1494.49, 1304.18, 1093.29, 3, 16, 'None', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 7, 2424.1, 1672.07, 10.8203, '10 0 0', '8 0 0', '6 0 0', '4 0 0', '2 0 0', '0|0|0', '0 0 0', 2398.94, 1658.53, 10.5474, 2395.81, 1687.54, 19.523, 179.164, 183.556),
(17, 'Verdant Family', 1122.89, -2037, 69.894, 2544.49, -1304.77, 1054.64, 2, 17, 'None', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 10, 0, 0, 0, '150000 10000 0', '130000 10000 0', '110000 10000 0', '100000 5000 0', '80000 5000 0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(18, 'The Rifa', 2632.32, 2350.61, 10.8203, 2544.49, -1304.77, 1054.64, 2, 18, '0', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 1, 15, 15, 0, 0, 0, '150000 10000 0', '130000 10000 0', '110000 10000 0', '100000 5000 0', '80000 5000 0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(19, 'San Fierro Police Department', -1605.64, 711.33, 13.8672, 246.78, 63.3446, 1003.64, 6, 19, '0', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 10, -1620.62, 684.888, 7.1875, '30 12 0', '25 10 8', '20 8 5', '15 5 5', '10 5 3', '0|0|0', '0|0|0', -1616.74, 651.306, 6.91455, -1681.28, 705.873, 30.7784, 359.312, 270.179),
(20, 'San Fierro Paramedic Departament', -2655.06, 639.121, 14.4531, 1494.46, 1304.12, 1093.29, 3, 19, '0', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 1, 0, 15, 7, -2664.68, 636.717, 14.4531, '25 0 0', '20 0 0', '15 0 0', '10 0 0', '5 0 0', '0|0|0', '0|0|0', -2682.66, 634.186, 14.1806, -2574.74, 642.998, 28.0625, 181.06, 179.732),
(21, 'School Instructors SF', -2065.85, -859.943, 32.1719, 1494.49, 1304.18, 1093.29, 3, 21, 'None', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 7, -2097.71, -860.074, 32.1719, '10 0 0', '8 0 0', '6 0 0', '4 0 0', '2 0 0', '0|0|0', '0|0|0', -2125.46, -837.556, 31.7489, -2026.5, -859.932, 32.4219, 269.493, 269.51),
(22, 'Tow Truck Company SF', -2455.75, 503.971, 30.0781, 626.835, -12.0344, 1000.92, 1, 22, 'None', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 1, 15, 7, -2446.99, 523.174, 30.3015, '20 15 15', '18 13 13', '15 10 10', '13 8 8', '10 5 5', '0|0|0', '0|0|0', -2440.77, 523.337, 29.6372, 0, 0, 0, 180.063, 0),
(23, 'Yango', -2665.65, -5.4771, 6.1328, 1701.24, -1668.03, 20.2188, 18, 23, 'Welcome to faction! Link discord :', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', '# Director', 0, 0, 15, 7, -2692.51, -35.2311, 4.33594, '20 0 0', '15 0 0', '10 0 0', '10 0 0', '5 0 0', '0|0|0', '0 0 0', -2683.3, -55.323, 4.06306, -2648.48, -30.2745, 6.32195, 0.721721, 179.277),
(24, 'Special Guard', -2281.96, 2288.39, 4.974, 288.763, 167.704, 1007.17, 3, 24, 'cine nu face raportu suge pula', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 15, -2284.72, 2282.29, 4.96712, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', -2260.67, 2287.61, 4.81466, 0, 0, 0, 359.563, 0),
(25, 'SF Bikers', -2463.01, 132.31, 35.1719, 2544.49, -1304.77, 1054.64, 2, 25, 'Ares e boss pe sv', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 15, 0, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(26, 'Camorra Family', -2624.65, 1412.26, 7.0938, 2544.49, -1304.77, 1054.64, 2, 26, 'None', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Rank7', 0, 0, 15, 15, 0, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0),
(27, 'Avispa Cartel', -2521.21, -624.953, 132.784, 2544.49, -1304.77, 1054.64, 2, 27, 'none', 'Rank1', 'Rank2', 'Rank3', 'Rank4', 'Rank5', 'Rank6', 'Admin', 0, 0, 15, 15, 0, 0, 0, '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `faction_apply`
--

CREATE TABLE `faction_apply` (
  `ID` int(11) NOT NULL,
  `FactionID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `I1` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I2` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I3` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I4` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I5` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I6` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I7` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I8` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I9` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I10` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I11` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I12` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I13` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I14` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `I15` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faction_logs`
--

CREATE TABLE `faction_logs` (
  `id` int(11) NOT NULL,
  `player` int(11) NOT NULL,
  `leader` int(11) NOT NULL,
  `Text` text NOT NULL,
  `time` varchar(30) NOT NULL DEFAULT '01.01.1999 10:00:00',
  `deleted` int(11) NOT NULL,
  `player_name` varchar(32) NOT NULL DEFAULT 'invalid',
  `leader_name` varchar(32) NOT NULL DEFAULT 'invalid',
  `skin` int(11) NOT NULL,
  `faction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `ID` int(11) NOT NULL,
  `friendID` int(11) NOT NULL,
  `friendName` varchar(644) NOT NULL,
  `AddBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `garages`
--

CREATE TABLE `garages` (
  `ID` int(11) NOT NULL,
  `EntranceX` float NOT NULL,
  `EntranceY` float NOT NULL,
  `EntranceZ` float NOT NULL,
  `House` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='5';

--
-- Dumping data for table `garages`
--

INSERT INTO `garages` (`ID`, `EntranceX`, `EntranceY`, `EntranceZ`, `House`) VALUES
(1, -58.0712, -1505.76, 1.62162, 1);

-- --------------------------------------------------------

--
-- Table structure for table `graffiti`
--

CREATE TABLE `graffiti` (
  `ID` int(10) NOT NULL,
  `X` float NOT NULL,
  `Y` float NOT NULL,
  `Z` float NOT NULL,
  `Owned` int(10) NOT NULL,
  `RotX` float NOT NULL,
  `RotY` float NOT NULL,
  `RotZ` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `ID` int(10) NOT NULL,
  `Entrancex` float NOT NULL,
  `Entrancey` float NOT NULL,
  `Entrancez` float NOT NULL,
  `Exitx` float NOT NULL,
  `Exity` float NOT NULL,
  `Exitz` float NOT NULL,
  `Owner` varchar(25) NOT NULL DEFAULT 'The State',
  `Discription` varchar(50) NOT NULL DEFAULT 'Fara descriere.',
  `Value` int(20) NOT NULL,
  `Hel` int(11) NOT NULL,
  `Arm` int(11) NOT NULL,
  `Interior` int(11) NOT NULL,
  `Lockk` int(11) NOT NULL,
  `Owned` int(11) NOT NULL,
  `Rent` int(11) NOT NULL,
  `Rentabil` int(11) NOT NULL,
  `Takings` int(11) NOT NULL,
  `Level` int(11) NOT NULL,
  `Virtual` int(11) NOT NULL,
  `Radio` int(11) NOT NULL DEFAULT -1,
  `Zise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`ID`, `Entrancex`, `Entrancey`, `Entrancez`, `Exitx`, `Exity`, `Exitz`, `Owner`, `Discription`, `Value`, `Hel`, `Arm`, `Interior`, `Lockk`, `Owned`, `Rent`, `Rentabil`, `Takings`, `Level`, `Virtual`, `Radio`, `Zise`) VALUES
(1, 860.819, -1255.55, 14.7578, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 1, 0, 5, 1, 3, 0),
(2, 2012.29, 919.952, 10.8203, 140.182, 1366.47, 1083.86, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 1, 0, 5, 2, -1, 0),
(3, 2006.82, 1167.48, 10.8203, 234.203, 1064.15, 1084.21, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 3, -1, 0),
(4, 2238.9, 1285.52, 10.8203, 140.182, 1366.47, 1083.86, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 1, 0, 5, 4, -1, 0),
(5, 2364.44, 2377.49, 10.8203, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 1, 0, 5, 5, -1, 0),
(6, 1319.1, 1249.48, 10.8203, 234.203, 1064.15, 1084.21, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 6, -1, 0),
(7, 1624.66, 1018.31, 10.8203, 2282.79, -1139.4, 1050.9, 'The State', 'Fara descriere.', 0, 0, 0, 11, 0, 1, 250, 1, 0, 5, 7, -1, 0),
(8, 1845.76, 741.383, 11.4609, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 8, -1, 0),
(9, 2397.59, 656.107, 11.4609, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 9, -1, 0),
(10, 2581.27, 1060.55, 11.7815, 300.862, 309.887, 1003.3, 'The State', 'Fara descriere.', 0, 0, 0, 4, 0, 1, 250, 1, 0, 5, 10, -1, 0),
(11, 1497.02, -687.897, 95.5633, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 1, 0, 5, 11, -1, 0),
(12, 980.489, -677.259, 121.976, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 1, 0, 5, 12, -1, 0),
(13, 300.277, -1154.49, 81.3905, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 1, 0, 5, 13, -1, 0),
(14, 416.747, -1154.17, 76.6876, 234.203, 1064.15, 1084.21, 'HALKFLORIN67', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 14, -1, 0),
(15, 2818.31, 2415.34, 11.0625, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 15, -1, 0),
(16, 2826.76, 2203.61, 11.0234, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 16, -1, 0),
(17, 2546.57, 1972.64, 10.8203, 328.003, 1478.55, 1084.44, 'The State', 'Fara descriere.', 0, 0, 0, 15, 0, 1, 250, 1, 0, 5, 17, -1, 0),
(18, 2167.16, 2164.57, 10.8203, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 18, -1, 0),
(19, 168.094, -1769.07, 4.47643, 234.203, 1064.15, 1084.21, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 19, -1, 0),
(20, 315.875, -1769.43, 4.62261, 226.705, 1114.25, 1080.99, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 1, 0, 5, 20, -1, 0),
(21, 1382.14, -1088.79, 28.2066, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 1, 0, 5, 21, -1, 0),
(22, 1421.75, -886.227, 50.6861, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 22, -1, 0),
(23, 1540.47, -851.381, 64.3361, 223.08, 1287.74, 1082.14, 'The State', 'Fara descriere.', 0, 0, 0, 1, 0, 1, 250, 1, 0, 5, 23, -1, 0),
(24, 1045.11, -642.947, 120.117, 235.407, 1187.37, 1080.26, 'The State', 'Fara descriere.', 0, 0, 0, 3, 0, 1, 250, 1, 0, 5, 24, -1, 0),
(25, 848.729, -1817.99, 12.1938, 140.182, 1366.47, 1083.86, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 1, 0, 5, 25, -1, 0),
(26, 821.93, -1757.84, 13.6484, 234.203, 1064.15, 1084.21, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 0, 0, 5, 26, -1, 0),
(27, 725.797, -1440.45, 13.5391, 490.865, 1399.2, 1080.26, 'The State', 'Fara descriere.', 0, 0, 0, 2, 0, 1, 250, 0, 0, 5, 27, -1, 0),
(28, 1566.66, 23.294, 24.1641, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 0, 0, 5, 28, -1, 0),
(29, 1685.02, -2099.02, 13.8343, 234.203, 1064.15, 1084.21, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 29, -1, 0),
(30, 2177.88, 655.857, 11.4609, 2365.34, -1134.84, 1050.88, 'The State', 'Fara descriere.', 0, 0, 0, 8, 0, 1, 250, 0, 0, 5, 30, -1, 0),
(31, 1305.62, 1622.88, 10.8203, 490.865, 1399.2, 1080.26, 'The State', 'Fara descriere.', 0, 0, 0, 2, 0, 1, 250, 0, 0, 5, 31, 1, 0),
(32, 2019.8, 1007.65, 10.8203, 234.203, 1064.15, 1084.21, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 32, 19, 0),
(33, 1280.62, -813.754, 83.6623, 225.662, 1022.08, 1084.02, 'The State', 'Fara descriere.', 0, 0, 0, 7, 0, 1, 250, 0, 0, 5, 33, -1, 0),
(34, 228.305, -1405.21, 51.6094, 2496.02, -1692.68, 1014.74, 'The State', 'Fara descriere.', 0, 0, 0, 3, 0, 1, 250, 0, 0, 5, 34, -1, 0),
(35, 298.699, -1338.18, 53.4415, 2365.34, -1134.84, 1050.88, 'The State', 'Fara descriere.', 0, 0, 0, 8, 0, 1, 250, 0, 0, 5, 35, -1, 0),
(36, 423.864, 2536.45, 16.1484, 2308.81, -1212.24, 1049.02, 'The State', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 250, 1, 0, 5, 36, 1, 0),
(37, 2113.76, 2499.3, 14.839, 226.705, 1114.25, 1080.99, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 0, 0, 5, 37, -1, 0),
(38, 2226.73, 1838.22, 10.8203, 140.182, 1366.47, 1083.86, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 0, 0, 5, 38, -1, 0),
(39, 839.013, -2152.69, 13.6607, 226.705, 1114.25, 1080.99, 'The State', 'Fara descriere.', 0, 0, 0, 5, 0, 1, 250, 0, 0, 5, 39, -1, 0),
(40, -2721.08, -320.887, 7.84375, 234.203, 1064.15, 1084.21, 'SebiAdv', 'Fara descriere.', 0, 0, 0, 6, 0, 1, 0, 0, 0, 10, 40, -1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `iplogs`
--

CREATE TABLE `iplogs` (
  `ID` int(11) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `playerid` int(24) NOT NULL,
  `time` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `ID` int(10) NOT NULL,
  `Name` varchar(32) NOT NULL DEFAULT 'No name',
  `NeedLevel` int(10) NOT NULL,
  `Legal` int(10) NOT NULL,
  `Skill1Veh` int(10) NOT NULL DEFAULT 400,
  `Skill2Veh` int(10) NOT NULL DEFAULT 400,
  `Skill3Veh` int(10) NOT NULL DEFAULT 400,
  `Skill4Veh` int(10) NOT NULL DEFAULT 400,
  `Skill5Veh` int(10) NOT NULL DEFAULT 400,
  `Skill6Veh` int(10) NOT NULL DEFAULT 400,
  `Owner` varchar(24) NOT NULL DEFAULT 'None',
  `Userid` int(11) NOT NULL,
  `WorkPos` varchar(100) NOT NULL DEFAULT '0.0,0.0,0.0',
  `Pos` varchar(100) NOT NULL DEFAULT '0.0,0.0,0.0',
  `Balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`ID`, `Name`, `NeedLevel`, `Legal`, `Skill1Veh`, `Skill2Veh`, `Skill3Veh`, `Skill4Veh`, `Skill5Veh`, `Skill6Veh`, `Owner`, `Userid`, `WorkPos`, `Pos`, `Balance`) VALUES
(1, 'Farmer', 1, 1, 531, 531, 531, 531, 531, 531, 'None', 0, '-84.3012,45.7011,3.1172', '-95.1542,25.3176,3.1172', 50431),
(2, 'Trucker', 1, 1, 515, 515, 515, 515, 515, 515, 'None', 0, '2430.5615,-2207.2661,13.5469', '2415.4604,-2228.9482,13.5469', 2500),
(3, 'Lumberjack', 1, 1, 478, 478, 478, 478, 478, 478, 'None', 0, '-589.4131,-1078.9364,23.4845', '-601.1035,-1065.3776,23.4033', 49974),
(4, 'Garbage Man', 1, 1, 408, 408, 408, 408, 408, 408, 'None', 0, '2521.5334,2793.2646,10.8203', '2502.9802,2778.5674,10.8203', 2500),
(5, 'Arms Dealer', 2, 3, 400, 400, 400, 400, 400, 400, 'None', 0, '2798.1772,1976.6501,10.8203', '2810.8726,1987.0040,10.8203', 2500),
(6, 'Drugs Dealer', 3, 0, 400, 400, 400, 400, 400, 411, 'None', 0, '-807.8198,2430.9902,156.9962', '-797.0580,2439.1462,157.0806', 2500),
(7, 'Quarry Worker', 3, 1, 400, 400, 400, 400, 400, 400, 'None', 0, '839.6926,888.8485,13.3516', '816.6052,856.5006,12.7891', 2500),
(8, 'Detective', 5, 1, 400, 400, 400, 400, 400, 400, 'None', 0, '0.0,0.0,0.0', '-2056.7822,454.7194,35.1719', 0),
(9, 'Pizza Boy', 1, 1, 448, 448, 448, 448, 448, 448, 'None', 0, '2631.8708,1845.4863,10.8203', '2638.7864,1849.7213,11.0234', 2500),
(10, 'Courier', 1, 1, 482, 499, 499, 499, 499, 499, 'None', 0, '2805.2300,967.9019,10.7500', '2814.7793,972.6347,10.7500', 2500),
(11, 'Fisher LV', 1, 1, 400, 400, 400, 400, 400, 400, 'None', 0, '0.0,0.0,0.0', '2325.4380,556.3793,8.4116', 54624),
(12, 'Forklift', 1, 1, 530, 530, 530, 530, 530, 530, 'None', 0, '972.0071,2125.2549,10.8203', '966.9892,2133.0393,10.8203', 9853),
(13, 'Fisher LS', 1, 1, 400, 400, 400, 400, 400, 400, 'None', 0, '0.0,0.0,0.0', '401.6425,-2070.5994,10.7423', 2500),
(14, 'Bus Driver', 1, 1, 437, 437, 437, 437, 437, 437, 'None', 0, '2828.9609,1328.1018,10.7708', '2840.7317,1318.4473,11.3906', 2500),
(15, 'Glovo', 3, 0, 510, 510, 510, 510, 468, 468, 'None', 0, '-2460.2925,741.7111,34.6232', '-2471.6094,756.4418,35.1786', 190966),
(16, 'Fisher SF', 1, 1, 400, 400, 400, 400, 400, 400, 'None', 0, '0.0,0.0,0.0', '-2960.9246,476.9930,5.4050', 21893);

-- --------------------------------------------------------

--
-- Table structure for table `kenny_happs`
--

CREATE TABLE `kenny_happs` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `UserName` varchar(90) NOT NULL,
  `Type` int(11) NOT NULL,
  `Answers` text NOT NULL,
  `Questions` text NOT NULL,
  `Status` int(11) NOT NULL,
  `Date` varchar(90) NOT NULL,
  `ActionBy` varchar(90) NOT NULL,
  `Reason` text NOT NULL,
  `AnswerDate` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kenny_hquestions`
--

CREATE TABLE `kenny_hquestions` (
  `ID` int(11) NOT NULL,
  `Question` text NOT NULL,
  `Type` int(11) NOT NULL,
  `Date` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kenny_lapps`
--

CREATE TABLE `kenny_lapps` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `UserName` varchar(90) NOT NULL,
  `Type` int(11) NOT NULL,
  `Answers` text NOT NULL,
  `Questions` text NOT NULL,
  `Status` int(11) NOT NULL,
  `Date` varchar(90) NOT NULL,
  `ActionBy` varchar(90) NOT NULL,
  `Reason` text NOT NULL,
  `AnswerDate` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kenny_lquestions`
--

CREATE TABLE `kenny_lquestions` (
  `ID` int(11) NOT NULL,
  `Question` text NOT NULL,
  `Type` int(11) NOT NULL,
  `Date` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kenny_lquestions`
--

INSERT INTO `kenny_lquestions` (`ID`, `Question`, `Type`, `Date`) VALUES
(1, 'alo?', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `key`
--

CREATE TABLE `key` (
  `ID` int(11) NOT NULL,
  `code` varchar(128) NOT NULL,
  `valid` int(11) NOT NULL DEFAULT -1,
  `hdwid` varchar(144) NOT NULL DEFAULT '-1',
  `version` varchar(24) NOT NULL DEFAULT '1.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `ID` int(10) NOT NULL,
  `Userid` int(10) NOT NULL,
  `Text` varchar(256) NOT NULL,
  `Date` varchar(256) NOT NULL,
  `Type` int(10) NOT NULL,
  `IP` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_logs`
--

CREATE TABLE `money_logs` (
  `ID` int(11) NOT NULL,
  `Name` int(11) NOT NULL,
  `Userid` int(11) NOT NULL,
  `reasonAction` varchar(128) DEFAULT NULL,
  `Time` varchar(64) NOT NULL DEFAULT '1999-1-1 10:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_answers`
--

CREATE TABLE `panel_answers` (
  `ID` int(11) NOT NULL,
  `ApplicationID` varchar(15) NOT NULL,
  `question` varchar(256) NOT NULL,
  `answer` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_applications`
--

CREATE TABLE `panel_applications` (
  `ID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Userid` int(11) NOT NULL,
  `Type` varchar(32) NOT NULL,
  `Status` int(11) NOT NULL,
  `unque` varchar(10) NOT NULL,
  `Group` int(11) NOT NULL,
  `Date` varchar(32) NOT NULL,
  `Reason` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_badge`
--

CREATE TABLE `panel_badge` (
  `ID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Icon` varchar(144) NOT NULL,
  `Color` varchar(32) NOT NULL,
  `Userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_comment`
--

CREATE TABLE `panel_comment` (
  `ID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Text` varchar(144) NOT NULL,
  `time` varchar(32) NOT NULL,
  `BanID` varchar(32) NOT NULL,
  `Skin` int(11) NOT NULL,
  `Userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_comment_complaints`
--

CREATE TABLE `panel_comment_complaints` (
  `ID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Model` int(11) NOT NULL,
  `Time` varchar(32) NOT NULL,
  `CommentID` varchar(10) NOT NULL,
  `Userid` int(11) NOT NULL,
  `badge` int(11) NOT NULL,
  `Text` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_comment_tickets`
--

CREATE TABLE `panel_comment_tickets` (
  `ID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Model` int(11) NOT NULL,
  `Time` varchar(32) NOT NULL,
  `CommentID` varchar(15) NOT NULL,
  `Userid` int(11) NOT NULL,
  `Text` varchar(256) NOT NULL,
  `badge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_complaints`
--

CREATE TABLE `panel_complaints` (
  `ID` int(11) NOT NULL,
  `Against` varchar(32) NOT NULL,
  `Creator` varchar(32) NOT NULL,
  `Date` varchar(32) NOT NULL,
  `Status` int(11) NOT NULL,
  `unque` varchar(10) NOT NULL,
  `Reason` varchar(64) NOT NULL,
  `Link` varchar(256) NOT NULL,
  `Description` varchar(1024) NOT NULL,
  `Admin` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Member` int(11) NOT NULL,
  `Userid` int(11) NOT NULL,
  `ByUserid` int(11) NOT NULL,
  `Action` varchar(32) NOT NULL,
  `Grad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_question`
--

CREATE TABLE `panel_question` (
  `ID` int(11) NOT NULL,
  `Text` varchar(256) NOT NULL,
  `Type` int(11) NOT NULL,
  `Group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_queue`
--

CREATE TABLE `panel_queue` (
  `ID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL DEFAULT '',
  `AdminName` varchar(32) NOT NULL DEFAULT '',
  `playerid` int(11) NOT NULL,
  `Type` int(11) NOT NULL,
  `Userid` int(11) NOT NULL,
  `Reason` varchar(64) NOT NULL,
  `Amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_recovery`
--

CREATE TABLE `panel_recovery` (
  `ID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Code` varchar(50) NOT NULL,
  `Time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_suspend`
--

CREATE TABLE `panel_suspend` (
  `ID` int(11) NOT NULL,
  `Userid` int(11) NOT NULL,
  `IP` varchar(32) NOT NULL,
  `Reason` varchar(128) NOT NULL,
  `Admin` varchar(32) NOT NULL,
  `Date` varchar(32) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_tickets`
--

CREATE TABLE `panel_tickets` (
  `ID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Type` int(11) NOT NULL,
  `Priority` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Date` varchar(32) NOT NULL,
  `Description` varchar(3000) NOT NULL,
  `Code` varchar(14) NOT NULL,
  `Model` int(11) NOT NULL,
  `Userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `panel_unban`
--

CREATE TABLE `panel_unban` (
  `ID` int(11) NOT NULL,
  `Username` varchar(32) NOT NULL DEFAULT 'Invalid',
  `Userid` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `unque` varchar(14) NOT NULL DEFAULT 'invalid',
  `Reason` varchar(256) NOT NULL,
  `Photo` varchar(144) NOT NULL,
  `Others` varchar(256) NOT NULL,
  `time` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `safezones`
--

CREATE TABLE `safezones` (
  `ID` int(10) NOT NULL,
  `X` float NOT NULL,
  `Y` float NOT NULL,
  `Z` float NOT NULL,
  `Range` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `safezones`
--

INSERT INTO `safezones` (`ID`, `X`, `Y`, `Z`, `Range`) VALUES
(1, -1972.45, 136.23, 27.6875, 15),
(2, 1221.84, -1693.78, 19.7344, 50),
(3, 1228.21, -1692.59, 18.5222, 20);

-- --------------------------------------------------------

--
-- Table structure for table `sanctions`
--

CREATE TABLE `sanctions` (
  `ID` int(10) NOT NULL,
  `Player` varchar(256) NOT NULL,
  `By` varchar(256) NOT NULL,
  `Time` varchar(256) NOT NULL,
  `Userid` int(10) NOT NULL,
  `Type` int(10) NOT NULL,
  `Reason` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seif`
--

CREATE TABLE `seif` (
  `sID` int(10) NOT NULL,
  `sFactionID` int(10) NOT NULL,
  `sPosX` float NOT NULL,
  `sPosY` float NOT NULL,
  `sPosZ` float NOT NULL,
  `sMoney` int(10) NOT NULL DEFAULT 500000,
  `sDrugs` int(10) NOT NULL DEFAULT 1000,
  `sMaterials` int(10) NOT NULL DEFAULT 100000,
  `sVirtualID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `seif`
--

INSERT INTO `seif` (`sID`, `sFactionID`, `sPosX`, `sPosY`, `sPosZ`, `sMoney`, `sDrugs`, `sMaterials`, `sVirtualID`) VALUES
(1, 1, 240.683, 71.1112, 1005.04, 1000000, 1000, 1000, 1),
(2, 2, 228.863, 169.008, 1003.02, 1000000, 1000, 1000, 2),
(3, 3, 301.576, 187.933, 1007.17, 100000, 1000, 1000, 3),
(4, 4, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 4),
(5, 5, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 5),
(6, 6, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 6),
(7, 7, 1502.14, 1308.88, 1093.29, 100000, 1000, 1000, 7),
(8, 8, 604.763, -26.5193, 1004.78, 100000, 1000, 1000, 8),
(9, 9, -2034.81, -114.67, 1035.17, 100000, 1000, 1000, 9),
(10, 10, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 10),
(11, 11, -2165.66, 646.313, 1052.38, 100000, 1000, 1000, 11),
(12, 12, 1723.13, -1673.03, 20.2233, 100000, 1000, 1000, 12),
(13, 13, 1501.94, 1309.4, 1093.29, 100000, 1000, 1000, 13),
(14, 14, 259.444, 107.849, 1003.22, 100000, 1000, 1000, 14),
(15, 15, 1722.87, -1673.41, 20.2231, 100000, 1000, 1000, 15),
(16, 16, 1502.14, 1308.88, 1093.29, 100000, 1000, 1000, 16),
(17, 17, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 17),
(18, 18, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 18),
(19, 19, 240.683, 71.1112, 1005.04, 100000, 1000, 1000, 19),
(20, 20, 1501.94, 1309.4, 1093.29, 100000, 1000, 1000, 20),
(21, 21, 1502.14, 1308.88, 1093.29, 100000, 1000, 1000, 21),
(22, 22, 604.763, -26.5193, 1004.78, 100000, 1000, 1000, 22),
(23, 23, 1722.87, -1673.41, 20.2231, 100000, 1000, 1000, 23),
(24, 24, 280.831, 188.109, 1007.17, 100000, 1000, 1000, 24),
(25, 25, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 25),
(26, 26, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 26),
(27, 27, 2550.15, -1287.49, 1054.64, 100000, 1000, 1000, 27);

-- --------------------------------------------------------

--
-- Table structure for table `stuff`
--

CREATE TABLE `stuff` (
  `ID` int(11) NOT NULL,
  `Tax` int(20) NOT NULL,
  `TaxValue` int(20) NOT NULL,
  `ServerStock` varchar(50) NOT NULL DEFAULT '0|0|0|0|0|0|0|0|0|0|',
  `goal` int(11) NOT NULL,
  `mgoal` int(11) NOT NULL,
  `nickname` varchar(128) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '0',
  `AdminRaport` int(11) NOT NULL,
  `HelperRaport` int(11) NOT NULL,
  `App` int(11) NOT NULL,
  `AppLeader` int(11) NOT NULL,
  `Payday` int(11) NOT NULL,
  `chapter` int(11) NOT NULL,
  `bpTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stuff`
--

INSERT INTO `stuff` (`ID`, `Tax`, `TaxValue`, `ServerStock`, `goal`, `mgoal`, `nickname`, `password`, `AdminRaport`, `HelperRaport`, `App`, `AppLeader`, `Payday`, `chapter`, `bpTime`) VALUES
(1, 0, 0, '100 100 100 100 100 100 100 100 100', 626809, 0, 'RPG.ELYSIUM.RO | DESCHIDEREA 24.03.2023', 'madalin123', 50, 25, 0, 0, 2, 1, 1684515461);

-- --------------------------------------------------------

--
-- Table structure for table `svehicles`
--

CREATE TABLE `svehicles` (
  `vID` int(11) NOT NULL,
  `vModel` int(10) NOT NULL,
  `LocationX` float NOT NULL,
  `LocationY` float NOT NULL,
  `LocationZ` float NOT NULL,
  `Angle` float NOT NULL,
  `Color1` int(10) NOT NULL,
  `Color2` int(10) NOT NULL,
  `Faction` int(10) NOT NULL,
  `Rank` int(10) NOT NULL,
  `NumberPlate` varchar(64) NOT NULL DEFAULT 'NewCar'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `svehicles`
--

INSERT INTO `svehicles` (`vID`, `vModel`, `LocationX`, `LocationY`, `LocationZ`, `Angle`, `Color1`, `Color2`, `Faction`, `Rank`, `NumberPlate`) VALUES
(8, 521, 2498.72, -1685.79, 13.021, 1.342, 234, 234, 4, 0, 'NewCar'),
(9, 521, 2497, -1685.85, 13.005, 2.478, 234, 234, 4, 0, 'NewCar'),
(10, 521, 2491.37, -1686.05, 13.08, 359.63, 234, 234, 4, 0, 'NewCar'),
(11, 521, 2493.23, -1685.99, 13.08, 0.537, 234, 234, 4, 0, 'NewCar'),
(12, 409, 2473.25, -1694.45, 13.316, 0.469, 234, 234, 4, 0, 'NewCar'),
(13, 487, 2531.51, -1677.05, 19.93, 89.792, 234, 234, 4, 0, 'NewCar'),
(14, 518, 2482.11, -1692.78, 13.191, 354.135, 234, 234, 4, 0, 'NewCar'),
(15, 579, 2501.76, -1655.58, 13.389, 58.75, 234, 234, 4, 0, 'NewCar'),
(16, 579, 2504.07, -1681.12, 13.387, 298.51, 234, 234, 4, 0, 'NewCar'),
(17, 579, 2508.74, -1674.69, 13.356, 343.662, 234, 234, 4, 0, 'NewCar'),
(18, 579, 2509.69, -1666.5, 13.415, 7.776, 234, 234, 4, 0, 'NewCar'),
(19, 551, 2471.61, -1677.58, 13.191, 211.529, 234, 234, 4, 0, 'NewCar'),
(20, 551, 2468.37, -1670.22, 13.193, 194.4, 234, 234, 4, 0, 'NewCar'),
(21, 560, 2486.38, -1653.47, 13.103, 86.734, 234, 234, 4, 0, 'NewCar'),
(22, 560, 2479.78, -1653.79, 13.094, 89.889, 234, 234, 4, 0, 'NewCar'),
(24, 480, 2479.91, -1683.32, 13.18, 249.715, 234, 234, 4, 0, 'NewCar'),
(25, 480, 2471.47, -1653.61, 13.176, 90.528, 234, 234, 4, 0, 'NewCar'),
(26, 521, 2635.23, 2350.97, 10.346, 201.6, 125, 125, 18, 0, 'NewCar'),
(27, 521, 2636.99, 2351.16, 10.346, 202.602, 125, 125, 18, 0, 'NewCar'),
(28, 521, 2629.35, 2349, 10.348, 209.617, 125, 125, 18, 0, 'NewCar'),
(29, 521, 2627.98, 2348.34, 10.348, 210.915, 125, 125, 18, 0, 'NewCar'),
(30, 560, 2611.07, 2279.53, 10.526, 88.034, 125, 125, 18, 0, 'NewCar'),
(31, 560, 2611.25, 2275.3, 10.525, 89.75, 125, 125, 18, 0, 'NewCar'),
(32, 409, 2611, 2271.08, 10.62, 90.889, 125, 125, 18, 0, 'NewCar'),
(33, 518, 2611.33, 2267.02, 10.491, 90.483, 125, 125, 18, 0, 'NewCar'),
(34, 480, 2611.18, 2262.76, 10.594, 89.362, 125, 125, 18, 0, 'NewCar'),
(35, 480, 2611.21, 2258.52, 10.589, 90.945, 125, 125, 18, 0, 'NewCar'),
(36, 579, 2593.08, 2279.04, 10.748, 270.527, 125, 125, 18, 0, 'NewCar'),
(37, 579, 2593.07, 2275.33, 10.752, 269.318, 125, 125, 18, 0, 'NewCar'),
(38, 579, 2593.1, 2271.67, 10.756, 270.725, 125, 125, 18, 0, 'NewCar'),
(39, 579, 2593.11, 2267.86, 10.7531, 269.926, 125, 125, 18, 0, 'NewCar'),
(40, 551, 2594.21, 2250.99, 10.621, 0.777, 125, 125, 18, 0, 'NewCar'),
(41, 551, 2589.98, 2251, 10.621, 359.582, 125, 125, 18, 0, 'NewCar'),
(42, 551, 2585.19, 2250.98, 10.621, 1.458, 125, 125, 18, 0, 'NewCar'),
(43, 551, 2580.47, 2250.81, 10.621, 359.89, 125, 125, 18, 0, 'NewCar'),
(44, 487, 2577.3, 2307.65, 17.98, 256.322, 125, 125, 18, 0, 'NewCar'),
(45, 579, 657.18, -1274.67, 13.5669, 270.422, 228, 228, 6, 0, 'NewCar'),
(46, 579, 657.079, -1262.9, 13.5052, 270.278, 228, 228, 6, 0, 'NewCar'),
(47, 579, 672.779, -1295.38, 13.5661, 88.8371, 228, 228, 6, 0, 'NewCar'),
(48, 579, 672.558, -1291.24, 13.5085, 90.6385, 228, 228, 6, 0, 'NewCar'),
(49, 487, 726.274, -1244.87, 13.6376, 87.5075, 228, 228, 6, 0, 'NewCar'),
(50, 518, 657.172, -1266.95, 13.3188, 268.877, 228, 228, 6, 0, 'NewCar'),
(51, 521, 687.373, -1262.63, 13.0955, 83.7724, 228, 228, 6, 0, 'NewCar'),
(52, 521, 687.223, -1251.96, 13.1993, 89.5486, 228, 228, 6, 0, 'NewCar'),
(53, 521, 687.406, -1258.63, 13.1033, 88.2548, 228, 228, 6, 0, 'NewCar'),
(54, 521, 687.429, -1254.68, 13.1536, 85.8223, 228, 228, 6, 0, 'NewCar'),
(55, 409, 657.231, -1283.66, 13.4353, 0.396389, 228, 228, 6, 0, 'NewCar'),
(56, 560, 672.858, -1262.46, 13.2993, 89.545, 228, 228, 6, 0, 'NewCar'),
(57, 560, 672.98, -1256.58, 13.2969, 90.0246, 228, 228, 6, 0, 'NewCar'),
(58, 480, 672.788, -1286.69, 13.3835, 88.2666, 228, 228, 6, 0, 'NewCar'),
(59, 480, 672.553, -1267.29, 13.3726, 89.6505, 228, 228, 6, 0, 'NewCar'),
(60, 579, 1413.22, 743.065, 10.753, 269.491, 167, 167, 10, 0, 'NewCar'),
(61, 579, 1413.19, 749.366, 10.755, 269.711, 167, 167, 10, 0, 'NewCar'),
(62, 579, 1413.19, 755.97, 10.754, 269.925, 167, 167, 10, 0, 'NewCar'),
(63, 579, 1413.12, 762.375, 10.754, 271.091, 167, 167, 10, 0, 'NewCar'),
(64, 521, 1453.75, 745.125, 10.592, 91.789, 167, 167, 10, 0, 'NewCar'),
(65, 521, 1453.75, 743.451, 10.592, 88.332, 167, 167, 10, 0, 'NewCar'),
(66, 521, 1453.55, 756.663, 10.592, 91.525, 167, 167, 10, 0, 'NewCar'),
(67, 521, 1453.55, 758.185, 10.592, 91.046, 167, 167, 10, 0, 'NewCar'),
(68, 560, 1412.92, 768.592, 10.526, 270.608, 167, 167, 10, 0, 'NewCar'),
(69, 560, 1412.9, 775.013, 10.526, 270.097, 167, 167, 10, 0, 'NewCar'),
(70, 480, 1413.04, 781.519, 10.594, 270.572, 167, 167, 10, 0, 'NewCar'),
(71, 480, 1412.97, 787.853, 10.593, 269.968, 167, 167, 10, 0, 'NewCar'),
(72, 409, 1429.05, 795.801, 10.62, 89.267, 167, 167, 10, 0, 'NewCar'),
(73, 518, 1445.52, 787.53, 10.491, 180.513, 167, 167, 10, 0, 'NewCar'),
(74, 487, 1412.91, 730.831, 11.018, 269.52, 167, 167, 10, 0, 'NewCar'),
(75, 461, 1459.32, 2778.99, 10.4033, 269.106, 155, 155, 5, 0, 'NewCar'),
(76, 461, 1459.33, 2781.1, 10.3988, 270.116, 155, 155, 5, 0, 'NewCar'),
(77, 521, 1459.35, 2783.44, 10.3823, 268.396, 155, 155, 5, 0, 'NewCar'),
(78, 521, 1459.53, 2785.76, 10.3861, 262.024, 155, 155, 5, 0, 'NewCar'),
(79, 560, 1468.45, 2798.29, 10.4471, 312.972, 155, 155, 5, 0, 'NewCar'),
(80, 426, 1479.64, 2843.01, 10.5636, 180.306, 155, 155, 5, 0, 'NewCar'),
(81, 426, 1484.27, 2843.11, 10.5632, 180.781, 155, 155, 5, 0, 'NewCar'),
(82, 426, 1489.48, 2843.25, 10.5635, 181.177, 155, 155, 5, 0, 'NewCar'),
(83, 480, 1494.49, 2843.36, 10.5941, 180.564, 155, 155, 5, 0, 'NewCar'),
(84, 567, 1484.7, 2791.26, 10.689, 269.544, 155, 155, 5, 0, 'NewCar'),
(85, 409, 1505.21, 2793.41, 10.5407, 204.986, 155, 155, 5, 0, 'NewCar'),
(86, 409, 1505.52, 2753.03, 10.5423, 334.401, 155, 155, 5, 0, 'NewCar'),
(87, 567, 1485.26, 2754.4, 10.6918, 269.442, 155, 155, 5, 0, 'NewCar'),
(88, 560, 1472.59, 2745.6, 10.4489, 236.339, 155, 155, 5, 0, 'NewCar'),
(89, 579, 1492.57, 2742.29, 10.6722, 287.2, 155, 155, 5, 0, 'NewCar'),
(90, 487, 1521.54, 2731.9, 10.9945, 88.6134, 155, 155, 5, 0, 'NewCar'),
(91, 521, 1132.77, -2048.26, 68.5737, 267.791, 36, 36, 17, 0, 'NewCar'),
(92, 521, 1132.84, -2050.08, 68.5786, 272.529, 36, 36, 17, 0, 'NewCar'),
(93, 461, 1132.38, -2025.48, 68.583, 271.61, 36, 36, 17, 0, 'NewCar'),
(94, 461, 1132.36, -2023.35, 68.5835, 269.968, 36, 36, 17, 0, 'NewCar'),
(95, 480, 1145.39, -2005.22, 68.7818, 270.55, 36, 36, 17, 0, 'NewCar'),
(96, 487, 1116.09, -2017.79, 74.607, 271.309, 36, 36, 17, 0, 'NewCar'),
(97, 560, 1164.56, -2005.32, 68.7127, 269.756, 36, 36, 17, 0, 'NewCar'),
(98, 426, 1174.99, -2031.06, 68.751, 0.358274, 36, 36, 17, 0, 'NewCar'),
(99, 579, 1167.78, -2036.93, 68.9355, 89.9587, 36, 36, 17, 0, 'NewCar'),
(100, 402, 1181.41, -2037.07, 68.8395, 269.746, 36, 36, 17, 0, 'NewCar'),
(101, 426, 1175.24, -2044.53, 68.7508, 181.482, 36, 36, 17, 0, 'NewCar'),
(102, 480, 1142.43, -2068.79, 68.6994, 271.187, 36, 36, 17, 0, 'NewCar'),
(103, 560, 1166.38, -2068.87, 68.7127, 270.876, 36, 36, 17, 0, 'NewCar'),
(104, 409, 1150.88, -2047.01, 68.8006, 328.206, 36, 36, 17, 0, 'NewCar'),
(105, 409, 1149.22, -2026.93, 68.8042, 226.039, 36, 36, 17, 0, 'NewCar'),
(106, 567, 1274.8, -2010.01, 58.867, 90.0461, 36, 36, 17, 0, 'NewCar'),
(107, 567, 1274.71, -2015.15, 58.8633, 89.299, 36, 36, 17, 0, 'NewCar'),
(108, 412, 1249.33, -2042.08, 59.5671, 269.475, 36, 36, 17, 0, 'NewCar'),
(109, 579, -2641.02, 1329.58, 7.12377, 269.276, 226, 226, 26, 0, 'NewCar'),
(110, 579, -2632.1, 1329.54, 7.12849, 270.012, 226, 226, 26, 0, 'NewCar'),
(111, 567, -2622.94, 1333.78, 7.06296, 315.53, 226, 226, 26, 0, 'NewCar'),
(112, 567, -2614.75, 1348.19, 7.06473, 359.124, 226, 226, 26, 0, 'NewCar'),
(113, 426, -2646.97, 1377.86, 6.91499, 180.131, 226, 226, 26, 0, 'NewCar'),
(114, 426, -2642.47, 1377.83, 6.89713, 179.498, 226, 226, 26, 0, 'NewCar'),
(115, 480, -2637.96, 1378.09, 6.9161, 181.139, 226, 1, 26, 0, 'NewCar'),
(116, 480, -2633.28, 1378.07, 6.91346, 179.36, 226, 1, 26, 0, 'NewCar'),
(117, 409, -2628.9, 1377.87, 6.93828, 180.736, 226, 1, 26, 0, 'NewCar'),
(118, 409, -2624.28, 1377.9, 6.93854, 179.54, 226, 1, 26, 0, 'NewCar'),
(119, 461, -2632.75, 1398.24, 6.67409, 185.786, 226, 226, 26, 0, 'NewCar'),
(120, 461, -2636.94, 1397.06, 6.67789, 191.746, 226, 226, 26, 0, 'NewCar'),
(121, 461, -2639.95, 1396.23, 6.67778, 194.73, 226, 226, 26, 0, 'NewCar'),
(122, 461, -2643.15, 1395.4, 6.67643, 194.266, 226, 226, 26, 0, 'NewCar'),
(123, 461, -2646.66, 1394.39, 6.67849, 197.105, 226, 226, 26, 0, 'NewCar'),
(124, 560, -2620.84, 1378.11, 6.84541, 180, 226, 226, 26, 0, 'NewCar'),
(125, 560, -2617.1, 1378.09, 6.84518, 179.676, 226, 226, 26, 0, 'NewCar'),
(126, 487, -2595, 1377.36, 7.29607, 157.663, 226, 1, 26, 0, 'NewCar'),
(127, 461, -2528.66, -622.714, 132.331, 358.731, 158, 158, 27, 0, 'NewCar'),
(128, 461, -2530.33, -622.713, 132.329, 1.20648, 158, 158, 27, 0, 'NewCar'),
(129, 461, -2532.14, -622.67, 132.321, 2.21691, 158, 158, 27, 0, 'NewCar'),
(130, 461, -2533.83, -622.63, 132.319, 4.15496, 158, 158, 27, 0, 'NewCar'),
(131, 461, -2535.79, -622.639, 132.312, 358.237, 158, 158, 27, 0, 'NewCar'),
(132, 560, -2535.46, -602, 132.267, 180.268, 158, 158, 27, 0, 'NewCar'),
(133, 560, -2531.79, -601.938, 132.268, 181.605, 158, 158, 27, 0, 'NewCar'),
(134, 409, -2528.14, -602.292, 132.362, 179.852, 158, 1, 27, 0, 'NewCar'),
(135, 409, -2524.29, -602.37, 132.362, 180.069, 158, 1, 27, 0, 'NewCar'),
(136, 480, -2520.61, -602.04, 132.336, 180.131, 158, 1, 27, 0, 'NewCar'),
(137, 480, -2516.93, -601.915, 132.335, 179.655, 158, 1, 27, 0, 'NewCar'),
(138, 426, -2513.28, -602.273, 132.306, 180.639, 158, 1, 27, 0, 'NewCar'),
(139, 426, -2509.33, -602.21, 132.306, 180.473, 158, 1, 27, 0, 'NewCar'),
(141, 567, -2505.71, -602.153, 132.433, 179.416, 158, 1, 27, 0, 'NewCar'),
(142, 567, -2501.86, -602.004, 132.43, 180.899, 158, 1, 27, 0, 'NewCar'),
(143, 579, -2498.23, -602.112, 132.494, 180.511, 158, 158, 27, 0, 'NewCar'),
(144, 579, -2494.54, -602.103, 132.493, 179.635, 158, 158, 27, 0, 'NewCar'),
(145, 487, -2466.89, -597.716, 132.589, 96.7495, 158, 1, 27, 0, 'NewCar'),
(146, 560, -2462.87, 156.383, 34.7677, 359.362, 168, 168, 25, 0, 'NewCar'),
(147, 560, -2462.82, 148.355, 34.7698, 0.642166, 168, 168, 25, 0, 'NewCar'),
(148, 480, -2445.21, 142.455, 34.8047, 270.927, 168, 1, 25, 0, 'NewCar'),
(149, 480, -2437.13, 142.491, 34.8044, 270.287, 168, 1, 25, 0, 'NewCar'),
(150, 461, -2449.63, 129.804, 34.7519, 359.406, 168, 1, 25, 0, 'NewCar'),
(151, 461, -2437.57, 129.935, 34.7491, 358.317, 168, 1, 25, 0, 'NewCar'),
(152, 461, -2447.11, 129.692, 34.7555, 359.018, 168, 1, 25, 0, 'NewCar'),
(153, 461, -2440.54, 129.925, 34.7513, 1.23639, 168, 1, 25, 0, 'NewCar'),
(154, 461, -2443.78, 129.694, 34.7523, 1.99344, 168, 1, 25, 0, 'NewCar'),
(155, 409, -2435.36, 174.096, 34.8464, 269.504, 168, 1, 25, 0, 'NewCar'),
(156, 575, -2444.47, 174.021, 34.6339, 269.378, 168, 1, 25, 0, 'NewCar'),
(158, 579, -2462.76, 166.758, 34.9598, 0.262681, 168, 1, 25, 0, 'NewCar'),
(159, 579, -2456.73, 181.601, 34.9659, 314.861, 168, 1, 25, 0, 'NewCar'),
(160, 487, -2395.54, 182.378, 35.4882, 104.948, 168, 1, 25, 0, 'NewCar'),
(161, 426, -2440.73, 185.392, 34.7705, 270.041, 168, 1, 25, 0, 'NewCar'),
(162, 510, 2146.84, 2337, 10.4201, 91.9623, -1, -1, 0, 0, 'NewCar'),
(163, 510, 2140.65, 2336.95, 10.4278, 88.4746, -1, -1, 0, 0, 'NewCar'),
(164, 510, 2149.79, 2337.01, 10.42, 89.5296, -1, -1, 0, 0, 'NewCar'),
(165, 510, 2167.42, 2337.13, 10.4201, 91.3602, -1, -1, 0, 0, 'NewCar'),
(166, 510, 2164, 2337.03, 10.4201, 89.9928, -1, -1, 0, 0, 'NewCar'),
(167, 510, 2160.16, 2337.02, 10.4201, 90.057, -1, -1, 0, 0, 'NewCar'),
(168, 510, 2153.29, 2336.96, 10.42, 91.4542, -1, -1, 0, 0, 'NewCar'),
(169, 510, 2156.5, 2337.11, 10.4201, 90.9557, -1, -1, 0, 0, 'NewCar'),
(170, 510, 2118.18, 2337.02, 10.4279, 88.0908, -1, -1, 0, 0, 'NewCar'),
(171, 510, 2171.07, 2337.1, 10.4201, 92.5655, -1, -1, 0, 0, 'NewCar'),
(172, 510, 2177.46, 2337.13, 10.4201, 90.0531, -1, -1, 0, 0, 'NewCar'),
(173, 510, 2174.32, 2336.98, 10.4201, 91.0418, -1, -1, 0, 0, 'NewCar'),
(174, 510, 2143.84, 2337.03, 10.4201, 89.8831, -1, -1, 0, 0, 'NewCar'),
(175, 510, 2121.36, 2337.11, 10.4279, 91.0577, -1, -1, 0, 0, 'NewCar'),
(176, 510, 1195.73, -1728.44, 13.1758, 180.804, -1, -1, 0, 0, 'NewCar'),
(177, 510, 1207.02, -1728.19, 13.178, 179.303, -1, -1, 0, 0, 'NewCar'),
(178, 510, 1197.64, -1728.32, 13.1757, 179.237, -1, -1, 0, 0, 'NewCar'),
(179, 510, 1204.68, -1728.23, 13.1756, 179.179, -1, -1, 0, 0, 'NewCar'),
(180, 510, 1202.74, -1728.25, 13.1756, 177.481, -1, -1, 0, 0, 'NewCar'),
(181, 510, 1199.7, -1728.31, 13.1757, 180.746, -1, -1, 0, 0, 'NewCar'),
(182, 510, 1201.19, -1728.32, 13.1757, 185.869, -1, -1, 0, 0, 'NewCar'),
(183, 510, -2412.29, 352.244, 34.7795, 232.866, -1, -1, 0, 0, 'NewCar'),
(184, 510, -2413.21, 350.935, 34.7794, 233.27, -1, -1, 0, 0, 'NewCar'),
(185, 510, -2414.12, 349.631, 34.7794, 237.222, -1, -1, 0, 0, 'NewCar'),
(186, 510, -2415.06, 348.406, 34.7794, 232.334, -1, -1, 0, 0, 'NewCar'),
(187, 510, -2415.97, 347.081, 34.7862, 238.674, -1, -1, 0, 0, 'NewCar'),
(188, 510, -2431.28, 318.569, 34.7794, 247.041, -1, -1, 0, 0, 'NewCar'),
(189, 510, -2430.74, 319.804, 34.7794, 243.33, -1, -1, 0, 0, 'NewCar'),
(190, 510, -2430.16, 320.952, 34.7794, 242.732, -1, -1, 0, 0, 'NewCar'),
(191, 510, -2429.61, 322.245, 34.7794, 241.391, -1, -1, 0, 0, 'NewCar'),
(192, 510, -2428.99, 323.606, 34.7794, 240.735, -1, -1, 0, 0, 'NewCar'),
(193, 519, 1288.18, 1361.32, 11.715, 269.125, 6, 6, 0, 0, 'NewCar'),
(194, 452, 727.349, -1493.95, -0.453706, 182.23, 0, 0, 0, 0, 'NewCar'),
(196, 487, 1337.39, 1686.72, 10.8203, 268.64, 69, 1, 0, 0, 'NewCar'),
(197, 487, 1565.11, 1416.37, 11.1591, 89.7476, 69, 1, 0, 0, 'NewCar'),
(198, 487, 1560.44, 1492.1, 10.9938, 88.59, 69, 1, 0, 0, 'NewCar'),
(199, 487, 1628.59, 1359.39, 10.8038, 135.561, 69, 1, 0, 0, 'NewCar'),
(200, 509, 2104.96, 2336.85, 10.3304, 89.6105, -1, -1, 0, 0, 'NewCar'),
(201, 509, 2107.44, 2336.86, 10.3322, 90.4862, -1, -1, 0, 0, 'NewCar'),
(202, 509, 2109.73, 2336.95, 10.3322, 91.6987, -1, -1, 0, 0, 'NewCar'),
(203, 509, 2112.51, 2337.01, 10.3322, 90.4219, -1, -1, 0, 0, 'NewCar'),
(204, 509, 2115.63, 2336.99, 10.3322, 90.5748, -1, -1, 0, 0, 'NewCar'),
(205, 510, 2124.46, 2336.92, 10.4279, 89.0498, -1, -1, 0, 0, 'NewCar'),
(206, 510, 2127.32, 2337, 10.4279, 90.7012, -1, -1, 0, 0, 'NewCar'),
(207, 510, 2130.61, 2337.05, 10.4279, 90.2094, -1, -1, 0, 0, 'NewCar'),
(208, 510, 2137.49, 2336.93, 10.4279, 88.3521, -1, -1, 0, 0, 'NewCar'),
(209, 510, 2133.82, 2337.08, 10.4279, 88.8409, -1, -1, 0, 0, 'NewCar'),
(223, 487, 1939.14, -2648.35, 13.5469, 358.001, 211, 226, 0, 0, 'NewCar'),
(224, 487, 1952.91, -2648.22, 13.7362, 355.266, 211, 226, 0, 0, 'NewCar'),
(225, 487, 1966.54, -2647.19, 13.7322, 359.022, 226, 211, 0, 0, 'NewCar'),
(226, 487, 1979.19, -2647.93, 13.74, 358.341, 226, 211, 0, 0, 'NewCar'),
(227, 487, 1994.34, -2646.78, 13.8481, 4.66419, 205, 226, 0, 0, 'NewCar'),
(228, 487, 2007.78, -2646.62, 13.7339, 356.209, 205, 226, 0, 0, 'NewCar'),
(229, 519, 1902.2, -2629.27, 14.4657, 359.1, 205, 226, 0, 0, 'NewCar'),
(230, 519, 1875.08, -2629, 14.4666, 358.408, 205, 226, 0, 0, 'NewCar'),
(231, 487, 2021.45, -2418.79, 13.7364, 88.0069, 205, 226, 0, 0, 'NewCar'),
(232, 487, 1561.18, 1471.41, 11.0104, 89.0722, 211, 226, 0, 0, 'NewCar'),
(233, 487, 1563.03, 1453.71, 11.0299, 92.2322, 211, 226, 0, 0, 'NewCar'),
(234, 487, 1563.48, 1435.56, 11.0109, 90.6671, 211, 226, 0, 0, 'NewCar'),
(235, 487, -1555.1, -225.836, 14.3655, 42.8927, 211, 226, 0, 0, 'NewCar'),
(236, 487, -1562.96, -233.924, 14.3302, 43.6249, 211, 226, 0, 0, 'NewCar'),
(237, 487, -1571.41, -242.994, 14.3243, 42.5896, 211, 226, 0, 0, 'NewCar'),
(238, 487, -1578.91, -251.836, 14.3325, 42.0404, 211, 226, 0, 0, 'NewCar'),
(239, 487, -1547.93, -217.827, 14.327, 39.8444, 211, 226, 0, 0, 'NewCar'),
(240, 519, -1284.77, 28.7138, 15.067, 134.831, 211, 226, 0, 0, 'NewCar'),
(241, 519, -1264.29, 7.99412, 15.0707, 133.567, 211, 226, 0, 0, 'NewCar'),
(242, 452, 733.655, -1496.19, -0.52491, 181.772, 226, 211, 0, 0, 'NewCar'),
(243, 452, 718.816, -1493.88, -0.439052, 182.641, 226, 211, 0, 0, 'NewCar'),
(244, 452, 1628.67, 572.255, -0.464026, 91.0879, 226, 211, 0, 0, 'NewCar'),
(245, 473, 1636.79, 587.062, -0.293964, 178.554, 226, 211, 0, 0, 'NewCar'),
(246, 473, 1636.92, 596.099, -0.405819, 185.281, 226, 211, 0, 0, 'NewCar'),
(247, 473, 1636.76, 579.707, -0.189769, 180.342, 205, 211, 0, 0, 'NewCar'),
(248, 473, 1619.74, 596.352, -0.276705, 182.294, 211, 226, 0, 0, 'NewCar'),
(249, 473, 1619.75, 586.725, -0.221683, 178.899, 211, 226, 0, 0, 'NewCar'),
(250, 473, 1619.77, 578.531, -0.27762, 179.187, 211, 226, 0, 0, 'NewCar'),
(251, 411, -1938.55, 228.96, 34.1562, 123.84, 0, 0, 0, 0, 'NewCar');

-- --------------------------------------------------------

--
-- Table structure for table `svf`
--

CREATE TABLE `svf` (
  `ID` int(11) NOT NULL,
  `Faction` int(11) NOT NULL,
  `Model` int(11) NOT NULL,
  `Rank` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  `Color1` int(11) NOT NULL,
  `Color2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `svf`
--

INSERT INTO `svf` (`ID`, `Faction`, `Model`, `Rank`, `Stock`, `Color1`, `Color2`) VALUES
(1, 1, 411, 3, 10, 1, 1),
(2, 1, 523, 1, 15, 1, 0),
(3, 1, 522, 3, 15, 1, 0),
(5, 1, 598, 1, 15, 1, 0),
(6, 1, 599, 2, 15, 1, 0),
(7, 1, 497, 3, 15, 1, 0),
(8, 1, 427, 2, 15, 1, 0),
(11, 2, 490, 1, 15, 0, 0),
(12, 2, 601, 2, 15, 0, 0),
(13, 2, 541, 2, 15, 0, 0),
(14, 2, 522, 3, 15, 0, 0),
(15, 2, 528, 1, 15, 0, 0),
(16, 2, 497, 3, 15, 0, 0),
(17, 3, 425, 3, 15, 42, 42),
(18, 3, 522, 2, 15, 42, 42),
(19, 3, 598, 1, 15, 42, 42),
(20, 3, 520, 3, 15, 1, 1),
(22, 3, 451, 3, 15, 42, 42),
(23, 3, 470, 1, 20, 42, 42),
(24, 3, 476, 2, 15, 42, 42),
(25, 3, 433, 3, 15, 42, 42),
(26, 7, 551, 1, 15, 128, 128),
(27, 7, 560, 2, 15, 128, 128),
(28, 7, 487, 3, 15, 128, 128),
(29, 8, 525, 1, 15, 1, 102),
(31, 8, 552, 2, 15, 1, 102),
(36, 11, 469, 1, 40, 0, 0),
(37, 11, 402, 1, 15, 0, 0),
(38, 11, 560, 3, 15, 0, 0),
(39, 11, 487, 3, 15, 0, 0),
(40, 11, 521, 3, 15, 0, 0),
(41, 12, 420, 1, 20, 6, 6),
(43, 12, 438, 1, 15, 6, 6),
(44, 12, 560, 3, 15, 6, 6),
(45, 12, 487, 3, 15, 6, 6),
(47, 12, 602, 2, 15, 6, 6),
(48, 12, 506, 2, 15, 6, 6),
(49, 12, 566, 2, 15, 6, 6),
(50, 13, 416, 1, 25, 1, 3),
(51, 13, 599, 2, 15, 1, 3),
(52, 13, 563, 3, 15, 1, 3),
(61, 15, 409, 1, 15, 128, 0),
(62, 15, 411, 4, 15, 128, 0),
(63, 15, 541, 3, 15, 128, 0),
(64, 15, 560, 3, 15, 128, 0),
(65, 15, 415, 2, 15, 128, 0),
(66, 15, 579, 2, 15, 128, 0),
(67, 8, 443, 3, 15, 65, 65),
(68, 16, 551, 1, 15, 128, 128),
(69, 16, 560, 2, 15, 128, 128),
(70, 16, 487, 1, 15, 128, 128),
(76, 19, 599, 1, 15, 1, 0),
(77, 19, 497, 1, 15, 1, 0),
(78, 19, 597, 1, 15, 1, 0),
(79, 19, 523, 1, 15, 1, 0),
(81, 19, 522, 2, 15, 0, 0),
(82, 19, 411, 2, 15, 1, 1),
(83, 19, 411, 3, 15, 1, 1),
(86, 20, 416, 1, 25, 3, 1),
(87, 20, 544, 1, 15, 3, 1),
(88, 20, 505, 3, 15, 3, 1),
(89, 21, 551, 1, 15, 128, 128),
(92, 21, 560, 2, 15, 128, 128),
(93, 21, 487, 1, 15, 128, 128),
(94, 19, 411, 4, 15, 1, 1),
(95, 22, 525, 1, 15, 1, 102),
(96, 22, 552, 1, 15, 1, 102),
(97, 22, 443, 3, 15, 1, 102),
(98, 23, 487, 4, 15, 117, 117),
(99, 23, 411, 3, 15, 117, 117),
(100, 23, 411, 1, 15, 117, 117),
(102, 23, 541, 2, 15, 117, 0),
(103, 23, 522, 1, 15, 117, 117),
(104, 23, 522, 2, 15, 117, 117),
(105, 0, 488, 1, 10, 126, 1),
(106, 9, 582, 1, 15, 126, 1),
(107, 9, 522, 3, 15, 126, 1),
(108, 9, 560, 4, 15, 126, 1),
(109, 0, 487, 5, 15, 126, 1),
(116, 14, 598, 1, 20, 127, 1),
(117, 14, 523, 1, 20, 127, 1),
(118, 14, 497, 1, 15, 127, 1),
(119, 14, 522, 2, 15, 127, 1),
(120, 14, 411, 3, 15, 1, 127),
(121, 24, 432, 5, 15, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Type` text NOT NULL,
  `Status` int(11) NOT NULL,
  `Priority` text NOT NULL,
  `Description` text NOT NULL,
  `Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transferlog`
--

CREATE TABLE `transferlog` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Name2` varchar(64) NOT NULL,
  `psql1` int(11) NOT NULL,
  `psql2` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `time` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `turfs`
--

CREATE TABLE `turfs` (
  `ID` int(11) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Owned` int(11) NOT NULL,
  `Time` int(11) NOT NULL,
  `MinX` float NOT NULL,
  `MinY` float NOT NULL,
  `MaxX` float NOT NULL,
  `MaxY` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `turfs`
--

INSERT INTO `turfs` (`ID`, `Name`, `Owned`, `Time`, `MinX`, `MinY`, `MaxX`, `MaxY`) VALUES
(1, '', 4, 0, 90.8647, -1353.89, 516.865, -925.885),
(2, '', 4, 0, 517.875, -1353.89, 943.875, -925.886),
(3, '', 4, 0, 943.865, -1314.89, 1371.86, -925.885),
(4, '', 4, 24, 1370.85, -1353.89, 1796.85, -925.886),
(5, '', 4, 24, 1798.85, -1353.89, 2224.85, -925.886),
(6, '', 4, 24, 2224.84, -1354.89, 2573.84, -925.886),
(7, '', 4, 24, 2573.83, -1298.89, 2923.83, -925.886),
(8, '', 4, 24, 91.8508, -1781.89, 517.851, -1353.89),
(9, '', 4, 0, 517.851, -1781.89, 943.851, -1353.89),
(10, '', 4, 24, 943.865, -1704.89, 1371.86, -1314.89),
(11, '', 4, 24, 1370.84, -1782.88, 1798.84, -1353.88),
(12, '', 4, 24, 1798.85, -1781.89, 2224.85, -1353.89),
(13, '', 4, 24, 2224.84, -1782.89, 2573.84, -1353.89),
(14, '', 4, 24, 2573.83, -1671.89, 2923.83, -1298.89),
(15, '', 4, 24, 943.832, -2133.88, 1370.83, -1704.88),
(16, '', 4, 24, 943.828, -2561.87, 1369.83, -2131.87),
(17, '', 4, 24, 1372.84, -2210.87, 1798.84, -1782.87),
(18, '', 4, 24, 1798.83, -2210.87, 2224.83, -1782.87),
(19, '', 4, 24, 2224.85, -2210.87, 2573.85, -1781.87),
(20, '', 4, 24, 2573.82, -2100.87, 2922.82, -1671.87),
(21, '', 4, 24, 1372.83, -2639.85, 1798.83, -2211.85),
(22, '', 4, 24, 1798.83, -2639.85, 2224.83, -2211.85),
(23, '', 4, 24, 2224.83, -2640.85, 2573.83, -2211.85),
(24, '', 4, 24, 2573.81, -2530.86, 2922.81, -2101.86),
(25, '', 5, 24, 1108.68, 2464.21, 1484.68, 2894.21),
(26, '', 6, 0, 1484.67, 2464.22, 1860.67, 2894.22),
(27, '', 6, 0, 1860.67, 2464.22, 2236.67, 2894.22),
(28, '', 6, 0, 2235.66, 2464.22, 2611.66, 2894.22),
(29, '', 6, 0, 2610.66, 2464.22, 2986.66, 2894.22),
(30, '', 6, 24, 888.793, 2034.22, 1282.79, 2464.22),
(31, '', 6, 24, 1282.79, 2034.22, 1676.79, 2464.22),
(32, '', 4, 24, 1676.77, 2034.22, 2070.77, 2464.22),
(33, '', 4, 24, 2071.76, 2034.22, 2465.76, 2464.22),
(34, '', 18, 24, 2465.66, 2034.22, 2985.66, 2464.22),
(35, '', 4, 24, 888.789, 1604.22, 1282.79, 2034.22),
(36, '', 4, 24, 1282.79, 1604.22, 1676.79, 2034.22),
(37, '', 4, 24, 1676.77, 1604.22, 2070.77, 2034.22),
(38, '', 4, 24, 2071.76, 1604.22, 2465.76, 2034.22),
(39, '', 4, 24, 2466.76, 1604.22, 2986.76, 2034.22),
(40, '', 4, 24, 887.789, 1174.22, 1281.79, 1604.22),
(41, '', 4, 24, 1282.79, 1174.22, 1676.79, 1604.22),
(42, '', 4, 24, 1676.77, 1174.22, 2070.77, 1604.22),
(43, '', 4, 24, 2071.76, 1174.22, 2465.76, 1604.22),
(44, '', 4, 24, 2466.76, 1174.22, 2986.76, 1604.22),
(45, '', 4, 24, 1282.77, 744.219, 1676.77, 1174.22),
(46, '', 4, 24, 1676.77, 744.219, 2070.77, 1174.22),
(47, '', 4, 24, 2071.76, 744.219, 2465.76, 1174.22),
(48, '', 4, 24, 2466.76, 744.219, 2986.76, 1174.22),
(49, '', 4, 24, -2877.02, -521.938, -2561.02, -208.938),
(50, '', 4, 24, -2561.02, -521.938, -2245.02, -208.938),
(51, '', 4, 24, -2245.02, -521.938, -1929.02, -208.938),
(52, '', 4, 24, -1929.02, -521.938, -1613.02, -208.938),
(53, '', 4, 24, -1929.02, -209.938, -1613.02, 103.062),
(54, '', 4, 24, -2245.02, -209.938, -1929.02, 103.062),
(55, '', 4, 24, -2561.02, -209.938, -2245.02, 103.062),
(56, '', 4, 24, -2877.02, -209.938, -2561.02, 103.062),
(57, '', 4, 24, -2877.02, 102.062, -2561.02, 415.062),
(58, '', 25, 24, -2561.02, 102.062, -2245.02, 415.062),
(59, '', 4, 24, -2245.02, 102.062, -1929.02, 415.062),
(60, '', 25, 24, -1929.02, 102.062, -1613.02, 415.062),
(61, '', 25, 0, -2877.02, 414.062, -2561.02, 727.062),
(62, '', 25, 24, -2561.02, 414.062, -2245.02, 727.062),
(63, '', 25, 24, -2245.02, 414.062, -1929.02, 727.062),
(64, '', 25, 0, -1929.02, 414.062, -1613.02, 727.062),
(65, '', 25, 0, -1805.02, 726.062, -1489.02, 1039.06),
(66, '', 25, 0, -2121.02, 726.062, -1805.02, 1039.06),
(67, '', 25, 0, -2437.02, 726.062, -2121.02, 1039.06),
(68, '', 25, 0, -2753.02, 726.062, -2437.02, 1039.06),
(69, '', 25, 24, -2837.02, 1038.06, -2521.02, 1351.06),
(70, '', 25, 24, -2521.02, 1038.06, -2205.02, 1351.06),
(71, '', 25, 24, -2205.02, 1038.06, -1889.02, 1351.06),
(72, '', 25, 24, -1889.02, 1038.06, -1573.02, 1351.06);

-- --------------------------------------------------------

--
-- Table structure for table `unban-comments`
--

CREATE TABLE `unban-comments` (
  `ID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Text` text NOT NULL,
  `UnbanID` int(11) NOT NULL,
  `Date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unban-panel`
--

CREATE TABLE `unban-panel` (
  `ID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `Reason` text NOT NULL,
  `Poza` text NOT NULL,
  `Description` text NOT NULL,
  `Date` text NOT NULL,
  `Now` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `byAdmin` text NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `password` varchar(128) NOT NULL,
  `IP` varchar(16) NOT NULL DEFAULT 'Not logged',
  `Level` int(3) NOT NULL DEFAULT 1,
  `Admin` int(2) NOT NULL DEFAULT 0,
  `Helper` int(2) NOT NULL DEFAULT 0,
  `Premium` int(2) NOT NULL DEFAULT 0,
  `ConnectedTime` float NOT NULL DEFAULT 0,
  `Registered` int(2) NOT NULL DEFAULT 0,
  `Sex` int(2) NOT NULL DEFAULT 0,
  `Age` int(3) NOT NULL DEFAULT 0,
  `Muted` int(2) NOT NULL DEFAULT 0,
  `MuteTime` int(11) NOT NULL DEFAULT 0,
  `Respect` int(11) NOT NULL DEFAULT 0,
  `Money` bigint(20) NOT NULL DEFAULT 0,
  `Bank` bigint(20) NOT NULL DEFAULT 0,
  `Phonebook` int(2) NOT NULL DEFAULT 0,
  `WantedLevel` int(11) NOT NULL DEFAULT 0,
  `Job` int(3) NOT NULL DEFAULT 0,
  `Jailed` int(2) NOT NULL DEFAULT 0,
  `JailTime` int(11) NOT NULL DEFAULT 0,
  `Materials` int(11) NOT NULL DEFAULT 0,
  `Drugs` int(11) NOT NULL DEFAULT 0,
  `Leader` int(3) NOT NULL DEFAULT 0,
  `Member` int(3) NOT NULL DEFAULT 0,
  `Rank` int(2) NOT NULL DEFAULT 0,
  `FWarn` int(2) NOT NULL DEFAULT 0,
  `FPunish` int(4) NOT NULL DEFAULT 0,
  `Model` int(11) NOT NULL,
  `PhoneNr` varchar(15) NOT NULL DEFAULT '0',
  `PhoneCredits` int(4) NOT NULL DEFAULT 0,
  `House` int(11) NOT NULL DEFAULT 999,
  `Bizz` int(11) NOT NULL DEFAULT 255,
  `Rob` int(11) NOT NULL DEFAULT 0,
  `CarLicT` int(11) NOT NULL DEFAULT 0,
  `CarLic` int(2) NOT NULL DEFAULT 0,
  `FlyLicT` int(11) NOT NULL DEFAULT 0,
  `FlyLic` int(2) NOT NULL DEFAULT 0,
  `BoatLicT` int(11) NOT NULL DEFAULT 0,
  `BoatLic` int(2) NOT NULL DEFAULT 0,
  `FishLicT` int(11) NOT NULL DEFAULT 0,
  `FishLic` int(2) NOT NULL DEFAULT 0,
  `GunLicT` int(11) NOT NULL DEFAULT 0,
  `GunLic` int(2) NOT NULL DEFAULT 0,
  `Tutorial` int(2) NOT NULL DEFAULT 0,
  `Warnings` int(2) NOT NULL DEFAULT 0,
  `Rented` int(111) NOT NULL DEFAULT -1,
  `Fuel` int(11) NOT NULL DEFAULT 0,
  `WTalkie` int(2) NOT NULL DEFAULT 0,
  `Lighter` int(2) NOT NULL DEFAULT 0,
  `Cigarettes` int(2) NOT NULL DEFAULT 0,
  `Email` varchar(50) NOT NULL DEFAULT 'email@yahoo.com',
  `RegisterDate` varchar(50) NOT NULL DEFAULT 'Nu exista',
  `lastOn` varchar(50) NOT NULL DEFAULT 'Nu exista',
  `Radio2` int(2) NOT NULL DEFAULT 0,
  `Status` int(11) NOT NULL DEFAULT -1,
  `Phone` int(11) NOT NULL DEFAULT 0,
  `Accused` varchar(64) NOT NULL DEFAULT '********',
  `Crime1` varchar(184) NOT NULL DEFAULT 'Fara',
  `Crime2` varchar(184) NOT NULL DEFAULT 'Fara',
  `Crime3` varchar(184) NOT NULL DEFAULT 'Fara',
  `ShowJob` int(10) NOT NULL,
  `ShowFP` int(10) NOT NULL,
  `ShowLogo` int(10) NOT NULL DEFAULT 1,
  `ShowCeas` int(10) NOT NULL DEFAULT 1,
  `GoldPoints` int(10) NOT NULL,
  `Clan` int(10) NOT NULL,
  `ClanRank` int(10) NOT NULL,
  `Pin` int(10) NOT NULL DEFAULT 0,
  `Seconds` int(10) NOT NULL,
  `GiftPoints` int(10) NOT NULL,
  `NewbieMute` int(10) NOT NULL,
  `HelpedPlayers` int(10) NOT NULL,
  `SpawnChange` int(10) NOT NULL,
  `DailyMission1` int(11) NOT NULL DEFAULT -1,
  `DailyMission2` int(11) NOT NULL DEFAULT -1,
  `Progress1` int(11) NOT NULL,
  `Progress2` int(11) NOT NULL,
  `NeedProgress1` int(10) NOT NULL,
  `NeedProgress2` int(10) NOT NULL,
  `Youtuber` int(10) NOT NULL,
  `ReportTime` int(10) NOT NULL,
  `WTChannel` int(10) NOT NULL,
  `PizzaSkill` int(10) NOT NULL,
  `GasCan` int(10) NOT NULL,
  `ShowGlasses` int(10) NOT NULL,
  `Glasses` int(10) NOT NULL,
  `HelpedPlayersToday` int(10) NOT NULL,
  `Days` int(10) NOT NULL,
  `FarmerSkill` int(10) NOT NULL,
  `PilotSkill` int(10) NOT NULL,
  `ShowHP` int(10) NOT NULL,
  `ShowAP` int(10) NOT NULL,
  `Color` int(10) NOT NULL,
  `Kicks` int(10) NOT NULL,
  `Warns` int(10) NOT NULL,
  `Bans` int(10) NOT NULL,
  `Jails` int(10) NOT NULL,
  `Mutes` int(10) NOT NULL,
  `HoursMonth` int(10) NOT NULL,
  `Vip` int(10) NOT NULL,
  `Mats` int(10) NOT NULL,
  `ClanWarns` int(10) NOT NULL,
  `ClanDays` int(10) NOT NULL,
  `CarLicS` int(10) NOT NULL,
  `FlyLicS` int(10) NOT NULL,
  `BoatLicS` int(10) NOT NULL,
  `GunLicS` int(10) NOT NULL,
  `ShowDMG` int(10) NOT NULL,
  `EscapePoints` int(10) NOT NULL,
  `AJail` int(10) NOT NULL,
  `Hat` int(10) NOT NULL,
  `ShowHat` int(10) NOT NULL,
  `NewbieChat` int(10) NOT NULL,
  `TogLC` int(10) NOT NULL,
  `TogFC` int(10) NOT NULL,
  `TogWT` int(10) NOT NULL,
  `HidePM` int(10) NOT NULL,
  `TogNews` int(10) NOT NULL,
  `TogLicitatie` int(10) NOT NULL,
  `TogClan` int(10) NOT NULL,
  `TogEvent` int(10) NOT NULL,
  `TogDing` int(10) NOT NULL,
  `PhoneOnline` int(10) NOT NULL,
  `DayLogin` int(10) NOT NULL,
  `AW` int(10) NOT NULL,
  `HW` int(10) NOT NULL,
  `LW` int(10) NOT NULL,
  `Tag` int(10) NOT NULL,
  `Referral` int(11) NOT NULL,
  `ReferralMoney` int(11) NOT NULL,
  `ReferralRP` int(11) NOT NULL,
  `SpecialQuest` varchar(300) NOT NULL DEFAULT '0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0',
  `DM` int(10) NOT NULL,
  `WarKills` int(11) NOT NULL,
  `WarDeaths` int(11) NOT NULL,
  `WarTurf` int(11) NOT NULL,
  `TogVip` int(11) NOT NULL,
  `TogSurf` int(11) NOT NULL,
  `TogFind` int(11) NOT NULL,
  `TogRaport` int(11) NOT NULL,
  `TogJob` int(11) NOT NULL,
  `TogAlert` int(11) NOT NULL,
  `ShowCP` int(11) NOT NULL,
  `AchievementStatus` varchar(256) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0',
  `WantedTime` int(10) NOT NULL,
  `ShowProgress1` int(11) NOT NULL,
  `ShowProgress2` int(11) NOT NULL,
  `DailyLogin` int(11) NOT NULL,
  `Backpack` int(11) NOT NULL,
  `Voucher` varchar(50) NOT NULL DEFAULT '0 0 0 0 0',
  `Crates` varchar(100) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0|',
  `HudGen` int(11) NOT NULL DEFAULT 1,
  `Skin` varchar(256) NOT NULL DEFAULT '250 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1 -1',
  `DailyBonus` int(11) NOT NULL,
  `PetPoints` int(11) NOT NULL,
  `PetLevel` int(11) NOT NULL DEFAULT 1,
  `PetStatus` int(11) NOT NULL,
  `Pet` int(11) NOT NULL,
  `ShowBanca` int(11) NOT NULL,
  `TogRainBow` int(11) NOT NULL,
  `Hidden` int(11) NOT NULL,
  `ShowProgress3` int(11) NOT NULL,
  `JobOwner` int(11) NOT NULL,
  `Tickete` varchar(64) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0',
  `Quest` int(11) NOT NULL,
  `Credit` int(11) NOT NULL,
  `Slot` int(11) NOT NULL DEFAULT 3,
  `TogPremium` int(11) NOT NULL,
  `ShowProgress4` int(11) NOT NULL,
  `QuestFinish` int(11) NOT NULL,
  `Guns` varchar(50) NOT NULL DEFAULT '0 0 0 0 0 0',
  `DailyActivity` int(11) NOT NULL,
  `BPoints` int(11) NOT NULL,
  `job_skills_points` varchar(50) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0',
  `job_skills` varchar(50) NOT NULL DEFAULT '1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1 1',
  `Fireworks` int(11) NOT NULL,
  `FightStyle` int(11) NOT NULL,
  `PanelNoticeEdited` varchar(100) NOT NULL,
  `PanelNotice` varchar(250) NOT NULL,
  `hunger` varchar(50) NOT NULL DEFAULT '0 0 0 0 0',
  `emotes` varchar(50) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0',
  `KeyEmote1` int(11) NOT NULL DEFAULT -1,
  `KeyEmote2` int(11) NOT NULL DEFAULT -1,
  `CaseBattle` int(11) NOT NULL,
  `Raport` varchar(30) DEFAULT '0 0 0',
  `RaportExpire` int(11) NOT NULL DEFAULT -1,
  `TogTransfer` int(11) NOT NULL DEFAULT 1,
  `TogFriend` int(11) NOT NULL DEFAULT 1,
  `TogJobGoal` int(11) NOT NULL DEFAULT 1,
  `goal` int(11) NOT NULL,
  `DailyMission3` int(11) NOT NULL DEFAULT -1,
  `NeedProgress3` int(11) NOT NULL,
  `Progress3` int(11) NOT NULL,
  `ConnectedMonth` float NOT NULL DEFAULT 0,
  `Tester` tinyint(1) NOT NULL,
  `name_and_tag` varchar(50) NOT NULL,
  `panelStyle` int(11) NOT NULL,
  `ticketsArhive` int(11) NOT NULL,
  `complaintsArhive` int(11) NOT NULL,
  `ClanMoney` int(11) NOT NULL,
  `ClanPP` int(11) NOT NULL,
  `PetName` varchar(32) NOT NULL,
  `Acceptpoints` int(11) NOT NULL,
  `Reborn` int(11) NOT NULL,
  `Victim` varchar(32) NOT NULL DEFAULT 'None',
  `shards` varchar(50) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0',
  `lasers` varchar(100) NOT NULL DEFAULT '0 0 0 0 0 0',
  `hats` varchar(100) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0 0',
  `WantedDeaths` int(11) NOT NULL,
  `Rainbows` varchar(32) NOT NULL DEFAULT '0 0 0 0 0',
  `RainbowType` int(11) NOT NULL,
  `CasinoCredit` int(11) NOT NULL,
  `crime` varchar(144) NOT NULL,
  `TogLegend` int(11) NOT NULL,
  `stats_info` varchar(144) NOT NULL DEFAULT '0 0 0 0 0',
  `ChatColor` varchar(10) NOT NULL DEFAULT 'FFFFFF',
  `Stucks` int(11) NOT NULL,
  `Cheaters` int(11) NOT NULL,
  `A_DM` int(11) NOT NULL,
  `Complaints` int(11) NOT NULL,
  `acover` varchar(32) NOT NULL,
  `thema` tinyint(1) NOT NULL,
  `ExpHW` int(11) NOT NULL,
  `ExpLW` int(11) NOT NULL,
  `ExpAW` int(11) NOT NULL,
  `ExpFW` int(11) NOT NULL,
  `Progress4` int(11) NOT NULL,
  `Progress5` int(11) NOT NULL,
  `DailyMission4` int(11) NOT NULL DEFAULT -1,
  `DailyMission5` int(11) NOT NULL DEFAULT -1,
  `NeedProgress4` int(11) NOT NULL,
  `NeedProgress5` int(11) NOT NULL,
  `restriction` int(11) NOT NULL,
  `special_quests` varchar(32) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0',
  `Tier` int(11) NOT NULL,
  `BpExp` int(11) NOT NULL,
  `missions_bp` varchar(144) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0',
  `bp_claimed` varchar(144) NOT NULL DEFAULT '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0',
  `GoldPass` int(11) NOT NULL,
  `in_concurs` int(11) NOT NULL,
  `Parkour` int(11) NOT NULL,
  `ApplyDeelay` int(11) NOT NULL,
  `intro` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `war_logs`
--

CREATE TABLE `war_logs` (
  `ID` int(11) NOT NULL,
  `attackers` int(11) NOT NULL,
  `attackers_score` float NOT NULL,
  `defender` int(11) NOT NULL,
  `defender_score` float NOT NULL,
  `Time` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `war_members`
--

CREATE TABLE `war_members` (
  `ID` int(11) NOT NULL,
  `username` varchar(24) NOT NULL,
  `faction` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `kills` int(11) NOT NULL,
  `deaths` int(11) NOT NULL,
  `TurfTime` int(11) NOT NULL,
  `for_war` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `atm`
--
ALTER TABLE `atm`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `banlog`
--
ALTER TABLE `banlog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bizz`
--
ALTER TABLE `bizz`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `blacklist`
--
ALTER TABLE `blacklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `clanhq`
--
ALTER TABLE `clanhq`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `clans`
--
ALTER TABLE `clans`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `clanvehicle`
--
ALTER TABLE `clanvehicle`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `dsveh`
--
ALTER TABLE `dsveh`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `eat_stand`
--
ALTER TABLE `eat_stand`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `factionlog`
--
ALTER TABLE `factionlog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `factions`
--
ALTER TABLE `factions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faction_apply`
--
ALTER TABLE `faction_apply`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faction_logs`
--
ALTER TABLE `faction_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `garages`
--
ALTER TABLE `garages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `graffiti`
--
ALTER TABLE `graffiti`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `iplogs`
--
ALTER TABLE `iplogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `kenny_happs`
--
ALTER TABLE `kenny_happs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kenny_hquestions`
--
ALTER TABLE `kenny_hquestions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kenny_lapps`
--
ALTER TABLE `kenny_lapps`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kenny_lquestions`
--
ALTER TABLE `kenny_lquestions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `key`
--
ALTER TABLE `key`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `money_logs`
--
ALTER TABLE `money_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_answers`
--
ALTER TABLE `panel_answers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_applications`
--
ALTER TABLE `panel_applications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_badge`
--
ALTER TABLE `panel_badge`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_comment`
--
ALTER TABLE `panel_comment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_comment_complaints`
--
ALTER TABLE `panel_comment_complaints`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_comment_tickets`
--
ALTER TABLE `panel_comment_tickets`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_complaints`
--
ALTER TABLE `panel_complaints`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_question`
--
ALTER TABLE `panel_question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_queue`
--
ALTER TABLE `panel_queue`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_recovery`
--
ALTER TABLE `panel_recovery`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_suspend`
--
ALTER TABLE `panel_suspend`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_tickets`
--
ALTER TABLE `panel_tickets`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `panel_unban`
--
ALTER TABLE `panel_unban`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `safezones`
--
ALTER TABLE `safezones`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `sanctions`
--
ALTER TABLE `sanctions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `seif`
--
ALTER TABLE `seif`
  ADD PRIMARY KEY (`sID`);

--
-- Indexes for table `stuff`
--
ALTER TABLE `stuff`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `svehicles`
--
ALTER TABLE `svehicles`
  ADD PRIMARY KEY (`vID`);

--
-- Indexes for table `svf`
--
ALTER TABLE `svf`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transferlog`
--
ALTER TABLE `transferlog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `turfs`
--
ALTER TABLE `turfs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `unban-comments`
--
ALTER TABLE `unban-comments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `unban-panel`
--
ALTER TABLE `unban-panel`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `war_logs`
--
ALTER TABLE `war_logs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `war_members`
--
ALTER TABLE `war_members`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `atm`
--
ALTER TABLE `atm`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banlog`
--
ALTER TABLE `banlog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bans`
--
ALTER TABLE `bans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bizz`
--
ALTER TABLE `bizz`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `blacklist`
--
ALTER TABLE `blacklist`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clanhq`
--
ALTER TABLE `clanhq`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clans`
--
ALTER TABLE `clans`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clanvehicle`
--
ALTER TABLE `clanvehicle`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dsveh`
--
ALTER TABLE `dsveh`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `eat_stand`
--
ALTER TABLE `eat_stand`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `factionlog`
--
ALTER TABLE `factionlog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `factions`
--
ALTER TABLE `factions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `faction_apply`
--
ALTER TABLE `faction_apply`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faction_logs`
--
ALTER TABLE `faction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `garages`
--
ALTER TABLE `garages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `graffiti`
--
ALTER TABLE `graffiti`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `iplogs`
--
ALTER TABLE `iplogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `kenny_lapps`
--
ALTER TABLE `kenny_lapps`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kenny_lquestions`
--
ALTER TABLE `kenny_lquestions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `key`
--
ALTER TABLE `key`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `money_logs`
--
ALTER TABLE `money_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_answers`
--
ALTER TABLE `panel_answers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_applications`
--
ALTER TABLE `panel_applications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_badge`
--
ALTER TABLE `panel_badge`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_comment`
--
ALTER TABLE `panel_comment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_comment_complaints`
--
ALTER TABLE `panel_comment_complaints`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_comment_tickets`
--
ALTER TABLE `panel_comment_tickets`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_complaints`
--
ALTER TABLE `panel_complaints`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_question`
--
ALTER TABLE `panel_question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_queue`
--
ALTER TABLE `panel_queue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_recovery`
--
ALTER TABLE `panel_recovery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_suspend`
--
ALTER TABLE `panel_suspend`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_tickets`
--
ALTER TABLE `panel_tickets`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `panel_unban`
--
ALTER TABLE `panel_unban`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `safezones`
--
ALTER TABLE `safezones`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sanctions`
--
ALTER TABLE `sanctions`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seif`
--
ALTER TABLE `seif`
  MODIFY `sID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `stuff`
--
ALTER TABLE `stuff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `svehicles`
--
ALTER TABLE `svehicles`
  MODIFY `vID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=252;

--
-- AUTO_INCREMENT for table `svf`
--
ALTER TABLE `svf`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transferlog`
--
ALTER TABLE `transferlog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `turfs`
--
ALTER TABLE `turfs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `unban-comments`
--
ALTER TABLE `unban-comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unban-panel`
--
ALTER TABLE `unban-panel`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `war_logs`
--
ALTER TABLE `war_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `war_members`
--
ALTER TABLE `war_members`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
