<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    include '../common_functions.php';
    $projectID = $_POST['projectID'];
    $taskName = removeExtraWhitespaces($_POST['taskName']); 
    $assignedDeveloper = $_POST["assignedDeveloper"];
    $hours = trim($_POST['hours']);
    $minutes = trim($_POST['minutes']);
    $seconds = trim($_POST['seconds']);

    /* Input validation: */
    foreach(str_split($taskName) as $char)
        if(!isAlphaNumericOrSpace($char))
            die("'Task Name' accepts alpha-numerical characters and spaces only.");
    
    // Now to make sure that this task name doesn't already exist for the current project...
    $sql = "SELECT taskName From Tasks WHERE projectID = '$projectID'";
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($res))
        if($row['taskName'] == $taskName)
            die("The task name '$taskName' already exists for this project.");

    if(empty($hours)) $hours = 0;
    if(empty($minutes)) $minutes = 0;
    if(empty($seconds)) $seconds = 0;

    foreach(str_split($hours.$minutes.$seconds) as $char)
        if(!isNumeric($char))
            die("'Hours', 'Minutes' and 'seconds' must be integers.");

    $sql = "INSERT INTO Tasks(taskName, projectID, estimatedHours, estimatedMinutes, estimatedSeconds".($assignedDeveloper == 0 ? '' : ', assignedDeveloper').") ";
    $sql .= "VALUES('$taskName', '$projectID', '$hours', '$minutes', '$seconds'".($assignedDeveloper == 0 ? "" : ", '".$assignedDeveloper."'").")";
    mysqli_query($con, $sql) or die("Something went wrong when adding new task.");

    // Add a corresponding record to events table
    $sql = "SELECT @@IDENTITY AS id";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    $taskID = $row['id'];

    $sql = "INSERT INTO TasksEvents(taskID, statusID, developerID) VALUES('$taskID', '".($assignedDeveloper == 0 ? "1" : "2")."', ".($assignedDeveloper == 0 ? "NULL" : "'$assignedDeveloper'").")";
    mysqli_query($con, $sql) or die("Something went wrong when adding new event for task.");

    echo "Task successfully added.";
?>