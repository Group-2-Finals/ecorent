-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2025 at 08:30 PM
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
-- Database: `ecorent`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `attachmentID` int(100) NOT NULL,
  `itemID` int(100) NOT NULL,
  `fileName` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`attachmentID`, `itemID`, `fileName`) VALUES
(1, 1, 'eg1.jpg'),
(2, 2, 'eg2.2.jpeg'),
(3, 3, 'eg3.jpg'),
(4, 4, 'eg4.jpg'),
(5, 5, 'eg5.jpg'),
(6, 6, 'e6.jpg'),
(7, 7, 'e7.jpg'),
(8, 8, 't1.jpg'),
(9, 9, 't2.jpg'),
(10, 10, 't3.jpg'),
(11, 11, 't4.jpg'),
(12, 12, 't5.jpg'),
(13, 13, 'c1.jpg'),
(14, 14, 'c2.jpg'),
(15, 15, 'c3.jpg'),
(16, 16, 'c4.jpg'),
(17, 17, 'c5.jpeg'),
(18, 18, 's1.jpg'),
(19, 19, 's2.jpg'),
(20, 20, 's3.jpg'),
(21, 21, 's4.jpg'),
(22, 22, 's5.jpg'),
(23, 23, 'p1.jpg'),
(24, 24, 'p2.jpg'),
(25, 25, 'p3.jpg'),
(26, 26, 'p4.jpg'),
(27, 27, '2025Jan21031036000000-waterbottle.JPG'),
(28, 28, '2025Jan21031751000000-basketball.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantity` int(4) NOT NULL,
  `added_date` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(4) NOT NULL,
  `categoryName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES
(1, 'Electronics and Gadgets'),
(2, 'Transportation'),
(3, 'Clothing'),
(4, 'Sports & Outdoor'),
(5, 'Event Supplies\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

CREATE TABLE `conditions` (
  `conditionID` int(4) NOT NULL,
  `conditionName` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`conditionID`, `conditionName`) VALUES
(1, 'Excellet'),
(2, 'Good'),
(3, 'Okay'),
(4, 'Bad');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(4) NOT NULL,
  `categoryID` int(4) NOT NULL,
  `conditionID` int(4) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `itemType` varchar(64) NOT NULL,
  `gasEmissionSaved` decimal(10,2) NOT NULL,
  `pricePerDay` decimal(10,2) DEFAULT NULL,
  `itemSpecifications` varchar(1000) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `location` varchar(50) NOT NULL,
  `pricePerHour` decimal(10,3) DEFAULT NULL,
  `pricePerWeek` decimal(10,3) DEFAULT NULL,
  `securityDeposit` decimal(4,2) DEFAULT NULL,
  `listingDate` date NOT NULL DEFAULT current_timestamp(),
  `listingUpdatedDate` date NOT NULL DEFAULT current_timestamp(),
  `isFeatured` varchar(3) NOT NULL,
  `isDeleted` varchar(3) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `categoryID`, `conditionID`, `itemName`, `itemType`, `gasEmissionSaved`, `pricePerDay`, `itemSpecifications`, `description`, `location`, `pricePerHour`, `pricePerWeek`, `securityDeposit`, `listingDate`, `listingUpdatedDate`, `isFeatured`, `isDeleted`, `stock`) VALUES
(1, 1, 1, 'Canon EOS Rebel T7', 'DSLR', 2.50, 500.00, '24.1 MP CMOS sensor, built-in WiFi, EF-S 18-55mm lens, Full HD video recording, 3-inch LCD screen', 'A reliable and beginner-friendly DSLR camera perfect for capturing high-quality photos and videos.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-21', 'Yes', 'No', 1),
(2, 1, 2, 'Nikon D3500', 'DSLR', 2.60, 450.00, '24.2 MP DX-format sensor, SnapBridge connectivity, 5 fps continuous shooting, 1080p Full HD video, 3-inch LCD screen', 'Lightweight and easy to use, this DSLR is great for both beginners and casual photography enthusiasts.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-21', 'Yes', 'No', 0),
(3, 1, 3, 'Fujifilm Instax Mini 12', 'Instant Camera', 1.50, 250.00, 'Automatic exposure adjustment, close-up mode, built-in flash, film compatibility (Instax Mini), compact design', 'A fun and stylish instant camera that makes capturing and printing memories effortless.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(4, 1, 4, 'Apple iPad Pro 12.9', 'Tablet', 2.50, 700.00, '2.9-inch Liquid Retina XDR display, Apple M2 chip, 128GB storage, WiFi + Cellular, Face ID security\r\n', 'A powerful tablet for creatives and professionals, offering unmatched performance and a stunning display.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(5, 1, 5, 'Samsung Galaxy Tab S8+', 'Tablet', 2.30, 600.00, '12.4-inch AMOLED display, Snapdragon 8 Gen 1 processor, 256GB storage, S Pen included, 8GB RAM', 'A versatile tablet with vibrant visuals, ideal for entertainment, work, and creative tasks.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(6, 1, 3, 'Dell XPS 13', 'Ultrabook', 3.80, 1200.00, 'Intel Core i7 12th Gen, 16GB RAM, 512GB SSD, 13.4-inch InfinityEdge display, Windows 11', 'A sleek and lightweight laptop designed for productivity and portability, perfect for professionals on the go.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(7, 1, 1, 'MacBook Pro 16-inch (2023)', 'Work Laptop', 4.20, 1500.00, 'Apple M2 Max chip, 32GB RAM, 1TB SSD, Liquid Retina XDR display, 21-hour battery life', 'A powerhouse laptop for heavy-duty tasks, offering exceptional performance and premium build quality.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(8, 2, 2, 'Brompton Folding Bike', 'Bike with Basket', 3.00, 350.00, 'Lightweight, 6-speed, compact fold, aluminum alloy frame, 16-inch wheels', 'A versatile and space-saving bike perfect for urban commutes. Its folding design makes it easy to store and transport.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(9, 2, 3, 'Giant Talon 29 3', 'Mountain Bike', 4.50, 500.00, 'Aluminum frame, hydraulic disc brakes, 29-inch tires, Shimano drivetrain, front suspension fork', 'Designed for off-road adventures, this mountain bike combines durability with smooth handling.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(10, 2, 5, 'Razor E300 Electric Scooter', 'Scooter', 3.80, 400.00, '24V battery, 24 km/h max speed, up to 40 min runtime, 10-inch pneumatic tires, twist-grip throttle', 'An eco-friendly and fun way to get around town, offering a smooth and reliable ride.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(11, 2, 0, 'Mongoose Legion L80', 'BMX', 3.20, 450.00, '20-inch tires, hi-ten steel frame, freestyle geometry, sealed bearings, 360° rotor', 'Built for tricks and stunts, this BMX bike is ideal for freestyle enthusiasts and urban riders.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(12, 2, 0, 'Electra Townie 7D', 'Bike with Basket', 3.50, 300.00, '7-speed, ergonomic design, rear rack, step-through frame, puncture-resistant tires', 'A stylish and comfortable bike for leisurely rides and quick errands around the neighborhood.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(13, 3, 0, 'Hugo Boss Formal Suit', 'Men’s Suit', 1.50, 700.00, 'Slim fit, wool blend, navy color, two-button closure, notched lapels', 'A sophisticated and timeless choice for formal occasions and business meetings.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(14, 3, 0, 'Vera Wang Event Gown', 'Gown', 1.80, 1200.00, 'Silk fabric, sequin details, A-line silhouette, adjustable straps, hidden zipper', 'A stunning gown that exudes elegance, perfect for weddings, galas, and other special events', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(15, 3, 0, 'Filipiniana Modern Terno', 'Filipiniana', 1.20, 600.00, 'Organza, butterfly sleeves, embroidered patterns, full-length skirt, fitted bodice', 'A modern take on traditional Filipino attire, blending heritage with contemporary style', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(16, 3, 0, 'Custom Barong Tagalog', 'Barong Tagalog', 1.30, 500.00, 'Piña fiber, hand-woven, traditional design, embroidered details, button-down closure', 'A classic Barong Tagalog that showcases Filipino craftsmanship, perfect for formal and cultural events.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(17, 3, 0, 'Ralph Lauren Evening Suit', 'Men’s Suit', 1.60, 750.00, 'Classic fit, black wool, notch lapel, double vent, fully lined', 'An elegant evening suit that provides a polished and refined look for formal gatherings.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(18, 4, 0, 'Coleman Sundome Tent', 'Camping Tent', 2.00, 400.00, '4-person, weatherproof, easy setup', 'Ideal for family camping trips, this tent is quick to set up and provides excellent protection from the elements.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(19, 4, 0, 'Osprey Aether 65', 'Hiking Backpack', 1.80, 350.00, '65L capacity, adjustable fit, hydration-compatible', 'Perfect for long hikes, this backpack offers ample storage, comfort, and hydration compatibility for your adventures.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(20, 4, 0, 'Decathlon Quechua MH100', 'Camping Tent', 2.30, 300.00, '2-person, lightweight, UV protection', 'A lightweight and compact tent, perfect for short camping trips with UV protection and easy setup.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(21, 4, 0, 'CamelBak MULE Pro', 'Hiking Backpack', 1.50, 250.00, '20L capacity, insulated water reservoir, breathable straps', 'A compact and functional hiking backpack with built-in hydration, ideal for day hikes or biking.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(22, 4, 0, 'Black Diamond Stormline', 'Rain Jacket', 1.20, 200.00, 'Waterproof, lightweight, stretch fabric', 'Stay dry in the toughest weather conditions with this lightweight, waterproof jacket designed for outdoor enthusiasts.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(23, 5, 0, 'Karaoke Machine', 'Audio Equipment', 0.80, 500.00, 'Wireless microphones, Bluetooth connectivity, 12-hour battery life', 'This karaoke machine is perfect for any event looking to add some fun and entertainment. It comes with wireless microphones for ease of movement and features Bluetooth connectivity, allowing you to easily play your favorite tracks. The machine has a long battery life, making it ideal for parties or gatherings that go on for hours. It also includes built-in speakers for clear sound quality, ensuring everyone can enjoy the karaoke experience.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(24, 5, 0, 'Tables and Chairs (Set of 6)', 'Furniture', 1.00, 0.00, 'Foldable, durable metal frame, cushioned seats', 'This set of 6 tables and chairs is designed for versatility and comfort. The foldable design makes it easy to transport and set up, while the durable metal frame ensures stability for guests. The cushioned seats add comfort for long hours of sitting, making it ideal for both casual and formal events. Whether you\'re hosting a small gathering or a larger event, this furniture set is the perfect choice for seating your guests.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(25, 5, 0, 'Party Decor Kit', 'Party Supplies', 0.50, 400.00, 'Balloons, streamers, fairy lights, banners, and tablecloths', 'Transform your venue into a festive wonderland with this all-in-one party decor kit. The kit includes vibrant balloons, colorful streamers, fairy lights for ambiance, cheerful banners, and matching tablecloths to complete the look. Perfect for birthdays, weddings, or any special occasion, this decor kit will add a touch of celebration and fun to your event. It’s a quick and easy way to set the mood and make your event unforgettable.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0),
(26, 5, 0, 'Pop-Up Canopy Tent', 'Outdoor Shelter', 1.20, 600.00, '10x10 ft, waterproof, UV-resistant, easy setup', 'This pop-up canopy tent offers reliable shelter for your outdoor events, whether you\'re hosting a wedding, outdoor market, or family gathering. Measuring 10x10 ft, it provides ample space for guests and supplies. The waterproof and UV-resistant materials ensure that you and your guests are protected from the elements, while the easy setup design allows for quick assembly and disassembly. It’s perfect for both sunny days and rainy weather, keeping your event going smoothly no matter the conditions.', 'Brgy.San Antonio, Sto.Tomas, Batangas', NULL, NULL, NULL, '2025-01-10', '2025-01-10', 'Yes', 'No', 0);

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `preferenceID` int(4) NOT NULL,
  `userID` int(4) NOT NULL,
  `categoryID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`preferenceID`, `userID`, `categoryID`) VALUES
(1, 4, 1),
(2, 2, 1),
(3, 13, 2),
(4, 13, 4),
(5, 13, 1),
(6, 13, 1),
(7, 13, 2),
(8, 13, 5),
(9, 13, 5),
(10, 13, 1),
(11, 15, 5),
(12, 15, 5),
(13, 17, 1),
(14, 17, 2),
(15, 17, 5),
(16, 17, 1),
(17, 18, 1),
(18, 18, 1),
(19, 18, 5),
(20, 19, 4),
(21, 19, 5),
(22, 19, 1),
(23, 20, 1),
(24, 20, 2),
(25, 20, 3),
(26, 23, 2),
(27, 23, 4),
(28, 23, 1),
(29, 24, 3);

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `rentalID` int(4) NOT NULL,
  `renterID` int(4) NOT NULL,
  `itemID` int(4) NOT NULL,
  `reservationDate` date NOT NULL DEFAULT current_timestamp(),
  `startRentalDate` date NOT NULL DEFAULT current_timestamp(),
  `endRentalDate` date NOT NULL DEFAULT current_timestamp(),
  `rentalPeriod` varchar(10) NOT NULL,
  `rateType` varchar(20) NOT NULL,
  `shippingMode` varchar(20) NOT NULL,
  `isDepositPaid` varchar(5) NOT NULL,
  `totalPrice` decimal(10,0) NOT NULL,
  `rentalStatus` varchar(20) NOT NULL,
  `itemQuantity` int(100) DEFAULT NULL,
  `totalCO2Saved` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`rentalID`, `renterID`, `itemID`, `reservationDate`, `startRentalDate`, `endRentalDate`, `rentalPeriod`, `rateType`, `shippingMode`, `isDepositPaid`, `totalPrice`, `rentalStatus`, `itemQuantity`, `totalCO2Saved`) VALUES
(1, 4, 5, '2025-01-09', '2025-01-09', '2025-01-09', '7 days', 'per day', 'meetup', 'true', 490, 'on rent', 2, 0),
(2, 2, 2, '2025-01-09', '2025-01-09', '2025-01-09', '3 days', 'per hour', 'cash-on-pickup', 'false', 189, 'cancelled', 3, 0),
(3, 2, 1, '2025-01-09', '2025-01-09', '2025-01-09', '3 days', 'per day', 'cash-on-pickup', 'false', 500, 'pending', 3, 26),
(4, 1, 1, '2025-01-10', '2025-01-15', '2025-01-20', '5 days', 'per day', 'pickup', '', 500, 'pending', 1, 50),
(5, 1, 2, '2025-01-18', '2025-01-20', '2025-01-23', '3 days', 'per day', 'pickup', '', 300, 'on rent', 1, 30),
(6, 2, 3, '2025-01-05', '2025-01-07', '2025-01-10', '3 days', 'per day', 'pickup', '', 300, 'pickup', 2, 30),
(7, 2, 4, '2025-01-15', '2025-01-16', '2025-01-18', '2 days', 'per day', 'pickup', '', 200, 'returned', 1, 20),
(8, 3, 5, '2025-01-12', '2025-01-13', '2025-01-15', '2 days', 'per day', 'pickup', '', 150, 'cancelled', 1, 20),
(9, 3, 6, '2025-01-20', '2025-01-21', '2025-01-23', '2 days', 'per day', 'pickup', '', 300, 'on rent', 2, 35),
(10, 4, 7, '2025-01-08', '2025-01-10', '2025-01-15', '5 days', 'per day', 'pickup', '', 750, 'on rent', 1, 60),
(11, 4, 8, '2025-01-12', '2025-01-14', '2025-01-18', '4 days', 'per day', 'pickup', '', 600, 'extended', 1, 50),
(12, 5, 9, '2025-01-01', '2025-01-03', '2025-01-07', '4 days', 'per day', 'pickup', '', 400, 'overdue', 3, 40),
(13, 5, 10, '2025-01-05', '2025-01-08', '2025-01-10', '2 days', 'per day', 'pickup', '', 200, 'pickup', 1, 25),
(14, 6, 11, '2025-01-05', '2025-01-08', '2025-01-14', '6 days', 'per day', 'pickup', '', 600, 'extended', 2, 70),
(15, 6, 12, '2025-01-18', '2025-01-19', '2025-01-22', '3 days', 'per day', 'pickup', '', 300, 'pending', 1, 35),
(16, 7, 13, '2025-01-10', '2025-01-12', '2025-01-16', '4 days', 'per day', 'pickup', '', 400, 'returned', 1, 35),
(17, 7, 14, '2025-01-15', '2025-01-16', '2025-01-20', '4 days', 'per day', 'pickup', '', 400, 'on rent', 2, 45),
(18, 8, 15, '2025-01-14', '2025-01-15', '2025-01-18', '3 days', 'per day', 'pickup', '', 300, 'pending', 1, 25),
(19, 8, 16, '2025-01-20', '2025-01-21', '2025-01-24', '3 days', 'per day', 'pickup', '', 300, 'on rent', 1, 40),
(20, 9, 17, '2025-01-10', '2025-01-15', '2025-01-20', '5 days', 'per day', 'pickup', '', 500, 'pending', 1, 50),
(21, 10, 18, '2025-01-12', '2025-01-14', '2025-01-16', '2 days', 'per day', 'pickup', '', 200, 'pickup', 1, 30),
(22, 11, 19, '2025-01-08', '2025-01-10', '2025-01-13', '3 days', 'per day', 'pickup', '', 300, 'on rent', 1, 35),
(23, 12, 20, '2025-01-18', '2025-01-20', '2025-01-23', '3 days', 'per day', 'pickup', '', 450, 'extended', 2, 45),
(24, 13, 21, '2025-01-15', '2025-01-17', '2025-01-20', '3 days', 'per day', 'pickup', '', 450, 'returned', 1, 40),
(25, 14, 22, '2025-01-14', '2025-01-15', '2025-01-17', '2 days', 'per day', 'pickup', '', 200, 'cancelled', 1, 20),
(26, 15, 23, '2025-01-18', '2025-01-19', '2025-01-22', '3 days', 'per day', 'pickup', '', 300, 'pending', 1, 35),
(27, 16, 24, '2025-01-16', '2025-01-18', '2025-01-22', '4 days', 'per day', 'pickup', '', 400, 'on rent', 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(4) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(15) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `status` varchar(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `contactNumber` varchar(15) NOT NULL,
  `address` varchar(50) NOT NULL,
  `accountCreationDate` date NOT NULL DEFAULT current_timestamp(),
  `accountUpdatedDate` date NOT NULL DEFAULT current_timestamp(),
  `profilePicture` varchar(20) NOT NULL,
  `role` varchar(100) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `password`, `status`, `gender`, `contactNumber`, `address`, `accountCreationDate`, `accountUpdatedDate`, `profilePicture`, `role`) VALUES
(1, 'Alan', 'Smithee', 'alan.smithee@gmail.com', 'alan123', 'Active', 'Male', '+63-912-345-678', '1234 Maple Street, Springfield, IL 62701', '2025-01-09', '2025-01-09', 'alan.jpg', 'user'),
(2, 'Ian', 'Anderson', 'ian.anderson@gmail.com', 'ian123', 'Inactive', 'Male', '+63-921-234-567', '5678 Oak Avenue, Los Angeles, CA 90001', '2025-01-09', '2025-01-09', 'ian.jpg', 'user'),
(3, 'Oscar', 'Johnson', 'oscar.johnson@gmail.com', 'oscar123', 'Inactive', 'Male', '+63-928-123-456', '4321 Pine Road, Miami, FL 33101', '2025-01-09', '2025-01-09', 'oscar.jpg', 'user'),
(4, 'William', 'Johnson', 'william.johnson@gmail.com', 'william123', 'Active', 'Male', '+63-937-876-543', '8765 Birch Lane, Dallas, TX 75201', '2025-01-09', '2025-01-09', 'william.jpg', 'user'),
(5, 'Harry', 'Jones', 'harry.jones@gmail.com', 'harry123', 'Active', 'Male', '+63-915-678-123', '2345 Elm Drive, Chicago, IL 60601', '2025-01-09', '2025-01-09', 'harry.jpg', 'user'),
(20, 'Mark Louie', 'Villanueva', 'marklouievillanueva584@gmail.com', '$2y$10$fdDATs0n5omc9K2Dbh7IFeMcgWmM.o7N0qZJyhQyisQAOyF4rLhuu', '', '', '', '', '2025-01-17', '2025-01-17', '', 'user'),
(21, 'mark', 'villanueva', 'mark@gmail.com', '$2y$10$XT75e0iMRUdX5VvJTCvkTu4j7tzMcnk/9BMaSL8DKxTr34xomd6IO', '', '', '', '', '2025-01-18', '2025-01-18', '', 'user'),
(22, '', '', 'ecorent@gmail.com', 'ecorent123', '', '', '', '', '2025-01-18', '2025-01-18', '', 'admin'),
(23, 'Ludwiggg', 'Atkinson', 'ludwig@gmail.com', '$2y$10$XQheueZy3Ho3Hw3azlXr4u5r7m.5IV1rowYB/d7GAjKu2B0CBF.6K', '', '', '', '', '2025-01-19', '2025-01-19', '', 'user'),
(24, 'john', 'doe', 'john@gmail.com', '$2y$10$HlPwXbFwzQZ1xKBFwv9sXOKZFPDpYDsrmN2WoikMEpfbjY1rjyjEe', '', '', '', '', '2025-01-19', '2025-01-19', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`attachmentID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `conditions`
--
ALTER TABLE `conditions`
  ADD PRIMARY KEY (`conditionID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`preferenceID`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`rentalID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `attachmentID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `conditions`
--
ALTER TABLE `conditions`
  MODIFY `conditionID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `preferenceID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `rentalID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
