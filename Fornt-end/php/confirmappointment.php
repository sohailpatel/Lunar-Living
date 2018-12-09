<?php
    if (isset($_GET["date"]) && isset($_GET["time"]) && isset($_GET["userinfo"])) {
        $date = $_GET["date"];
        $time = $_GET["time"];
        $userinfo = $_GET["userinfo"];
        session_start();
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/bookAppointment');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');

        //set JSON data
        $jsonData = array(
            'user_info' => $userinfo,
            'visit_date' => $date,
            'visit_time' => $time
        );

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        curl_close($ch);
        $message = "Booked";
        if($result == 'false'){
            $message = "Failed";
        }
        echo "<script type='text/javascript'>alert('$message');
        window.location.href='index.php';</script>";
    }
?>