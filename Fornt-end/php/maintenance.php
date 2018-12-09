<?php
    session_start();
?>
<!doctype html>
<html lang='en'>
<?php include 'header.php'; ?>
<body class='background background-astronauts'>
	<?php
		$username = $_SESSION['username'];
		$first_name = $_SESSION['firstName'];
	?>
	<main>
		<div class='container-fluid padding-zero'>
            <?php include 'signInNavbar.php'; ?>
		</div>
		<?php
			if(isset($_GET['ticketID'])){
				$ticketID = $_GET['ticketID'];
				$ch = curl_init('https://lunar-living.herokuapp.com/getTicketInfo');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					"ticket_id: $ticketID"
					));
				$data = curl_exec($ch);
				$info = curl_getinfo($ch);
				$ticketDetails = json_decode($data);
				curl_close($ch);
			}
			else{
				echo"<script>window.location.href = 'index.php'</script>";
			}
		?>
		<div class="container-fluid userlease_container">
            <div class="row">
                <div class="col-sm-3">
                    <div class='wrapper'>
                        <aside class='main_sidebar'>
                            <ul>
                                <li><a href='profile.php'>Profile</a></li>
                                <?php
                                if($_SESSION["usertype"] == 1){
                                    echo"<li><a href='user_lease.php'>Lease</a></li>
                                    <li><a href='payment.php'>Payment</a></li>";
                                }
                                if($_SESSION["usertype"] == 2){
                                    echo"<li><a href='newlease.php'>New Lease</a></li>";
                                    echo"<li><a href='allLogin.php'>All Users</a></li>";
									echo"<li><a href='allLease.php'>All Leases</a></li>";
									echo"<li><a href='appointments.php'>All Appointments</a></li>";
									echo"<li><a href='allpromocodes.php'>All Promo Codes</a></li>";
                                }
                                if($_SESSION["usertype"] == 2){
                                    echo"<li><a href='adminchat.php'>Chats</a></li>";
                                }
                                ?>
                                <li class='active'><a href='ticketStatus.php'>Tickets</a></li>
                                <?php
                                if($_SESSION["usertype"] != 1){
                                    echo"<li><a href='map.php'>Ticket Map</a></li>";
                                }
                                ?>
                                <li><a href='events.php'>Events</a></li>
                                <li><a href='laundry.php'>Laundry</a></li>
                                <li><a href='review.php'>Review</a></li>
                                <?php
                                if($_SESSION["usertype"] == 2){
                                    echo"<li>
                                        <a onclick='displayStats()' href='#'>Stats</a>
                                        <ul id='statsChilds' class= 'statsChilds'>
                                            <li><a href='paymentstats.php'>Payment Stats</a></li>
                                            <li><a href='ticketstats.php'>Ticket Area Stats</a></li>
                                            <li><a href='ticketstatsstatus.php'>Ticket Status Stats</a></li>
                                        </ul>
                                    </li>";
                                }
                                ?>
                            </ul>
                        </aside>
                    </div>
                </div>
                <div class="col-sm-9">
                	<div class="container">
					<h2 class = 'lease_info'>Ticket Information</h2>
						<?php
							if($_SESSION["usertype"] == 1){
							echo"<div class='container container-maintenance-ticket'>
								<h5 class='maintenance-ticket-title'>". $ticketDetails->title ."</h5>
								<h5 class='maintenance-ticket-subtitle'>You created this ticket on: <span class='maintenance-ticket-date'>". substr($ticketDetails->openDate, 0, 10) ."</span></h5>
								<div class='container container-maintenance-ticket-content'>
									<h6>".
									$ticketDetails->about	
									."</h6>
								</div>";
								if($ticketDetails->ticketStatus == 'CANCELED'){
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('CREATED','" . $ticketID . "')\">REOPEN</button>";
								}
								else if($ticketDetails->ticketStatus == 'CREATED'){
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('CANCELED','" . $ticketID . "')\">CANCEL</button>";
								}
							echo"</div>";
							}
							else if($_SESSION["usertype"] == 3){
							echo"<div class='container container-maintenance-ticket'>
								<h5 class='maintenance-ticket-title'>".
								$ticketDetails->title
								."</h5>
								<h5 class='maintenance-ticket-subtitle'>
									<span class='maintenance-ticket-user'>". $first_name ."</span> created on: <span class='maintenance-ticket-date'>". substr($ticketDetails->openDate, 0, 10) ."</span>
								</h5>
								<div class='container container-maintenance-ticket-content'>
									<h6>".
									$ticketDetails->about	
									."</h6>
								</div>";
								if($ticketDetails->ticketStatus == 'CREATED'){
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('OPEN','" . $ticketID . "')\">OPEN</button>";
								}
								else if($ticketDetails->ticketStatus == 'OPEN'){
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('CLOSED','" . $ticketID . "')\">CLOSE</button>";
								}
								else {
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('OPEN','" . $ticketID . "')\" disabled>REOPEN</button>";
								}
							echo"</div>";
							}
							else{
							echo"<div class='container container-maintenance-ticket'>
								<h5 class='maintenance-ticket-title'>".
								$ticketDetails->title	
								."</h5>
								<h5 class='maintenance-ticket-subtitle'>
									<span class='maintenance-ticket-user'>". $first_name ."</span> created on: <span class='maintenance-ticket-date'>". substr($ticketDetails->openDate, 0, 10) ."</span>
								</h5>
								<h5 class='maintenance-ticket-subtitle'>
									You assigned this job to <span class='maintenance-ticket-user'>Bob Worker</span>.
								</h5>
								<div class='container container-maintenance-ticket-content'>
									<h6>".
									$ticketDetails->about	
									."</h6>
								</div>";
								if($ticketDetails->ticketStatus == 'CREATED'){
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('CANCELED','" . $ticketID . "')\">CANCEL</button>";
								}
								else if($ticketDetails->ticketStatus == 'OPEN'){
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('CLOSED','" . $ticketID . "')\">CLOSE</button>";
								}
								else{
									echo"<button class='btn btn-info btn-md button-maintenance-ticket' type='submit' onclick=\"changeStatus('OPEN','" . $ticketID . "')\">REOPEN</button>";
								}
							echo"</div>";
							}
						?>              
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
	</main>

	<!-- postJS -->
    <script src='../js/jquery-3.3.1.js'></script>		<!-- Jquery JS (necessary for dropdowns) -->
    <script src='../js/bootstrap.bundle.min.js'></script>		<!-- Bootstrap Bundle JS (necessary for dropdowns) -->
    <!-- <script src='js/bootstrap.min.js'></script> -->		<!-- Bootstrap JS � disabled because when enabled it has a conflict with Bootstrap Bundle JS that makes dropdowns require two clicks to dropdown; it doesn't seem that any needed functionality is lacking when this is disabled -->
	<script>
		function changeStatus(status, ticketID){
			window.location.href = 'updateticket.php?status=' + status + '&ticketID=' + ticketID;
		}
	</script>
</body>
</html>