<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    $taskID = $_POST['taskID'];
    $sql = "SELECT taskName, estimatedHours, estimatedMinutes, estimatedSeconds, projectID, assignedDeveloper, projectName, CONCAT(fname, ' ', lname) AS devName FROM Tasks LEFT JOIN Projects ON Projects.id = projectID LEFT JOIN Developers ON Developers.id = assignedDeveloper WHERE Tasks.id = '$taskID'";
    $resTasks = mysqli_query($con, $sql);
    $rowTasks = mysqli_fetch_array($resTasks);

    $hours = $rowTasks['estimatedHours'];
    $minutes = $rowTasks['estimatedMinutes'];
    $seconds = $rowTasks['estimatedSeconds'];

    echo "<div class = 'input-box'>";
    echo "<label for = 'txtTaskName'>Task Name</label> ";
    echo "<input type = 'text' value = '".$rowTasks['taskName']."' placeholder = 'Enter task name' id = 'txtTaskName'>";
    echo "</div>";

    echo "<div class = 'input-box'>";
    echo "<label>Project</label>";
    echo "<div class = 'column'>";
    echo "<div class = 'select-box'>";
    echo "<select id = 'cboProjets'>";
    $sql = "SELECT id, projectName FROM Projects WHERE userID = '".$_SESSION['id']."'";
    $resProjects = mysqli_query($con, $sql);
    while($rowProjects = mysqli_fetch_array($resProjects))
        echo "<option id = 'cboProjets_option_".$rowProjects['id']."'".($rowProjects['id'] == $rowTasks['projectID'] ? " selected" : "").">".$rowProjects['projectName']."</option>";
    echo "</select>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "<div class = 'input-box'>";
    echo "<label>Developer</label>";
    echo "<div class = 'column'>";
    echo "<div class = 'select-box'>";
    echo "<select id = 'cboDevelopers'>";
    $sql = "SELECT id, CONCAT(fname, ' ', lname) AS devName FROM Developers WHERE userID = '".$_SESSION['id']."'";
    $resDevelopers = mysqli_query($con, $sql);
    echo "<option id = 'cboDevelopers_option_0'".($rowTasks['assignedDeveloper'] == 'NULL' ? " selected" : "").">None</option>";
    while($rowDevelopers = mysqli_fetch_array($resDevelopers))
        echo "<option id = 'cboDevelopers_option_".$rowDevelopers['id']."'".($rowDevelopers['id'] == $rowTasks['assignedDeveloper'] ? " selected" : "").">".$rowDevelopers['devName']."</option>";
    echo "</select>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "<div class = 'column'>";
    echo "<div class = 'input-box'>";
    echo "<label>Estimated Time</label>";
    echo "</div>";
    echo "<div class = 'input-box'>";
    echo "<label><input type = 'text' class = 'txtEstimatedTime' maxlength = '3' placeholder = '$hours' id = 'txtEstimatedHours'> hour/s</label>";
    echo "</div>";
    echo "<div class = 'input-box'>";
    echo "<label><input type = 'text' class = 'txtEstimatedTime' maxlength = '2' placeholder = '$minutes' id = 'txtEstimatedMinutes'> minute/s</label>";
    echo "</div>";
    echo "<div class = 'input-box'>";
    echo "<label><input type = 'text' class = 'txtEstimatedTime' maxlength = '2' placeholder = '$seconds' id = 'txtEstimatedSeconds'> second/s</label>";
    echo "</div>";
    echo "</div>";
  
    echo "<button onclick = 'btnSave_clicked()'>Save</button>";

    echo "<p id = 'feedback'></p>";
?>