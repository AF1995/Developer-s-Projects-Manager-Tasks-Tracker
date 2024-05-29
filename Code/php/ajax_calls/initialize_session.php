<?php
    session_start();
    
    $userType = $_POST['userType'];
    $_SESSION['id'] = $_POST['id'];

    if($userType == "leader"){
        $_SESSION['userName'] = $_POST['userName'];
        $_SESSION['role'] = "leader";
    }
    else if($userType == "developer"){
        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['lname'] = $_POST['lname'];
        $_SESSION['role'] = "developer";
    }
?>