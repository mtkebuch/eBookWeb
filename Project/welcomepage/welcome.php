<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>E-Libra | Welcome</title>
  <link rel="stylesheet" href="welcome.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

  <div class="gif-intro">
    <img src="cropped.gif" alt="Intro Animation" class="intro-gif">
  </div>

  <header class="header">
    <div class="container">
      <div class="logo">E-Libra</div>
      <nav class="nav-links">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Tutorials</a>
        <a href="#">Contact</a>
      </nav>
    </div>
  </header>

  <main class="hero">
    <div class="container hero-content">
      <div class="text">
        <h1>Explore Knowledge</h1>
        <p>Thousands of free eBooks, tutorials, and learning resources await you. Start your E-Libra journey today.</p>

        <div class="registration-form">
          <h2>Login to E-Libra</h2>
          <form action="login_action.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div class="cta-buttons">
              <button type="submit" class="btn btn-login">Log In</button>
            </div>

            
            <p class="register-text">Don't have an account? <a href="../registration/registration.php">Register here</a></p>
          </form>
        </div>

      </div>
    
  </main>

  <script>
    window.addEventListener("DOMContentLoaded", () => {
      setTimeout(() => {
        document.body.classList.add("animation-done");
      }, 2500);
    });
  </script>

</body>
</html>
