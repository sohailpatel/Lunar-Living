<nav class='navbar navbar-expand-lg navbar-light bg-light'>
	<a class='navbar-brand' href='index.php'><img src='../images/Title.png' class='title'></a>
	<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
		<span class='navbar-toggler-icon'></span>
	</button>
	<?php
	if(isset($_SESSION['username'])){
		echo"<ul class='navbar-nav ml-auto'>";
			echo "<li>
			<div class='dropdown'>
				<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Hello, ". $_SESSION['firstName'] ."</button>
				<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
					<a class='dropdown-item' href='profile.php'>Profile</a>
					<a class='dropdown-item' href='logout.php'>Signout</a>
				</div>
			</div>
			</li>";
		echo "</ul>";
	}
	else{
		echo"<a class='login-link' href = 'login.php'>Login</a>";
	}
	?>
</nav>