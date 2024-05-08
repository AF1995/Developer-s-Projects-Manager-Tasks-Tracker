<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    $projectID = $_POST['projectID'];

    $sql = "SELECT Tasks.id as taskID, taskName, CONCAT(fname, ' ', lname) AS devName FROM Tasks LEFT JOIN Developers ON assignedDeveloper = Developers.id WHERE projectID = '$projectID'";
    $res = mysqli_query($con, $sql);

    $sql = "SELECT id, CONCAT(fname, ' ', lname) AS devName FROM Developers WHERE userID = '".$_SESSION['id']."'";
    $devs = mysqli_query($con, $sql);
    $devsData = array();
    $i = 0;

    while($dev = mysqli_fetch_array($devs)){
        $devsData[$i][0] = $dev['id'];
        $devsData[$i][1] = $dev['devName'];
        $i++;
    }

    echo "<table id = 'editTask'>";
    echo "<tr>";
    echo "<th>Task</th>";
    echo "<th>Developer</th>";
    echo "<th>Actions</th>";
    echo "<th></th>";
    echo "</tr>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr>";
        echo "<td id = 'editTasks_taskName_".$row['taskID']."'>".$row['taskName']."</td>";
        echo "<td id = 'editTasks_assignedDeveloper_".$row['taskID']."'>";
        echo "<select id = 'cboDevs_editTasks_".$row['taskID']."'>";
        echo "<option".($row['devName'] == null ? " selected" : "")." id = 'cboDevs_editTasks_option_0'>None</option>";
        foreach($devsData as $devData){
            echo "<option".($devData[1] == $row['devName'] ? " selected" : "")." id = 'cboDevs_editTasks_option_".$devData[0]."'>";
            echo $devData[1];
            echo "</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "<td id = 'editTasks_actions_".$row['taskID']."'><img src = '../../images/archive.png' alt = 'Archive project' id = 'editTasks_img_archive_".$row['taskID']."'></td>";
        echo "<td id = 'editTasks_feedback_".$row['taskID']."'></td>";
        echo "</tr>";
    }
    echo "</table>";
?>