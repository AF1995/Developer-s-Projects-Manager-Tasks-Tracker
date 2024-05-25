<?php session_start();
    if(!isset($_SESSION['role'])) return;

    require '../connect.php';
    include '../common_functions.php';

    $fname = removeExtraWhitespaces($_POST['fname']);
    $lname = removeExtraWhitespaces($_POST['lname']);
    $email = removeExtraWhitespaces($_POST['email']);
    $phone = removeExtraWhitespaces($_POST['phone']);
    $hoursPerDay = removeExtraWhitespaces($_POST['hoursPerDay']);

    $output = array("fname" => "", "lname" => "", "email" => "", "phone" => "", "hoursPerDay" => "", "response" => "", "sendEmail" => "");
    $isDirty = false;
    
    // Input validation:
    foreach(str_split($fname) as $char)
        if(!isAlphabeticOrSpace($char)){
            $output["fname"] = "Alpha-numerical characters and spaces only.";
            $isDirty = true;
            break;
        }

    foreach(str_split($lname) as $char)
        if(!isAlphabeticOrSpace($char)){
            $output["lname"] = "Alpha-numerical characters and spaces only.";
            $isDirty = true;
            break;
        }

    if(!validateEmail($email)){
        $output["email"] = "Wrong email format.";
        $isDirty = true;
    }

    if(!isPhoneCharactersOnly($phone)){
        $output['phone'] = "Wrong phone format.";
        $isDirty = true;
    }

    foreach(str_split($hoursPerDay) as $char)
        if(!isNumeric($char)){
            $output["hoursPerDay"] = "Must be an integer";
            $isDirty = true;
            break;
        }
    
    if($output["hoursPerDay"] == ""){
        $hoursPerDay = (int)$hoursPerDay;
        if($hoursPerDay < 1 || $hoursPerDay > 24){

            $output["hoursPerDay"] = "1 to 24 only.";
            $isDirty = true;
        }
    }

    if($isDirty) die(json_encode($output));

    // Check if the email already exists for the current user:
    $sql = "SELECT id FROM Developers WHERE userID = '".$_SESSION['id']."' AND email = '$email'";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res) > 0)
        die(json_encode(array("fname" => "", "lname" => "", "email" => "Email already exists.", "phone" => "", "hoursPerDay" => "", "response" => "", "sendEmail" => "")));

    // Generate a password for the developer:
    $password = generatePassowrd();

    $sql = "INSERT INTO Developers(userID, fname, lname, email, password, phone, hoursPerDay) VALUES('".$_SESSION['id']."', '$fname', '$lname', '$email', '$password', '$phone', '$hoursPerDay')";
    mysqli_query($con, $sql) or die(json_encode(array("fname" => "", "lname" => "", "email" => "", "phone" => "", "hoursPerDay" => "", "response" => "Something went wrong when adding new developer.", "sendEmail" => "")));

    echo json_encode(array("fname" => "", "lname" => "", "email" => "", "phone" => "", "hoursPerDay" => "", "response" => "Successfully added new developer.", "sendEmail" => "$email $password"));
?>