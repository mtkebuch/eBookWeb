document.addEventListener('DOMContentLoaded', () => {
    const loginToggle = document.getElementById('loginToggle');
    const signupToggle = document.getElementById('signupToggle');

    loginToggle.addEventListener('click', () => {
        loginToggle.classList.add('active');
        signupToggle.classList.remove('active');

        
        document.getElementById('formContainer').innerHTML = `
            <form id="loginForm" class="form" action="login_action.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn">Log In</button>
            </form>
        `;
    });

    signupToggle.addEventListener('click', () => {
        
        window.location.href = '../registration/registration.php';
    });
});
window.addEventListener('load', () => {
    setTimeout(() => {
      document.querySelector('.gif-intro').style.display = 'none';
      document.body.classList.add('animation-done');
    }, 3000); 
  });