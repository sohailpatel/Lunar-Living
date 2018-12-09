<?php
session_start();
if (isset($_SESSION['username'])) {
    session_destroy();
}
?>
<!doctype html>
<html lang='en'>
<link rel='stylesheet' href='../css/login.css'>
<body class = "background background-mars-in-space">


    <main>
<div class='row justify-content-center align-items-center'>
<form action = 'loginverify.php' method = 'post'>
<div class="login-wrapper">
  <div class="login-left">
    <img src="../images/mars-wallpaper1.jpg">
    <div class="h1">Enter Lunar Living</div>
  </div>
  <div class="login-right">
    <div class="h2">Login</div>
    <div class="form-group">
      <input type='text' id='login-username' name='loginUsername' placeholder='Username'>
      <label for="Email">Email</label>
    </div>
    <div class="form-group">
      <input type='password' id='login-password' name='loginPassword' placeholder='Password'>
      <label for="Password">Password</label>
    </div>
    <div class="button-area">
      <button class="btn btn-secondary" value='Login' type='submit' name='loginButtonLogin' id="loginButtonLogin">Login</button>
      <button class="btn btn-primary" value='Signup' type='submit' name='loginButtonSignup' formaction = 'newuser.php'>Sign Up</button>
    </div>
  </div>
</div>
</form>
    </main>

<!-- postJS -->
    <script src='../js/bootstrap.min.js'></script>      <!-- Bootstrap JS -->
    <script type="text/javascript">
    var openLoginRight = document.querySelector('.h1');
var loginWrapper = document.querySelector('.login-wrapper');

openLoginRight.addEventListener('click', function(){
  loginWrapper.classList.toggle('open');
});
    </script>

</main>

</body>

</html>
