<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    include '../task_worked_time_for_dev.php';
    include '../common_functions.php';

    $devID = $_SESSION['id'];

    $output_projectsWorkTime = "<div class = 'list'>";

    $totalWorkedTime = array("days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0);

    $sql = "SELECT hoursPerDay FROM Developers WHERE id = '$devID'";
    $res = mysqli_query($con, $sql);
    $hoursPerDay = mysqli_fetch_array($res)['hoursPerDay'];

    $sql = "SELECT DISTINCT projectID, projectName FROM Tasks LEFT JOIN Projects ON Projects.id = projectID WHERE assignedDeveloper = '$devID'";
    $res = mysqli_query($con, $sql);
    $projects = array();
    while($row = mysqli_fetch_array($res))
        array_push($projects, array('id' => $row['projectID'], 'name' => $row['projectName']));

    foreach($projects as $project){
        $subProjectOutput = "";

        $projectWorkTime = array("days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0);

        $sql = "SELECT id, taskName FROM Tasks WHERE projectID = '".$project['id']."' AND assignedDeveloper = '$devID'";
        $res = mysqli_query($con, $sql);
        $subProjectOutput .= "<ul>";
        while($row = mysqli_fetch_array($res)){
            
            $taskWorkTime = taskWorkedTimeForDev($row['id'], $devID);

            $workedTime = "";
            if($taskWorkTime['days'] != 0) $workedTime .= $taskWorkTime['days']."d ";
            if($taskWorkTime['hours'] != 0) $workedTime .= $taskWorkTime['hours']."h ";
            if($taskWorkTime['minutes'] != 0) $workedTime .= $taskWorkTime['minutes']."m ";
            if($taskWorkTime['seconds'] != 0) $workedTime .= $taskWorkTime['seconds']."s";
            if($workedTime == "") $workedTime = "0";

            $subProjectOutput .= "<li class = 'li_".$project['id']."'><p>".$row['taskName']."</p> <span>$workedTime</span></li>";

            $projectWorkTime = addTwoSeperatedDateTime($projectWorkTime, $taskWorkTime, $hoursPerDay);
        }
        $subProjectOutput .= "</ul>";
        
        $workedTime = "";
        if($projectWorkTime['days'] != 0) $workedTime .= $projectWorkTime['days']."d ";
        if($projectWorkTime['hours'] != 0) $workedTime .= $projectWorkTime['hours']."h ";
        if($projectWorkTime['minutes'] != 0) $workedTime .= $projectWorkTime['minutes']."m ";
        if($projectWorkTime['seconds'] != 0) $workedTime .= $projectWorkTime['seconds']."s";
        if($workedTime == "") $workedTime = "0";

        $subProjectOutput = "<h2><span id = 'block_".$project['id']."' style = 'cursor: pointer;' onclick = 'toggleVisibility(\"li_".$project['id']."\")'>&#x25BC;</span>".$project['name'].": $workedTime</h2>".$subProjectOutput;

        $output_projectsWorkTime .= $subProjectOutput;

        $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $projectWorkTime, $hoursPerDay);
    }

    $workedTime = "";
    if($totalWorkedTime['days'] != 0) $workedTime .= $totalWorkedTime['days']."d ";
    if($totalWorkedTime['hours'] != 0) $workedTime .= $totalWorkedTime['hours']."h ";
    if($totalWorkedTime['minutes'] != 0) $workedTime .= $totalWorkedTime['minutes']."m ";
    if($totalWorkedTime['seconds'] != 0) $workedTime .= $totalWorkedTime['seconds']."s";
    if($workedTime == "") $workedTime = "0";

    $output_projectsWorkTime .= "</div>";

    echo "<h1>Total Worked Time: $workedTime </h1>";
    echo $output_projectsWorkTime;
?>