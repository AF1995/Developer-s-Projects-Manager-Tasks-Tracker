<?php session_start();
    require '../connect.php';
    $sql = "SELECT id, CONCAT(fname, ' ', lname) AS devName FROM Developers WHERE userID = '".$_SESSION['id']."'";
    $res = mysqli_query($con, $sql);
    $output = "";
    while($row = mysqli_fetch_array($res)){
        $output .= "<input type = 'checkbox' class = 'filter_developer' id = 'filter_developer_".$row['id']."' onchange = 'triggerFilter()'>";
        $output .= "<label for = 'filter_developer_".$row['id']."'>".$row['devName']."</label>";
        $output .= "<br>";
    }
    echo $output;
?>