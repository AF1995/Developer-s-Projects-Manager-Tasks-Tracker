<?php session_start();
    require '../connect.php';
    include '../common_functions.php';

    $search = isset($_POST['search']) ? cleanInput($_POST['search']) : "";

    $selectCompletedTasks = "SELECT developerID, COUNT(TasksEvents.id) AS completedTasks FROM TasksEvents WHERE statusID = '6' GROUP BY developerID ORDER BY developerID";
    $selectAllTasks = "SELECT assignedDeveloper, COUNT(Tasks.id) AS allTasks FROM Tasks GROUP BY assignedDeveloper ORDER BY assignedDeveloper";
    $sql = "SELECT Developers.id AS devID, CONCAT(fname, ' ', lname) AS devName, email, phone, selectAllTasks.allTasks AS allTasks, selectCompletedTasks.completedTasks AS completedTasks FROM Developers LEFT JOIN ($selectAllTasks) AS selectAllTasks ON Developers.id = selectAllTasks.assignedDeveloper LEFT JOIN ($selectCompletedTasks) AS selectCompletedTasks ON developerID = assignedDeveloper WHERE Developers.userID = '".$_SESSION['id']."'";
    if($search != "")
        $sql .= " AND (CONCAT(fname, ' ', lname) LIKE '%$search%' OR email LIKE '%$search%')";
    $res = mysqli_query($con, $sql);

    echo "<h3>Developers:</h3>";
    echo "<table>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Phone</th>";
    echo "<th>All Tasks</th>";
    echo "<th>Completed Tasks</th>";
    echo "<th>Actions</th>";
    echo "<th></th>";
    echo "</tr>";
    while($row = mysqli_fetch_array($res)){
        echo "<tr>";
        echo "<td id = 'displayDev_devName_".$row['devID']."'>".$row['devName']."</td>";
        echo "<td id = 'displayDev_email_".$row['devID']."'>".$row['email']."</td>";
        echo "<td id = 'displayDev_phone_".$row['devID']."'>".$row['phone']."</td>";
        echo "<td id = 'displayDev_allTasks_".$row['devID']."'>".$row['allTasks']."</td>";
        echo "<td id = 'displayDev_completedTasks_".$row['devID']."'>".$row['completedTasks']."</td>";
        echo "<td id = 'displayDev_actions_".$row['devID']."'>";
        echo "<a href = 'view_developer_tasks.php?id=".$row['devID']."'><img src = '../../images/check_tasks.png'></a>";
        echo "<img src = '../../images/fire_developer.png' onclick = 'imgFireDeveloper_clicked(".$row['devID'].")'>";
        echo "</td>";
        echo "<td id = 'displayDev_feedback_".$row['devID']."'></td>";
        echo "</tr>";
    }
    echo "</table>";
?>