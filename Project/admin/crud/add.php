<?php
include('../../registration/db.php');

$tables = ['authors', 'books', 'book_reviews', 'genres', 'users'];
$selectedTable = $_POST['table'] ?? '';

if (!$selectedTable || !in_array($selectedTable, $tables)) {
    header("Location: ../admin-dash.php?msg=" . urlencode("Invalid table.") . "&type=error");
    exit;
}


if ($selectedTable === 'users') {
    header("Location: ../admin-dash.php?table=$selectedTable&msg=" . urlencode("Can't add user. User must register themselves.") . "&type=error");
    exit;
}

if ($selectedTable === 'book_reviews') {
    header("Location: ../admin-dash.php?table=$selectedTable&msg=" . urlencode("Can't add review directly. User must add it themselves.") . "&type=error");
    exit;
}

$columnsResult = mysqli_query($conn, "SHOW COLUMNS FROM $selectedTable");
if (!$columnsResult) {
    header("Location: ../admin-dash.php?table=$selectedTable&msg=" . urlencode("Invalid table.") . "&type=error");
    exit;
}

$columns = [];
$values = [];

while ($col = mysqli_fetch_assoc($columnsResult)) {
    $colName = $col['Field'];
    if (preg_match('/(id|ID)$/', $colName)) continue; 

    $columns[] = $colName;
    $val = $_POST[$colName] ?? '';
    $values[] = "'" . mysqli_real_escape_string($conn, $val) . "'";
}

if (count($columns) > 0) {
    $colsStr = implode(", ", $columns);
    $valsStr = implode(", ", $values);

    $insertQuery = "INSERT INTO $selectedTable ($colsStr) VALUES ($valsStr)";
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: ../admin-dash.php?table=$selectedTable&msg=" . urlencode("Record added successfully.") . "&type=success");
        exit;
    } else {
        header("Location: ../admin-dash.php?table=$selectedTable&msg=" . urlencode("Error adding record: " . mysqli_error($conn)) . "&type=error");
        exit;
    }
} else {
    header("Location: ../admin-dash.php?table=$selectedTable&msg=" . urlencode("No columns to insert.") . "&type=error");
    exit;
}
?>
