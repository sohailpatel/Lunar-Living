<?php
    if(isset($_POST['promoid']) && isset($_POST['maxuse']) && isset($_POST['off'])){
        session_start();
        $promocode = $_POST['promoid'];
        $maxuse = $_POST['maxuse'];
        $offBy = $_POST['off'];
        //setup the request, you can also use CURLOPT_URL
        $ch = curl_init('https://lunar-living.herokuapp.com/addPromoCode');

        // Returns the data/output as a string instead of raw data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        //set JSON data
        $jsonData = array(
            'promocode' => $promocode,
            'maxuse' => $maxuse,
            'offBy' => $offBy
        );

        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
        $message = "Promo Code Added";
        echo "<script type='text/javascript'>alert('$message');
        window.location.href='allpromocodes.php';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('Failed');
        window.location.href='index.php';</script>";
    }
?>