<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    include '../common_functions.php';

    $taskID = $_POST['taskID'];
    $taskName = removeExtraWhitespaces($_POST['taskName']);
    $projectID = $_POST['projectID'];
    $developerID = $_POST['developerID'];
    $estimatedHours = $_POST['estimatedHours'];
    $estimatedMinutes = $_POST['estimatedMinutes'];
    $estimatedSeconds = $_POST['estimatedSeconds'];
    
    foreach(str_split($taskName) as $char)
        if(!isAlphaNumericOrSpace($char))
            die("'Task name' accepts alpha-numerical characters and spaces only.");

    $sql = "SELECT id FROM Tasks WHERE taskName = '$taskName' AND id <> '$taskID' AND projectID = '$projectID'";
    $res = mysqli_query($con, $sql);
    if(mysqli_num_rows($res) > 0)
        die("This task already exists for this project.");

    if(empty($estimatedHours)) $estimatedHours = 0;
    if(empty($estimatedMinutes)) $estimatedMinutes = 0;
    if(empty($estimatedSeconds)) $estimatedSeconds = 0;
    
    foreach(str_split($estimatedHours.$estimatedMinutes.$estimatedSeconds) as $char)
        if(!isNumeric($char))
            die("'Hours', 'Minutes' and 'seconds' must be integers.");

    $sql = "UPDATE Tasks SET taskName = '$taskName', projectID = '$projectID', assignedDeveloper = ".($developerID == '0' ? "NULL" : "'$developerID'").", estimatedHours = '$estimatedHours', estimatedMinutes = '$estimatedMinutes', estimatedSeconds = '$estimatedSeconds' WHERE id = '$taskID'";
    mysqli_query($con, $sql) or die("Something went wrong when updating task.");
    if($developerID != '0'){
        $sql = "INSERT INTO TasksEvents(taskID, developerID, statusID) VALUES('$taskID', '$developerID', '2')";
        mysqli_query($con, $sql) or die("Something went wrong when creating event.");
    }
    echo "Task was successfully edited.";
?>