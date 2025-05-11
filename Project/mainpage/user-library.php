<?php
session_start();
include('../registration/db.php');

if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in to proceed.");
}

$userID = $_SESSION['user_id'];  

if (isset($_GET['addBook'])) {
    $bookID = (int)$_GET['addBook'];

    if ($bookID > 0) {
        $checkQuery = $conn->prepare("SELECT * FROM users_books WHERE UserID = ? AND BookID = ?");
        $checkQuery->bind_param("ii", $userID, $bookID);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        if ($checkResult->num_rows > 0) {
            $message = "This book is already in your library!";
        } else {
            $query = $conn->prepare("INSERT INTO users_books (UserID, BookID) VALUES (?, ?)");
            $query->bind_param("ii", $userID, $bookID);

            if ($query->execute()) {
                $message = "Book added to your library!";
            } else {
                $message = "Error adding book to library: " . $query->error;
            }
        }
    } else {
        $message = "Invalid book ID.";
    }
}

if (isset($_GET['removeBook'])) {
    $bookID = (int)$_GET['removeBook'];

    if ($bookID > 0) {
        $removeQuery = $conn->prepare("DELETE FROM users_books WHERE UserID = ? AND BookID = ?");
        $removeQuery->bind_param("ii", $userID, $bookID);

        if ($removeQuery->execute()) {
            $message = "Book removed from your library!";
        } else {
            $message = "Error removing book from library: " . $removeQuery->error;
        }
    } else {
        $message = "Invalid book ID.";
    }
}

$searchQuery = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $searchQuery = "AND Title LIKE '%$search%'";
}

$query = $conn->prepare("SELECT books.* FROM books 
                         JOIN users_books ON books.BookID = users_books.BookID 
                         WHERE users_books.UserID = ? $searchQuery");
$query->bind_param("i", $userID);  
$query->execute();
$result = $query->get_result();

if (!$result) {
    die("Error fetching books: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Library</title>
  <link rel="stylesheet" href="user-library.css">
</head>
<body>
  <div class="header">
    <h1>Your Library</h1>
  </div>

  <div class="search-bar">
    <form method="GET" action="">
      <input type="text" name="search" placeholder="Search for books" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
      <button type="submit">Search</button>
    </form>
  </div>

  <?php if (isset($message)) { ?>
    <div class="message-overlay" id="messageOverlay" style="display: flex;">
      <div class="message">
        <p id="messageText"><?php echo htmlspecialchars($message); ?></p>
      </div>
    </div>
  <?php } ?>

  <div class="library-content">
    <?php
    while ($book = mysqli_fetch_assoc($result)) {
        echo "<div class='book-card'>";
        echo "<img src='" . (!empty($book['CoverImage']) ? 'images/' . $book['CoverImage'] : 'images/default.jpg') . "' alt='Book cover'>";
        echo "<h3>" . htmlspecialchars($book['Title']) . "</h3>"; 
        echo "<a href='" . htmlspecialchars($book['PDF_FilePath']) . "' target='_blank' class='read-btn'>Read</a>";
        echo "<a href='?removeBook=" . $book['BookID'] . "' class='remove-btn'>Remove</a>";
        echo "</div>";
    }
    ?>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var messageOverlay = document.querySelector('.message-overlay');
      if (messageOverlay) {
        setTimeout(function() {
          messageOverlay.classList.add('fade-out');
          setTimeout(function() {
            messageOverlay.style.display = 'none';
          }, 100); 
        }, 300); 
      }
    });
  </script>

</body>
</html>
