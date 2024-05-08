<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    $taskID = $_POST['taskID'];
    $sql = "SELECT taskName, dateCreated FROM Tasks WHERE id = '$taskID'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    echo $row['taskName']." - Issued at: ".$row['dateCreated'];
?>