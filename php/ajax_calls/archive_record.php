<?php require '../connect.php';
    $tableName = $_POST['tableName'];
    $id = $_POST['id'];

    // Collect all column names:
    $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName'";
    $res = mysqli_query($con, $sql);
    $columns = array();
    $i = 0;
    while($row = mysqli_fetch_array($res))
        $columns[$i++] = $row[3]; // $row[3] happens to contain the column name

    // Collect row data to be archived:
    $sql = "SELECT * FROM $tableName WHERE id = '$id'";
    $res = mysqli_query($con, $sql);
    $data = array();
    $i = 0;
    $row = mysqli_fetch_array($res);
    foreach($columns as $cell)
        $data[$i++] = $row[$cell];

    // Build json:
    $json = "";
    $i = 0;
    foreach($columns as $cell){
        if(gettype($data[$i]) == 'NULL')
            $json .= $cell.":NULL,";
        else
            $json .= $cell.':"'.$data[$i].'",';
        $i++;
    }
    $json = trim($json, ",");

    // Archive record:
    $sql = "INSERT INTO Archives(tableName, jsonData) VALUE('$tableName', '$json')";
    mysqli_query($con, $sql) or die("Something went wrong when adding record to archive.");
    $sql = "DELETE FROM $tableName WHERE id = '".$data[0]."'";
    mysqli_query($con, $sql) or die("Something went wrong when removing record from Tasks.");
    echo "Record archieved successfully.";
?>