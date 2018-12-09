<!doctype html>
<html lang='en'>
<?php include 'header.php'; ?>
<head>
	<link rel='stylesheet' href='../css/bootstrap-datepicker3.css'>		<!-- Bootstrap Datepicker 3 CSS -->
</head>
<body class='background background-chilling'>
	<main>
		
	<?php include 'signInNavbar.php'; ?>

		<div class='spacer-events'></div>

		<div id='events-background'>
			<br>
			<a id='events-header-link' href='events.php'>
				<h1 id='events-header' class='events-header-in-link'>Events</h1>
			</a>
			<br>
			<br>
			<?php
			if (isset($_GET["eventID"])) {
				$eventID = $_GET["eventID"];
				$index = $_GET["index"];
				$username = $_SESSION['username'];
				$ch = curl_init('https://lunar-living.herokuapp.com/getEventInfo');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					"event_id: $eventID"
					));
				$data = curl_exec($ch);
				$info = curl_getinfo($ch);
				$eventInfo = json_decode($data);
				curl_close($ch);
			
			echo"<div class='createevent-container'>
				<br>
				<h1 class='event-title'>Edit Event</h1>
				<div class='createevent-form-container'>
					<form action='updateevent.php' method='post'>
						<div class='form-group text-centered'>
							<br>
							<input name='eventId' style='display:none;' value ='". $eventID ."'>
							<br>
							<h4>". $eventInfo->title ."</h4>
							<br>
							<h4>". substr($eventInfo->eventDate, 0, 10) ."</h4>
							<br>
							<h4>Description</h4>
							<div class='form-group'>
								<textarea wrap='soft' id='createevent-description-input' name='createeventDescriptionInput' placeholder='Event description'>". $eventInfo->describtion ."</textarea>
							</div>
							<br>
							<button type='submit' class='btn btn-info btn-md'>Update Event</button>
							
							<a class='btn btn-danger btn-md' onclick=\"deleteEvent(". $eventID .")\">Cancel Event</a>
						</div>
					</form>
				</div>
				<br>
			</div>";
			}
			?>
			<br>
			<br>
		</div>

		<div class='spacer-events'></div>
		
	</main>

	<!-- postJS -->
    <script src='../js/jquery-3.3.1.js'></script>		<!-- Jquery JS (necessary for dropdowns) -->
    <script src='../js/bootstrap.bundle.min.js'></script>		<!-- Bootstrap Bundle JS (necessary for dropdowns) -->
    <!-- <script src='js/bootstrap.min.js'></script> -->		<!-- Bootstrap JS – disabled because when enabled it has a conflict with Bootstrap Bundle JS that makes dropdowns require two clicks to dropdown; it doesn't seem that any needed functionality is lacking when this is disabled -->
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
		function deleteEvent(eventID){
			window.location.href='deleteevent.php?eventID=' + eventID;
		}
	</script>

</body>
</html>