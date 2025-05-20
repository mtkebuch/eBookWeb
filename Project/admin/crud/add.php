<?php
include('../../registration/db.php');

function redirect_with_msg($table = '', $msg = '', $type = 'error') {
    $url = "../admin-dash.php";
    $params = [];

    if ($table) $params['table'] = $table;
    if ($msg) $params['msg'] = $msg;
    if ($type) $params['type'] = $type;

    header("Location: $url?" . http_build_query($params));
    exit;
}


$table = $_POST['table'] ?? '';
if (!$table) {
    redirect_with_msg('', 'Missing table name', 'error');
}


$restricted = ['users', 'book_reviews', 'messages'];
if (in_array($table, $restricted)) {
    $msg = ($table === 'messages') ? 'Cannot add records to this table' : 'This has to be written by user itself';
    redirect_with_msg('', $msg, 'error');
}


$columnsRes = mysqli_query($conn, "SHOW COLUMNS FROM `$table`");
if (!$columnsRes || mysqli_num_rows($columnsRes) === 0) {
    redirect_with_msg($table, 'Invalid table structure', 'error');
}

$fields = [];
$values = [];

while ($col = mysqli_fetch_assoc($columnsRes)) {
    $field = $col['Field'];

    if (preg_match('/(id|ID)$/', $field)) continue;

    $val = $_POST[$field] ?? '';
    if (trim($val) === '') {
        redirect_with_msg($table, "Missing value for $field", 'error');
    }

    $fields[] = "`$field`";
    $values[] = "'" . mysqli_real_escape_string($conn, $val) . "'";
}

$fieldStr = implode(', ', $fields);
$valueStr = implode(', ', $values);

$sql = "INSERT INTO `$table` ($fieldStr) VALUES ($valueStr)";
if (mysqli_query($conn, $sql)) {
    redirect_with_msg($table, 'Record added successfully', 'success');
} else {
    redirect_with_msg($table, 'Insert failed: ' . mysqli_error($conn), 'error');
}
?>
