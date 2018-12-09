<?php
    session_start();
    $username = $_SESSION['chatuser'];
    $ch = curl_init('https://lunar-living.herokuapp.com/fetchUserMsg');
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
    if(isset($_COOKIE['deliver']) && $_COOKIE['deliver'] == 1){
        $ch = curl_init('https://lunar-living.herokuapp.com/fetchReadMsg');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "username: $username"
            ));
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
    }

    if($apiData != null){
        $allmsgs = explode ("~", $apiData->msg);
        foreach($allmsgs as $msg){
            $currmsg = explode ("^", $msg);
            $name = explode ("-", $currmsg[1]);
            echo "<p><span>".$currmsg[0]."</span>
            <span><strong>". $name[0] ."</strong></span>
            <span>". $name[1] ."</span>
            </p>";
        }
    }
?>