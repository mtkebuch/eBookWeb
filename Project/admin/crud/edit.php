<?php
include('../../registration/db.php');

$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';

if (!$table || !$id) {
    header("Location: ../admin-dash.php?msg=Missing+table+or+ID&type=error");
    exit;
}

function getPrimaryKey($conn, $table) {
    $res = mysqli_query($conn, "SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        return $row['Column_name'];
    }
    return null;
}

$pkCol = getPrimaryKey($conn, $table);
if (!$pkCol) {
    header("Location: ../admin-dash.php?msg=Primary+key+not+found&type=error");
    exit;
}

$idSafe = mysqli_real_escape_string($conn, $id);
$result = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$pkCol` = '$idSafe' LIMIT 1");

if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: ../admin-dash.php?msg=Record+not+found&type=error");
    exit;
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit <?= htmlspecialchars($table) ?></title>
    <link rel="stylesheet" href="../admin-dash.css">
</head>
<body>
<div class="my-form">
    <h3 class="my-form-title">Edit <?= ucfirst(htmlspecialchars($table)) ?> Record</h3>
    <form method="POST" action="update.php">
        <input type="hidden" name="table" value="<?= htmlspecialchars($table) ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($row[$pkCol]) ?>">
        <?php foreach ($row as $col => $val): ?>
            <?php if ($col === $pkCol) continue; ?>
            <label for="<?= $col ?>"><?= htmlspecialchars($col) ?>:</label>
            <input type="text" name="<?= htmlspecialchars($col) ?>" id="<?= $col ?>" value="<?= htmlspecialchars($val) ?>" required>
        <?php endforeach; ?>
        <button type="submit" class="add-btn">Update</button>
    </form>
</div>
</body>
</html>
