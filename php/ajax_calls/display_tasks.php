<?php session_start();
    require '../connect.php';
    $sql = "SELECT LeaderViewTasks.devID AS devID, LeaderViewTasks.taskID, LeaderViewTasks.taskName AS taskName, LeaderViewTasks.projectName AS projectName, LeaderViewTasks.status AS status, LeaderViewTasks.devName AS devName FROM LeaderViewTasks LEFT JOIN Projects ON Projects.projectName = LeaderViewTasks.projectName LEFT JOIN Statuses ON Statuses.status = LeaderViewTasks.status WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);

    echo "<table>";
    echo "<tr>";
    echo "<th>Task Name</th>";
    echo "<th>Project Name</th>";
    echo "<th>Status</th>";
    echo "<th>Developer</th>";
    echo "<th>Actions</th>";
    echo "<th></th>";
    echo "</tr>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr>";
        echo "<td id = 'viewTasks_taskName_".$row['taskID']."'>".$row['taskName']."</td>";
        echo "<td id = 'viewTasks_projectName_".$row['taskID']."'>".$row['projectName']."</td>";
        echo "<td id = 'viewTasks_status_".$row['taskID']."'>".$row['status']."</td>";
        echo "<td id = 'viewTasks_devName_".$row['taskID']."'>".$row['devName']."</td>";
        echo "<td id = 'viewTasks_actions_".$row['taskID']."'>";
        echo "<a href = 'view_task.php?id=".$row['taskID']."'><img src = '../../images/view.png' alt = 'View Task'></a> ";
        echo "<a href = 'edit_task.php?id=".$row['taskID']."'><img src = '../../images/edit.png' alt = 'Edit Task'></a> ";
        
        if($row['status'] != "completed"){
            echo "<img src = '../../images/completed.png' alt = 'Mark Task as \"completed\"' onclick = 'imgSetTaskAsCompleted_clicked(".$row['taskID'].", ".$row['devID'].")'> ";
            if($row['status'] == "done")
                echo "<img src = '../../images/on_hold.png' alt = 'Mark Task as \"on hold\"' onclick = 'imgSetTaskAsOnHold_clicked(".$row['taskID'].", ".$row['devID'].")'> ";
        }
        echo "<img src = '../../images/archive.png' alt = 'Archive Task' onclick = 'imgArchiveTask_clicked(".$row['taskID'].")'";
        echo "</td>";
        echo "<td id = 'viewTasks_feedback_".$row['taskID']."'></td>";
        echo "</tr>";
    }
    echo "</table>";
?>