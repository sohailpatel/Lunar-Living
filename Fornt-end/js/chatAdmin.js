
// jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit==true){window.location = 'chat.php?logout=1';}		
    });
});
$("#submitmsg").click(function(){	
    var clientmsg = $("#usermsg").val();
    $.post("chatpostAdmin.php", {text: clientmsg});				
    $("#usermsg").attr("value", "");
    return false;
});
function loadLog(){		
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url:'chatfetchAdmin.php',
        type: 'post',
        data: 'msg',
        success: function(data){
            $('.chat .message').html(data);
        }
    });
}
function loadStatus(){		
    $.ajax({
        url:'chatStatusAdmin.php',
        type: 'post',
        data: 'msg',
        success: function(data){
            $('.chat .status').html(data);
        }
    });
}
setInterval(loadLog, 5000);
setInterval(loadStatus, 5000);