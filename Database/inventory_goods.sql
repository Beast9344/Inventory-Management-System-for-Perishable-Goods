-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 06:36 PM
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
-- Database: `inventory_goods`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `alert_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `alert_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `alert_type`, `description`, `alert_date`, `status`) VALUES
(1, 'System', 'System maintenance scheduled.', '2024-12-01', 'Active'),
(2, 'Order', 'Order #1001 delayed.', '2024-12-02', 'Resolved'),
(3, 'Inventory', 'Low stock for product P001.', '2024-12-03', 'Active'),
(4, 'System', 'Server restarted successfully.', '2024-12-04', 'Closed'),
(5, 'Order', 'Order #1002 cancelled.', '2024-12-05', 'Closed'),
(6, 'Inventory', 'Overstock in warehouse W001.', '2024-12-06', 'Active'),
(7, 'System', 'New software version available.', '2024-12-07', 'Active'),
(8, 'Order', 'Order #1003 completed.', '2024-12-06', 'Resolved'),
(9, 'Inventory', 'New stock added for product P002.', '2024-12-07', 'Active'),
(10, 'System', 'Backup completed successfully.', '2024-12-07', 'Resolved'),
(11, 'System', 'Backup Complete', '2024-12-26', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `job_title` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `years_of_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `name`, `department`, `job_title`, `location`, `years_of_service`) VALUES
('A001', 'Olivia Taylor', 'Admin', 'Office Manager', 'Houston', 10),
('A002', 'Benjamin Lee', 'Admin', 'Administrative Assistant', 'Atlanta', 4),
('A003', 'Charlotte White', 'Admin', 'Facilities Coordinator', 'Phoenix', 6),
('HR001', 'Isabella Harris', 'HR', 'HR Manager', 'Philadelphia', 8),
('HR002', 'Lucas Martinez', 'HR', 'Recruitment Specialist', 'San Diego', 5),
('HR003', 'Mia Walker', 'HR', 'Employee Relations Officer', 'Las Vegas', 2),
('IT001', 'Alice Johnson', 'IT', 'Software Engineer', 'San Francisco', 4),
('IT002', 'Raj Patel', 'IT', 'System Administrator', 'Dallas', 7),
('IT003', 'Emily Chen', 'IT', 'Data Analyst', 'Seattle', 2),
('M001', 'Sophia Brown', 'Marketing', 'Marketing Manager', 'Boston', 6),
('M002', 'Liam Wilson', 'Marketing', 'Content Strategist', 'Miami', 3),
('M003', 'Ethan Davis', 'Marketing', 'SEO Specialist', 'Denver', 2),
('S001', 'John Smith', 'Sales', 'Regional Sales Manager', 'New York', 8),
('S002', 'Jane Doe', 'Sales', 'Sales Executive', 'Los Angeles', 3),
('S003', 'Carlos Martinez', 'Sales', 'Account Manager', 'Chicago', 5);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `quantity`, `price`, `description`) VALUES
(1, 'Dell Inspiron Laptop', 15, 7500.00, '15.6 inch, 8GB RAM, 256GB SSD, Windows 11'),
(2, 'Logitech Wireless Mouse', 50, 25.99, 'Ergonomic design, USB receiver, compatible with Windows and Mac'),
(3, 'Samsung Galaxy A54', 30, 349.00, '128GB storage, 5G compatible, 6.4-inch AMOLED display'),
(4, 'HP OfficeJet Pro Printer', 10, 150.50, 'All-in-one wireless printer, scanner, and copier'),
(5, 'Standing Desk', 8, 299.99, 'Adjustable height desk, 48x30 inches, solid wood top'),
(6, 'Bose Noise Cancelling Headphones', 20, 199.00, 'Wireless Bluetooth, 20-hour battery life, with microphone'),
(7, 'Canon EOS 2000D Camera', 5, 450.00, '24.1 MP DSLR camera, with 18-55mm lens kit'),
(8, 'Apple MacBook Pro', 12, 1800.00, '13-inch, M2 chip, 8GB RAM, 512GB SSD'),
(9, 'Google Nest Smart Thermostat', 25, 129.99, 'Energy-efficient smart thermostat with Wi-Fi control'),
(10, 'Anker Power Bank', 40, 49.99, '20,000mAh portable charger, USB-C and USB-A ports');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `status` enum('Pending','Processing','Completed','Cancelled') DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `order_date`, `status`, `total_amount`) VALUES
(1, 'Alice Johnson', '2024-11-05', 'Completed', 150.75),
(2, 'Bob Smith', '2024-10-02', 'Pending', 250.00),
(3, 'Charlie Davis', '2024-12-03', 'Processing', 199.99),
(4, 'Diana White', '2024-09-05', 'Cancelled', 0.00),
(5, 'Evan Brown', '2024-08-05', 'Completed', 500.20),
(6, 'Fiona Green', '2024-07-06', 'Processing', 125.49),
(7, 'George Hill', '2024-12-07', 'Pending', 80.00),
(8, 'Hannah Adams', '2024-12-07', 'Completed', 300.10),
(9, 'Ian Black', '2024-12-06', 'Cancelled', 10.00),
(10, 'Charlie Davis', '2024-12-13', 'Completed', 100.00),
(11, 'Charlie ', '2024-12-27', 'Processing', 200.00),
(12, 'Davis', '2024-12-12', 'Processing', 300.00),
(13, 'shanto', '2024-12-11', 'Completed', 300.00),
(14, 'alam', '2025-01-09', 'Completed', 200.00),
(15, 'Esha', '2025-01-10', 'Completed', 300.00),
(16, 'abdullah', '2024-11-19', 'Completed', 300.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`, `subtotal`, `payment_method`, `total`, `order_date`) VALUES
(1, 33662232, 'Smartphone', 500.00, 1, 500.00, 'cashOnDelivery', 550.00, '2024-12-19 21:35:52'),
(2, 3030472, 'Smartphone', 500.00, 3, 1500.00, 'paypal', 1650.00, '2024-12-19 22:04:27'),
(3, 30209280, 'Smartphone', 500.00, 2, 1000.00, 'creditCard', 2699.40, '2024-12-20 00:27:29'),
(4, 30209280, 'Laptop', 700.00, 2, 1400.00, 'creditCard', 2699.40, '2024-12-20 00:27:29'),
(5, 30209280, 'T-Shirt', 15.00, 3, 45.00, 'creditCard', 2699.40, '2024-12-20 00:27:29'),
(6, 30209280, 'Apples', 3.00, 3, 9.00, 'creditCard', 2699.40, '2024-12-20 00:27:29'),
(7, 66267654, 'Smartphone', 500.00, 1, 500.00, 'paypal', 616.00, '2024-12-20 00:27:50'),
(8, 66267654, 'T-Shirt', 15.00, 4, 60.00, 'paypal', 616.00, '2024-12-20 00:27:50'),
(9, 66713923, 'Smartphone', 500.00, 3, 1500.00, 'paypal', 3960.00, '2024-12-20 00:28:35'),
(23, 66713924, 'Smartphone', 500.00, 1, 500.00, 'cashOnDelivery', 550.00, '2024-12-19 21:35:07'),
(24, 66713925, 'Smartphone', 500.00, 1, 500.00, 'cashOnDelivery', 550.00, '2024-12-19 21:36:53'),
(25, 66713926, 'Smartphone', 500.00, 1, 500.00, 'cashOnDelivery', 550.00, '2024-12-19 21:37:01'),
(26, 96956982, 'Laptop', 700.00, 3, 2100.00, 'cashOnDelivery', 4042.50, '2024-12-20 02:45:45'),
(27, 96956982, 'Smartphone', 500.00, 3, 1500.00, 'cashOnDelivery', 4042.50, '2024-12-20 02:45:45'),
(28, 96956982, 'T-Shirt', 15.00, 5, 75.00, 'cashOnDelivery', 4042.50, '2024-12-20 02:45:45'),
(29, 29393083, 'Laptop', 700.00, 2, 1400.00, 'creditCard', 3239.50, '2024-12-20 05:10:20'),
(30, 29393083, 'T-Shirt', 15.00, 3, 45.00, 'creditCard', 3239.50, '2024-12-20 05:10:20'),
(31, 29393083, 'Smartphone', 500.00, 3, 1500.00, 'creditCard', 3239.50, '2024-12-20 05:10:20'),
(32, 8154383, 'Keyboard', 29.99, 5, 149.95, 'cashOnDelivery', 9030.64, '2024-12-20 20:27:00'),
(33, 8154383, 'Smartwatch', 249.99, 7, 1749.93, 'cashOnDelivery', 9030.64, '2024-12-20 20:27:00'),
(34, 8154383, 'Organic Eggs', 2.00, 5, 10.00, 'cashOnDelivery', 9030.64, '2024-12-20 20:27:00'),
(35, 8154383, 'Smartphone', 799.99, 7, 5599.93, 'cashOnDelivery', 9030.64, '2024-12-20 20:27:00'),
(36, 8154383, 'Headphones', 49.99, 14, 699.86, 'cashOnDelivery', 9030.64, '2024-12-20 20:27:00'),
(37, 91309789, 'Milk - Full Cream', 3.50, 2, 7.00, 'cashOnDelivery', 78.08, '2024-12-20 21:09:36'),
(38, 91309789, 'Organic Eggs', 2.00, 2, 4.00, 'cashOnDelivery', 78.08, '2024-12-20 21:09:36'),
(39, 91309789, 'Keyboard', 29.99, 2, 59.98, 'cashOnDelivery', 78.08, '2024-12-20 21:09:36'),
(40, 24843992, 'Laptop', 700.00, 6, 4200.00, 'paypal', 4666.20, '2024-12-20 21:10:23'),
(41, 24843992, 'Apples', 3.00, 14, 42.00, 'paypal', 4666.20, '2024-12-20 21:10:23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `stock_quantity`, `price`) VALUES
('101', 'Milk - Full Cream', 'Dairy', 250, 3.50),
('102', 'Cheddar Cheese', 'Dairy', 120, 5.25),
('103', 'Organic Eggs', 'Eggs', 450, 2.00),
('104', 'Fresh Butter', 'Dairy', 80, 4.75),
('P001', 'Laptop', 'Electronics', 50, 999.99),
('P002', 'Smartphone', 'Electronics', 100, 799.99),
('P003', 'Tablet', 'Electronics', 30, 499.99),
('P004', 'Headphones', 'Accessories', 200, 49.99),
('P005', 'Monitor', 'Electronics', 70, 199.99),
('P006', 'Keyboard', 'Accessories', 150, 29.99),
('P007', 'Mouse', 'Accessories', 300, 19.99),
('P008', 'Smartwatch', 'Electronics', 40, 249.99),
('P009', 'Printer', 'Office Supplies', 20, 159.99),
('P010', 'Desk Lamp', 'Office Supplies', 80, 39.99),
('P017', 'potato', 'vegatable', 100, 1000.00);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report_name` varchar(100) DEFAULT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_name`, `report_date`, `details`) VALUES
(1, 'Monthly Sales Report', '2024-12-01 03:00:00', 'Details on sales performance for November 2024'),
(2, 'Inventory Audit', '2024-12-05 08:30:00', 'Report on discrepancies found during inventory check'),
(3, 'Employee Performance Review', '2024-11-30 04:00:00', 'Summary of performance reviews conducted in Q4 2024'),
(4, 'Marketing Campaign ROI', '2024-11-28 05:00:00', 'Analysis of ROI from the Black Friday marketing campaign'),
(5, 'Customer Feedback Analysis', '2024-11-25 10:00:00', 'Insights from customer surveys conducted in November 2024'),
(6, 'Quarterly Financial Report', '2024-10-15 04:00:00', 'Financial summary for Q3 2024, including profit/loss statement'),
(7, 'IT Security Assessment', '2024-12-12 03:30:00', 'Evaluation of current IT security systems and vulnerabilities'),
(8, 'New Product Launch Metrics', '2024-12-10 09:00:00', 'Performance analysis of the newly launched product line'),
(9, 'Compliance Audit Report', '2024-11-20 07:00:00', 'Report on compliance with company policies and industry regulations'),
(10, 'Annual Revenue Summary', '2024-12-15 11:00:00', 'Comprehensive summary of revenues for 2024.');

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `storage_id` varchar(50) NOT NULL,
  `storage_name` varchar(100) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `used_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`storage_id`, `storage_name`, `capacity`, `used_capacity`) VALUES
('S001', 'Main Storage', 1000, 750),
('S002', 'Secondary Storage', 500, 300),
('S003', 'Backup Storage', 300, 150),
('S004', 'Overflow Storage', 200, 50),
('S005', 'Cold Storage', 400, 100),
('S006', 'Dry Storage', 600, 450),
('S007', 'Chemical Storage', 200, 180),
('S008', 'Hazmat Storage', 100, 90),
('S009', 'Raw Material Storage', 500, 350),
('S010', 'Finished Goods Storage', 700, 650),
('S011', 'Raw Material Storage-2', 1000, 500);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`) VALUES
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$RcY9.npv3MfQs9pvl7YdA.OIGRid/adDLTW2qiTqfnOT3380gcm0S', 'admin'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$a.8zcXc1S2swLeQLGGeKWeXUrhiVdRD3ot6xGypIh.tF4B8nQugAC', 'Sales Officer'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$gF1FsFpYzL3dqEkcCn/wyO6aLIix0rD6ZeotRolmv6IquGKhvqja2', 'Product Officer'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$SVpShAWyzD/OFwcslPRLXureM16osjPsTbFHhlCjkEpBQmXHovQWq', 'Warehouse Manager'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$9RVpj53OTh6K.rXPnFa9leu5iIeb1EMgaDfMFndx0sXj/wthSmlsK', 'Customer'),
(0, 'ABDULLAH', 'abdullah@gmail.com', '$2y$10$WFkWv/8lpJFX3kTbcazdjOuHfmT3jon9e2yz5tJdluiDcwZ5549ka', 'Consumer');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `visitor_ip` varchar(45) DEFAULT NULL,
  `visit_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `warehouse_id` int(11) NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL,
  `stock_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`warehouse_id`, `warehouse_name`, `location`, `capacity`, `stock_level`) VALUES
(1, 'Warehouse A(San Francisco)', '37.7749,-122.4194', 1000, 800),
(2, 'Warehouse B(Los Angeles)', '34.0522,-118.2437', 2000, 1500),
(3, 'Warehouse C(New York)', '40.7128,-74.0060', 1500, 1200),
(4, 'Warehouse D(London)', '51.5074,-0.1278', 2500, 2000),
(5, 'Warehouse D(London)', '53.5074,-0.1278', 3500, 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`storage_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10238;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
