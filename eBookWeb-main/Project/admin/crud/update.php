<?php
include('../../registration/db.php');

$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';

if (!$table || !$id) {
    header("Location: ../admin-dash.php?msg=Missing+data&type=error");
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
    header("Location: ../admin-dash.php?table=" . urlencode($table) . "&msg=Primary+key+not+found&type=error");
    exit;
}

$idSafe = mysqli_real_escape_string($conn, $id);
$updates = [];
$errors = [];


if ($table === 'books') {
    $authorID = $_POST['AuthorID'] ?? null;
    $genreID = $_POST['GenreID'] ?? null;

    
    if ($authorID === null || mysqli_num_rows(mysqli_query($conn, "SELECT 1 FROM authors WHERE AuthorID = " . intval($authorID))) == 0) {
        $errors[] = "Invalid AuthorID.";
    }
    
    if ($genreID === null || mysqli_num_rows(mysqli_query($conn, "SELECT 1 FROM genres WHERE GenreID = " . intval($genreID))) == 0) {
        $errors[] = "Invalid GenreID.";
    }
}

foreach ($_POST as $col => $val) {
    if ($col === 'id' || $col === 'table') continue;
    $val = trim($val);
    if ($val === '') {
        $errors[] = "Field '$col' cannot be empty.";
    }
    $valSafe = mysqli_real_escape_string($conn, $val);
    $updates[] = "`$col` = '$valSafe'";
}

if (!empty($errors)) {
    $msg = urlencode(implode(" ", $errors));
    header("Location: ../admin-dash.php?table=" . urlencode($table) . "&action=edit&msg=$msg&type=error");
    exit;
}

$updateStr = implode(', ', $updates);
$sql = "UPDATE `$table` SET $updateStr WHERE `$pkCol` = '$idSafe'";

if (mysqli_query($conn, $sql)) {
    header("Location: ../admin-dash.php?table=" . urlencode($table) . "&msg=Record+updated+successfully&type=success");
} else {
    $error = urlencode("Error updating record: " . mysqli_error($conn));
    header("Location: ../admin-dash.php?table=" . urlencode($table) . "&msg=$error&type=error");
}

exit;
?>
