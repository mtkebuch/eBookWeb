<?php
include('../registration/db.php');

if (!isset($_GET['table'])) {
  echo "Table not specified.";
  exit;
}

$table = $_GET['table'];
$allowedTables = ['authors', 'books', 'book_reviews', 'genres', 'users'];
if (!in_array($table, $allowedTables)) {
  echo "Invalid table.";
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM $table");

if ($result && mysqli_num_rows($result) > 0) {
  echo "<h2>$table Data</h2>";
  echo "<table><tr>";

  while ($field = mysqli_fetch_field($result)) {
    echo "<th>{$field->name}</th>";
  }
  echo "</tr>";

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr data-id='" . reset($row) . "'>";
    foreach ($row as $val) {
      echo "<td>$val</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "<p>No data in $table</p>";
}

mysqli_close($conn);
?>
