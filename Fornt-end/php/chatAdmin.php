<?php
session_start(); 
if(isset($_GET['logout'])){     
    //Simple exit message
    header("Location: index.php"); //Redirect the user
}
?>
<div id="wrapper" class='chat'>
    <div id="menu">
        <h3 class="welcome">Welcome, <b><?php echo $_SESSION['firstName']; ?></b></h3>
        <div style="clear:both"></div>
    </div>    
    <div id="chatbox" class='message'>

    </div>
    <div class='status'>
        
    </div>    
    <form name="message" action="">
        <input name="usermsg" type="text" id="usermsg" class = 'text-area'/>
        <input name="submitmsg" type="submit" id="submitmsg" value="Send" class="btn" />
    </form>
</div>
    