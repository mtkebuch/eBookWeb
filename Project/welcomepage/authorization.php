<?php

include('../registration/db.php'); 

$error_message = "";


if (isset($_POST['submit'])) {
   
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    if (empty($email) || empty($password)) {
        $error_message = "Please fill in both fields!";
    } else {
       
        $result = $conn->query("SELECT * FROM users WHERE email = '$email'");

        if ($result->num_rows == 0) {
            $error_message = "Email does not exist.";
        } else {
           
            $user = $result->fetch_assoc();

           
            if ($password == $user['Password']) {
              header("Location: dashboard/dashboard.php");
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
  <title>Authorization</title>
  <link rel="stylesheet" href="auth.css">
</head>
<body>

<div class="registration-form"> 
    <?php if ($error_message): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
  <?php endif; ?>
  <br>
  <a href="admin_login.php" class="admin-dot" title="Admin Access">👨🏻‍💻</a>
  <h2>Login to E-Libra</h2>
  <form action="" method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <div class="cta-buttons">
      <button type="submit" name="submit" class="btn btn-login">Log In</button>
    </div>
    <br>
    <p class="register-text">No account? <a href="../registration/registration.php">Register here</a></p>
  </form>
</div>

</body>
</html>
