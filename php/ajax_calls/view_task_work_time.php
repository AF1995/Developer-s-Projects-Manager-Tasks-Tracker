<?php require '../connect.php';
    include '../common_functions.php';
    $taskID = $_POST['taskID'];

    $sql = "SELECT statusID, eventDate, developerID, hoursPerDay FROM TasksEvents LEFT JOIN Developers ON Developers.id = developerID WHERE taskID = '$taskID'";
    $res = mysqli_query($con, $sql);
    
    $devsWorkedTime = array();
    $totalWorkedTime = array("days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0);
    $dateTime1 = "";
    $dateTime2 = "";
    $devID = 0;
    $hoursPerDay = 24;
    while($row = mysqli_fetch_array($res)){
        $devID = $row['developerID'];
        $hoursPerDay = $row['hoursPerDay'];
        if($row['statusID'] == 4){ // Status: "in progress"
            $dateTime1 = $row['eventDate'];
        }
        else if($dateTime1 != ""){
            $dateTime2 = $row['eventDate'];
        }

        if($dateTime1 != "" && $dateTime2 != ""){

            $sql = "SELECT TIMESTAMPDIFF(second, '$dateTime1', '$dateTime2') AS seconds";
            $res1 = mysqli_query($con, $sql);
            $row1 = mysqli_fetch_array($res1);

            if(!isset($devsWorkedTime[$devID])){
                $devsWorkedTime[$devID] = seperateDateTime($row1['seconds'], $hoursPerDay);
                $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $devsWorkedTime[$devID], $hoursPerDay);
            }
            else{
                $current = seperateDateTime($row1['seconds'], $hoursPerDay);
                $devsWorkedTime[$devID] = addTwoSeperatedDateTime($devsWorkedTime[$devID], $current, $hoursPerDay);
                $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $current, $hoursPerDay);
            }

            $dateTime1 = $dateTime2 = "";
        }
    }
    if($dateTime1 != ""){ // Then the last record in the events table for this task is "in progress". 
        $sql = "SELECT TIMESTAMPDIFF(second, '$dateTime1', CURRENT_TIMESTAMP()) AS seconds";
        $res1 = mysqli_query($con, $sql);
        $row1 = mysqli_fetch_array($res1);

        if(!isset($devsWorkedTime[$devID])){
            $devsWorkedTime[$devID] = seperateDateTime($row1['seconds'], $hoursPerDay);
            $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $devsWorkedTime[$devID], $hoursPerDay);
        }
        else{
            $current = seperateDateTime($row1['seconds'], $hoursPerDay);
            $devsWorkedTime[$devID] = addTwoSeperatedDateTime($devsWorkedTime[$devID], $current, $hoursPerDay);
            $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, $current, $hoursPerDay);
        }
    }

    echo "<h3>Work Time per Developer:</h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Developer</th>";
    echo "<th>Total Time</th>";
    echo "</tr>";
    foreach($devsWorkedTime as $devID => $devWorkTime){
        $sql = "SELECT CONCAT(fname, ' ', lname) AS devName FROM Developers WHERE id = '".$devID."'";
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($res);
        $workTime = "";
        if($devWorkTime['days'] != 0) $workTime .= $devWorkTime['days']."d ";
        if($devWorkTime['hours'] != 0) $workTime .= $devWorkTime['hours']."h ";
        if($devWorkTime['minutes'] != 0) $workTime .= $devWorkTime['minutes']."m ";
        if($devWorkTime['seconds'] != 0) $workTime .= $devWorkTime['seconds']."s";
        echo "<tr>";
        echo "<td>".$row['devName']."</td>";
        echo "<td>".$workTime."</td>";
        echo "</tr>";
    }
    echo "</table>";

    $workTime = "";
    if($totalWorkedTime['days'] != 0) $workTime .= $totalWorkedTime['days']."d ";
    if($totalWorkedTime['hours'] != 0) $workTime .= $totalWorkedTime['hours']."h ";
    if($totalWorkedTime['minutes'] != 0) $workTime .= $totalWorkedTime['minutes']."m ";
    if($totalWorkedTime['seconds'] != 0) $workTime .= $totalWorkedTime['seconds']."s";
    echo "<h3>Total Time Worked: $workTime</h3>";
?>