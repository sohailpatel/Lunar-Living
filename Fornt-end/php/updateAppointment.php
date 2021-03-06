<?php
    if(isset($_GET['userinfo']) && isset($_GET['appointmentID']) && isset($_GET['status'])){
        $userinfo = $_GET['userinfo'];
        $appointmentID = $_GET['appointmentID'];
        $status = $_GET['status'];
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/updateAppointment');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        //set JSON data
        $jsonData = array(
            'userinfo' => $userinfo,
            'appointmentID' => $appointmentID,
            'status' => $status,
        );

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
        $message = "Appointment Updated";
        echo "<script type='text/javascript'>alert('$message');
        window.location.href='appointments.php';</script>";
    }
    else{
        echo "window.location.href='index.php';</script>";
    }
?>