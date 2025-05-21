<?php
include('../../registration/db.php');

$table = $_POST['table'] ?? '';
$id = $_POST['id'] ?? '';

if (!$table || !$id) {
    header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Select an item to delete.") . "&type=error");
    exit;
}


$tablesAllowed = ['authors', 'books', 'book_reviews', 'genres', 'users'];
if (!in_array($table, $tablesAllowed)) {
    header("Location: ../admin-dash.php?msg=" . urlencode("Invalid table.") . "&type=error");
    exit;
}


$idNameResult = mysqli_query($conn, "SELECT * FROM $table LIMIT 1");
if (!$idNameResult) {
    header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Invalid table name.") . "&type=error");
    exit;
}
$idName = mysqli_fetch_field_direct($idNameResult, 0)->name;


if ($table === 'users') {
    $checkReviews = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM book_reviews WHERE UserID = '$id'");
    $rowReviews = mysqli_fetch_assoc($checkReviews);
    if ($rowReviews['cnt'] > 0) {
        header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Cannot delete user: related book reviews exist.") . "&type=error");
        exit;
    }

    $checkBooks = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM users_books WHERE UserID = '$id'");
    $rowBooks = mysqli_fetch_assoc($checkBooks);
    if ($rowBooks['cnt'] > 0) {
        header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Cannot delete user: related books exist.") . "&type=error");
        exit;
    }
}


if ($table === 'book_reviews') {
    $userCheck = mysqli_query($conn, "SELECT UserID FROM book_reviews WHERE ReviewID = '$id'");
    if (!$userCheck || mysqli_num_rows($userCheck) == 0) {
        header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Review not found.") . "&type=error");
        exit;
    }
    $userId = mysqli_fetch_assoc($userCheck)['UserID'];

    $userExists = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM users WHERE UserID = '$userId'");
    $userExistsRow = mysqli_fetch_assoc($userExists);
    if ($userExistsRow['cnt'] > 0) {
        header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Cannot delete review: related user still exists.") . "&type=error");
        exit;
    }
}


$deleteQuery = "DELETE FROM $table WHERE $idName = '$id'";
if (mysqli_query($conn, $deleteQuery)) {
    header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Record deleted successfully.") . "&type=success");
    exit;
} else {
    header("Location: ../admin-dash.php?table=$table&msg=" . urlencode("Error deleting record: " . mysqli_error($conn)) . "&type=error");
    exit;
}
?>
