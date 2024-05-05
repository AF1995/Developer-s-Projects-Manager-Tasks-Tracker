<?php session_start();
    require '../connect.php';

    $sql = "SELECT id, projectName FROM Projects WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);

    echo "<div id = 'addNewTask'>";
    echo "Task Name: <input type = 'text' id = 'txtTaskName'> ";
    if($_POST['includeProject'] == "true")
    {
        echo "Project: ";
        echo "<select id = 'cboProjects_addNewTask'>";
        while($row = mysqli_fetch_array($res)){
            echo "<option id = 'cboProjects_addNewTask_option_".$row['id']."'>";
            echo $row['projectName'];
            echo "</option>";
        }
        echo "</select>";
    }

    $sql = "SELECT id, CONCAT(fname, ' ', lname) as devName FROM Developers WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);
    
    echo "Developer: ";
    echo "<select id = 'cboDevs_addNewTask'>";
    echo "<option selected id = 'cboDevs_addNewTask_option_0'>None</option>";
    while($row = mysqli_fetch_array($res)){
        echo "<option id = 'cboDevs_addNewTask_option_".$row['id']."'>";
        echo $row['devName'];
        echo "</option>";
    }
    echo "</select>";

    echo "<br>";
    echo "Estimated Time:";
    echo "<input type = 'text' maxlength = 3 id = 'txtHours'><label for = 'txtHours'> Hour/s</label> " ;
    echo "<input type = 'text' maxlength = 2 id = 'txtMinutes'><label for = 'txtMinutes'> Minutes/s</label> ";
    echo "<input type = 'text' maxlength = 2 id = 'txtSeconds'><label for = 'txtSeconds'> Seconds/s</label>";

    echo "<br>";
    echo "<input type = 'button' value = 'Add New Task' onclick = 'btnAddNewTask_clicked()'>";
    echo "<p id = 'feedbackAddNewTask'></p>";
    echo "</div>";
?>