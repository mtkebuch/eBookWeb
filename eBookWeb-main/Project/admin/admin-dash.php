<?php
include('../registration/db.php');

$tables = ['authors', 'books', 'book_reviews', 'genres', 'users','users_books'];
$restrictedTables = ['users', 'book_reviews', 'messages'];

$selectedTable = $_GET['table'] ?? $tables[0];
$action = $_GET['action'] ?? '';
$message = $_GET['msg'] ?? '';
$msg_type = $_GET['type'] ?? 'success';

function getPrimaryKeyColumn($conn, $table) {
    $result = mysqli_query($conn, "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['Column_name'];
    }
    return null;
}

$editData = null;
$pkCol = getPrimaryKeyColumn($conn, $selectedTable);
if ($action === 'edit' && isset($_POST['id']) && $pkCol) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $result = mysqli_query($conn, "SELECT * FROM `$selectedTable` WHERE `$pkCol` = '$id' LIMIT 1");
    if ($result && mysqli_num_rows($result) > 0) {
        $editData = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin_dash.css">
</head>
<body>

<a href="../mainpage/logout.php" class="logout-link">
  <img src="../mainpage/logout.png" alt="Logout" style="width:35px; height:35px;">
</a>

<div class="page-title">Admin Dashboard</div>

<?php if (!empty($message)): ?>
  <div class="message-overlay" id="messageOverlay" title="Click to dismiss">
    <p class="message <?= htmlspecialchars($msg_type) ?>">
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

<br>

<div id="table-data">
<?php
if ($selectedTable && in_array($selectedTable, $tables)) {
    $result = mysqli_query($conn, "SELECT * FROM $selectedTable");
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<form method='POST' id='table-actions-form'>";
        echo "<input type='hidden' name='table' value='" . htmlspecialchars($selectedTable) . "'>";
        echo "<table><tr>";
        while ($field = mysqli_fetch_field($result)) {
            echo "<th>" . htmlspecialchars($field->name) . "</th>";
        }
        if ($selectedTable !== 'users_books') {
            echo "<th>Actions</th>";
        }
        echo "</tr>";

        $pkCol = getPrimaryKeyColumn($conn, $selectedTable);

        while ($row = mysqli_fetch_assoc($result)) {
            $idVal = $pkCol && isset($row[$pkCol]) ? $row[$pkCol] : reset($row);
            echo "<tr>";
            foreach ($row as $val) {
                echo "<td>" . htmlspecialchars($val) . "</td>";
            }
            if ($selectedTable !== 'users_books') {
                echo "<td><input type='radio' name='id' value='" . htmlspecialchars($idVal) . "' required></td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        if ($selectedTable !== 'users_books') {
            echo "<div class='table-actions'>";
            echo "<button type='submit' formaction='?table=" . urlencode($selectedTable) . "&action=edit'>Edit</button> ";
            echo "<button type='submit' formaction='crud/delete.php'>Delete</button> ";

            if (!in_array($selectedTable, $restrictedTables)) {
                echo "<a href='?table=" . urlencode($selectedTable) . "&action=add'><button type='button'>Add New</button></a>";
            } else {
                echo "<div class='notification error' style='display:inline-block; margin-left:15px; padding:6px 12px; border-radius:4px; background: linear-gradient(90deg, #b30000, #ff4d4d); color:#fff;'>";
                if ($selectedTable === 'users') {
                    echo "Users must register themselves; new user records cannot be added here.";
                } elseif ($selectedTable === 'book_reviews') {
                    echo "Reviews must be submitted through the site; new review records cannot be added here.";
                } else {
                    echo "Adding new records to <strong>" . htmlspecialchars($selectedTable) . "</strong> is not allowed.";
                }
                echo "</div>";
            }
            echo "</div>";
        }

        echo "</form>";
    } else {
        echo "<p>No data in " . htmlspecialchars($selectedTable) . "</p>";
        if ($selectedTable !== 'users_books') {
            echo "<div class='table-actions'>";
            if (!in_array($selectedTable, $restrictedTables)) {
                echo "<a href='?table=" . urlencode($selectedTable) . "&action=add'><button type='button'>Add New</button></a>";
            } else {
                echo "<div class='notification error' style='display:inline-block; padding:6px 12px; border-radius:4px; background: linear-gradient(90deg, #b30000, #ff4d4d); color:#fff;'>";
                if ($selectedTable === 'users') {
                    echo "Users must register themselves; new user records cannot be added here.";
                } elseif ($selectedTable === 'book_reviews') {
                    echo "Reviews must be submitted through the site; new review records cannot be added here.";
                } else {
                    echo "Adding new records to <strong>" . htmlspecialchars($selectedTable) . "</strong> is not allowed.";
                }
                echo "</div>";
            }
            echo "</div>";
        }
    }
}
?>
</div>

<?php if ($action === 'add' && !in_array($selectedTable, $restrictedTables) && $selectedTable !== 'users_books'): ?>
<div class="my-form">
  <h3 class="my-form-title">Add New <?= ucfirst(htmlspecialchars($selectedTable)) ?></h3>
  <form method="POST" id="add-form" action="crud/add.php">
    <input type="hidden" name="table" value="<?= htmlspecialchars($selectedTable) ?>">
    <?php
    $columnsResult = mysqli_query($conn, "SHOW COLUMNS FROM $selectedTable");

    while ($col = mysqli_fetch_assoc($columnsResult)) {
        $colName = $col['Field'];

        
        if ($col['Key'] === 'PRI' && strpos($col['Extra'], 'auto_increment') !== false) continue;

        $val = $_POST[$colName] ?? '';
        echo "<label for='$colName'>" . ucfirst(htmlspecialchars($colName)) . ":</label>";
        echo "<input type='text' name='$colName' id='$colName' value='" . htmlspecialchars($val) . "' required>";
    }
    ?>
    <button type="submit" name="submit" class="add-btn">Add</button>
  </form>
</div>
<?php endif; ?>



<?php if ($editData): ?>
<div class="my-form">
  <h3 class="my-form-title">Edit <?= ucfirst(htmlspecialchars($selectedTable)) ?> Record</h3>
  <form method="POST" action="crud/update.php">
    <input type="hidden" name="table" value="<?= htmlspecialchars($selectedTable) ?>">
    <input type="hidden" name="id" value="<?= htmlspecialchars($editData[$pkCol]) ?>">
    <?php foreach ($editData as $col => $val):
        if ($col === $pkCol) continue;
    ?>
      <label for="<?= $col ?>"><?= htmlspecialchars($col) ?>:</label>
      <input type="text" name="<?= htmlspecialchars($col) ?>" id="<?= $col ?>" value="<?= htmlspecialchars($val) ?>" required>
    <?php endforeach; ?>
    <button type="submit" class="add-btn">Update</button>
  </form>
</div>
<?php endif; ?>

<script src="admin-dash.js"></script>
</body>
</html>
