-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2012 at 08:20 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rubric_creator`
--

-- --------------------------------------------------------

--
-- Table structure for table `rubric_assignment`
--

CREATE TABLE IF NOT EXISTS `rubric_assignment` (
  `assignment_id` int(5) NOT NULL AUTO_INCREMENT,
  `assignment_author` varchar(35) NOT NULL,
  `assignment_title` varchar(80) NOT NULL,
  `assignment_description` varchar(140) NOT NULL,
  `assignment_class_id` int(5) NOT NULL,
  `assignment_duedate` date NOT NULL,
  `assignment_points` int(5) NOT NULL,
  PRIMARY KEY (`assignment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `rubric_assignment`
--

INSERT INTO `rubric_assignment` (`assignment_id`, `assignment_author`, `assignment_title`, `assignment_description`, `assignment_class_id`, `assignment_duedate`, `assignment_points`) VALUES
(3, 'jenn', 'Mah assignment #1', 'Just a test project to be graded.', 5, '2012-02-10', 100);

-- --------------------------------------------------------

--
-- Table structure for table `rubric_class`
--

CREATE TABLE IF NOT EXISTS `rubric_class` (
  `class_id` int(5) NOT NULL AUTO_INCREMENT,
  `class_author` varchar(35) NOT NULL,
  `class_title` varchar(80) NOT NULL,
  `class_meetingtime` varchar(80) NOT NULL,
  `class_notes` text NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `rubric_class`
--

INSERT INTO `rubric_class` (`class_id`, `class_author`, `class_title`, `class_meetingtime`, `class_notes`) VALUES
(5, 'jenn', 'cmpt109-23', 'Spring 2012', 'Fake class to test this damn thang.'),
(6, 'jenn', 'cmpt183-04', 'spring 2012', 'A good section.');

-- --------------------------------------------------------

--
-- Table structure for table `rubric_form`
--

CREATE TABLE IF NOT EXISTS `rubric_form` (
  `rubric_id` int(5) NOT NULL AUTO_INCREMENT,
  `rubric_title` varchar(70) NOT NULL,
  `rubric_description` varchar(140) NOT NULL,
  `rubric_author` varchar(35) NOT NULL,
  `rubric_content` longtext NOT NULL,
  PRIMARY KEY (`rubric_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `rubric_form`
--

INSERT INTO `rubric_form` (`rubric_id`, `rubric_title`, `rubric_description`, `rubric_author`, `rubric_content`) VALUES
(4, 'SHORTY SHORTY', 'Just to test!', 'jenn', 'title	CMPT109 Project 1\r\nplaintext	<h2>For the report</h2>\r\ncriteria	radio	a. Clearly defined research question	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	b. summary statistics paragraph (includes mean, median, mode, maximum, standard deviation, and count for all dependent variables involved in research question)	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	c. figure 1 observation paragraph using GEE style	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	d. figure 1 is readable, clearly referred to in the text, & supports/illustrates observations made in report	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	e. figure 2 observation paragraph using GEE style	Excellent	10	Good	9	Average	7	Poor	3	Zero	0'),
(6, 'THE ULTIMATE TEST RUBRIC', 'Bleep blob bloop.', 'jenn', 'title	Jenn''s Form									\r\nplaintext	Here is my form. It''s awesome and <b>HTML</b> friendly!									\r\ncriteria	radio	Question 1 answers are correct	Yes, they are correct.	5	No, they are not correct.	0		\r\ncriteria	checklist	Question 2 was...	Awesome	5	Correct	5	Incorrect	0	Good effort	2\r\ncriteria	textarea	Extra credit'),
(8, 'EDITED FORM!', 'I think this just might work!', 'jenn', 'title	CMPT109 Project 1\r\nplaintext	<h2>For the report</h2>\r\ncriteria	radio	a. Clearly defined research question	Excellent	10	Good	9	Average	7	Poor	3	Zero	0');

-- --------------------------------------------------------

--
-- Table structure for table `rubric_grade`
--

CREATE TABLE IF NOT EXISTS `rubric_grade` (
  `grade_student` varchar(80) NOT NULL,
  `grade_rubric_id` int(5) NOT NULL,
  `grade_assignment_id` int(5) NOT NULL,
  `grade_content` longtext NOT NULL,
  `grade_points` int(5) NOT NULL,
  UNIQUE KEY `grade_student` (`grade_student`,`grade_assignment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubric_grade`
--

INSERT INTO `rubric_grade` (`grade_student`, `grade_rubric_id`, `grade_assignment_id`, `grade_content`, `grade_points`) VALUES
('', 4, 3, '[ student :::  ][ rubric-assignment ::: 3 ][ rubric-id ::: 4 ][ title ::: CMPT109 Project 1\r\n ][ plaintext ::: <h2>For the report</h2>\r\n ][ item-1 ::: 10 ][ comment-1 :::  ][ item-2 ::: 0 ][ comment-2 :::  ][ item-3 ::: 0 ][ comment-3 ::: adfadfds ][ item-4 ::: 3 ][ comment-4 :::  ][ item-5 ::: 0 ][ comment-5 :::  ]', 20),
('schifferj@mail.montclair.edu', 8, 3, '[ student ::: schifferj@mail.montclair.edu ][ rubric-assignment ::: 3 ][ rubric-id ::: 8 ][ title ::: CMPT109 Project 1\r\n ][ plaintext ::: <h2>For the report</h2>\r\n ][ item-1 ::: 9 ][ comment-1 ::: adfad ]', 20);

-- --------------------------------------------------------

--
-- Table structure for table `rubric_student`
--

CREATE TABLE IF NOT EXISTS `rubric_student` (
  `student_id` int(5) NOT NULL AUTO_INCREMENT,
  `student_name` varchar(80) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rubric_user`
--

CREATE TABLE IF NOT EXISTS `rubric_user` (
  `user_login` varchar(35) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_nicename` varchar(80) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  PRIMARY KEY (`user_login`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rubric_user`
--

INSERT INTO `rubric_user` (`user_login`, `user_password`, `user_email`, `user_nicename`, `user_role`) VALUES
('jenn', 'jenn', 'jjschiffer@gmail.com', 'Jenn Schiffer', 'grader');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
