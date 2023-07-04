-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2023 at 11:16 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `purchase_order_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_items`
--

CREATE TABLE `delivery_items` (
  `dn_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `unit_price` float NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `delivery_list`
--

CREATE TABLE `delivery_list` (
  `id` int(11) NOT NULL,
  `dn_no` varchar(50) NOT NULL,
  `rq_no` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=confirmed',
  `notes` text NOT NULL,
  `received_by` varchar(250) NOT NULL,
  `date_received` datetime NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_list`
--

CREATE TABLE `item_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 1 = Active, 0 = Inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_list`
--

INSERT INTO `item_list` (`id`, `name`, `description`, `status`, `date_created`) VALUES
(4, 'Flood Lights', '300 Wat Solar Led Flood Lights', 1, '2023-06-24 21:31:10'),
(5, 'G.I Stands', '2&#039;&#039; Pipes', 1, '2023-06-24 21:31:44'),
(6, 'Bolts', '3&#039;&#039; Bolts', 1, '2023-06-24 21:32:15'),
(7, 'Chain link', 'Plastic coated Shamba chain link', 1, '2023-06-30 16:02:37'),
(8, 'Cement', 'Simba cement', 1, '2023-06-30 16:02:57'),
(9, 'Binding Wire', 'Roll of binding wire', 1, '2023-06-30 16:09:05'),
(10, 'Concrete Posts', 'Concrete fencing posts', 1, '2023-06-30 16:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `po_id` int(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `unit_price` float NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`po_id`, `item_id`, `unit`, `unit_price`, `quantity`) VALUES
(1, 4, 'Pcs', 10000, 3),
(1, 5, 'Pcs', 9000, 3),
(1, 6, 'Pcs', 200, 12),
(2, 4, 'Pcs', 10000, 5),
(3, 4, 'Pcs', 10000, 5);

-- --------------------------------------------------------

--
-- Table structure for table `po_list`
--

CREATE TABLE `po_list` (
  `id` int(30) NOT NULL,
  `po_no` varchar(100) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `discount_percentage` float NOT NULL,
  `discount_amount` float NOT NULL,
  `tax_percentage` float NOT NULL,
  `tax_amount` float NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending, 1= Approved, 2 = Denied',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `po_list`
--

INSERT INTO `po_list` (`id`, `po_no`, `supplier_id`, `discount_percentage`, `discount_amount`, `tax_percentage`, `tax_amount`, `notes`, `status`, `date_created`, `date_updated`) VALUES
(1, 'PO-648826', 1, 0, 0, 0, 0, '', 1, '2023-06-28 14:54:19', '2023-06-28 20:53:47'),
(2, 'PO-637567', 2, 0, 0, 0, 0, '', 0, '2023-06-29 12:26:48', NULL),
(3, 'PO-622911', 2, 0, 0, 0, 0, '', 0, '2023-06-29 12:28:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` int(10) NOT NULL COMMENT '0=open,1=closed',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `created_on`, `updated_on`) VALUES
(1, 'Katundu', 'Dormitory and fencing', 0, '2023-06-24 13:23:59', '0000-00-00 00:00:00'),
(2, 'Stenland Security Lights', 'Supply and Installation of 3 security lights', 0, '2023-06-24 20:39:33', '0000-00-00 00:00:00'),
(3, 'Mission Nursing School Fencing', 'Fencing of nursing school with chain link.', 0, '2023-06-30 16:01:14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_items`
--

CREATE TABLE `requisition_items` (
  `rq_id` int(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `unit_price` float NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requisition_items`
--

INSERT INTO `requisition_items` (`rq_id`, `item_id`, `unit`, `unit_price`, `quantity`) VALUES
(9, 4, 'Pcs', 10000, 3),
(9, 5, 'Pcs', 9000, 3),
(9, 6, 'Pcs', 200, 12);

-- --------------------------------------------------------

--
-- Table structure for table `rq_list`
--

CREATE TABLE `rq_list` (
  `id` int(30) NOT NULL,
  `rq_no` varchar(100) NOT NULL,
  `deliver_to` varchar(250) NOT NULL,
  `ordered_by` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `department_name` varchar(250) NOT NULL,
  `building_name` varchar(250) NOT NULL,
  `p_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending, 1= Approved, 2 = Processing, 3 = Fulfilled',
  `date_fulfilled` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `fulfilled_by` int(11) NOT NULL,
  `checked_by` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rq_list`
--

INSERT INTO `rq_list` (`id`, `rq_no`, `deliver_to`, `ordered_by`, `approved_by`, `department_name`, `building_name`, `p_id`, `notes`, `status`, `date_fulfilled`, `fulfilled_by`, `checked_by`, `date_created`, `date_updated`) VALUES
(9, 'RQ-667591', 'Mutomo Mission Hospital', 2, 3, 'Maintenance and Repairs', 'Maintenance Office 004', 3, '', 1, '2023-07-01 00:04:36', 4, 5, '2023-07-01 00:03:39', '2023-07-01 00:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_list`
--

CREATE TABLE `supplier_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `contact_person` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = Inactive, 1 = Active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_list`
--

INSERT INTO `supplier_list` (`id`, `name`, `address`, `contact_person`, `contact`, `email`, `status`, `date_created`) VALUES
(1, 'Supplier 1', 'Machakos', 'Eric Thogo', '0790674324', 'eric.thogo@supplier.com', 1, '2023-06-22 20:27:12'),
(2, 'Supplier 2', 'Thika', 'Samantha Lou', '0112876345', 'samanthalou@supplier2.com', 1, '2021-09-08 10:25:12');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Automated Logistics & Procurement System'),
(6, 'short_name', 'ALPS'),
(11, 'logo', 'uploads/1687632360_rsk logo.jpg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1687336800_1687332600_login-bg.jpg'),
(15, 'company_name', 'Remmy & Sons Group'),
(16, 'company_email', 'info@remmy.com'),
(17, 'company_address', 'Mutomo, Kitui');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1687336620_1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2023-06-21 11:37:55'),
(2, 'Chris', 'Ongeta', 'chris', '6b34fe24ac2ff8103f6fce1f0da2ef57', 'uploads/1687336620_1624240500_avatar.png', NULL, 2, '2023-06-21 11:37:24', NULL),
(3, 'Remmy', 'Amya', 'remmy', '8769ddc9ece9050a5c3072d4fda6b49e', 'uploads/1687336680_1630999200_avatar5.png', NULL, 3, '2023-06-21 11:38:24', NULL),
(4, 'Mariam', 'Lisa', 'mariam', '13c6cf272b6dc642b9712d5dfccc2e42', 'uploads/1688150700_1687336620_1624240500_avatar.png', NULL, 4, '2023-06-28 11:41:00', '2023-06-30 21:45:29'),
(5, 'Maneno', 'Mingi', 'maneno', 'c0c4651b65e030fa9a8056318ccff013', NULL, NULL, 5, '2023-06-28 11:41:42', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD KEY `po_id` (`dn_id`),
  ADD KEY `item_no` (`item_id`),
  ADD KEY `dn_id` (`dn_id`);

--
-- Indexes for table `delivery_list`
--
ALTER TABLE `delivery_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dn_no` (`dn_no`),
  ADD KEY `order_no` (`rq_no`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `item_list`
--
ALTER TABLE `item_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `po_id` (`po_id`),
  ADD KEY `item_no` (`item_id`);

--
-- Indexes for table `po_list`
--
ALTER TABLE `po_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD KEY `po_id` (`rq_id`),
  ADD KEY `item_no` (`item_id`);

--
-- Indexes for table `rq_list`
--
ALTER TABLE `rq_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `supplier_list`
--
ALTER TABLE `supplier_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_list`
--
ALTER TABLE `delivery_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `po_list`
--
ALTER TABLE `po_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rq_list`
--
ALTER TABLE `rq_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_list`
--
ALTER TABLE `supplier_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD CONSTRAINT `delivery_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `delivery_list`
--
ALTER TABLE `delivery_list`
  ADD CONSTRAINT `delivery_list_ibfk_1` FOREIGN KEY (`rq_no`) REFERENCES `rq_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delivery_list_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`po_id`) REFERENCES `po_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `po_list`
--
ALTER TABLE `po_list`
  ADD CONSTRAINT `po_list_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD CONSTRAINT `requisition_items_ibfk_1` FOREIGN KEY (`rq_id`) REFERENCES `rq_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `requisition_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `rq_list`
--
ALTER TABLE `rq_list`
  ADD CONSTRAINT `rq_list_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `project_list` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
