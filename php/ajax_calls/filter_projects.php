<?php session_start();
    require '../connect.php';
    include '../common_functions.php';
    $filter = $_POST['filter'];
    
    echo "<table>";
    echo "<tr>";
    echo "<th>Project Name</th>";
    echo "<th>Number of Tasks</th>";
    echo "<th>Number of Envolved Developers</th>";
    echo "<th>Actions</th>";
    echo "<th></th>";
    echo "</tr>";
    foreach(str_split($filter) as $char)
        if(!isAlphaNumericOrSpace($char))
            die("</table>");
    
    $projectsData = array();
    $i = 0;
    $assignedDevs = array();
    
    $sql = "SELECT id, projectName FROM Projects WHERE projectName LIKE '%$filter%' AND userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($res)){
        $sql = "SELECT COUNT(id) as countID FROM Tasks WHERE projectID = '".$row['id']."'";
        $res2 = mysqli_query($con, $sql);
        $sql = "SELECT DISTINCT assignedDeveloper FROM Tasks WHERE projectID = '".$row['id']."'";
        $res3 = mysqli_query($con, $sql);
        $row2 = mysqli_fetch_array($res2);
        $projectsData[$i][0] = $row['projectName'];
        $projectsData[$i][1] = $row2['countID'];
        $projectsData[$i][2] = mysqli_num_rows($res3);
        $projectsData[$i][3] = $row['id'];
        $i++;
    }
    
    foreach($projectsData as $projectData){
        echo "<tr>";
        echo "<td id = 'viewProjects_projectName_".$projectData[3]."'>".$projectData[0]."</td>";
        echo "<td id = 'viewProjects_numberOfTasks_".$projectData[3]."'>".$projectData[1]."</td>";
        echo "<td id = 'viewProjects_numberOfEnvolvedDevelopers_".$projectData[3]."'>".$projectData[2]."</td>";
        echo "<td id = 'viewProjects_actions_".$projectData[3]."'><a href = 'view_project.php?id=".$projectData[3]."'><img src = '../../images/view.png' alt = 'View project'></a> <a href = 'edit_project.php?id=".$projectData[3]."'><img src = '../../images/edit.png' alt = 'Edit project'></a><img src = '../../images/archive.png' alt = 'Archive project' id = 'projects_img_archive_".$projectData[3]."'></td>";
        echo "<td id = 'viewProjects_feedback_".$projectData[3]."'></td>";
        echo "</tr>";
    }
    echo "</table>";
?>