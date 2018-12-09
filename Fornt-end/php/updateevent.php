<?php
    if(isset($_POST['eventId']) && isset($_POST['createeventDescriptionInput'])){
        session_start();
        $eventid = $_POST['eventId'];
        $createeventDescriptionInput = $_POST['createeventDescriptionInput'];
        
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/updateEvent');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        //set JSON data
        $jsonData = array(
            'event_id' => $eventid,
            'describtion' => $createeventDescriptionInput
        );

        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
        curl_close($ch);
        $message = "Event Updated";
        echo "<script type='text/javascript'>alert('$message');
        window.location.href='events.php';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('Failed');
        window.location.href='index.php';</script>";
    }
?>