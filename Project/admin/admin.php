<?php
session_start();
include('../registration/db.php'); 

$error_message = "";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error_message = "Please fill in both fields!";
    } else {
        $result = $conn->query("SELECT * FROM admins WHERE Email = '$email'");

        if ($result->num_rows == 0) {
            $error_message = "No admin found with this email.";
        } else {
            $user = $result->fetch_assoc();

            if ($password == $user['Password']) {
                $_SESSION['admin_email'] = $user['Email'];
                $_SESSION['admin_username'] = $user['Username'];

                header("Location: admin-dash.php");
                exit();
            } else {
                $error_message = "Incorrect password.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Panel Login</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="registration-form"> 
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <h2>Admin Login</h2>

    <form action="" method="POST">
        <label for="email">Admin Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <div class="cta-buttons">
            <button type="submit" name="submit" class="btn btn-login">Login</button>
        </div>
    </form>

</div>

</body>
</html>
