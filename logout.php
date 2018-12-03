<?php 
    session_start();
    if ($_SESSION["isAdmin"] == true){
        unset($_SESSION["isAdmin"]);
        header("Location: ./index.php");
    }
    if ($_SESSION["isUser"] == true){
        unset($_SESSION["isUser"]);
        unset($_SESSION["User"]);
        header("Location: ./index.php");
    }
	
?>
