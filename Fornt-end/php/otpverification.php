<!doctype html>
<html lang='en'>
<link rel='stylesheet' href='../css/otpverification.css'>
<!-- <link rel='stylesheet' href='../css/style.css'> -->
<body class='background background-mars-in-space'>
	<main>
		<div id='spacer-otpverification'></div>
		<div class='container container-form' id='container-otpverification'>
			<div class='row justify-content-center align-items-center'>
				<div class='col-md-7' id='login-column'>
					<form class="ctr" action = 'otpverify.php' method = 'post'>
	        	<div class="loader"></div>
		        <input type='text' id='otpverification-otp' name='otpverificationOTP' >
		        <div class="indicator" data-content="Enter OTP"></div>
	        </form>
				</div>
			</div>
		</div>
		<br>
		<br>

	</main>

	<!-- postJS -->
    <script src='../js/bootstrap.min.js'></script>		<!-- Bootstrap JS -->
  <script>
  input = document.querySelector "input"
form = document.querySelector "form"
indicator = document.querySelector ".indicator"
loader = document.querySelector ".loader"
content = input.value

form.addEventListener "submit", (e) ->
  e.preventDefault()
  indicator.setAttribute "data-content", "Saving..."
  loader.classList.add "full"
  setTimeout (
    ->
      indicator.setAttribute "data-content", "You've been subscribed!"
      loader.classList.add "done"
      input.classList.add "full"
      input.value ""
  ), 3000

input.addEventListener "input", ->
  indicator.setAttribute "data-content", "Now hit enter!"

balapaCop "Subscribe Form Interaction", "#999"
  </script>



</body>
</html>
