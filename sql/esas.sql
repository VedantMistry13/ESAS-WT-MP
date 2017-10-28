-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 28, 2017 at 06:30 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esas`
--

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `_id` int(11) NOT NULL,
  `course_id` varchar(5) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `held_on` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`_id`, `course_id`, `course_name`, `held_on`, `start_time`, `end_time`, `room_no`) VALUES
(1, 'CS-01', 'Data Structures', '2017-11-12', '08:00:00', '09:00:00', 2),
(2, 'CS-02', 'Programming in C', '2017-11-13', '08:00:00', '09:00:00', 2),
(3, 'CS-03', 'Digital Electronics', '2017-11-14', '10:00:00', '11:00:00', 9),
(4, 'CS-04', 'Theoretical Computer Sci.', '2017-11-16', '09:00:00', '10:00:00', 7),
(5, 'CS-05', 'Web Technology', '2017-10-17', '09:00:00', '10:00:00', 5),
(6, 'CS-06', 'Operating Systems', '2017-10-19', '09:00:00', '10:00:00', 4),
(7, 'CS-07', 'ECCF', '2017-10-20', '10:00:00', '11:00:00', 6);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `position` varchar(25) NOT NULL,
  `noa` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`_id`, `firstname`, `lastname`, `email`, `position`, `noa`, `available`) VALUES
(1, 'Ananya', 'Rane', 'ananya.sharma@ves.ac.in', 'professor', 1, 0),
(2, 'Arun', 'Kapoor', 'arunm@ves.ac.in', 'lecturer', 6, 0),
(3, 'Kajol', 'Bhatnakar', 'kajolb@ves.ac.in', 'professor', 1, 0),
(4, 'Kaushal', 'Mhalgi', 'kmhalgi@ves.ac.in', 'associateProfessor', 2, 1),
(5, 'Krishna', 'Murthi', 'krish.murthi@ves.ac.in', 'assistantProfessor', 4, 1),
(6, 'Rahul', 'Narayanan', 'rahuln@ves.ac.in', 'lecturer', 6, 1),
(7, 'Rajesh', 'Rastogi', 'rajesh.rastogi@ves.ac.in', 'professor', 1, 0),
(8, 'Ram', 'Patil', 'ramsharma@ves.ac.in', 'assistantProfessor', 4, 1),
(9, 'Raksham', 'Pandey', 'rpandey@ves.ac.in', 'assistantProfessor', 4, 1),
(10, 'Varun', 'Kamble', 'varun@ves.ac.in', 'professor', 1, 1),
(11, 'Vedant', 'Mistry', 'vedant.mistry@ves.ac.in', 'lecturer', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Vedant', 'Mistry', 'vedant@ves.ac.in', 'vedant123'),
(3, 'Raksham', 'Pandey', 'rpandey@ves.ac.in', 'panrak101'),
(4, 'Kaushal', 'Mhalgi', 'kmhalgi@ves.ac.in', 'kazzzrox'),
(5, 'Shubham', 'Parulekar', 'sparulekar@ves.ac.in', '125796');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
