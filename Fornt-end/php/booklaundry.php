<?php
    if (isset($_GET["machineSelect"]) && isset($_GET["time"])) {
        $machineID = $_GET["machineSelect"];
        $time = $_GET["time"];
        session_start();
        $username = $_SESSION['username'];
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/bookLaundry');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');


        //set JSON data
        $jsonData = array(
            'user_info' => $username,
            'machine_id' => $machineID,
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
        window.location.href='laundry.php';</script>";
    }
?>