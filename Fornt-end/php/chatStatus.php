<?php
    session_start();
    $username = $_SESSION['chatuser'];
    $ch = curl_init('https://lunar-living.herokuapp.com/checkAdminStatus');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "username: $username"
        ));
    $data = curl_exec($ch);
    $info = curl_getinfo($ch);
    $apiData = json_decode($data);
    curl_close($ch);

    if($apiData != null){
        if($apiData->readAdmin == 0){
            echo"<span>Message Status: Read</span>";
        }
        else if($apiData->deliveredAdmin == 0 && $apiData->readAdmin == 1){
            echo"<span>Message Status: Delivered</span>";
        }
        else{
            echo"<span>Message Status: Sent</span>";
        }
    }
?>