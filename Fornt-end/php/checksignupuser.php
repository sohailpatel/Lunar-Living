<?php
    session_start();
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
//setup the request, you can also use CURLOPT_URL
    $ch = curl_init('https://lunar-living.herokuapp.com/signup');

// Returns the data/output as a string instead of raw data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
    curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');

//Set your auth headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "username: $username"
    ));

// get stringified data/output. See CURLOPT_RETURNTRANSFER
    $data = curl_exec($ch);

// get info about the request
    $info = curl_getinfo($ch);

    $dataArray = json_decode($data, true);
    curl_close($ch);
    $_SESSION["newuser"] = $dataArray["newuser"];
    $_SESSION["usertype"] = $dataArray["usertype"];
    
    if($data == 'false'){
        echo "<script>alert('User not found');</script>";
    }else {
        echo "<script>window.location.href = 'otpverification.php';</script>";
    }
?>