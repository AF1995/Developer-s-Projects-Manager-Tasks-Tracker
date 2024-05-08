<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';

    $sql = "SELECT id, projectName FROM Projects WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);

    echo "<div class = 'input-box'>";
    echo "<label for = 'txtTaskName'>Task Name</label> ";
    echo "<input type = 'text' placeholder = 'Enter task name' id = 'txtTaskName'>";
    echo "</div>";

    if($_POST['includeProject'] == "true")
    {
        echo "<div class = 'input-box'>";
        echo "<label>Project</label> ";
        echo "<div class = 'column'>";
        echo "<div class = 'select-box'>";
        echo "<select id = 'cboProjects_addNewTask'>";
        while($row = mysqli_fetch_array($res)){
            echo "<option id = 'cboProjects_addNewTask_option_".$row['id']."'>";
            echo $row['projectName'];
            echo "</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    $sql = "SELECT id, CONCAT(fname, ' ', lname) as devName FROM Developers WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);
    
    
    echo "<div class = 'input-box'>";
    echo "<label>Developer</label> ";
    echo "<div class = 'column'>";
    echo "<div class = 'select-box'>";
    echo "<select id = 'cboDevs_addNewTask'>";
    echo "<option selected id = 'cboDevs_addNewTask_option_0'>None</option>";
    while($row = mysqli_fetch_array($res)){
        echo "<option id = 'cboDevs_addNewTask_option_".$row['id']."'>";
        echo $row['devName'];
        echo "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "</div>";
    echo "</div>";


    echo "<div class = 'column'>";
    echo "<div class = 'input-box'>";
    echo "<label>Estimated Time</label>";
    echo "</div>";
    echo "<div class = 'input-box'>";
    echo "<label for = 'txtHours'><input type = 'text' class = 'txtEstimatedTime' maxlength = '3' placeholder = '0' id = 'txtHours'> hour/s</label>";
    echo "</div>";
    echo "<div class = 'input-box'>";
    echo "<label for = 'txtMinutes'><input type = 'text' class = 'txtEstimatedTime' maxlength = '2' placeholder = '0' id = 'txtMinutes'> minute/s</label>";
    echo "</div>";
    echo "<div class = 'input-box'>";
    echo "<label for = 'txtSeconds'><input type = 'text' class = 'txtEstimatedTime' maxlength = '2' placeholder = '0' id = 'txtSeconds'> second/s</label>";
    echo "</div>";
    echo "</div>";

    echo "<button onclick = 'btnAddNewTask_clicked()'>Add New Task</button>";

    echo "<p id = 'feedbackAddNewTask'></p>";
?>