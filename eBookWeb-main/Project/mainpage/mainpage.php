<?php
session_start();
include('../registration/db.php');

if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit(); 
}

if (isset($_GET['addBook'])) {
    $bookID = $_GET['addBook'];
    $userID = $_SESSION['user_id']; 

    $checkQuery = "SELECT * FROM users_books WHERE BookID = $bookID AND UserID = $userID";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $message = "This book is already in your library!";
        $messageType = "error";  
    } else {
        $addQuery = "INSERT INTO users_books (UserID, BookID) VALUES ($userID, $bookID)";
        if (mysqli_query($conn, $addQuery)) {
            $message = "Book successfully added to your library!";
            $messageType = "success";  
        } else {
            $message = "An error occurred while adding the book. Please try again.";
            $messageType = "error";  
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Libra</title>
    <link rel="stylesheet" href="mainpage.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
  <div class="container">
    <div class="logo">
      <h1>Library</h1>
    </div>
    <div class="welcome-message">
      <?php if (isset($_SESSION['username'])): ?>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="user-library.php" class="clean-button">Manage Library</a>
      <?php else: ?>
        <span>Welcome, Guest!</span>
      <?php endif; ?>
    </div>
  </div>
</header>

<?php if (isset($message)): ?>
  <div class="message-overlay">
    <div class="message <?php echo $messageType; ?>">
      <?php echo $message; ?>
    </div>
  </div>
<?php endif; ?>

<div class="genre-container">
  <h2>Genres</h2>
  <form method="get">
    <select id="genre-select" name="genre" onchange="this.form.submit()">
      <option value="">All</option>
      <?php
      $genres = mysqli_query($conn, "SELECT * FROM genres");
      while ($genre = mysqli_fetch_assoc($genres)) {
        $selected = (isset($_GET['genre']) && $_GET['genre'] == $genre['GenreID']) ? "selected" : "";
        echo "<option value='{$genre['GenreID']}' $selected>{$genre['GenreName']}</option>";
      }
      ?>
    </select>
  </form>
</div>

<div class="main-content container">
  <section class="book-section">
    <div class="book-row">
      <?php
      $limit = 12;
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $offset = ($page - 1) * $limit;

      $filter = "";
      if (!empty($_GET['genre'])) {
        $genreID = intval($_GET['genre']);
        $filter = "WHERE books.GenreID = $genreID";
      }

      $query = "
        SELECT books.*, authors.FirstName, authors.LastName, genres.GenreName 
        FROM books 
        LEFT JOIN authors ON books.AuthorID = authors.AuthorID 
        LEFT JOIN genres ON books.GenreID = genres.GenreID
        $filter
        LIMIT $limit OFFSET $offset
      ";
      $result = mysqli_query($conn, $query);

      while ($book = mysqli_fetch_assoc($result)) {
        echo "
          <div class='book-card'>
            <img src='" . (!empty($book['CoverImage']) && file_exists('images/' . $book['CoverImage']) ? 'images/' . $book['CoverImage'] : 'images/default.jpg') . "' alt='Book cover'>
            <div class='description-dot'></div>
            <div class='description-tooltip'>" . htmlspecialchars($book['Description']) . "</div>
            <h3>{$book['Title']}</h3>
            <p class='author'>{$book['FirstName']} {$book['LastName']}</p>
            <a href='?addBook={$book['BookID']}'>Add to Library</a>
          </div>
        ";
      }

      $totalQuery = "SELECT COUNT(*) FROM books $filter";
      $totalResult = mysqli_query($conn, $totalQuery);
      $totalBooks = mysqli_fetch_row($totalResult)[0];
      $totalPages = ceil($totalBooks / $limit);

      if ($totalPages > 1) {
        echo "<div class='pagination'>"; 
        for ($i = 1; $i <= $totalPages; $i++) {
          echo "<a href='?page=$i'>$i</a> "; 
        }
        echo "</div>"; 
      }
      ?>
    </div>
  </section>
</div>

</body>
</html>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var messageOverlay = document.querySelector('.message-overlay');
    if (messageOverlay) {
      setTimeout(function() {
        messageOverlay.classList.add('fade-out');
        setTimeout(function() {
          messageOverlay.style.display = 'none';
        }, 100); // 
      }, 300); 
    }
  });
</script>
