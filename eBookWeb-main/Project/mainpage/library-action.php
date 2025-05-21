<?php
session_start();
include('../registration/db.php');

if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in to proceed.");
}

$userID = $_SESSION['user_id'];
$message = "";
$messageType = "";

foreach ($_GET as $key => $value) {
    if ($key === 'addBook') {
        $bookID = (int)$value;
        if ($bookID > 0) {
            $checkQuery = $conn->prepare("SELECT * FROM users_books WHERE UserID = ? AND BookID = ?");
            $checkQuery->bind_param("ii", $userID, $bookID);
            $checkQuery->execute();
            $checkResult = $checkQuery->get_result();

            if ($checkResult->num_rows > 0) {
                $message = "This book is already in your library!";
                $messageType = "error";
            } else {
                $query = $conn->prepare("INSERT INTO users_books (UserID, BookID) VALUES (?, ?)");
                $query->bind_param("ii", $userID, $bookID);

                if ($query->execute()) {
                    $message = "Book added to your library!";
                    $messageType = "success";
                } else {
                    $message = "Error adding book to library: " . $query->error;
                    $messageType = "error";
                }
            }
        } else {
            $message = "Invalid book ID.";
            $messageType = "error";
        }
        header("Location: user-library.php");
        exit;
    }
    if ($key === 'removeBook') {
        $bookID = (int)$value;
        if ($bookID > 0) {
            $removeQuery = $conn->prepare("DELETE FROM users_books WHERE UserID = ? AND BookID = ?");
            $removeQuery->bind_param("ii", $userID, $bookID);

            if ($removeQuery->execute()) {
                $message = "Book removed from your library!";
                $messageType = "error";
            } else {
                $message = "Error removing book from library: " . $removeQuery->error;
                $messageType = "error";
            }
        } else {
            $message = "Invalid book ID.";
            $messageType = "error";
        }
        header("Location: user-library.php");
        exit;
    }
    if ($key === 'toggleFavorite') {
        $bookID = (int)$value;

        $check = $conn->prepare("SELECT IsFavorite FROM users_books WHERE UserID = ? AND BookID = ?");
        $check->bind_param("ii", $userID, $bookID);
        $check->execute();
        $resultCheck = $check->get_result();

        if ($row = $resultCheck->fetch_assoc()) {
            $newValue = $row['IsFavorite'] ? 0 : 1;
            $update = $conn->prepare("UPDATE users_books SET IsFavorite = ? WHERE UserID = ? AND BookID = ?");
            $update->bind_param("iii", $newValue, $userID, $bookID);
            $update->execute();
        }
        header("Location: user-library.php");
        exit;
    }
}

if (!empty($_POST)) {
    if (isset($_POST['submitRatingReview'])) {
        $bookID = (int)$_POST['bookID'];
        $rating = (int)$_POST['rating'];
        $reviewText = isset($_POST['reviewText']) ? $_POST['reviewText'] : '';

        if ($bookID > 0 && $rating >= 1 && $rating <= 5) {
            $checkQuery = $conn->prepare("SELECT * FROM book_reviews WHERE UserID = ? AND BookID = ?");
            $checkQuery->bind_param("ii", $userID, $bookID);
            $checkQuery->execute();
            $checkResult = $checkQuery->get_result();

            if ($checkResult->num_rows > 0) {
                $updateQuery = $conn->prepare("UPDATE book_reviews SET Rating = ?, ReviewText = ? WHERE UserID = ? AND BookID = ?");
                $updateQuery->bind_param("isii", $rating, $reviewText, $userID, $bookID);
                if ($updateQuery->execute()) {
                    $message = "Rating and review updated successfully!";
                    $messageType = "success";
                } else {
                    $message = "Error updating rating and review: " . $updateQuery->error;
                    $messageType = "error";
                }
            } else {
                $insertQuery = $conn->prepare("INSERT INTO book_reviews (UserID, BookID, Rating, ReviewText) VALUES (?, ?, ?, ?)");
                $insertQuery->bind_param("iiis", $userID, $bookID, $rating, $reviewText);
                if ($insertQuery->execute()) {
                    $message = "Rating and review added successfully!";
                    $messageType = "success";
                } else {
                    $message = "Error adding rating and review: " . $insertQuery->error;
                    $messageType = "error";
                }
            }
        } else {
            $message = "Invalid book or rating.";
            $messageType = "error";
        }
    }
}

$query = $conn->prepare("
    SELECT b.*, ub.IsFavorite 
    FROM books b
    JOIN users_books ub ON b.BookID = ub.BookID
    WHERE ub.UserID = ?
    ORDER BY ub.IsFavorite ASC
");
$query->bind_param("i", $userID);
$query->execute();
$result = $query->get_result();

if (!$result) {
    die("Error fetching books: " . mysqli_error($conn));
}
?>
