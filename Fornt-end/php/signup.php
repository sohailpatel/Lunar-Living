<?php
session_start();
?>

<!doctype html>
<html lang='en'>
<?php include 'header.php';?>
<link rel='stylesheet' href='../css/signup.css'>
<body class='background background-mars-in-space'>
	<main>
	<?php include 'signInNavbar.php';?>
		<div id='spacer-signup'></div>
		<div class='container container-form' id='container-signup'>
			<div class='row justify-content-center align-items-center'>
				<div class='col-md-7' id='signup-column'>
					<div class='text-centered five-padding-bottom'><img src='../images\Logo - Signup.png' class='logo'></div>
					<br>
					<br>
					<form class='form' method = 'post' action='signupdetails.php'>
						<div class='form-group'>
							<input class='form-control' type='text' id='signup-first-name' name='signupFirstName' placeholder='First name'>
						</div>
						<div class='form-group'>
							<input class='form-control' type='text' id='signup-last-name' name='signupLastName' placeholder='Last name'>
						</div>
						<div class='form-group'>
							<div class='dropdown text-centered'>
								<select class='btn btn-secondary dropdown-toggle' type='button' id='signup-gender' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' name='signupGender'>
                                    <option class='dropdown-item' value="Gender">Gender </option>
                                    <option class='dropdown-item' value="Male">Male </option>
									<option class='dropdown-item' value = "Female">Female </option>
									<option class='dropdown-item' value = "other">Other</option>
									<option class='dropdown-item' value = "Prefer not to say">Prefer not to say</option>
                                </select>
							</div>
						</div>
						<div class='form-group'>
							<input class='form-control' type='password' id='signup-password' name='signupPassword' placeholder='Password'>
						</div>
						<div class='form-group'>
							<input class='form-control' type='password' id='signup-password-confirmation' name='signupPasswordConfirmation' placeholder='Confirm password'>
						</div>
						<div class='form-group text-centered'>
							<input class='btn btn-info btn-md' value='Submit' type='submit' name='signupButtonSubmit'>
						</div>
					</form>
				</div>
			</div>
		</div>
		<br>
		<br>
        <?php include 'footer.php';?>
	</main>

	<!-- postJS -->
    <script src='../js/jquery-3.3.1.js'></script>		<!-- Jquery JS (necessary for dropdowns) -->
    <script src='../js/bootstrap.bundle.min.js'></script>		<!-- Bootstrap Bundle JS (necessary for dropdowns) -->
    <!-- <script src='js/bootstrap.min.js'></script> -->		<!-- Bootstrap JS � disabled because when enabled it has a conflict with Bootstrap Bundle JS that makes dropdowns require two clicks to dropdown; it doesn't seem that any needed functionality is lacking when this is disabled -->
</body>
</html>