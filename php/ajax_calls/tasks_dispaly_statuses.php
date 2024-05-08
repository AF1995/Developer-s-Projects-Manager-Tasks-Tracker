<?php session_start();
    if(!isset($_SESSION['role'])) return;
    
    require '../connect.php';
    $sql = "SELECT id, status FROM Statuses";
    $res = mysqli_query($con, $sql);
    $output = "";
    while($row = mysqli_fetch_array($res)){
        $output .= "<input type = 'checkbox' class = 'filter_status' id = 'filter_status_".$row['id']."' onchange = 'triggerFilter()'>";
        $output .= "<label for = 'filter_status_".$row['id']."'> ".$row['status']."</label>";
        $output .= "<br>";
    }
    echo $output;
?>