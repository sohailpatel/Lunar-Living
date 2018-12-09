<?php
	session_start();
?>
<!doctype html>
<html lang='en'>
<head>
	<!-- metadata -->
    <meta charset='utf-8'>	<!-- Unicode characterset -->
    <meta http-equiv='X-UA-Compatible' content='IE=epdge'>	<!-- Internet Explorer compatibility -->
    <meta name='viewport' content='width=device-width, initial-scale=1'>	<!-- renders the page according to the device width -->
    <meta name='description' content='Rent a living space, in outer space.'>		<!-- description [shown on searchengine result] -->
    <meta name='keywords' content='Lunar, Living, space, rental, service, management, system, SpaceX, outer, Elon, Musk'>		<!-- keywords for searchengine optimization -->
    <meta name='author' content='IU SE G2'>		<!-- author name -->
	<link rel='icon' href='../images\Icon.ico'>		<!-- favicon -->
    <title>Lunar Living | Home</title>		<!-- title -->

	<!-- CSS -->
	<link rel='stylesheet' href='../css/reset.css'>		<!-- Reset CSS -->
    <link rel='stylesheet' href='../css/bootstrap.min.css'>		<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">		<!-- Font Awesome CSS (another one added by backend devs for some reason?) -->
    <link rel='stylesheet' href='../css/fontawesome.min.css'>		<!-- Font Awesome CSS -->
	<link rel='stylesheet' href='../css/bootstrap-datepicker3.css'>		<!-- Bootstrap Datepicker 3 CSS -->
	<link rel='stylesheet' href='../css/style.css'>		<!-- custom CSS -->
</head>
<body class="background">
<?php
	if(isset($_SESSION['username'])){
		// make sure to remove this line.. It is just static field for testing
		$username = $_SESSION['username'];
		//setup the request, you can also use CURLOPT_URL
		$ch = curl_init('https://lunar-living.herokuapp.com/getUserDetails');

		// Returns the data/output as a string instead of raw data
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
		curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');

		//Set your auth headers
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			"username: $username"
			));

		// get stringified data/output. See CURLOPT_RETURNTRANSFER
		$data = curl_exec($ch);

		// get info about the request
		$info = curl_getinfo($ch);

		if($data == 'false'){
		echo "User Not Found";
		}
		else {
			$apiData = json_decode($data);
		}

		// close curl resource to free up system resources
		curl_close($ch);
	}

	$ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"rating: 5"
		));
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);
	$fiveStar = json_decode($data)->total;
	curl_close($ch);
	
	$ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"rating: 4"
		));
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);
	$fourStar = json_decode($data)->total;
	curl_close($ch);
	
	$ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"rating: 3"
		));
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);
	$threeStar = json_decode($data)->total;
	curl_close($ch);
	
	$ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"rating: 2"
		));
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);
	$twoStar = json_decode($data)->total;
	curl_close($ch);
	
	$ch = curl_init('https://lunar-living.herokuapp.com/getReviews');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		"rating: 1"
		));
	$data = curl_exec($ch);
	$info = curl_getinfo($ch);
	$oneStar = json_decode($data)->total;
	curl_close($ch);
?>
	<main>
	<?php include 'signInNavbar.php'; ?>
		<img class='mySlides' src='../images/mars-city1.jpg'>
		<img class='mySlides' src='../images/mars-city2.jpg'>
		<img class='mySlides' src='../images/mars-city3.jpg'>
		<img class='mySlides' src='../images/mars-city4.jpg'>
		<img class='mySlides' src='../images/mars-city5.jpg'>
		<div id='spacer-index-after-banner'></div>
		<div class='container-fluid'>
			<div class='row'>
				<div class='col-sm-3'>
					<section class='contact-sidebar'>
						<div>
							<div>
								<img src='../images/contact.jpeg' alt='Lunar Living Rental Schema<'>
							</div>
							
							<div>
								<div class='contact-heading'><strong>Lunar Living Rental Schema</strong></div>
								<div>
									<span class='contact-phone'>&#9742 (812) 111-1212</span>
									<span class='contact-phone'>&#x2709 lunarliving.space@gmail.com</span>
								</div>
							</div>
						</div>	
					</section>
					<div id='spacer-index-after-banner'></div>
					<section class='contact-sidebar'>
						<div>
							<div class='contact-heading'>
								<strong>Schedule an Appointment</strong>
							</div>
							<br>
	        				<div>
								<div class='form-group text-centered'>
									<div class='input-group date' id='datepicker'>
										<input type='text' class='form-control' placeholder='Please select a date' onchange='setTimings()' id='selectdate'/>
										<span class='input-group-addon'>
											<span class='glyphicon glyphicon-calendar'></span>
										</span>
									</div><br/>
									<p class='error' id='DateError'>Select Date</p>
									<div class = 'showBookingDetails' id = 'showBookingDetails'>
									 
									</div>
									<p class='error' id='TimeError'>Select Time</p>
									<input type='email' class='form-control appointment-userinfo' placeholder='Enter your Email-Id' id='userinfo' required/><br/>
									<p class='error' id='EmailError'>Email Incorrect</p>
									<button class='btn btn-info btn-md' onclick='bookAppointment()'>Schedule</button>
								</div>
							</div>
						</div>
					</section>
					<div id='spacer-index-after-banner'></div>
					<section class='review-sidebar'>
						<div>
							<div class='contact-heading' id='review-heading'><strong>Review</strong></div>
							<p><strong>Help Us Improve</strong></p>
							<p><span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star checked"></span>
							<span class="fa fa-star"></span></p>
							<?php
							echo"<p><button class='btn btn-info btn-md' onclick='reviewCall(\"". $username ."\")'>Submit a Review</button></p>";
							?>
						</div>
					</section>
				</div>
				<div class='col-sm-9'>
					<section class='index-details'>
						<div>
							<div class='name-heading'>Your <strong>living space</strong> – in <strong>outer space</strong></div>
							<p class='tags'>
								<b>
									Rental Apartments:
									<br>
									Spacious, 2 bedroom, 1 bathroom apartments.
									<br>
									Great for entertaining interplanetary guests.
									<br>
									Access exclusive events such as lunar golf and moon buggy rides.
									<br>
									Oxygen supply included.
								</b>
							</p>
							<img class ='aptImg hover-image' src='../images/apt1.jpg'>
							<img class ='aptImg hover-image' src='../images/apt2.jpg'>
							<img class ='aptImg hover-image' src='../images/apt3.jpg'>
							<img class ='aptImg hover-image' src='../images/apt4.jpg'>
						</div>
						<div id='spacer-index-after-banner'></div>
						<div id='bridge-kid-container'>
							<img id='bridge-kid' src='../images/Ko Phangan Infected Mushroom.jpg'/>
						</div>
						<div class='name-heading'><strong>User Reviews</strong></div>
						<div class='user-review'>
							<?php
							$totalVotes = $fiveStar + $fourStar + $threeStar + $twoStar + $oneStar;
							$sum = 5 * $fiveStar + 4 * $fourStar + 3 * $threeStar + 2 * $twoStar + $oneStar;
							if($totalVotes == 0){
								$avg = 0;
								$fiveWidth = 0;
								$fourWidth = 0;
								$threeWidth = 0;
								$twoWidth = 0;
								$oneWidth = 0;
							}
							else{
								$avg = $sum / $totalVotes;
								$fiveWidth = ($fiveStar/$totalVotes) * 100;
								$fourWidth = ($fourStar/$totalVotes) * 100;
								$threeWidth = ($threeStar/$totalVotes) * 100;
								$twoWidth = ($twoStar/$totalVotes) * 100;
								$oneWidth = ($oneStar/$totalVotes) * 100;
							}
							echo"
							<span class='heading'>User Rating &nbsp</span>";
							if($avg >= 1){
								echo "<span class='fa fa-star checked'></span>";
							}
							else{
								echo "<span class='fa fa-star'></span>";
							}
							if($avg >= 2){
								echo "<span class='fa fa-star checked'></span>";
							}
							else{
								echo "<span class='fa fa-star'></span>";
							}
							if($avg >= 3){
								echo "<span class='fa fa-star checked'></span>";
							}
							else{
								echo "<span class='fa fa-star'></span>";
							}
							if($avg >= 4){
								echo "<span class='fa fa-star checked'></span>";
							}
							else{
								echo "<span class='fa fa-star'></span>";
							}
							if($avg >= 5){
								echo "<span class='fa fa-star checked'></span>";
							}
							else{
								echo "<span class='fa fa-star'></span>";
							}
							echo"
							<p>". $avg . " average based on ". $totalVotes . " reviews.</p>
							<hr style='border:3px solid #f1f1f1'>
							<div class='row'>
							<div class='side'>
								<div>5 star</div>
							</div>
							<div class='middle'>
								<div class='bar-container'>
								<div class='bar-5' style='width:". $fiveWidth ."%;'></div>
								</div>
							</div>
							<div class='side right'>
								<div>". $fiveStar ."</div>
							</div>
							<div class='side'>
								<div>4 star</div>
							</div>
							<div class='middle'>
								<div class='bar-container'>
								<div class='bar-4' style='width:". $fourWidth ."%;'></div>
								</div>
							</div>
							<div class='side right'>
								<div>". $fourStar ."</div>
							</div>
							<div class='side'>
								<div>3 star</div>
							</div>
							<div class='middle'>
								<div class='bar-container'>
								<div class='bar-3' style='width:". $threeWidth ."%;'></div>
								</div>
							</div>
							<div class='side right'>
								<div>". $threeStar ."</div>
							</div>
							<div class='side'>
								<div>2 star</div>
							</div>
							<div class='middle'>
								<div class='bar-container'>
								<div class='bar-2' style='width:". $twoWidth ."%;'></div>
								</div>
							</div>
							<div class='side right'>
								<div>". $twoStar ."</div>
							</div>
							<div class='side'>
								<div>1 star</div>
							</div>
							<div class='middle'>
								<div class='bar-container'>
								<div class='bar-1' style='width:". $oneWidth ."%;'></div>
								</div>
							</div>
							<div class='side right'>
								<div>". $oneStar ."</div>
							</div>";
							?>
						</div>
					</section>
				</div>
			</div>
		</div>
		<div id='spacer-index-after-banner'></div>
		<?php include 'footer.php'; ?>
	</main>

	<!-- image hover modal -->
	<div id='apartment-modal' class='modal'>
		<span class='close'>&times;</span>
		<img class='modal-content' id='modal-image'>
		<div id='caption'></div>
	</div>

	<!-- postJS -->
    <script src='../js/jquery-3.3.1.js'></script>		<!-- Jquery JS (necessary for dropdowns and modal) -->
    <script src='../js/bootstrap.bundle.min.js'></script>		<!-- Bootstrap Bundle JS (necessary for dropdowns) -->
	<!-- <script src='js/bootstrap.min.js'></script> -->		<!-- Bootstrap JS � disabled because when enabled it has a conflict with Bootstrap Bundle JS that makes dropdowns require two clicks to dropdown; it doesn't seem that any needed functionality is lacking when this is disabled -->
	<!-- custom carousel JS -->
	<script>
		var myIndex = 0, reviewIndex = 0;
		carousel();
		function carousel() {
			var i;
			var x = document.getElementsByClassName("mySlides");
			for (i = 0; i < x.length; i++) {
				x[i].style.display = "none";  
			}
			myIndex++;
			if (myIndex > x.length) {myIndex = 1}    
			x[myIndex-1].style.display = "block";  
			setTimeout(carousel, 3500); // Change image every 3.5 seconds
		}
	</script>
	<script type='text/javascript' src='../js/bootstrap-datepicker.min.js'></script>		<!-- Bootstrap Datepicker 3 JS -->
	<!-- Bootstrap Datepicker 3 JS - for initialization -->
	<script>
		$(function()
		{
	        $('#datepicker').datepicker(
			{
	            format: 'mm/dd/yyyy',
	            autoclose: true,
	            todayHighlight: true,
		        showOtherMonths: true,
		        selectOtherMonths: true,
		        autoclose: true,
		        changeMonth: true,
		        changeYear: true,
		        orientation: 'button'
	        });
	    });
	</script>
	<script>
		var modal = document.getElementById('apartment-modal');
		var modalImg = document.getElementById('modal-image');
		var captionText = document.getElementById('caption');
		$(document).ready(function()
		{
			$('img.hover-image').click(function()
			{
				modal.style.display = 'block';
				modalImg.src = this.src;
				captionText.innerHTML = this.alt;
			});
		});

		document.getElementsByClassName('close')[0].onclick = function()
		{ 
			modal.style.display = 'none';
		}
		$(document).keyup(function(e)
		{
			if (e.key === "Escape")
			{
				modal.style.display = 'none';
			}
		});

		function setTimings(){
			var selectedDate = document.getElementById('selectdate').value;
			var timingDiv = document.getElementById('showBookingDetails');
			var userinfo = document.getElementById('userinfo');
			userinfo.style.display = "block";
			var bookedTimings = [];
			var xmlhttp = new XMLHttpRequest();
			var url = 'https://cors-anywhere.herokuapp.com/https://lunar-living.herokuapp.com/getAppointmentTimes';
			xmlhttp.open("GET", url, true);
			xmlhttp.setRequestHeader("visit_date", selectedDate);
			xmlhttp.setRequestHeader('Content-Type','application/json');
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var output = JSON.parse(this.responseText);
					if(output.timings != null){
						bookedTimings = output.timings.split(",");
					}
					var appendData = "";
					for(var iterator = 10; iterator < 18; iterator += 0.5){
						if(bookedTimings.includes(iterator.toString())){
							continue;
						}
						if(bookedTimings.includes((iterator - 0.5).toString() + ":30")){
							continue;
						}
						if(iterator.toString().length == 4){
							var newIterator = iterator - 0.5;
							appendData += "<div class='time-box'\>" +
							"<input type='radio' id = 'time' name='time' value ='"+ newIterator +":30'\>" +
							"<p\>"+newIterator+":30</p\>" +
							"</div\>";
						}
						else{
							appendData += "<div class='time-box'\>" +
							"<input type='radio' id = 'time' name='time' value='"+ iterator +"'\>" +
							"<p\>" +iterator +":00</p\>" +
							"</div\>";
						}
					}
					timingDiv.innerHTML = appendData;
				}
			};
			xmlhttp.send();
		}

		function bookAppointment(){
			var date = document.getElementById('selectdate').value;
			var time;
			var flag = false, emailFlag = false;
			var userinfo = document.getElementById('userinfo').value;
			// get list of radio buttons with specified name
			var radios = document.getElementsByName("time");
			// loop through list of radio buttons
			for (var i=0, len=radios.length; i<len; i++) {
				if ( radios[i].checked ) { // radio checked?
					time = radios[i].value; // if so, hold its value in val
					flag = true;
					break; // and break out of for loop
				}
			}
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(userinfo))
  			{
    			emailFlag = true;
  			}
			if(!flag){
				document.getElementById('TimeError').style.display = "block";
			}
			else if(!emailFlag){
				document.getElementById('EmailError').style.display = "block";
			}
			else{
			window.location.href = 'confirmappointment.php?date=' + date + '&time=' + time + '&userinfo=' + userinfo;
			}
		}
		
		function reviewCall(username){
			if(username.length == 0){
				window.location.href = 'login.php';
			}
			else{
				window.location.href = 'review.php';
			}
		}
	</script>
</body>
</html>