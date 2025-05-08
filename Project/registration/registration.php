<?php
include('db.php');  

$usernameErr = $emailErr = $passwordErr = '';
$username = $email = $password = $confirm_password = ''; 


$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (isset($_POST['submit'])) {
    
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {
       
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);
        $confirm_password = mysqli_real_escape_string($conn, $confirm_password);

        
        $check_user_query = "SELECT * FROM users WHERE Username='$username' OR Email='$email'";
        $result = mysqli_query($conn, $check_user_query);

        if (mysqli_num_rows($result) > 0) {
          
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['Username'] == $username) {
                    $usernameErr = "🚨 Username already exists!";
                }
                if ($row['Email'] == $email) {
                    $emailErr = "🚨 Email already exists!";
                }
            }
        } else {
            
            if ($password === $confirm_password) {
               
                if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
                    echo "<script>alert('Password must be at least 6 characters long and include uppercase, lowercase, number, and symbol!');</script>";
                } else {
                    
                    $subscription_type = "basic"; 
                    $insert_query = "INSERT INTO users (Username, Password, Email, SubscriptionType) 
                                     VALUES ('$username', '$password', '$email', '$subscription_type')";  

                    if (mysqli_query($conn, $insert_query)) {
                        echo "<script>alert('Registration successful!'); window.location.href='mainpage.php';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
                    }
                }
            } else {
                echo "<script>alert('Passwords do not match!');</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="registration-form">
        <img src="eBook.png" alt="Online Library Logo" class="logo"> 
        <h2>Register</h2>
        <form method="POST" id="registrationForm">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
            <?php if (!empty($usernameErr)) echo "<p class='error'>$usernameErr</p>"; ?>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            <?php if (!empty($emailErr)) echo "<p class='error'>$emailErr</p>"; ?>

            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" value="<?= htmlspecialchars($password) ?>" required>
                <span class="password-toggle" onclick="togglePassword('password')">🌑</span>
            </div>

            <label for="confirm_password">Confirm Password</label>
            <div class="password-wrapper">
                <input type="password" id="confirm_password" name="confirm_password" value="<?= htmlspecialchars($confirm_password) ?>" required>
                <span class="password-toggle" onclick="togglePassword('confirm_password')">🌑</span>
            </div>

            <button type="submit" id="submitBtn" name="submit">Next</button>
        </form>
    </div>

    <script src="registration.js"></script>
</body>
