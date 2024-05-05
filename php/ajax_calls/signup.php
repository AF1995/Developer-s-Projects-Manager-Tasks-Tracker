<?php
    require '../connect.php';
    include '../common_functions.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $err = "";

    if(!validateName($name)) $err .= "Name must be 3 at least characters containing only alpabetic characters and spaces.<br>";
    if(!validateEmail($email)) $err .= "Wrong email format.<br>";
    if(strlen($password) < 8) $err .= "Password must be at least 8 characters long.<br>";
    else if($password != $confirmPassword) $err .= "Password doesn't match.<br>";

    if(!empty($err)){
        echo $err;
        return;
    }

    /* Check if the company name or email already exists. */
    $sql = "SELECT COUNT(id) FROM Users WHERE LOWER(userName) = '".strtolower($name)."'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    if($row[0] != 0)
        $err .= "Name already taken. Consider using another name.<br>";

    $sql = "SELECT COUNT(id) FROM Users WHERE LOWER(email) = '".strtolower($email)."'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    if($row[0] != 0)
        $err .= "Email already taken. Consider using another email.<br>";
    
    if(!empty($err)){
        echo $err;
        return;
    }

    /* Add the new record. */
    $sql = "INSERT INTO Users(userName, email, password) VALUES('$name', '$email', '$password')";
    mysqli_query($con, $sql) or die("Failed to register user.");
    
    echo "";
?>