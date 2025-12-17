-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 08:09 AM
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
-- Database: `travel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guests` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `hotel_id`, `check_in`, `check_out`, `guests`, `total_price`, `booking_date`, `status`) VALUES
(1, 1, 7, '2025-11-22', '2025-11-23', 1, 1250.00, '2025-11-21 01:00:57', 'Confirmed'),
(3, 3, 7, '2025-11-01', '2025-11-12', 1, 13750.00, '2025-11-24 04:17:38', 'Confirmed'),
(4, 3, 7, '2025-11-01', '2025-11-13', 1, 15000.00, '2025-11-24 04:17:58', 'Pending'),
(5, 3, 7, '2025-11-01', '2025-11-11', 1, 12500.00, '2025-11-24 04:18:13', 'Pending'),
(6, 3, 8, '2025-12-15', '2025-12-17', 1, 50000.00, '2025-12-15 14:32:55', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `description` varchar(400) NOT NULL,
  `best_season` varchar(50) NOT NULL,
  `price_range` varchar(50) NOT NULL,
  `highlights` varchar(200) NOT NULL,
  `image_url` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `title`, `country`, `description`, `best_season`, `price_range`, `highlights`, `image_url`) VALUES
(1, 'Sauraha | Chitwan', 'Nepal', 'Sauraha is a town for jungle adventures, with cultural experiences, an Elephant Breeding Center, and possible wildlife sightings near the Rapti.', 'Spring season (October–March)', '7000 (per-person)', 'Chitwan National Park Safari', 'https://visitsauraha.com/wp-content/uploads/elementor/thumbs/nepal-rhino-national-park-949592-q3wcopu8fa12ywcgfh48fa8l5m002ish46czjpjv3e.jpg'),
(2, 'Boudhanath Stupa, Kathmandu', 'Nepal', 'It is filled with consecrated substances, and its massive mandala makes it the largest spherical stupa in Nepal.', 'Autumn season (October – December)', '500 (per-person)', 'Massive White Dome & All-Seeing Buddha Eyes', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIpp6WaXuD9Vo-Vu_WRvY6yfxS8xFiai7llQ&s'),
(3, 'Patan Durbar square', 'Nepal', 'It is one of the three Durbar Squares in the Kathmandu Valley, all of which are UNESCO World Heritage Sites.', 'Spring season (October–March)', '500 (per-person)', 'krishna mandir', 'https://i.pinimg.com/736x/c5/0a/6a/c50a6aabf92a1340ed361565aee8ae27.jpg'),
(5, 'Mustang', 'Nepal', 'Mustang is the fifth largest district of Nepal in terms of area. The district is home to Muktinath Temple (lord of liberation or moksha).', 'march- may', '25000', 'Muktinath Temple', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXM8zoyQ4pr7nK_4igEJfM3ciQ7GDfCJPkTw&s');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `location`, `description`, `price`, `rating`, `reviews`, `type`, `image_url`) VALUES
(1, 'Ganesh Hotel & spa', 'jadibuti, Kathmandu, Nepal', 'Ganesh Hotel & Spa offers a seamless blend of comfort, luxury, and authentic hospitality in a serene and tranquil setting. ', 1500.00, 5.0, 20, 'budget', 'https://ebn-images.s3.amazonaws.com/777f30dc-801c-4eca-af10-1d8a129437e5/1755261287440-delux.jpeg'),
(7, 'Zostel Pokhara', 'Pokhara 18, Sedi Bagar, Lakeside', 'A 5-minute walk from the shores of Phewa Lake, this laid-back hostel is 2 km from Tal Barahi Temple and 5 km from Pokhara Airport.', 1250.00, 4.3, 53, 'budget', 'https://lh3.googleusercontent.com/gps-cs-s/AG0ilSxpeDKbK2zNiJZ2MCzRLrtZDOU9O_1ZLZTx7W7igueeare1bigFglDiayP--V5xDgvj44p7zjY7emSkyeGPP5iQTTOc6R7K6F2I305KxztTVKe44o0-vXhsX7j1TJPI2sMdmCQf=w243-h174-n-k-no-nu'),
(8, 'Soaltee Westend Resort Nagarkot', 'Nagarkot', 'Welcome to Soaltee Westend Resort Nagarkot, an oasis of luxury and natural beauty where modern comfort meets stunning vistas.', 25000.00, 4.5, 643, 'luxury', 'https://soaltee.com/images/6764fb5be51dc_1734671195.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `from_location` varchar(100) NOT NULL,
  `to_location` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `departure_time` varchar(20) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `name`, `from_location`, `to_location`, `description`, `price`, `rating`, `reviews`, `type`, `duration`, `departure_time`, `image_url`) VALUES
(1, 'Yeti express', 'kathmandu', 'pokhara', 'Yeti Express provides fast, reliable ground transportation across Nepal, offering comfortable travel services to major cities and popular tourist destinations.', 1500.00, 4.3, 69, 'Bus', '5 hours', '7 pm (Daily)', 'https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcROBJ_ZN-WAdP2czp1Nl847zkLpkh8HUgJbLa3CCAdjCbBgeLz8'),
(2, 'CaratFeet', 'desired', 'desired', 'CaratFeet is a reliable car rental service offering well maintained vehicles and flexible rental options for convenient travel in and around the city.', 7000.00, 4.5, 609, 'Car Rental', '', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT89I6jYY49P3jVejOVkku05Sg5eY67hQQaWWCk4c0MTU7bOHg2'),
(3, 'City Bikes', 'desired', 'desired', 'City Bikes provides affordable and convenient bicycle rentals, offering well maintained bikes for easy city exploration and short-distance travel.', 2500.00, 4.6, 689, 'Motorcycle', '', '', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3IS8XYurKJX0aP2RT8yPPacUvS5S_kRZroHJMwSF0YSCMxQMl');

-- --------------------------------------------------------

--
-- Table structure for table `transport_bookings`
--

CREATE TABLE `transport_bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transport_id` int(11) NOT NULL,
  `travel_date` date NOT NULL,
  `guests` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport_bookings`
--

INSERT INTO `transport_bookings` (`id`, `user_id`, `transport_id`, `travel_date`, `guests`, `total_price`, `booking_date`, `status`) VALUES
(3, 4, 2, '2025-11-22', 1, 7000.00, '2025-11-21 03:28:50', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin123', 'admin', '2025-11-21 01:00:17'),
(3, 'ripesh', 'ripesh@gmail.com', 'ripesh123', 'user', '2025-11-21 02:38:10'),
(4, 'hello', 'hello@gmail.com', 'hello123', 'user', '2025-11-21 02:46:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_bookings`
--
ALTER TABLE `transport_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transport_bookings`
--
ALTER TABLE `transport_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
