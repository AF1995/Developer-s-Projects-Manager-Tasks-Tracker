<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    include '../task_worked_time_for_dev.php';
    include '../common_functions.php';

    $devID = $_SESSION['id'];

    $output_assigned = "";
    $output_current = "";
    $output_done = "";
    $output_completed = "";
    
    $sql = "SELECT hoursPerDay FROM Developers WHERE id = '$devID'";
    $res = mysqli_query($con, $sql);
    $hoursPerDay = mysqli_fetch_array($res)['hoursPerDay'];

    $lastEvent = "SELECT e1.statusID, e1.taskID FROM TasksEvents AS e1 WHERE e1.id = (SELECT MAX(e2.id) FROM TasksEvents AS e2 WHERE e2.taskID = e1.taskID)";
    
    $sql = "SELECT Tasks.id AS taskID, taskName, estimatedHours, estimatedMinutes, estimatedSeconds, projectName, Tasks.dateCreated FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '2')";
    $res_assignedTasks = mysqli_query($con, $sql);

    $output_assigned .= "<table>";
    $output_assigned .= "<thead>";
    $output_assigned .= "<tr>";
    $output_assigned .= "<th>Task</th>";
    $output_assigned .= "<th>Project</th>";
    $output_assigned .= "<th>Estimated Time</th>";
    $output_assigned .= "<th>Date Created</th>";
    $output_assigned .= "<th>Actions</th>";
    $output_assigned .= "<th></th>";
    $output_assigned .= "</tr>";
    $output_assigned .= "</thead>";
    $output_assigned .= "<tbody>";
    while($row = mysqli_fetch_array($res_assignedTasks)){
        $estimatedTimeInSeconds = $row['estimatedSeconds'] + ($row['estimatedMinutes'] * 60) + ($row['estimatedHours'] * 60 * 60);
        $estimatedTimeArray = seperateDateTime($estimatedTimeInSeconds, $hoursPerDay);
        $estimatedTime = "";
        if($estimatedTimeArray['days'] != 0) $estimatedTime .= $estimatedTimeArray['days']."d ";
        if($estimatedTimeArray['hours'] != 0) $estimatedTime .= $estimatedTimeArray['hours']."h ";
        if($estimatedTimeArray['minutes'] != 0) $estimatedTime .= $estimatedTimeArray['minutes']."m ";
        if($estimatedTimeArray['seconds'] != 0) $estimatedTime .= $estimatedTimeArray['seconds']."s";
        if($estimatedTime == "") $estimatedTime = "0";

        $output_assigned .= "<tr>";
        $output_assigned .= "<td>".$row['taskName']."</td>";
        $output_assigned .= "<td>".$row['projectName']."</td>";
        $output_assigned .= "<td>".$estimatedTime."</td>";
        $output_assigned .= "<td>".$row['dateCreated']."</td>";
        $output_assigned .= "<td>";
        $output_assigned .= "<button style = 'background-color: #88B04B;' onclick = 'imgStartTask_clicked(".$row['taskID'].")'><i class='bx bx-play' ></i></button>";
        $output_assigned .= "</td>";
        $output_assigned .= "<td id = 'assignedTasks_feedback_".$row['taskID']."'></td>";
        $output_assigned .= "</tr>";
    }
    $output_assigned .= "</tbody>";
    $output_assigned .= "</table>";

    
    $sql = "SELECT Tasks.id AS taskID, taskName, estimatedHours, estimatedMinutes, estimatedSeconds, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '3' OR statusID = '4')";
    $res_currentTasks = mysqli_query($con, $sql);
    
    $output_current .= "<table>";
    $output_current .= "<thead>";
    $output_current .= "<tr>";
    $output_current .= "<th>Task</th>";
    $output_current .= "<th>Project</th>";
    $output_current .= "<th>Date Created</th>";
    $output_current .= "<th>Status</th>";
    $output_current .= "<th>Estimated Time</th>";
    $output_current .= "<th>Worked Time</th>";
    $output_current .= "<th>Actions</th>";
    $output_current .= "<th></th>";
    $output_current .= "</tr>";
    $output_current .= "</thead>";
    $output_current .= "<tbody>";
    while($row = mysqli_fetch_array($res_currentTasks)){
        $estimatedTimeInSeconds = $row['estimatedSeconds'] + ($row['estimatedMinutes'] * 60) + ($row['estimatedHours'] * 60 * 60);
        $estimatedTimeArray = seperateDateTime($estimatedTimeInSeconds, $hoursPerDay);
        $estimatedTime = "";
        if($estimatedTimeArray['days'] != 0) $estimatedTime .= $estimatedTimeArray['days']."d ";
        if($estimatedTimeArray['hours'] != 0) $estimatedTime .= $estimatedTimeArray['hours']."h ";
        if($estimatedTimeArray['minutes'] != 0) $estimatedTime .= $estimatedTimeArray['minutes']."m ";
        if($estimatedTimeArray['seconds'] != 0) $estimatedTime .= $estimatedTimeArray['seconds']."s";
        if($estimatedTime == "") $estimatedTime = "0";

        $row['workedTime'] = taskWorkedTimeForDev($row['taskID'], $devID);
        $workedTime = "";
        if($row['workedTime']['days'] != 0) $workedTime .= $row['workedTime']['days']."d ";
        if($row['workedTime']['hours'] != 0) $workedTime .= $row['workedTime']['hours']."h ";
        if($row['workedTime']['minutes'] != 0) $workedTime .= $row['workedTime']['minutes']."m ";
        if($row['workedTime']['seconds'] != 0) $workedTime .= $row['workedTime']['seconds']."s";

        $output_current .= "<tr>";
        $output_current .= "<td>".$row['taskName']."</td>";
        $output_current .= "<td>".$row['projectName']."</td>";
        $output_current .= "<td>".$row['dateCreated']."</td>";
        $output_current .= "<td>".$row['status']."</td>";
        $output_current .= "<td>".$estimatedTime."</td>";
        $output_current .= "<td>".$workedTime."</td>";
        $output_current .= "<td>";
        if($row['status'] == 'in progress')
            $output_current .= "<button style = 'background-color: #EFC050;' onclick = 'imgPauseTask_clicked(".$row['taskID'].")'><i class='bx bx-pause-circle' ></i></button> ";
        else if($row['status'] == 'on hold')
            $output_current .= "<button style = 'background-color: #009B77;' onclick = 'imgResume_clicked(".$row['taskID'].")'><i class='bx bx-play-circle'></i></button> ";
        $output_current .= "<button style = 'background-color: #55B4B0;' onclick = 'imgDone_clicked(".$row['taskID'].")'><i class='bx bx-check-circle' ></i></button>";
        $output_current .= "</td>";
        $output_current .= "<td id = 'currentTasks_feedback_".$row['taskID']."'></td>";
        $output_current .= "</tr>";
    }
    $output_current .= "</tbody>";
    $output_current .= "</table>";

    $sql = "SELECT Tasks.id AS taskID, taskName, estimatedHours, estimatedMinutes, estimatedSeconds, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '5')";
    $res_doneTasks = mysqli_query($con, $sql);
    
    $output_done .= "<table>";
    $output_done .= "<thead>";
    $output_done .= "<tr>";
    $output_done .= "<th>Task</th>";
    $output_done .= "<th>Project</th>";
    $output_done .= "<th>Date Created</th>";
    $output_done .= "<th>Estimated Time</th>";
    $output_done .= "<th>Worked Time</th>";
    $output_done .= "</tr>";
    $output_done .= "</thead>";
    $output_done .= "<tbody>";
    while($row = mysqli_fetch_array($res_doneTasks)){
        $estimatedTimeInSeconds = $row['estimatedSeconds'] + ($row['estimatedMinutes'] * 60) + ($row['estimatedHours'] * 60 * 60);
        $estimatedTimeArray = seperateDateTime($estimatedTimeInSeconds, $hoursPerDay);
        $estimatedTime = "";
        if($estimatedTimeArray['days'] != 0) $estimatedTime .= $estimatedTimeArray['days']."d ";
        if($estimatedTimeArray['hours'] != 0) $estimatedTime .= $estimatedTimeArray['hours']."h ";
        if($estimatedTimeArray['minutes'] != 0) $estimatedTime .= $estimatedTimeArray['minutes']."m ";
        if($estimatedTimeArray['seconds'] != 0) $estimatedTime .= $estimatedTimeArray['seconds']."s";
        if($estimatedTime == "") $estimatedTime = "0";

        $row['workedTime'] = taskWorkedTimeForDev($row['taskID'], $devID);
        $workedTime = "";
        if($row['workedTime']['days'] != 0) $workedTime .= $row['workedTime']['days']."d ";
        if($row['workedTime']['hours'] != 0) $workedTime .= $row['workedTime']['hours']."h ";
        if($row['workedTime']['minutes'] != 0) $workedTime .= $row['workedTime']['minutes']."m ";
        if($row['workedTime']['seconds'] != 0) $workedTime .= $row['workedTime']['seconds']."s";

        $output_done .= "<tr>";
        $output_done .= "<td>".$row['taskName']."</td>";
        $output_done .= "<td>".$row['projectName']."</td>";
        $output_done .= "<td>".$row['dateCreated']."</td>";
        $output_done .= "<td>".$estimatedTime."</td>";
        $output_done .= "<td>".$workedTime."</td>";
        $output_done .= "</tr>";
    }
    $output_done .= "</tbody>";
    $output_done .= "</table>";
    
    $sql = "SELECT Tasks.id AS taskID, taskName, estimatedHours, estimatedMinutes, estimatedSeconds, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '6')";
    $res_completedTasks = mysqli_query($con, $sql);

    $output_completed .= "<table>";
    $output_completed .= "<thead>";
    $output_completed .= "<tr>";
    $output_completed .= "<th>Task</th>";
    $output_completed .= "<th>Project</th>";
    $output_completed .= "<th>Date Created</th>";
    $output_completed .= "<th>Estimated Time</th>";
    $output_completed .= "<th>Worked Time</th>";
    $output_completed .= "</tr>";
    $output_completed .= "</thead>";
    $output_completed .= "<tbody>";
    while($row = mysqli_fetch_array($res_completedTasks)){
        $estimatedTimeInSeconds = $row['estimatedSeconds'] + ($row['estimatedMinutes'] * 60) + ($row['estimatedHours'] * 60 * 60);
        $estimatedTimeArray = seperateDateTime($estimatedTimeInSeconds, $hoursPerDay);
        $estimatedTime = "";
        if($estimatedTimeArray['days'] != 0) $estimatedTime .= $estimatedTimeArray['days']."d ";
        if($estimatedTimeArray['hours'] != 0) $estimatedTime .= $estimatedTimeArray['hours']."h ";
        if($estimatedTimeArray['minutes'] != 0) $estimatedTime .= $estimatedTimeArray['minutes']."m ";
        if($estimatedTimeArray['seconds'] != 0) $estimatedTime .= $estimatedTimeArray['seconds']."s";
        if($estimatedTime == "") $estimatedTime = "0";

        $row['workedTime'] = taskWorkedTimeForDev($row['taskID'], $devID);
        $workedTime = "";
        if($row['workedTime']['days'] != 0) $workedTime .= $row['workedTime']['days']."d ";
        if($row['workedTime']['hours'] != 0) $workedTime .= $row['workedTime']['hours']."h ";
        if($row['workedTime']['minutes'] != 0) $workedTime .= $row['workedTime']['minutes']."m ";
        if($row['workedTime']['seconds'] != 0) $workedTime .= $row['workedTime']['seconds']."s";

        $output_completed .= "<tr>";
        $output_completed .= "<td>".$row['taskName']."</td>";
        $output_completed .= "<td>".$row['projectName']."</td>";
        $output_completed .= "<td>".$row['dateCreated']."</td>";
        $output_completed .= "<td>".$estimatedTime."</td>";
        $output_completed .= "<td>".$workedTime."</td>";
        $output_completed .= "</tr>";
    }
    $output_completed .= "</tbody>";
    $output_completed .= "</table>";

    echo json_encode(array("assigned" => $output_assigned, "current" => $output_current, "done" => $output_done, "completed" => $output_completed));
?>