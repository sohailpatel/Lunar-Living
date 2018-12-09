<?php
    if (isset($_POST["ticketsearchid"]) && isset($_POST["ticketsearchtitle"]) && isset($_POST["ticketsearchStatus"])) {
        $id = $_POST["ticketsearchid"];
        $title = $_POST["ticketsearchtitle"];
        $status = $_POST["ticketsearchStatus"];
        session_start();
        $username = $_SESSION['username'];
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/getUserTicketFilter');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        //set JSON data
        $jsonData = array(
            'id' => $id,
            'title' => $title,
            'status' => $status,
            'username' => $username
        );

        $jsonDataEncoded = json_encode($jsonData);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
        $query = json_decode($result)->query;
        curl_close($ch);
        $_SESSION['query'] = $query;
        //echo "<script type='text/javascript'>alert('". $result ."')</script>";
        
        echo "<script type='text/javascript'>
            window.location.href='../ticketStatus.php?flag=1';</script>";
    }
    else{
        echo "<script type='text/javascript'>
            window.location.href='../index.php';</script>";
    }
?>