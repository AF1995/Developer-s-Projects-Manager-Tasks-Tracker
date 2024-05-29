<?php
    function taskWorkedTimeForDev($taskID, $devID){
        require 'connect.php';
        $sql = "SELECT statusID, eventDate, developerID, hoursPerDay FROM TasksEvents LEFT JOIN Developers ON Developers.id = developerID WHERE taskID = '$taskID'";
        $res = mysqli_query($con, $sql);
        $totalWorkedTime = array("days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0);
        $dateTime1 = "";
        $dateTime2 = "";
        $hoursPerDay = 24;
        while($row = mysqli_fetch_array($res)){
            $hoursPerDay = $row['hoursPerDay'];
            if($row['statusID'] == 4 && $devID == $row['developerID']){ // Status: "in progress"
                $dateTime1 = $row['eventDate'];
            }
            else if($dateTime1 != ""){
                $dateTime2 = $row['eventDate'];
            }

            if($dateTime1 != "" && $dateTime2 != ""){
                $sql = "SELECT TIMESTAMPDIFF(second, '$dateTime1', '$dateTime2') AS seconds";
                $res1 = mysqli_query($con, $sql);
                $row1 = mysqli_fetch_array($res1);
                
                $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, seperateDateTime($row1['seconds']), $hoursPerDay);

                $dateTime1 = $dateTime2 = "";
            }
        }
        if($dateTime1 != ""){ // Then the last record in the events table for this task is "in progress". 
            $sql = "SELECT TIMESTAMPDIFF(second, '$dateTime1', CURRENT_TIMESTAMP()) AS seconds";
            $res1 = mysqli_query($con, $sql);
            $row1 = mysqli_fetch_array($res1);

            $totalWorkedTime = addTwoSeperatedDateTime($totalWorkedTime, seperateDateTime($row1['seconds']), $hoursPerDay);
        }
        return $totalWorkedTime;
    }
?>