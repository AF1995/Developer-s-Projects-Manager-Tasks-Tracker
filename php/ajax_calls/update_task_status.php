<?php require '../connect.php';
    $status = $_POST['statusID'];
    $taskID = $_POST['taskID'];
    $devID = $_POST['devID'];

    $sql = "INSERT INTO TasksEvents(taskID, statusID, developerID) VALUES('$taskID', '$status', ".($devID == 0 ? "NULL" : "'$devID'").")";
    mysqli_query($con, $sql) or die("Something went wrong when addnig event.");
    echo "done";
?>