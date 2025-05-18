<?php
include('../registration/db.php');

$tables = ['authors', 'books', 'book_reviews', 'genres', 'users'];
$selectedTable = $_GET['table'] ?? $tables[0];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin-dash.css">
</head>
<body>
   <div class="page-title">Admin Dashboard</div>

  <form method="GET" id="table-select-form">
    <label for="table-select">SELECT TABLE</label>
    <select name="table" id="table-select" onchange="this.form.submit()">
      <?php foreach ($tables as $table): ?>
        <option value="<?= $table ?>" <?= $table === $selectedTable ? 'selected' : '' ?>>
          <?= ucfirst($table) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </form>

  <div id="table-data">
    <?php
    if ($selectedTable && in_array($selectedTable, $tables)) {
      $result = mysqli_query($conn, "SELECT * FROM $selectedTable");

      if ($result && mysqli_num_rows($result) > 0) {
        echo "<br>";
        echo "<p>$selectedTable Data</p>";
        echo "<form method='GET' action=''>";
        echo "<input type='hidden' name='table' value='$selectedTable'>";
        echo "<table><tr>";

        while ($field = mysqli_fetch_field($result)) {
          echo "<th>{$field->name}</th>";
        }
        echo "<th>Actions</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
          $id = reset($row);
          echo "<tr>";
          foreach ($row as $val) {
            echo "<td>$val</td>";
          }
          echo "<td><input type='radio' name='id' value='$id'></td>";
          echo "</tr>";
        }
        echo "</table>";

        echo "<div class='table-actions'>";
        echo "<button type='submit' formaction='edit.php'>Edit Selected</button>";
        echo "<button type='submit' formaction='delete.php' onclick='return confirm(\"Are you sure?\")'>Delete Selected</button>";
        echo "<a href='add.php?table=$selectedTable' class='add'>Add New</a>";
        echo "</div>";

        echo "</form>";
      } else {
        echo "<p>No data in $selectedTable</p>";
      }
    }
    mysqli_close($conn);
    ?>
  </div>
</body>
</html>
