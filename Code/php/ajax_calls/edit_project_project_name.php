<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';

    $projectID = $_POST['projectID'];
    $sql = "SELECT projectName FROM Projects WHERE id = '$projectID'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    $projectName = $row["projectName"];

    echo "<div class = 'input-box'>";
    echo "<label for = 'txtProjectName'>Project Name</label> ";
    echo "<input type = 'text' value = '$projectName' placeholder = 'Enter project name' id = 'txtProjectName'>";
    echo "</div>";

    echo "<button onclick = 'btnConfirmName_clicked()'>Confirm Name</button>";

    echo "<p id = 'feedbackProjectName'></p>";
?>