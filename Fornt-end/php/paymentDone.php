<?php
    session_start();
    $username = $_SESSION['username'];
    $aptID = $_SESSION['aptID'];
    $amount = $_SESSION['amount'];
    //setup the request, you can also use CURLOPT_URL
    $ch = curl_init('https://lunar-living.herokuapp.com/pay');

    // Returns the data/output as a string instead of raw data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
    curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');


    //set JSON data
    $jsonData = array(
        'username' => $username,
        'aptID' => $aptID,
        'amount' => $amount
    );

    $jsonDataEncoded = json_encode($jsonData);

    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $result = curl_exec($ch);
    $message = "Payment Successful";
    echo "<script type='text/javascript'>alert('$message');
    window.location.href='payment.php';</script>";
?>