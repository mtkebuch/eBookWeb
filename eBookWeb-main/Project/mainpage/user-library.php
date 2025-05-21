<?php
include('library-action.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Library</title>
  <link rel="stylesheet" href="user-library.css"> 
</head>
<body>
  <header>
  <div class="header">
    <h1>MY LIBRARY  <img src="shelf.png"></h1>
    <nav>
      <a href="#my-books">My Books</a>
      <a href="#star-rating" class="rate-link">Rate</a>
      <a href="logout.php" id="logout" class="logout-link">
      Logout <img src="logout.png" alt="Logout" style="width:20px; height:20px; vertical-align: middle; margin-left: 8px;" />
      </a>
    <nav>
  </div>
</header>

  <?php if (!empty($message)) { ?>
    <div class="message-overlay" id="messageOverlay" style="display: flex;">
      <div class="message <?php echo htmlspecialchars($messageType ?? ''); ?>">
        <p id="messageText"><?php echo htmlspecialchars($message); ?></p>
      </div>
    </div>
  <?php } ?>

<div class="library-content">
  <?php while ($book = mysqli_fetch_assoc($result)) { ?>
    <div class="book-card" style="position: relative;">
      
    <a href="?toggleFavorite=<?php echo $book['BookID']; ?>" class="favorite-icon" style="position: absolute; top: 5px; left: 5px;">
    <img src="<?php echo $book['IsFavorite'] ? 'favorite.png' : 'nofavorite.png'; ?>" alt="Favorite Toggle">
    </a>


      <img src="<?php echo !empty($book['CoverImage']) ? 'images/' . $book['CoverImage'] : 'images/default.jpg'; ?>" alt="Book cover">
      <h3><?php echo htmlspecialchars($book['Title']); ?></h3>
      <a href="<?php echo htmlspecialchars($book['PDF_FilePath']); ?>" target="_blank" class="read-btn">Read</a>
      <a href="?removeBook=<?php echo $book['BookID']; ?>" class="remove-btn">Remove</a>
    </div>
  <?php } ?>
</div>


  <div class="rating-wrapper">
  <h2>Rate and Review a Book</h2>
  <form method="POST" class="rating-form-global">
    <div class="rating-section">
      <label for="bookID"></label>
      <select name="bookID" id="bookID" required>
        <option value="">Choose a book</option>
        <?php
          mysqli_data_seek($result, 0); 
          while ($bookOption = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $bookOption['BookID'] . '">' . htmlspecialchars($bookOption['Title']) . '</option>';
          }
        ?>
      </select>
      <br>

      <label for="rating">Rating</label>
      <br><br>
      <div class="star-rating" id="star-rating">
        <img class="star" data-rating="1" src="star.png" alt="1 star">
        <img class="star" data-rating="2" src="star.png" alt="2 stars">
        <img class="star" data-rating="3" src="star.png" alt="3 stars">
        <img class="star" data-rating="4" src="star.png" alt="4 stars">
        <img class="star" data-rating="5" src="star.png" alt="5 stars">
      </div>
    </div>

    <div class="review-section">
      <label for="reviewText">Review:</label>
      <textarea name="reviewText" id="reviewText" placeholder="Write your review..." required></textarea>
    </div>

  
    <button type="submit" name="submitRatingReview">Send</button>
  </form>
</div>


  <script src="user-library.js"></script>
</body>
</html>
