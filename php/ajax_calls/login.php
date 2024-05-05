<?php 
    require '../connect.php';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    
    $sql = "";
    
    if($userType == "leader"){
        $sql = "SELECT id, userName FROM Users WHERE email = '$email' AND password = '$password'";
    }
    else if ($userType == "developer"){
        $sql = "SELECT id, fname, lname FROM Developers WHERE email = '$email' AND password = '$password'";
    }
    else {
        echo json_encode(array("found" => "no", "feedback" => "User type is not chosen."));
        return;
    }

    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);

    if(mysqli_num_rows($res) == 0){
        echo json_encode(array("found" => "no", "feedback" => "Wrong email or password."));
        return;
    }
    
    /* If email was found: */
    if($userType == "leader"){
        echo json_encode(array("found" => "yes", "id" => $row['id'], "userName" => $row['userName']));
    }
    else if ($userType == "developer"){
        echo json_encode(array("found" => "yes", "id" => $row['id'], "fname" => $row['fname'], "lname" => $row['lname']));
    }
?>