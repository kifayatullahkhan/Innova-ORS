-- phpMyAdmin SQL Dump
-- version 2.9.0.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Mar 07, 2008 at 01:27 AM
-- Server version: 5.0.27
-- PHP Version: 5.2.0
-- 
-- Database: `innova_kizmo`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `certificate`
-- 

CREATE TABLE `certificate` (
  `cert_id` int(15) NOT NULL auto_increment,
  `std_id` int(15) default NULL,
  `date` date default NULL,
  `class_code` varchar(20) collate utf8_unicode_ci NOT NULL default 'AAAAAA',
  `grade` char(2) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`cert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4000 ;

-- 
-- Dumping data for table `certificate`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `classes`
-- 

CREATE TABLE `classes` (
  `class_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `timing` time default NULL,
  `course_code` varchar(15) collate utf8_unicode_ci default NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `active` int(1) default NULL,
  `modified_fee` int(11) default NULL,
  PRIMARY KEY  (`class_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `classes`
-- 

INSERT INTO `classes` (`class_code`, `timing`, `course_code`, `start_date`, `end_date`, `active`, `modified_fee`) VALUES 
('ACC1PH080302', '08:00:00', 'ACC1PH', '2008-03-02', '2008-05-02', 1, 3000),
('ACC1PH080307', '08:00:00', 'ACC1PH', '2007-03-02', '2007-05-02', 0, 3000),
('ACC1PH08032', '08:00:00', 'ACC1PH', '2008-03-02', '0000-00-00', 1, 3000),
('ACC2DI080302', '12:45:00', 'ACC2DI', '2007-03-02', '2007-05-02', 0, 8000),
('ACC2DI080356', '12:15:00', 'ACC2DI', '2008-03-02', '2008-05-02', 1, 8000),
('PRC1AP080301', '09:30:00', 'PRC1AP', '2008-03-01', '2008-05-01', 1, 3500),
('WEB2AN080302', '08:00:00', 'WEB2AN', '2008-03-02', '2008-05-02', 1, 5000),
('WEB2AN080334', '14:00:00', 'WEB2AN', '2008-03-02', '2008-05-02', 1, 5000),
('WEB2AN080344', '12:00:00', 'WEB2AN', '2008-03-02', '2008-05-02', 1, 5000);

-- --------------------------------------------------------

-- 
-- Table structure for table `course_outline`
-- 

CREATE TABLE `course_outline` (
  `course_outline_id` int(11) NOT NULL auto_increment,
  `course_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `Title` varchar(50) collate utf8_unicode_ci NOT NULL,
  `Details` varchar(6000) collate utf8_unicode_ci NOT NULL,
  `Duration` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`course_outline_id`),
  UNIQUE KEY `course_code` (`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Course Outlines' AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `course_outline`
-- 

INSERT INTO `course_outline` (`course_outline_id`, `course_code`, `Title`, `Details`, `Duration`) VALUES 
(1, 'PRG1JV', 'test', '<p>cvbcvbvbcv</p>', 'dfgdfgf'),
(2, 'WEB2PH', 'PHP Programming', '<p>fsdfsdfsdfsdfsdfdsfdsfsdf</p>', '3 Months'),
(3, 'WEB1CW', 'sdfsdfsd', '<p>sdfdsfsdfsd</p>', 'fsdfsdfsdfds'),
(4, 'DIT1IT', 'asdasdasd', '', 'asdasdasdas'),
(5, 'PRG1CP', 'zfas', '', 'fsadfsdfsdfsd'),
(6, 'GRP3DG', 'sdfsdf', '<p>sdfsdfsdfsdfsdfsdf</p>', 'sdfsdfsdf'),
(7, '', 'sdfds', '<p>xcvccx</p>', 'fsdfsdfsd'),
(8, 'ACC1PH', 'dgd', '', 'gdfgdfgdf'),
(10, 'NET1DN', 'DFGFDGDF', '<p>DFGFDGDFGDFG</p>', 'DFGDFGFD');

-- --------------------------------------------------------

-- 
-- Table structure for table `courses`
-- 

CREATE TABLE `courses` (
  `course_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `name` varchar(100) character set utf8 default NULL,
  `fee` int(5) default NULL,
  PRIMARY KEY  (`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Courses Offered';

-- 
-- Dumping data for table `courses`
-- 

INSERT INTO `courses` (`course_code`, `name`, `fee`) VALUES 
('ACC1PH', 'Accounting/peachtree', 3000),
('ACC2DI', 'Diploma in Accounting', 8000),
('DBA1MG', 'DBA Management', 12000),
('DBS1OA', 'OCP (DBA)', 10000),
('DBS1OC', 'Oracle', 3000),
('DBS1OD', 'OCP Developer', 8000),
('DBS2AC', 'MS ACCESS', 2500),
('DIT1IT', 'DIT(Diploma in Information technaloge)', 6500),
('GPR2FW', 'Fire Works', 4000),
('GRP2AI', 'Adobe Image Styler', 4000),
('GRP2AP', 'Adobe Photoshop', 4000),
('GRP2CC', 'Visual Basic', 4000),
('GRP2GR', 'Graphic Designing for the web', 3500),
('GRP2MF', 'Macromedia Flash', 4000),
('GRP3DG', 'Diploma in Graphics', 6000),
('NET1CC', 'CCNA', 6000),
('NET1DN', 'Diploma In Network', 8000),
('NET1LA', 'Linux Administration', 6000),
('NET1MC', 'Microsoft Certified System Engineer', 4500),
('NET1WN', 'Wireless networking', 3000),
('OFF1OA', 'Office Automation', 3000),
('PRC1AP', 'A+ Certification', 3000),
('PRC1PN', 'Practical networking', 4000),
('PRC1WN', 'Windows', 3000),
('PRC2PH', 'Practical Networking', 1500),
('PRG1CP', 'C / C++', 4000),
('PRG1JV', 'Java', 3000),
('PRG2CS', 'C# (C Sharp)', 5000),
('PRG2MC', 'Micro controller programming', 2000),
('PRG2VB', 'VB.NET', 5000),
('PRG2VC', 'Visual C++', 5000),
('PRJ2AS', 'ASP+ Sql Server/ Access', 4000),
('PRJ2MF', 'Macromedia Flash', 4000),
('PRJ2OD', 'Oracle Developer 2000', 4000),
('PRJ2PM', 'PHP+MySql', 4000),
('PRJ2VB', 'VB+Sql Server/Access', 2000),
('WEB1CW', 'ECommerce', 6000),
('WEB1WE', 'Web Engineering', 6000),
('WEB2AN', 'Asp.Net', 5000),
('WEB2AS', 'Asp', 5000),
('WEB2PH', 'PHP', 4000);

-- --------------------------------------------------------

-- 
-- Table structure for table `dt_months`
-- 

CREATE TABLE `dt_months` (
  `month_dgt` int(11) NOT NULL,
  `month_title` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`month_dgt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='12 Months of the Year';

-- 
-- Dumping data for table `dt_months`
-- 

INSERT INTO `dt_months` (`month_dgt`, `month_title`) VALUES 
(1, 'January'),
(2, 'February'),
(3, 'March'),
(4, 'April'),
(5, 'May'),
(6, 'June'),
(7, 'July'),
(8, 'August'),
(9, 'September'),
(10, 'October'),
(11, 'November'),
(12, 'December');

-- --------------------------------------------------------

-- 
-- Table structure for table `exp_type`
-- 

CREATE TABLE `exp_type` (
  `exp_type_id` int(11) NOT NULL auto_increment,
  `name` varchar(30) collate utf8_unicode_ci default NULL,
  `type` char(1) collate utf8_unicode_ci default NULL,
  `comments` varchar(200) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`exp_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `exp_type`
-- 

INSERT INTO `exp_type` (`exp_type_id`, `name`, `type`, `comments`) VALUES 
(1, 'Building Rent', 'F', 'Monthly building rent paid to the owner.(3500)'),
(2, 'Eelctricity Bill', 'V', 'Monthly Electricity Bill'),
(3, 'Meals and Food', 'V', 'Dealy Meals and Food Charges'),
(5, 'Motor car charges', 'V', 'Motor car fuel and repair charges'),
(6, 'Stationary & Paper', 'V', 'Stationary & Paper charges'),
(7, 'Miscellaneous Charges', 'V', 'Miscellaneous Expenses of various purchases or service repairs');

-- --------------------------------------------------------

-- 
-- Table structure for table `expenses`
-- 

CREATE TABLE `expenses` (
  `exp_id` int(30) NOT NULL auto_increment,
  `voucher_number` varchar(5) collate utf8_unicode_ci default NULL,
  `amount` int(7) default NULL,
  `date` date default NULL,
  `description` varchar(255) collate utf8_unicode_ci default NULL,
  `exp_type_id` int(11) default NULL,
  PRIMARY KEY  (`exp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `expenses`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `receipts`
-- 

CREATE TABLE `receipts` (
  `receipt_id` int(20) NOT NULL auto_increment,
  `recipt_number` varchar(4) collate utf8_unicode_ci default NULL,
  `std_id` int(15) default NULL,
  `amount` int(5) default NULL,
  `date` date default NULL,
  `class_code` varchar(14) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `receipts`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `sallaries`
-- 

CREATE TABLE `sallaries` (
  `sallary_id` int(15) NOT NULL auto_increment,
  `amount` int(7) NOT NULL default '0',
  `date` date default NULL,
  `user_id` int(11) NOT NULL default '0',
  `month` varchar(20) collate utf8_unicode_ci default NULL,
  PRIMARY KEY  (`sallary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `sallaries`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `std_classes`
-- 

CREATE TABLE `std_classes` (
  `std_class_id` bigint(20) NOT NULL auto_increment,
  `std_id` bigint(20) NOT NULL,
  `class_code` varchar(20) collate utf8_unicode_ci NOT NULL,
  `joining_date` date NOT NULL,
  `agreed_fee` int(11) NOT NULL COMMENT 'agreed fee the student has to pay',
  PRIMARY KEY  (`std_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Classes Joined by Student' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `std_classes`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `std_perm_address`
-- 

CREATE TABLE `std_perm_address` (
  `perm_add_id` bigint(20) NOT NULL auto_increment,
  `std_id` bigint(20) NOT NULL default '0',
  `address` varchar(150) collate utf8_unicode_ci NOT NULL,
  `city` varchar(20) collate utf8_unicode_ci NOT NULL,
  `post_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `county_province` varchar(20) collate utf8_unicode_ci NOT NULL,
  `country` varchar(25) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`perm_add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Applicant Permanent Address' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `std_perm_address`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `std_qualification`
-- 

CREATE TABLE `std_qualification` (
  `qualification_id` bigint(20) NOT NULL auto_increment,
  `institute_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `degree_certificate` varchar(50) collate utf8_unicode_ci NOT NULL,
  `subject` varchar(50) collate utf8_unicode_ci NOT NULL,
  `session` varchar(15) collate utf8_unicode_ci NOT NULL,
  `grade_percentage` varchar(5) collate utf8_unicode_ci NOT NULL,
  `comments` varchar(150) collate utf8_unicode_ci NOT NULL,
  `std_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`qualification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Student Education Details' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `std_qualification`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `std_references`
-- 

CREATE TABLE `std_references` (
  `reference_id` bigint(20) NOT NULL auto_increment,
  `std_id` bigint(20) NOT NULL default '0',
  `name` varchar(25) collate utf8_unicode_ci NOT NULL default '',
  `position` varchar(25) collate utf8_unicode_ci NOT NULL default '',
  `address` varchar(100) collate utf8_unicode_ci NOT NULL default '',
  `country` varchar(50) collate utf8_unicode_ci NOT NULL default '',
  `post_code` varchar(10) collate utf8_unicode_ci NOT NULL default '',
  `phone_no` varchar(16) collate utf8_unicode_ci NOT NULL default '',
  `fax_no` varchar(16) collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(150) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='student referees' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `std_references`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `std_temp_address`
-- 

CREATE TABLE `std_temp_address` (
  `temp_add_id` bigint(20) NOT NULL auto_increment,
  `std_id` bigint(20) NOT NULL default '0',
  `address` varchar(150) collate utf8_unicode_ci NOT NULL,
  `city` varchar(20) collate utf8_unicode_ci NOT NULL,
  `post_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `county_province` varchar(20) collate utf8_unicode_ci NOT NULL,
  `country` varchar(25) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`temp_add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `std_temp_address`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `std_work_experience`
-- 

CREATE TABLE `std_work_experience` (
  `work_exp_id` bigint(20) NOT NULL auto_increment,
  `position` varchar(15) collate utf8_unicode_ci NOT NULL,
  `organization` varchar(20) collate utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `address` varchar(100) collate utf8_unicode_ci NOT NULL,
  `std_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`work_exp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Student Work Experiences' AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `std_work_experience`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `students`
-- 

CREATE TABLE `students` (
  `std_id` bigint(20) NOT NULL auto_increment,
  `title` varchar(4) collate utf8_unicode_ci NOT NULL default 'Mr.',
  `first_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `father_name` varchar(40) collate utf8_unicode_ci NOT NULL,
  `gender` char(1) collate utf8_unicode_ci NOT NULL default 'M',
  `course_code` int(11) default '0',
  `phone_no` varchar(16) collate utf8_unicode_ci default NULL,
  `mobile_no` varchar(16) collate utf8_unicode_ci default NULL,
  `nationality` varchar(25) collate utf8_unicode_ci default 'Pakistan',
  `personal_statement` varchar(150) collate utf8_unicode_ci default NULL,
  `email` varchar(150) collate utf8_unicode_ci default NULL,
  `dob` date default '0000-00-00',
  `admission_date` date default '0000-00-00',
  `online_sign` char(1) collate utf8_unicode_ci default 'Y',
  `admission_status` char(1) collate utf8_unicode_ci default 'Y',
  PRIMARY KEY  (`std_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='applicants details' AUTO_INCREMENT=4000 ;

-- 
-- Dumping data for table `students`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `user_perm_address`
-- 

CREATE TABLE `user_perm_address` (
  `perm_add_id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL default '0',
  `address` varchar(150) collate utf8_unicode_ci NOT NULL,
  `city` varchar(20) collate utf8_unicode_ci NOT NULL,
  `post_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `county_province` varchar(20) collate utf8_unicode_ci NOT NULL,
  `country` varchar(25) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`perm_add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Applicant Permanent Address' AUTO_INCREMENT=20 ;

-- 
-- Dumping data for table `user_perm_address`
-- 

INSERT INTO `user_perm_address` (`perm_add_id`, `user_id`, `address`, `city`, `post_code`, `county_province`, `country`) VALUES 
(1, 1, 'Innova \r\nPeshawar', 'Peshawar', '25000', 'NWFP', 'Pakistan'),
(11, 5, 'swat', 'peshawar', '25000', 'ftgh', 'Pakistan'),
(12, 5, 'Swat', 'pesahwe', '245', 'nfgh', 'Pakistan'),
(13, 2, 'Swat', 'Swat', '23500', 'NWFP', 'usa'),
(14, 4, 'Malkand', 'Batkhela', '23050', 'NWFP', 'Pakistan'),
(15, 45, 'IslamAbad', 'rawalpidi', '25000', 'panjab', 'Pakistan'),
(16, 12, 'dfdfgdf', 'dfgdfgf', '34544', 'nwfp', 'Pakistan'),
(17, 13, 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdf', 'sdfsdfsdfsdf', 'sdfsdfsdfsd'),
(18, 0, 'St 1, K3 Hayatabad', 'Peshawar', '25000', 'NWFP', 'Pakistan'),
(19, 0, 'h9 arbb coloney', 'Peshawar', '25000', 'NWFP', 'Pakistan');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_qualification`
-- 

CREATE TABLE `user_qualification` (
  `qualification_id` bigint(20) NOT NULL auto_increment,
  `institute_name` varchar(50) collate utf8_unicode_ci NOT NULL,
  `degree_certificate` varchar(50) collate utf8_unicode_ci NOT NULL,
  `subject` varchar(50) collate utf8_unicode_ci NOT NULL,
  `session` varchar(15) collate utf8_unicode_ci NOT NULL,
  `grade_percentage` varchar(5) collate utf8_unicode_ci NOT NULL,
  `comments` varchar(150) collate utf8_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`qualification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Student Education Details' AUTO_INCREMENT=11 ;

-- 
-- Dumping data for table `user_qualification`
-- 

INSERT INTO `user_qualification` (`qualification_id`, `institute_name`, `degree_certificate`, `subject`, `session`, `grade_percentage`, `comments`, `user_id`) VALUES 
(1, 'UPS', 'Matric', 'CS', '1995', 'A', 'Testing', 1),
(2, 'Islamia', 'F.Sc', 'Computer', '2004', 'A', 'Passed', 2),
(4, 'albadar', 'SSC', 'Urdu', '2002', 'A', 'hfjyhtgj', 1),
(5, 'SPS', 'SSC', 'SCIENSE', '2000', 'A+', 'Passed', 23),
(6, 'Islamia College Peshawar', 'BCS', 'Computer science', '2008', 'A+', 'Passed', 5),
(7, 'dfgdf', 'dgdf', 'gdfgd', 'fgdfg', 'dfgdf', 'dfgd', 12),
(8, 'sdfsdfd', 'sdfsdfsd', 'fsdfsdfsdf', 'sdfsdfsd', 'fsdfs', 'fsdfsdfsdfds', 13),
(9, 'MM', 'Masters', 'Computer', '2007', 'A', 'NA', 0),
(10, 'dfgfd', 'dfgfdgdf', 'gdfgdfgdf', 'gdfgdfgdfg', 'dfgdf', 'dgfdfgfdg', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `user_temp_address`
-- 

CREATE TABLE `user_temp_address` (
  `temp_add_id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL default '0',
  `address` varchar(150) collate utf8_unicode_ci NOT NULL,
  `city` varchar(20) collate utf8_unicode_ci NOT NULL,
  `post_code` varchar(10) collate utf8_unicode_ci NOT NULL,
  `county_province` varchar(20) collate utf8_unicode_ci NOT NULL,
  `country` varchar(25) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`temp_add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- 
-- Dumping data for table `user_temp_address`
-- 

INSERT INTO `user_temp_address` (`temp_add_id`, `user_id`, `address`, `city`, `post_code`, `county_province`, `country`) VALUES 
(1, 1, 'sdfsd', 'Peshawar', '25000', 'NWFP', 'Pakistan'),
(2, 3, 'Malakand', 'Batkhela', '23000', 'NWFP', 'Pakistan'),
(3, 54, 'Malakand', 'Batkhela', '23000', 'NWFP', 'Pakistan'),
(6, 5, 'Swabi', 'managi', '23000', 'Nwfp', 'Pakistan'),
(9, 5, 'Malakand', 'Batkhela', '23050', 'NWFP', 'Pakistan'),
(10, 87, 'nsmjm', 'bsmm', 'sbdan', 'ansbamn', 'Pakistan'),
(11, 12, 'Asdfsdfsfsad', 'sdfsdsdfasdf', '25000', 'dfdfsdfsdfdsfs', 'pakistan'),
(12, 13, 'sdfsdfsd', 'sdfsdf', 'sdfsdfs', 'dfsdfsd', 'fsdfsdf'),
(13, 0, 'St 1, K3 Hayatabad', 'Peshawar', '25000', 'NWFP', 'Pakistan'),
(14, 0, 'h9 arbb coloney', 'Peshawar', '25000', 'NWFP', 'Pakistan');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_type`
-- 

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL auto_increment,
  `user_type_title` varchar(30) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Account Type' AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `user_type`
-- 

INSERT INTO `user_type` (`user_type_id`, `user_type_title`) VALUES 
(1, 'Administrators'),
(2, 'Employees'),
(3, 'Students');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_work_experience`
-- 

CREATE TABLE `user_work_experience` (
  `work_exp_id` bigint(20) NOT NULL auto_increment,
  `position` varchar(15) collate utf8_unicode_ci NOT NULL,
  `organization` varchar(20) collate utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `address` varchar(100) collate utf8_unicode_ci NOT NULL,
  `status` varchar(15) collate utf8_unicode_ci default NULL,
  `user_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`work_exp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Student Work Experiences' AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `user_work_experience`
-- 

INSERT INTO `user_work_experience` (`work_exp_id`, `position`, `organization`, `start_date`, `end_date`, `address`, `status`, `user_id`) VALUES 
(1, 'Director', 'Get N Put', '2007-01-01', '2022-01-01', 'Innova', 'Test', 1),
(5, 'MD', 'NEW hostel', '2008-02-08', '2010-08-07', 'Peshawar', 'yes', 2),
(6, 'MD', 'New Hostel', '2008-07-08', '2010-08-07', 'Peshawar', 'Full time', 7),
(7, 'dsfd', 'fsdfsdsd', '0000-00-00', '0000-00-00', 'sdfsdsd', 'None', 12),
(8, 'dfgfdg', 'dfgdfg', '0000-00-00', '0000-00-00', 'dfgdfgf', 'None', 12),
(9, 'dgfdgf', 'dfgfdg', '0000-00-00', '0000-00-00', 'dfgfgf', NULL, 12),
(10, 'sdfsdfdsf', 'sfsdfdsf', '0000-00-00', '0000-00-00', 'sdfsdfsd', NULL, 13),
(11, 'Lecturer', 'Innova Institute of ', '2006-01-01', '2007-01-01', 'Arbab Colony', 'A', 0),
(12, 'dfgfdg', 'fdgfdgdf', '0000-00-00', '0000-00-00', 'dfgdf', 'gdfgdf', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `user_id` bigint(20) NOT NULL auto_increment,
  `username` varchar(20) collate utf8_unicode_ci NOT NULL COMMENT 'unique user login name',
  `password` varchar(15) collate utf8_unicode_ci NOT NULL COMMENT 'User Account Password',
  `user_type_id` int(11) NOT NULL,
  `title` varchar(4) collate utf8_unicode_ci NOT NULL,
  `first_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `last_name` varchar(20) collate utf8_unicode_ci NOT NULL,
  `phone_no` varchar(16) collate utf8_unicode_ci NOT NULL,
  `mobile_no` varchar(16) collate utf8_unicode_ci NOT NULL,
  `nationality` varchar(25) collate utf8_unicode_ci NOT NULL,
  `email` varchar(150) collate utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL default '0000-00-00',
  `create_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `fix_salary` int(11) default NULL,
  PRIMARY KEY  (`user_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='System Users and Employees' AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`user_id`, `username`, `password`, `user_type_id`, `title`, `first_name`, `last_name`, `phone_no`, `mobile_no`, `nationality`, `email`, `dob`, `create_date`, `fix_salary`) VALUES 
(1, 'admin', 'admin', 1, 'Mr.', 'System', 'Administrator', '0915702921', '0915702921', 'Pakistan', 'admin@innova.edu.pk', '2008-01-19', '2008-01-19 00:00:00', 0),
(2, 'kifayat', 'whoami_78', 1, 'Mr.', 'Kifayat', 'Ullah', '0915702921', '0915702921', 'Pakistan', 'kifayat@innova.edu.pk', '1978-03-06', '2008-01-19 00:00:00', 0),
(3, 'ejaz', 'whoami_78', 2, 'Mr.', 'Ejaz', 'Ahmad', '0915702921', '0915702921', 'Pakistan', 'ejaz@innova.edu.pk', '1978-03-06', '2008-01-19 00:00:00', 6000),
(4, 'obaid', 'obaid', 2, 'Mr.', 'Obaid', 'Shah', '0915702921', '0915702921', 'Pakistan', 'obaid@innova.edu.pk', '2008-01-19', '2008-01-19 00:00:00', 2700);
