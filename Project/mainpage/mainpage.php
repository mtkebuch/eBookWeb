<?php
include('../registration/db.php');
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
    <h1>E-Libra</h1>
    <span>Welcome, Guest!</span>
  </div>
</header>

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
      $limit = 10;
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
            <h3>{$book['Title']}</h3>
            <p class='author'>{$book['FirstName']} {$book['LastName']}</p>
            <a href='{$book['PDF_FilePath']}' target='_blank'>Read</a>
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
