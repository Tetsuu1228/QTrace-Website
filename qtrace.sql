-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2026 at 04:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qtrace`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_table`
--

CREATE TABLE `account_table` (
  `Account_Id` int(11) NOT NULL,
  `Image_Path` varchar(100) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Name` varchar(50) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Role` int(11) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor_documents_table`
--

CREATE TABLE `contractor_documents_table` (
  `Contractor_Documents_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Document_Type` varchar(100) NOT NULL,
  `Document_Path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_documents_table`
--

INSERT INTO `contractor_documents_table` (`Contractor_Documents_Id`, `Contractor_Id`, `Document_Type`, `Document_Path`) VALUES
(1, 2, 'Document1_Test1', '/QTrace-Website/uploads/documents/Company_Test_1._.Document1_Test1.pdf'),
(2, 2, 'Document2_Test1', '/QTrace-Website/uploads/documents/Company_Test_1._.Document2_Test1.pdf'),
(3, 3, 'Document1_Test1', '/QTrace-Website/uploads/documents/Company_Test_2._.Document1_Test1.pdf'),
(4, 3, 'Document2_Test1', '/QTrace-Website/uploads/documents/Company_Test_2._.Document2_Test1.pdf'),
(5, 3, 'Company3_Test_2', '/QTrace-Website/uploads/documents/Company_Test_2._.Company3_Test_2.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_expertise_table`
--

CREATE TABLE `contractor_expertise_table` (
  `Contractor_Expertise_Id` int(11) NOT NULL,
  `Contractor_Id` int(11) NOT NULL,
  `Expertise` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_expertise_table`
--

INSERT INTO `contractor_expertise_table` (`Contractor_Expertise_Id`, `Contractor_Id`, `Expertise`) VALUES
(2, 2, 'Skill 1'),
(3, 2, 'skill 2'),
(4, 2, 'skill 3'),
(5, 3, 'skill1');

-- --------------------------------------------------------

--
-- Table structure for table `contractor_table`
--

CREATE TABLE `contractor_table` (
  `Contractor_Id` int(11) NOT NULL,
  `Contractor_Logo_Path` varchar(100) NOT NULL,
  `Contractor_Name` varchar(50) NOT NULL,
  `Owner_Name` varchar(50) NOT NULL,
  `Company_Address` varchar(100) NOT NULL,
  `Contact_Number` bigint(20) NOT NULL,
  `Company_Email_Address` varchar(50) NOT NULL,
  `Years_Of_Experience` int(11) NOT NULL,
  `Additional_Notes` varchar(250) NOT NULL,
  `Created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor_table`
--

INSERT INTO `contractor_table` (`Contractor_Id`, `Contractor_Logo_Path`, `Contractor_Name`, `Owner_Name`, `Company_Address`, `Contact_Number`, `Company_Email_Address`, `Years_Of_Experience`, `Additional_Notes`, `Created_At`) VALUES
(2, '../../uploads/logos/Company_Test_1_.png', 'Company_Test_1', 'Zlatan Paul', '764 Pioneer Street, Robinsons Cybergate Metro Manila', 83926482, 'Company_Test_1@gmail.com', 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel diam at felis posuere ultrices sed a ligula. Etiam nec scelerisque risus. Integer ornare neque sed rhoncus finibus. Duis vulputate justo nec purus blandit condimentum. Sed facilisis vel', '2026-01-13'),
(3, '../../uploads/logos/Company_Test_2_.jpg', 'Company_Test_2', 'Vinzent Haraldr', '78c atherton st. Nort Fairview', 945923747, 'Company_Test_2@gmail.com', 1, 'Pellentesque vestibulum luctus arcu, consequat gravida ipsum pellentesque et. Suspendisse vel tellus quam. Phasellus a mollis turpis. Donec auctor gravida eros, a dapibus ex laoreet faucibus. Nam ut est et dui tempor lacinia vitae in elit. Vestibulum', '2026-01-13');

-- --------------------------------------------------------

--
-- Table structure for table `projectdetails_table`
--

CREATE TABLE `projectdetails_table` (
  `ProjectDetails_ID` int(11) NOT NULL,
  `Project_ID` int(11) DEFAULT NULL,
  `ProjectDetails_Title` varchar(255) NOT NULL,
  `ProjectDetails_Description` varchar(255) NOT NULL,
  `ProjectDetails_Budget` double NOT NULL,
  `ProjectDetails_Street` varchar(255) NOT NULL,
  `ProjectDetails_Barangay` varchar(255) NOT NULL,
  `ProjectDetails_ZIP_Code` int(11) NOT NULL,
  `ProjectDetails_StartedDate` date DEFAULT NULL,
  `ProjectDetails_EndDate` date DEFAULT NULL,
  `ProjectDetails_CreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `ProjectDetails_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectdetails_table`
--

INSERT INTO `projectdetails_table` (`ProjectDetails_ID`, `Project_ID`, `ProjectDetails_Title`, `ProjectDetails_Description`, `ProjectDetails_Budget`, `ProjectDetails_Street`, `ProjectDetails_Barangay`, `ProjectDetails_ZIP_Code`, `ProjectDetails_StartedDate`, `ProjectDetails_EndDate`, `ProjectDetails_CreatedAt`, `ProjectDetails_UpdatedAT`) VALUES
(1, 2, 'Project_Test_1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel eros luctus, iaculis dolor vitae, tempor diam. Nulla mauris elit, laoreet in risus nec, consectetur euismod nisl. Morbi sollicitudin mauris a dui faucibus finibus. Fusce nulla mauris, euis', 100000, 'Tandang Sora Avenue', 'Tandang Sora', 1124, '2026-01-15', '2026-01-15', '2026-01-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projectmilestone_table`
--

CREATE TABLE `projectmilestone_table` (
  `projectMilestone_PhotoID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `projectMilestone_Image_Path` varchar(255) DEFAULT NULL,
  `projectMilestone_Phase` varchar(100) NOT NULL,
  `projectMilestone_CreatedAt` date NOT NULL DEFAULT current_timestamp(),
  `projectMilestone_UploadedAT` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projectsdocument_table`
--

CREATE TABLE `projectsdocument_table` (
  `ProjectDocument_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `ProjectDocument_FileLocation` varchar(255) DEFAULT NULL,
  `ProjectDocument_Type` varchar(50) DEFAULT NULL,
  `ProjectDocument_UploadedAt` datetime DEFAULT current_timestamp(),
  `ProjectDocument_CreatedAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects_table`
--

CREATE TABLE `projects_table` (
  `Project_ID` int(11) NOT NULL,
  `Contractor_ID` int(11) NOT NULL,
  `Project_Status` varchar(50) NOT NULL,
  `Project_Category` varchar(50) NOT NULL,
  `Project_Lng` decimal(20,8) NOT NULL,
  `Project_Lat` decimal(20,8) NOT NULL,
  `Project_CreatedAt` date DEFAULT curdate(),
  `Project_UpdatedAT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects_table`
--

INSERT INTO `projects_table` (`Project_ID`, `Contractor_ID`, `Project_Status`, `Project_Category`, `Project_Lng`, `Project_Lat`, `Project_CreatedAt`, `Project_UpdatedAT`) VALUES
(2, 2, 'Planned', 'Infrastructure', 121.05410100, 14.66777000, '2026-01-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_table`
--

CREATE TABLE `report_table` (
  `report_ID` int(11) NOT NULL,
  `Project_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `report_type` varchar(50) DEFAULT NULL,
  `report_description` varchar(255) DEFAULT NULL,
  `report_evidencesPhoto_URL` varchar(255) DEFAULT NULL,
  `report_status` varchar(50) DEFAULT NULL,
  `report_CreatedAt` datetime DEFAULT current_timestamp(),
  `reportParent_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_ID` int(11) NOT NULL,
  `QC_ID_Number` varchar(20) DEFAULT NULL,
  `user_lastName` varchar(50) NOT NULL,
  `user_firstName` varchar(50) NOT NULL,
  `user_middleName` varchar(20) DEFAULT NULL,
  `user_Email` varchar(20) NOT NULL,
  `user_Password` varchar(255) NOT NULL,
  `user_Role` enum('citizen','admin') NOT NULL,
  `user_birthDate` date NOT NULL,
  `user_sex` enum('female','male','other') NOT NULL,
  `user_contactInformation` bigint(20) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `created_At` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_ID`, `QC_ID_Number`, `user_lastName`, `user_firstName`, `user_middleName`, `user_Email`, `user_Password`, `user_Role`, `user_birthDate`, `user_sex`, `user_contactInformation`, `user_address`, `created_At`) VALUES
(6, '74373497704', 'Manongdo', 'Gerald', 'P.', 'ipoglang@gmail.com', '$2y$10$ABJV3LTejJGIWKXjcUeS2eUr5/C6P0GzzkCkHWT15Vgyc7y7ThXJe', 'admin', '2005-09-12', 'male', 3123123214, 'blk 51 lt 49 noche buena st. ', '2026-01-11'),
(7, '97192855754', 'Tan', 'Kurt', 'Clet', 'KurtTan@gmail.com', '$2y$10$5x4VPncdSUs9Wg81LIVcbOlcXAsnik7C7ESH5OiSbyyr1UREM56EG', 'citizen', '2006-03-10', 'female', 43243432, '123', '2026-01-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD PRIMARY KEY (`Contractor_Documents_Id`),
  ADD KEY `fk_documents_contractor` (`Contractor_Id`);

--
-- Indexes for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD PRIMARY KEY (`Contractor_Expertise_Id`),
  ADD KEY `fk_expertise_contractor` (`Contractor_Id`);

--
-- Indexes for table `contractor_table`
--
ALTER TABLE `contractor_table`
  ADD PRIMARY KEY (`Contractor_Id`);

--
-- Indexes for table `projectdetails_table`
--
ALTER TABLE `projectdetails_table`
  ADD PRIMARY KEY (`ProjectDetails_ID`);

--
-- Indexes for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  ADD PRIMARY KEY (`projectMilestone_PhotoID`),
  ADD KEY `fk_projectMilestone_projects` (`Project_ID`);

--
-- Indexes for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  ADD PRIMARY KEY (`ProjectDocument_ID`),
  ADD KEY `fk_projectsDocument_projects` (`Project_ID`);

--
-- Indexes for table `projects_table`
--
ALTER TABLE `projects_table`
  ADD PRIMARY KEY (`Project_ID`),
  ADD KEY `idx_projects_contractor_id` (`Contractor_ID`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `report_table`
--
ALTER TABLE `report_table`
  ADD PRIMARY KEY (`report_ID`),
  ADD KEY `fk_report_projects` (`Project_ID`),
  ADD KEY `fk_report_user` (`user_ID`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  MODIFY `Contractor_Documents_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  MODIFY `Contractor_Expertise_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contractor_table`
--
ALTER TABLE `contractor_table`
  MODIFY `Contractor_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projectdetails_table`
--
ALTER TABLE `projectdetails_table`
  MODIFY `ProjectDetails_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  MODIFY `projectMilestone_PhotoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  MODIFY `ProjectDocument_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects_table`
--
ALTER TABLE `projects_table`
  MODIFY `Project_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_table`
--
ALTER TABLE `report_table`
  MODIFY `report_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contractor_documents_table`
--
ALTER TABLE `contractor_documents_table`
  ADD CONSTRAINT `fk_documents_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contractor_expertise_table`
--
ALTER TABLE `contractor_expertise_table`
  ADD CONSTRAINT `fk_document_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_expertise_contractor` FOREIGN KEY (`Contractor_Id`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projectmilestone_table`
--
ALTER TABLE `projectmilestone_table`
  ADD CONSTRAINT `fk_projectMilestone_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `projectsdocument_table`
--
ALTER TABLE `projectsdocument_table`
  ADD CONSTRAINT `fk_projectsDocument_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `projects_table`
--
ALTER TABLE `projects_table`
  ADD CONSTRAINT `fk_projects_contractor` FOREIGN KEY (`Contractor_ID`) REFERENCES `contractor_table` (`Contractor_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report_table`
--
ALTER TABLE `report_table`
  ADD CONSTRAINT `fk_report_projects` FOREIGN KEY (`Project_ID`) REFERENCES `projects_table` (`Project_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_report_user` FOREIGN KEY (`user_ID`) REFERENCES `user_table` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
