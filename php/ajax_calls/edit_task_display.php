<?php session_start();
    require '../connect.php';
    $taskID = $_POST['taskID'];
    $sql = "SELECT taskName, projectID, assignedDeveloper, projectName, CONCAT(fname, ' ', lname) AS devName FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN Developers ON Developers.id = assignedDeveloper WHERE Tasks.id = '$taskID'";
    $resTasks = mysqli_query($con, $sql);
    $rowTasks = mysqli_fetch_array($resTasks);

    echo "<table>";
    echo "<tr>";
    echo "<td>Task Name:</td>";
    echo "<td><input type = 'text' value = '".$rowTasks['taskName']."' id = 'txtTaskName'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Projects: </td>";
    echo "<td>";
    echo "<select id = 'cboProjets'>";
    $sql = "SELECT id, projectName FROM Projects WHERE userID = '".$_SESSION['id']."'";
    $resProjects = mysqli_query($con, $sql);
    while($rowProjects = mysqli_fetch_array($resProjects))
        echo "<option id = 'cboProjets_option_".$rowProjects['id']."'".($rowProjects['id'] == $rowTasks['projectID'] ? " selected" : "").">".$rowProjects['projectName']."</option>";
    echo "</select>";
    echo "<td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Developer: </td>";
    echo "<td>";
    echo "<select id = 'cboDevelopers'>";
    $sql = "SELECT id, CONCAT(fname, ' ', lname) AS devName FROM Developers WHERE userID = '".$_SESSION['id']."'";
    $resDevelopers = mysqli_query($con, $sql);
    echo "<option id = 'cboDevelopers_option_0'".($rowTasks['assignedDevelopers'] == 'NULL' ? " selected" : "").">None</option>";
    while($rowDevelopers = mysqli_fetch_array($resDevelopers))
        echo "<option id = 'cboDevelopers_option_".$rowDevelopers['id']."'".($rowDevelopers['id'] == $rowTasks['assignedDeveloper'] ? " selected" : "").">".$rowDevelopers['devName']."</option>";
    echo "</select>";
    echo "<td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td>Estimated Time: </td>";
    echo "<td>";
    echo "<input type = 'text' maxlength = '3' id = 'txtEstimatedHours'><label for = 'txtEstimatedHours'> hour/s</label> ";
    echo "<input type = 'text' maxlength = '2' id = 'txtEstimatedMinutes'><label for = 'txtEstimatedMinutes'> minute/s</label> ";
    echo "<input type = 'text' maxlength = '2' id = 'txtEstimatedSeconds'><label for = 'txtEstimatedSeconds'> second/s</label>";
    echo "</td>";
    echo "</tr>";
    echo "<tr><td></td><td><input type = 'button' value = 'Save' onclick = 'btnSave_clicked()'></td></tr>";
    echo "<tr><td colspan = 2 id = 'feedback'></td></tr>";
    echo "</table>";
?>