<?php
session_start();
if(isset($_GET['otheruser'])){
    $_SESSION['chatuser'] = $_GET['otheruser'];
    header('Location: adminchat.php');
}
?>