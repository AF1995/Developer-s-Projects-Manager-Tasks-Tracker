<?php require '../connect.php';
    $projectID = $_POST['projectID'];
    $sql = "SELECT projectName FROM Projects WHERE id = '$projectID'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    echo "<h2>".$row['projectName']."</h2>";

    $sql = "SELECT Tasks.taskName, CONCAT(Developers.fname, ' ', Developers.lname) as devName FROM Tasks, Developers WHERE projectID = '$projectID' AND Developers.id = assignedDeveloper";
    $res = mysqli_query($con, $sql);

    echo "<table>";
    echo "<tr>";
    echo "<th>Task</th>";
    echo "<th>Developer</th>";
    echo "</tr>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr>";
        echo "<td>".$row['taskName']."</td>";
        echo "<td>".$row['devName']."</td>";
        echo "</tr>";
    }
    echo "</table>";
?>