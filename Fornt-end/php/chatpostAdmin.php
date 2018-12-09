<?php
session_start();
    if (isset($_SESSION["firstName"])) {
        $username = $_SESSION['chatuser'];
        $ch = curl_init('https://lunar-living.herokuapp.com/sendAdminMsg');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
        $jsonData = array(
            'username' => $username,
            'firstName' => $_SESSION["firstName"],
            'msg' => $_POST['text']
        );

        $jsonDataEncoded = json_encode($jsonData);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $result = curl_exec($ch);
        curl_close($ch);
    }
?>