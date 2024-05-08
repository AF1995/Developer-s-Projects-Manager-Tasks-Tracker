<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    $sql = "SELECT LeaderViewTasks.devID AS devID, LeaderViewTasks.taskID, LeaderViewTasks.taskName AS taskName, LeaderViewTasks.projectName AS projectName, LeaderViewTasks.status AS status, LeaderViewTasks.devName AS devName FROM LeaderViewTasks LEFT JOIN Projects ON Projects.projectName = LeaderViewTasks.projectName LEFT JOIN Statuses ON Statuses.status = LeaderViewTasks.status WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);

    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Task Name</th>";
    echo "<th>Project Name</th>";
    echo "<th>Status</th>";
    echo "<th>Developer</th>";
    echo "<th>Actions</th>";
    echo "<th>Feedback</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr>";
        echo "<td id = 'viewTasks_taskName_".$row['taskID']."'>".$row['taskName']."</td>";
        echo "<td id = 'viewTasks_projectName_".$row['taskID']."'>".$row['projectName']."</td>";
        echo "<td id = 'viewTasks_status_".$row['taskID']."'>".$row['status']."</td>";
        echo "<td id = 'viewTasks_devName_".$row['taskID']."'>".$row['devName']."</td>";
        echo "<td id = 'viewTasks_actions_".$row['taskID']."'>";
        echo "<a href = 'view_task.php?id=".$row['taskID']."'><button style = 'background-color: #34568B;'><i class='bx bx-show'></i></button></a> ";
        echo "<a href = 'edit_task.php?id=".$row['taskID']."'><button style = 'background-color: #0298cf;'><i class='bx bx-edit' ></i></button></a> ";
        
        if($row['status'] != "completed"){
            echo "<button style = 'background-color: #88B04B;'><i class='bx bx-check-square' onclick = 'imgSetTaskAsCompleted_clicked(".$row['taskID'].", ".$row['devID'].")'></i></button> ";
            if($row['status'] == "done")
                echo "<button style = 'background-color: #EFC050;'><i class='bx bx-pause-circle' onclick = 'imgSetTaskAsOnHold_clicked(".$row['taskID'].", ".$row['devID'].")'></i></button> ";                
        }
        echo "<button style = 'background-color: #DD4124;'><i class='bx bxs-file-archive' onclick = 'imgArchiveTask_clicked(".$row['taskID'].")'></i></button>";
        echo "</td>";
        echo "<td id = 'viewTasks_feedback_".$row['taskID']."'></td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
?>