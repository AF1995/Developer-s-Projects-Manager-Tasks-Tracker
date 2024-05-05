<?php require '../connect.php';
    $newAssignedDeveloper = $_POST['newAssignedDeveloper'];
    $taskID = $_POST['taskID'];
    $sql = "";

    if($newAssignedDeveloper == '0')
        $sql = "UPDATE Tasks SET assignedDeveloper = NULL WHERE id = '$taskID'";
    else
        $sql = "UPDATE Tasks SET assignedDeveloper = '$newAssignedDeveloper' WHERE id = '$taskID'";

    mysqli_query($con, $sql) or die("Something went wrong when changing assigned developer.");

    $sql = "INSERT INTO TasksEvents(taskID, developerID, statusID) VALUES('$taskID', ".($newAssignedDeveloper == 0 ? "NULL" : "'$newAssignedDeveloper'").", '".($newAssignedDeveloper == 0 ? '1' : '2')."')";
    mysqli_query($con, $sql) or die("Something went wrong when creating event.");
    
    echo "Successfully updated assigned developer.";
?>