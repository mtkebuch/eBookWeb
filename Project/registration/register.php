<?php

include('db.php');


if (isset($_POST['submit'])) {
   
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if ($password === $confirm_password) {
        
        $check_query = "SELECT * FROM users WHERE Username = '$username' OR Email = '$email'";
        $check_result = mysql_query($check_query, $conn);

        
        if (mysql_num_rows($check_result) > 0) {
            echo "Username or Email already exists!";
        } else {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            
            $query = "INSERT INTO users (Username, Email, Password) VALUES ('$username', '$email', '$hashed_password')";

           
            if (mysql_query($query, $conn)) {
                echo "Registration successful!";
            } else {
                echo "Error: " . mysql_error();
            }
        }
    } else {
        echo "Passwords do not match!";
    }
}
?>
