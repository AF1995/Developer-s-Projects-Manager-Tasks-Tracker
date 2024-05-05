<?php session_start();
    require '../connect.php';
    include '../common_functions.php';
    $projectName = $_POST['projectName'];

    // Project Name must only contain alpha-numerical characters and spaces:
    foreach(str_split($projectName) as $char)
        if(!isAlphaNumericOrSpace($char))
            die("'Project name' accepts alpha-numerical characters and spaces only.");

    // Project name can't exist:
    $sql = "SELECT projectName FROM Projects WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($res))
        if($row['projectName'] == $projectName)
            die("You already have a project with the name '$projectName'.");

    // Add the new project:
    $sql = "INSERT INTO Projects(projectName, userID) VALUES('$projectName', '".$_SESSION['id']."')";
    mysqli_query($con, $sql) or die("SOmethign went wrong while adding the new project.");
    echo "Successfully added the new project.";
?>