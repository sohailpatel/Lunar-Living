<!doctype html>

<html lang='en'>
<link rel='stylesheet' href='../css/newuser.css'>
<link rel='stylesheet' href='../css/style.css'>
<?php include 'signInNavbar.php';?>
<?php include 'header.php';?>
<body class='background background-mars-in-space'>
	<main>
		<!-- <div id='spacer-newuser'></div>
		<div class='container container-form' id='container-newuser'>
			<div class='row justify-content-center align-items-center'>
				<div class='col-md-7' id='newuser-column'>
					<div class='text-centered five-padding-bottom'><img src='../images\Logo - New User.png' class='logo'></div>
					<br>
					<strong>Sign Up requires to hold a lease.</strong>
					<br>
					<br>
					<form class='form' method = 'post' action='checksignupuser.php'>
						<div class='form-group'>
							<input class='form-control' type='text' id='newuser-email-id' name='username' placeholder='Email ID'>
						</div>
						<div class='form-group text-centered'>
							<input class='btn btn-info btn-md' value='Submit' type='submit' name='newuserButtonSubmit' id = "newuserButtonSubmit">
						</div>
					</form>
				</div>
			</div>
		</div>
		<br>
		<br> -->
		<div class="login-page">
  <div class="form">
  <strong style = "font-weight:bold">NEW USER</strong>
  <br>
					<br>
					<strong>Sign Up requires to hold a lease.</strong>
					<br>
					<br>
    <form class="login-form" method = 'post' action='checksignupuser.php'>
      <input type="text" type='text' id='newuser-email-id' name='username' placeholder='Email ID'/>
      <button type='submit' name='newuserButtonSubmit' id = "newuserButtonSubmit">Submit</button>
    </form>
  </div>
</div>
<?php include 'footer.php';?>

	</main>

	<!-- postJS -->
	<script src='../js/bootstrap.min.js'></script>		<!-- Bootstrap JS -->


</body>
</html>
