<?php
    if(isset($_GET['eventID'])){
        $eventId = $_GET['eventID'];
        $ch = curl_init('https://lunar-living.herokuapp.com/deleteEvent');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			"event_id: $eventId"
			));
		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		$userInfoData = json_decode($data);
        curl_close($ch);
        
        $message = "Event Deleted";
        echo "<script type='text/javascript'>alert('$message');
        window.location.href='events.php';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('Failed');
        window.location.href='index.php';</script>";
    }
?>