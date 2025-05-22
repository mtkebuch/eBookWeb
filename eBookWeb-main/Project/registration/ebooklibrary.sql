-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 01:49 PM
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
-- Database: `ebooklibrary`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `Email`, `Password`) VALUES
(1, 'giorgi.kandelaki@example.com', 'pass123'),
(8, 'elene.chikovani@example.com', 'elenepass');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `AuthorID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`AuthorID`, `FirstName`, `LastName`) VALUES
(1, 'George', 'Orwell'),
(2, 'Paulo', 'Coelho'),
(3, 'Stephen', 'Hawking'),
(4, 'Plato', ''),
(5, 'Harper', 'Lee'),
(6, 'Charles', 'Darwin'),
(7, 'Fyodor', 'Dostoevsky'),
(8, 'Marcus', 'Aurelius'),
(9, 'Carl', 'Sagan'),
(10, 'Aldous', 'Huxley'),
(18, 'Miguel de ', 'Cervantes'),
(20, 'Jane ', 'Austen'),
(21, 'J.R.R.', 'Tolkien'),
(22, 'J.K.', 'Rowling');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `AuthorID` int(11) DEFAULT NULL,
  `GenreID` int(11) DEFAULT NULL,
  `PDF_FilePath` varchar(255) NOT NULL,
  `CoverImage` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `AuthorID`, `GenreID`, `PDF_FilePath`, `CoverImage`, `Description`) VALUES
(1, '1984', 1, 1, 'pdf/1984.pdf', 'image1.jpg', 'Dystopian.'),
(2, 'The Alchemist', 2, 2, 'pdf/alchemist.pdf', 'image2.jpg', 'Journey.'),
(3, 'A Brief History of Time', 3, 3, 'pdf/history_of_time.pdf', 'image3.jpg', 'Science explained'),
(4, 'The Republic', 4, 2, 'pdf/republic.pdf', 'image4.jpg', 'Philosophy classic'),
(5, 'To Kill a Mockingbird', 5, 1, 'pdf/mockingbird.pdf', 'image5.jpg', 'Justice and race'),
(6, 'The Origin of Species', 6, 3, 'pdf/origin_species.pdf', 'image6.jpg', 'Evolution theory'),
(7, 'Crime and Punishment', 7, 1, 'pdf/crime_punishment.pdf', 'image7.jpg', 'Guilt and redemption'),
(8, 'Meditations', 8, 2, 'pdf/meditations.pdf', 'image8.jpg', 'Stoic philosophy'),
(9, 'Cosmos', 9, 3, 'pdf/cosmos.pdf', 'image9.jpg', 'Universe exploration'),
(10, 'Brave New World', 10, 1, 'pdf/brave_new_world.pdf', 'image10.jpg', 'Futuristic control'),
(26, 'Don Quixote', 18, 13, 'pdf/donquixote.pdf', 'image11.jpg', 'Knightly madness in a world of reason.'),
(27, 'Pride and Prejudice', 20, 8, 'pdf/prideandprejudice', 'image12.jpg', 'A romantic novel about manners, marriage, and misunderstandings in 19th-century England.'),
(30, 'The Hobbit', 21, 6, 'pdf/hobbit.pdf', 'image13.jpg', 'A hobbit embarks on a dangerous quest to reclaim a lost treasure.'),
(31, 'Harry Potter (1)', 22, 6, 'pdf/harry_potter1.pdf', 'image14.jpg', 'A young wizard discovers his magical heritage and attends Hogwarts.');

-- --------------------------------------------------------

--
-- Table structure for table `book_reviews`
--

CREATE TABLE `book_reviews` (
  `ReviewID` int(11) NOT NULL,
  `BookID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ReviewText` text DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_reviews`
--

INSERT INTO `book_reviews` (`ReviewID`, `BookID`, `UserID`, `ReviewText`, `Rating`) VALUES
(1, 1, 12, 'i really liked this book!', 3),
(2, 4, 12, 'wqeq', 3),
(3, 2, 12, 'i really loved thi book', 3),
(4, 3, 2, 'dzalian momewona22', 3),
(5, 2, 1, 'wow!', 3),
(6, 2, 6, 'wow its really good book, i recommend it!!', 3),
(7, 1, 11, 'sdasd', 3),
(8, 1, 14, 'wow', 3),
(9, 1, 1, 'qaaaaaaaaaaaaaaaaaaaaaaa', 3),
(10, 6, 7, '222222222222222', 3),
(11, 2, 15, 'wq', 5),
(12, 3, 1, 'qq', 3),
(13, 2, 8, 'ikjnskajdsad', 3);

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `GenreID` int(11) NOT NULL,
  `GenreName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`GenreID`, `GenreName`) VALUES
(1, 'Dystopian'),
(2, 'Philosophy'),
(3, 'Science'),
(4, 'Fiction'),
(5, 'Science Fiction'),
(6, 'Fantasy'),
(7, 'Mystery'),
(8, 'Romance'),
(13, 'Adventure');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`) VALUES
(1, 'mari', 'tyebu@12', 'tyebuchava@gmail.com'),
(2, 'maria', 'tyebu12!@', 'mari222@gmail.com'),
(6, 'marikuna', 'tyebu@12B', 'tyebuchava2121@gmail.com'),
(7, 'melinoe32', 'tyebu@12AAA', 'mtkebuchava2222@gmail.com'),
(8, 'elene', 'elene@20A', 'elenenems@gmail.com'),
(9, 'anano', 'anano1234@A', 'anano.jolokhava@gau.edu.ge'),
(11, 'valorant', 'valo@12A', 'valorant@gmail.com'),
(12, 'melinoe22323', 'anuki@121A', 'dsad@gmail.com'),
(14, 'anii', 'anuki2323@A', 'anuki@gmail.com'),
(15, 'eleniko', 'lovelove@12A', 'eleneeko@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users_books`
--

CREATE TABLE `users_books` (
  `UserID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `IsFavorite` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_books`
--

INSERT INTO `users_books` (`UserID`, `BookID`, `IsFavorite`) VALUES
(1, 6, 1),
(1, 7, 1),
(6, 1, 1),
(6, 2, 1),
(6, 3, 0),
(6, 4, 0),
(6, 6, 0),
(6, 7, 1),
(7, 1, 1),
(7, 6, 0),
(7, 10, 1),
(8, 2, 1),
(8, 3, 1),
(9, 1, 0),
(9, 2, 0),
(9, 3, 1),
(9, 4, 1),
(9, 7, 0),
(9, 8, 0),
(9, 9, 0),
(9, 10, 0),
(11, 1, 0),
(11, 3, 1),
(14, 1, 1),
(14, 2, 0),
(14, 3, 0),
(15, 1, 0),
(15, 2, 0),
(15, 31, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`AuthorID`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`),
  ADD KEY `AuthorID` (`AuthorID`),
  ADD KEY `GenreID` (`GenreID`);

--
-- Indexes for table `book_reviews`
--
ALTER TABLE `book_reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `BookID` (`BookID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`GenreID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `users_books`
--
ALTER TABLE `users_books`
  ADD PRIMARY KEY (`UserID`,`BookID`),
  ADD KEY `BookID` (`BookID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `AuthorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `BookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `book_reviews`
--
ALTER TABLE `book_reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `GenreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `authors` (`AuthorID`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`GenreID`) REFERENCES `genres` (`GenreID`);

--
-- Constraints for table `book_reviews`
--
ALTER TABLE `book_reviews`
  ADD CONSTRAINT `book_reviews_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
  ADD CONSTRAINT `book_reviews_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `users_books`
--
ALTER TABLE `users_books`
  ADD CONSTRAINT `users_books_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `users_books_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
