<?php
include('../registration/db.php');

$table = $_GET['table'];
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM $table WHERE " . mysqli_fetch_field_direct(mysqli_query($conn, "SELECT * FROM $table"), 0)->name . " = '$id'");
$row = mysqli_fetch_assoc($result);
?>

<form method="POST">
  <?php foreach ($row as $key => $value): ?>
    <label><?= $key ?></label>
    <input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>"><br>
  <?php endforeach; ?>
  <input type="hidden" name="table" value="<?= $table ?>">
  <input type="hidden" name="id" value="<?= $id ?>">
  <button type="submit" name="save">Save</button>
</form>

<?php
if (isset($_POST['save'])) {
  $updates = [];
  foreach ($_POST as $key => $value) {
    if ($key != 'id' && $key != 'table' && $key != 'save') {
      $updates[] = "$key='" . mysqli_real_escape_string($conn, $value) . "'";
    }
  }
  $idName = mysqli_fetch_field_direct(mysqli_query($conn, "SELECT * FROM $table"), 0)->name;
  $sql = "UPDATE $table SET " . implode(", ", $updates) . " WHERE $idName = '$id'";
  mysqli_query($conn, $sql);
  header("Location: admin-dash.php?table=$table");
}
?>
