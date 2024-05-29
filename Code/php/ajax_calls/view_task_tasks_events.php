<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    $taskID = $_POST['taskID'];
    $sql = "SELECT Statuses.status AS status, DATE(eventDate) AS eventDate, TIME(eventDate) AS eventTime, CONCAT(fname, ' ', lname) AS devName FROM TasksEvents LEFT JOIN Developers ON Developers.id = developerID LEFT JOIN Statuses ON Statuses.id = statusID WHERE taskID = '$taskID'";
    $res = mysqli_query($con, $sql);

    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Status</th>";
    echo "<th>Date</th>";
    echo "<th>Time</th>";
    echo "<th>Developer</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr>";
        echo "<td>".$row['status']."</td>";
        echo "<td>".$row['eventDate']."</td>";
        echo "<td>".$row['eventTime']."</td>";
        echo "<td>".$row['devName']."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
?>