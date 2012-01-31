-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2012 at 08:15 PM
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
  `assignment_title` varchar(80) NOT NULL,
  `assignment_description` varchar(140) NOT NULL,
  `assignment_duedate` date NOT NULL,
  `assignment_rubric` int(5) NOT NULL,
  `assignment_points` int(5) NOT NULL,
  PRIMARY KEY (`assignment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rubric_form`
--

INSERT INTO `rubric_form` (`rubric_id`, `rubric_title`, `rubric_description`, `rubric_author`, `rubric_content`) VALUES
(1, 'CMPT109 Project #1', 'Dr. Hill''s first project for her section of CMPT109. I''m not sure when it''s due, but this will have to do until she gets me the CMPT 183 rub', 'jenn', 'title	CMPT109 Project 1\r\nplaintext	<h2>For the report</h2>\r\ncriteria	radio	a. Clearly defined research question	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	b. summary statistics paragraph (includes mean, median, mode, maximum, standard deviation, and count for all dependent variables involved in research question)	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	c. figure 1 observation paragraph using GEE style	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	d. figure 1 is readable, clearly referred to in the text, & supports/illustrates observations made in report	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	e. figure 2 observation paragraph using GEE style	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	f. figure 2 is readable, clearly referred to in the text, & supports/illustrates observations made in report	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	g. conclusion paragraph	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	h. at least one figure observation paragraph uses a new variable generated in spreadsheet (derived from 2+ other columns of data handed out)	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\nplaintext	<h2>For the spreadsheet</h2>\r\ncriteria	radio	i. Must be xls, xlsx, or ods spreadsheet document and NOT a csv file	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	j. Includes data from at least 2 CSV files (Choose any two from: SNOW, SNWD, PRCP, TMAX, & TMIN)	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	k. Includes data from at least 25 year-stationid combinations	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	l. column headings are boldface & frozen	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	m. data is sorted by some column other than the stationid	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	n. added at least one new column derived from some combination of other columns (''new variable'')	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\nplaintext	<h2>Should include 4 figures, 2 of which are in the final report. Each figure should convey meaningful information about the data, and be clearly labelled (axes & title/description)</h2>\r\ncriteria	radio	o. Figure 1	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	p. Figure 2	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	q. Figure 3	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	r. Figure 4	Excellent	10	Good	9	Average	7	Poor	3	Zero	0\r\ncriteria	radio	s. At least one of the figures plots composite data from the new variable	Excellent	10	Good	9	Average	7	Poor	3	Zero	0');

-- --------------------------------------------------------

--
-- Table structure for table `rubric_grade`
--

CREATE TABLE IF NOT EXISTS `rubric_grade` (
  `grade_student` int(80) NOT NULL,
  `grade_assignment` int(5) NOT NULL,
  `grade_content` longtext NOT NULL,
  `grade_points` int(5) NOT NULL,
  PRIMARY KEY (`grade_student`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
