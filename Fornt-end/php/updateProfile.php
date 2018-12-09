<?php
    if (isset($_GET["firstName"]) && isset($_GET["lastName"]) &&  isset($_GET["gender"])) {
        $newFirstName = $_GET["firstName"];
        $newLastName = $_GET["lastName"];
        $newGender = $_GET["gender"];
        session_start();
        $username = $_SESSION['username'];
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/updateUserDetails');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');


        //set JSON data
        $jsonData = array(
            'username' => $username,
            'first_name' => $newFirstName,
            'last_name' => $newLastName,
            'gender' => $newGender
        );

        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
        $message = "Updated";
        if($result == 'false'){
            $message = "Failed";
        }
        echo "<script type='text/javascript'>alert('$message');
        window.location.href='profile.php';</script>";
    }
?>