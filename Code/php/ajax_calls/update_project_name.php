<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    include '../common_functions.php';

    $projectID = $_POST['projectID'];
    $newProjectName = $_POST['newProjectName'];

    $newProjectName = removeExtraWhitespaces($newProjectName);

    foreach(str_split($newProjectName) as $char)
        if(!isAlphaNumericOrSpace($char))
           die("Alpha-numerical characters and spaces only.");

    $sql = "SELECT projectName FROM Projects WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($res))
        if($row['projectName'] == $newProjectName)
            die("The name '$newProjectName' already exists. Consider using another name.");

    $sql = "UPDATE Projects SET projectName = '$newProjectName' WHERE id = '$projectID'";
    mysqli_query($con, $sql) or die("Something went wrong when changing Project's Name.");
    echo "Succefully changed projet's name to '$newProjectName'.";
?>