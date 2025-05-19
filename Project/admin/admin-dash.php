<?php
include('../registration/db.php');

$tables = ['authors', 'books', 'book_reviews', 'genres', 'users'];
$selectedTable = $_GET['table'] ?? $tables[0];
$message = $_GET['msg'] ?? '';
$msg_type = $_GET['type'] ?? 'success'; 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admindash.css">
</head>
<body>
  <div class="page-title">Admin Dashboard</div>

 <?php if ($message): ?>
  <div class="message-overlay">
    <p class="message <?= $msg_type === 'error' ? 'error' : 'success' ?>">
      <?= htmlspecialchars($message) ?>
    </p>
  </div>
<?php endif; ?>

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
        echo "<form method='POST'>";
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
            echo "<td>" . htmlspecialchars($val) . "</td>";
          }
          echo "<td><input type='radio' name='id' value='$id'></td>";
          echo "</tr>";
        }
        echo "</table>";

        echo "<div class='table-actions'>";
        echo "<button type='submit' formaction='crud/edit.php'>Edit Selected</button>";
        echo "<button type='submit' formaction='crud/delete.php'>Delete Selected</button>";
        echo "<button type='submit' formaction='crud/add.php'>Add New</button>";
        echo "</div>";

        echo "</form>";
      } else {
        echo "<p>No data in $selectedTable</p>";
      }
    }
    mysqli_close($conn);
    ?>

    <script src="admin-dash.js"></script>
  </div>
</body>
</html>
