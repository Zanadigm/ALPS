-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2023 at 05:49 PM
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
-- Table structure for table `backorder_items`
--

CREATE TABLE `backorder_items` (
  `bo_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `backorder_items`
--

INSERT INTO `backorder_items` (`bo_id`, `item_id`, `quantity`) VALUES
(1, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `backorder_list`
--

CREATE TABLE `backorder_list` (
  `id` int(11) NOT NULL,
  `bo_code` varchar(255) NOT NULL,
  `rq_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `backorder_list`
--

INSERT INTO `backorder_list` (`id`, `bo_code`, `rq_id`, `date_created`) VALUES
(1, 'BO-0001', 22, '2023-08-07 03:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `client_info`
--

CREATE TABLE `client_info` (
  `id` int(30) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `company_email` varchar(50) NOT NULL,
  `company_address` varchar(50) NOT NULL,
  `company_location` varchar(50) NOT NULL,
  `company_mobile` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_items`
--

CREATE TABLE `delivery_items` (
  `dn_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_items`
--

INSERT INTO `delivery_items` (`dn_id`, `item_id`, `quantity`) VALUES
(3, 8, 10),
(3, 4, 20),
(3, 5, 25),
(3, 6, 40),
(4, 4, 5),
(4, 5, 6),
(4, 9, 2),
(4, 10, 10),
(4, 8, 5);

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
  `date_received` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_list`
--

INSERT INTO `delivery_list` (`id`, `dn_no`, `rq_no`, `driver_id`, `status`, `notes`, `received_by`, `date_received`, `date_created`, `date_updated`) VALUES
(3, 'DN-606009', 22, 5, 1, '', '2', '2023-08-07 04:10:47', '2023-08-07 03:49:16', '2023-08-07 04:10:47'),
(4, 'DN-271781', 10, 5, 0, '', '', NULL, '2023-08-07 04:01:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_list`
--

CREATE TABLE `invoice_list` (
  `id` int(11) NOT NULL,
  `in_no` varchar(50) NOT NULL,
  `dn_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=pending,1=paid',
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
  `unit` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `selling_price` float NOT NULL,
  `buying_price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT ' 1 = Active, 0 = Inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_list`
--

INSERT INTO `item_list` (`id`, `name`, `unit`, `description`, `selling_price`, `buying_price`, `status`, `date_created`) VALUES
(4, 'Flood Lights', 'Pcs', '300 Wat Solar Led Flood Lights', 12000, 10000, 1, '2023-06-24 21:31:10'),
(5, 'G.I Stands', 'Pcs', '2&#039;&#039; Pipes', 10000, 9000, 1, '2023-06-24 21:31:44'),
(6, 'Bolts', 'Pcs', '3&#039;&#039; Bolts', 700, 600, 1, '2023-06-24 21:32:15'),
(7, 'Chain link', 'Pcs', 'Plastic coated Shamba chain link', 6000, 5000, 1, '2023-06-30 16:02:37'),
(8, 'Cement', 'Bags', 'Simba cement', 600, 550, 1, '2023-06-30 16:02:57'),
(9, 'Binding Wire', 'Roll', 'Roll of binding wire', 2000, 1500, 1, '2023-06-30 16:09:05'),
(10, 'Concrete Posts', 'Pcs', 'Concrete fencing posts', 200, 150, 1, '2023-06-30 16:09:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `po_id` int(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`po_id`, `item_id`, `quantity`) VALUES
(1, 4, 3),
(1, 5, 3),
(1, 6, 12),
(2, 4, 5),
(8, 4, 10);

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
(2, 'PO-637567', 2, 0, 0, 0, 0, '', 1, '2023-06-29 12:26:48', '2023-07-06 09:44:57'),
(8, 'PO-775181', 2, 0, 0, 0, 0, '', 0, '2023-07-07 17:58:16', '2023-07-09 01:43:34');

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
(2, 'Stenland Security Lights', 'Supply and Installation of 3 security lights', 0, '2023-06-24 20:39:33', '0000-00-00 00:00:00'),
(4, 'Nursing School', 'Mutomo Mission nursing school classroom', 0, '2023-07-08 22:04:00', '0000-00-00 00:00:00'),
(6, 'Katundu Primary School', 'Dormitory', 0, '2023-07-09 00:58:19', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_items`
--

CREATE TABLE `requisition_items` (
  `rq_id` int(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requisition_items`
--

INSERT INTO `requisition_items` (`rq_id`, `item_id`, `quantity`) VALUES
(10, 4, 5),
(10, 5, 6),
(10, 6, 16),
(10, 9, 2),
(10, 10, 10),
(10, 8, 5),
(14, 4, 10),
(14, 8, 5),
(14, 5, 4),
(14, 6, 20),
(16, 4, 4),
(16, 8, 5),
(15, 4, 3),
(17, 8, 2),
(17, 4, 5),
(20, 8, 10),
(20, 4, 20),
(21, 8, 10),
(21, 4, 20),
(21, 5, 30),
(22, 8, 10),
(22, 4, 20),
(22, 5, 30),
(22, 6, 40);

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
(10, 'RQ-437375', 'Stenland', 2, 3, 'Security', 'Security Office', 2, '', 3, '2023-08-07 04:01:57', 4, 5, '2023-07-04 01:55:30', '2023-08-07 04:01:57'),
(14, 'RQ-929088', 'Mutomo Mission Hospital', 2, 3, 'Repair & Maintenance', 'Repair Office 302', 4, '', 1, '2023-08-05 12:19:07', 4, 5, '2023-07-08 22:08:12', '2023-08-05 12:19:07'),
(15, 'RQ-149671', 'Stenland', 2, 3, 'Agriculture', 'Agriculture Office 202', 2, '', 1, '2023-08-05 12:46:10', 4, 5, '2023-07-08 23:22:28', '2023-08-05 12:46:10'),
(16, 'RQ-000268', 'Katundu Primary School', 2, 3, 'Accomodation', 'Gate Section', 6, '', 1, '2023-08-05 12:39:39', 4, 5, '2023-07-09 01:01:52', '2023-08-05 12:39:39'),
(17, 'RQ-532818', 'Stenland', 2, 3, 'Admin Office', 'Admin Office', 2, '', 1, '2023-08-01 16:06:23', 4, 5, '2023-07-14 23:20:29', '2023-08-01 16:06:23'),
(20, 'RQ-120927', 'Sten', 2, 3, 'Sten', 'Sten', 4, '', 1, '2023-08-06 11:50:04', 4, 5, '2023-08-06 11:49:15', '2023-08-06 11:50:04'),
(21, 'RQ-817527', 'Mandazi road', 2, 3, 'Maandazi', 'Chifoo', 6, '', 1, '2023-08-06 12:00:33', 4, 5, '2023-08-06 12:00:19', '2023-08-06 12:00:33'),
(22, 'RQ-531052', 'test', 2, 3, 'test', 'test', 4, '', 2, '2023-08-07 03:08:12', 4, 5, '2023-08-06 12:08:02', '2023-08-07 03:08:12');

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
(1, 'Makutano', 'Machakos', 'Eric Thogo', '0790674324', 'eric.thogo@supplier.com', 1, '2023-06-22 20:27:12'),
(2, 'Ngumu Ngumu Hardware', 'Thika', 'Samantha Lou', '0112876345', 'samanthalou@supplier2.com', 1, '2021-09-08 10:25:12');

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
(16, 'company_email', 'info@remmy.co.ke'),
(17, 'company_address', 'P.O Box 16-90201'),
(18, 'company_location', 'Mutomo, Kibwezi-Kitui Road'),
(19, 'company_mobile', '0737899456');

-- --------------------------------------------------------

--
-- Table structure for table `test_table`
--

CREATE TABLE `test_table` (
  `rq_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test_table`
--

INSERT INTO `test_table` (`rq_id`, `item_id`, `quantity`) VALUES
(22, 8, 5),
(22, 4, 14),
(22, 5, 12),
(22, 6, 28);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
(5, 'Maneno', 'Mingi', 'maneno', 'c0c4651b65e030fa9a8056318ccff013', 'uploads/1688722260_1687336620_1624240500_avatar.png', NULL, 5, '2023-06-28 11:41:42', '2023-07-07 12:31:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backorder_items`
--
ALTER TABLE `backorder_items`
  ADD KEY `po_id` (`bo_id`),
  ADD KEY `item_no` (`item_id`),
  ADD KEY `dn_id` (`bo_id`),
  ADD KEY `rq_id` (`bo_id`);

--
-- Indexes for table `backorder_list`
--
ALTER TABLE `backorder_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rq_id` (`rq_id`);

--
-- Indexes for table `client_info`
--
ALTER TABLE `client_info`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `invoice_list`
--
ALTER TABLE `invoice_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`dn_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backorder_list`
--
ALTER TABLE `backorder_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_info`
--
ALTER TABLE `client_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `delivery_list`
--
ALTER TABLE `delivery_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoice_list`
--
ALTER TABLE `invoice_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `po_list`
--
ALTER TABLE `po_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rq_list`
--
ALTER TABLE `rq_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `supplier_list`
--
ALTER TABLE `supplier_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backorder_items`
--
ALTER TABLE `backorder_items`
  ADD CONSTRAINT `backorder_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `backorder_items_ibfk_2` FOREIGN KEY (`bo_id`) REFERENCES `backorder_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `backorder_list`
--
ALTER TABLE `backorder_list`
  ADD CONSTRAINT `backorder_list_ibfk_1` FOREIGN KEY (`rq_id`) REFERENCES `rq_list` (`id`);

--
-- Constraints for table `delivery_items`
--
ALTER TABLE `delivery_items`
  ADD CONSTRAINT `delivery_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `delivery_items_ibfk_2` FOREIGN KEY (`dn_id`) REFERENCES `delivery_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `delivery_list`
--
ALTER TABLE `delivery_list`
  ADD CONSTRAINT `delivery_list_ibfk_1` FOREIGN KEY (`rq_no`) REFERENCES `rq_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
