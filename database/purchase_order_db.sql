-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2023 at 02:07 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `backorder_list`
--

CREATE TABLE `backorder_list` (
  `id` int(11) NOT NULL,
  `bo_code` varchar(255) NOT NULL,
  `rq_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `has_po` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = Inactive, 1 = Active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `name`, `location`, `address`, `contact`, `email`, `status`, `date_created`) VALUES
(1, 'SMPI', 'Mutomo, Kitui', 'P.O Box 83', '9089895633', 'smpi@ngo.org', 1, '2023-08-25 17:53:35'),
(2, 'Our Lady of Lourdes Hospital', 'Mutomo, Kitui', 'P.O Box 78', '0789456325', 'ourlady@gmail.com', 1, '2023-08-25 17:54:21');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_items`
--

CREATE TABLE `delivery_items` (
  `dn_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
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
  `date_received` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_list`
--

CREATE TABLE `invoice_list` (
  `id` int(11) NOT NULL,
  `in_no` varchar(50) NOT NULL,
  `rq_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=paid',
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
(1, '2ft Fluorescent Fitting', 'Pc', 'Magnetic', 10000, 800, 1, '2023-08-25 07:26:22'),
(2, '2ft Tube', 'Pc', 'Day Light', 200, 150, 1, '2023-08-25 07:27:24'),
(3, 'Lamp Holder', 'Pc', 'Straight - Pin Type', 150, 100, 1, '2023-08-25 07:28:48'),
(4, '2.5mm T.w.E Cable', 'Mtrs', 'East African', 180, 150, 1, '2023-08-25 07:31:29'),
(5, 'Cable Clips', 'Pc', '6*10', 120, 100, 1, '2023-08-25 07:58:40'),
(6, 'Bulb', 'Pc', 'Energy Saver', 200, 150, 1, '2023-08-25 08:01:43'),
(7, 'Joint Box', 'Pc', '20A', 120, 100, 1, '2023-08-25 08:11:25'),
(8, 'Switch Box', 'Pc', 'Single', 50, 30, 1, '2023-08-25 08:11:58'),
(9, 'Conduits', 'Pc', '20mm', 180, 150, 1, '2023-08-25 08:12:32'),
(10, 'Switch', 'Pc', '1g2w', 100, 80, 1, '2023-08-25 08:14:58'),
(11, 'Tangit Glue', 'Lt', '1/2 Ltr', 750, 600, 1, '2023-08-25 18:19:21'),
(12, '4ft Fitting ', 'Pc', 'Magnetic', 1400, 1000, 1, '2023-08-25 18:22:14'),
(13, '4Ft Tube', 'Pc', 'Daylight', 250, 180, 1, '2023-08-25 18:22:54'),
(14, 'Socket Outlet', 'Pc', 'Double', 350, 250, 1, '2023-08-25 18:29:10'),
(15, 'Ceiling Rose', 'Pc', 'Complete', 200, 150, 1, '2023-08-25 18:29:43'),
(16, 'MCCB', 'Pc', '16A', 250, 180, 1, '2023-08-25 18:39:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `po_id` int(30) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `client` int(11) NOT NULL,
  `status` int(10) NOT NULL COMMENT '0=open,1=closed',
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `client`, `status`, `created_on`, `updated_on`) VALUES
(1, 'Stenland Pit Latrine', 'Electrification', 1, 0, '2023-08-25 08:05:35', '2023-08-25 08:10:42'),
(2, 'St. Joseph Kaindu Primary School', '2 Door Washroom Construction', 1, 0, '2023-08-25 12:50:12', '0000-00-00 00:00:00'),
(3, 'Repairs & Maintenance', 'Stenland', 1, 0, '2023-08-25 18:18:02', '0000-00-00 00:00:00'),
(4, 'Security House', 'Electrification', 1, 0, '2023-08-25 18:27:40', '2023-08-25 18:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `qo_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_list`
--

CREATE TABLE `quotation_list` (
  `id` int(30) NOT NULL,
  `qo_no` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `discount_percentage` float NOT NULL,
  `discount_amount` float NOT NULL,
  `tax_percentage` float NOT NULL,
  `tax_amount` float NOT NULL,
  `labor_percentage` float NOT NULL,
  `labor_amount` float NOT NULL,
  `notes` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `validity` datetime NOT NULL,
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 11, 1),
(2, 1, 3),
(2, 2, 3),
(1, 1, 1),
(1, 2, 1),
(1, 3, 2),
(1, 4, 6),
(1, 5, 1),
(1, 6, 2),
(1, 8, 1),
(1, 9, 2),
(1, 10, 1),
(1, 12, 1),
(1, 13, 1),
(1, 7, 1),
(3, 1, 1),
(3, 2, 1),
(3, 15, 1),
(3, 10, 1),
(3, 14, 1),
(3, 16, 2);

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
  `has_invoice` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rq_list`
--

INSERT INTO `rq_list` (`id`, `rq_no`, `deliver_to`, `ordered_by`, `approved_by`, `department_name`, `building_name`, `p_id`, `notes`, `status`, `date_fulfilled`, `fulfilled_by`, `checked_by`, `has_invoice`, `date_created`, `date_updated`) VALUES
(1, 'RQ-041780', 'Stenaland', 2, 3, 'Adminstration', 'Admin Block', 1, '', 0, NULL, 4, 5, 0, '2023-08-25 08:09:45', NULL),
(2, 'RQ-026317', 'Stenland', 2, 3, 'Adminstration', 'Admin Block', 3, '', 0, NULL, 4, 5, 0, '2023-08-25 18:20:37', NULL),
(3, 'RQ-184666', 'Stenland', 2, 3, 'Adminstration', 'Admin Block', 4, '', 0, NULL, 4, 5, 0, '2023-08-25 18:38:27', NULL);

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
(1, 'name', 'Remmy & Sons Group'),
(6, 'short_name', 'RSG'),
(11, 'logo', 'uploads/1692990060_WhatsApp Image 2023-06-24 at 9.45.30 PM(2).jpeg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1692990420_RSK.jpg'),
(15, 'company_name', 'Remmy & Sons Group'),
(16, 'company_email', 'info@remmygroup.co.ke'),
(17, 'company_address', 'P.O Box 151-90201'),
(18, 'company_location', 'Mutomo, Kibwezi-Kitui Road'),
(19, 'company_mobile', '0727601329');

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
(2, 'Chris', 'Ongeta', 'chris', '9d45115956829da8285c0acafc35393b', 'uploads/1687336620_1624240500_avatar.png', NULL, 2, '2023-06-21 11:37:24', '2023-08-25 19:42:44'),
(3, 'Remmy', 'Amya', 'remmy', '8769ddc9ece9050a5c3072d4fda6b49e', 'uploads/1687336680_1630999200_avatar5.png', NULL, 3, '2023-06-21 11:38:24', NULL),
(4, 'Mariam', 'Hemed', 'mariam', '13c6cf272b6dc642b9712d5dfccc2e42', 'uploads/1688150700_1687336620_1624240500_avatar.png', NULL, 4, '2023-06-28 11:41:00', '2023-08-25 19:13:01'),
(5, 'Maneno', 'Jappies', 'maneno', 'c0c4651b65e030fa9a8056318ccff013', 'uploads/1688722260_1687336620_1624240500_avatar.png', NULL, 5, '2023-06-28 11:41:42', '2023-08-25 07:14:13');

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
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
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
  ADD KEY `rq_id` (`rq_id`) USING BTREE;

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `client` (`client`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD KEY `po_id` (`qo_id`),
  ADD KEY `item_no` (`item_id`),
  ADD KEY `dn_id` (`qo_id`);

--
-- Indexes for table `quotation_list`
--
ALTER TABLE `quotation_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`client_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_list`
--
ALTER TABLE `delivery_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_list`
--
ALTER TABLE `invoice_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_list`
--
ALTER TABLE `item_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `po_list`
--
ALTER TABLE `po_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quotation_list`
--
ALTER TABLE `quotation_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rq_list`
--
ALTER TABLE `rq_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_list`
--
ALTER TABLE `supplier_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `invoice_list`
--
ALTER TABLE `invoice_list`
  ADD CONSTRAINT `invoice_list_ibfk_1` FOREIGN KEY (`rq_id`) REFERENCES `rq_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
-- Constraints for table `project_list`
--
ALTER TABLE `project_list`
  ADD CONSTRAINT `project_list_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_ibfk_1` FOREIGN KEY (`qo_id`) REFERENCES `quotation_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `quotation_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `quotation_list`
--
ALTER TABLE `quotation_list`
  ADD CONSTRAINT `quotation_list_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
