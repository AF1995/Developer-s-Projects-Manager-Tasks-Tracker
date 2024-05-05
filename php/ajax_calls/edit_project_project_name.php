<?php require '../connect.php';
    $projectID = $_POST['projectID'];
    $sql = "SELECT projectName FROM Projects WHERE id = '$projectID'";
    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($res);
    $projectName = $row["projectName"];

    echo "Project Name: <Input type = 'text' value = '$projectName' id = 'txtProjectName'> <input type = 'button' value = 'Confirm Name' onclick = 'btnConfirmName_clicked()'> <p id = 'feedbackProjectName'></p>";
?>