<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    include '../task_worked_time_for_dev.php';
    include '../common_functions.php';

    $devID = $_POST['devID'];

    $output_nameTime = "";
    $output_assigned = "";
    $output_current = "";
    $output_done = "";
    $output_completed = "";

    $sql = "SELECT CONCAT(fname, ' ', lname) AS devName FROM Developers WHERE id = '$devID'";
    $res = mysqli_query($con, $sql);
    $devName = mysqli_fetch_array($res)['devName'];
    
    $totalWorkedTime = array("days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0);
    
    $lastEvent = "SELECT e1.statusID, e1.taskID FROM TasksEvents AS e1 WHERE e1.id = (SELECT MAX(e2.id) FROM TasksEvents AS e2 WHERE e2.taskID = e1.taskID)";
    
    $sql = "SELECT Tasks.id AS taskID, taskName, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '2')";
    $res_assignedTasks = mysqli_query($con, $sql);

    $output_assigned .= "<table>";
    $output_assigned .= "<thead>";    
    $output_assigned .= "<tr>";
    $output_assigned .= "<th>Task</th>";
    $output_assigned .= "<th>Project</th>";
    $output_assigned .= "<th>Date Created</th>";
    $output_assigned .= "</tr>";
    $output_assigned .= "</thead>";
    $output_assigned .= "<tbody>";
    while($row = mysqli_fetch_array($res_assignedTasks)){ 
        $output_assigned .= "<tr>";
        $output_assigned .= "<td>".$row['taskName']."</td>";
        $output_assigned .= "<td>".$row['projectName']."</td>";
        $output_assigned .= "<td>".$row['dateCreated']."</td>";
        $output_assigned .= "</tr>";
    }
    $output_assigned .= "<t/body>";
    $output_assigned .= "</table>";

    
    $sql = "SELECT Tasks.id AS taskID, taskName, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '3' OR statusID = '4')";
    $res_currentTasks = mysqli_query($con, $sql);
    
    $output_current .= "<table>";
    $output_current .= "<thead>";
    $output_current .= "<tr>";
    $output_current .= "<th>Task</th>";
    $output_current .= "<th>Project</th>";
    $output_current .= "<th>Date Created</th>";
    $output_current .= "<th>Status</th>";
    $output_current .= "<th>Worked Time</th>";
    $output_current .= "</tr>";
    $output_current .= "</thead>";
    $output_current .= "<tbody>";
    while($row = mysqli_fetch_array($res_currentTasks)){
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
        $output_current .= "<td>".$workedTime."</td>";
        $output_current .= "</tr>";

        $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $row['workedTime']);
    }
    $output_current .= "</tbody>";
    $output_current .= "</table>";

    $sql = "SELECT Tasks.id AS taskID, taskName, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '5')";
    $res_doneTasks = mysqli_query($con, $sql);
    
    $output_done .= "<table>";
    $output_done .= "<thead>";
    $output_done .= "<tr>";
    $output_done .= "<th>Task</th>";
    $output_done .= "<th>Project</th>";
    $output_done .= "<th>Date Created</th>";
    $output_done .= "<th>Worked Time</th>";
    $output_done .= "<th>Actions</th>";
    $output_done .= "</tr>";
    $output_done .= "</thead>";
    $output_done .= "<tbody>";
    while($row = mysqli_fetch_array($res_doneTasks)){
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
        $output_done .= "<td>".$workedTime."</td>";
        $output_done .= "<td>";
        $output_done .= "<button style = 'background-color: #88B04B;'><i class='bx bx-check-square' onclick = 'imgMarkAsCompleted_clicked(".$row['taskID'].")'></i></button> ";
        $output_done .= "<button style = 'background-color: #EFC050;'><i class='bx bx-pause-circle' onclick = 'imgMarkAsOnHold_clicked(".$row['taskID'].")'></i></button>";
        $output_done .= "</td>";
        $output_done .= "</tr>";

        $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $row['workedTime']);
    }
    $output_done .= "</tbody>";
    $output_done .= "</table>";
    
    $sql = "SELECT Tasks.id AS taskID, taskName, projectName, Tasks.dateCreated, Statuses.status FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN ($lastEvent) AS lastEvent ON lastEvent.taskID = Tasks.id LEFT JOIN Statuses ON Statuses.id = lastEvent.statusID WHERE assignedDeveloper = '$devID' AND (statusID = '6')";
    $res_completedTasks = mysqli_query($con, $sql);

    $output_completed .= "<table>";
    $output_completed .= "<thead>";
    $output_completed .= "<tr>";
    $output_completed .= "<th>Task</th>";
    $output_completed .= "<th>Project</th>";
    $output_completed .= "<th>Date Created</th>";
    $output_completed .= "<th>Worked Time</th>";
    $output_completed .= "</tr>";
    $output_completed .= "</thead>";
    $output_completed .= "<tbody>";
    while($row = mysqli_fetch_array($res_completedTasks)){
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
        $output_completed .= "<td>".$workedTime."</td>";
        $output_completed .= "</tr>";

        $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $row['workedTime']);
    }
    $output_completed .= "</tbody>";
    $output_completed .= "</table>";

    $workedTime = "";
    if($totalWorkedTime['days'] != 0) $workedTime .= $totalWorkedTime['days']."d ";
    if($totalWorkedTime['hours'] != 0) $workedTime .= $totalWorkedTime['hours']."h ";
    if($totalWorkedTime['minutes'] != 0) $workedTime .= $totalWorkedTime['minutes']."m ";
    if($totalWorkedTime['seconds'] != 0) $workedTime .= $totalWorkedTime['seconds']."s";

    $output_nameTime = "<p>Developer: \"$devName\" - Total work time: $workedTime.</p>";

    echo json_encode(array("nameTime" => $output_nameTime, "assigned" => $output_assigned, "current" => $output_current, "done" => $output_done, "completed" => $output_completed));
?>