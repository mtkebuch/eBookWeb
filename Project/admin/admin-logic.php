<?php
include('../registration/db.php');

$tables = ['authors', 'books', 'book_reviews', 'genres', 'users'];
$allTablesOutput = "";

foreach ($tables as $table) {
  $allTablesOutput .= "<h2 class='table-name' data-table='$table'>$table</h2>";
  
  $allTablesOutput .= "
    <div class='table-actions' data-table='$table' style='display:none; margin-bottom: 20px;'>
      <a href='add.php?table=$table' class='add'>Add New</a>
      <a href='#' class='edit disabled'>Edit Selected</a>
      <a href='#' class='delete disabled'>Delete Selected</a>
    </div>
  ";
}

mysqli_close($conn);
echo "<div id='tables-container'>$allTablesOutput</div>";

?>
