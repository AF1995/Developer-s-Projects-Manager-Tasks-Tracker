<?php
    session_start();
    
    $userType = $_POST['userName'];
    $_SESSION['id'] = $_POST['id'];

    if($userType == "leader"){
        $_SESSION['userName'] = $_POST['userName'];
    }
    else if($userType == "developer"){
        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['lname'] = $_POST['lname'];
    }
?>