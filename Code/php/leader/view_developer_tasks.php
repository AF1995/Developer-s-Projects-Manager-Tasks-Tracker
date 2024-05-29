<?php 
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != "leader")
        header("Location: ../login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Developer's Tasks</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel = "stylesheet" href = "../../css/table.css?refresh=<?php echo "0"; ?>">
</head>
<style>
    .table_header{
        justify-content: center;
    }
    #nameAndWorkTime{
        text-align: center;
        font-weight: 600;
        padding: 20px;
        background: #f6f9fc;
        color: #8493a5;
    }
</style>
<body>
    <div id = "nameAndWorkTime"></div>

    <div>
        <div class = "table_header">
            <p class = "table_title">New Tasks</p>
        </div>
        <div class = "table_section assigned"></div>
    </div>

    <div>
        <div class = "table_header">
            <p class = "table_title">Current Tasks</p>
        </div>
        <div class = "table_section current"></div>
    </div>

    <div>
        <div class = "table_header">
            <p class = "table_title">Done Tasks</p>
        </div>
        <div class = "table_section done"></div>
    </div>

    <div>
        <div class = "table_header">
            <p class = "table_title">Completed Tasks</p>
        </div>
        <div class = "table_section completed"></div>
    </div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/view_developer_tasks.php',
                type: 'POST',
                async: true,
                data: {devID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    response = JSON.parse(response);
                    $("#nameAndWorkTime").html(response["nameTime"]);
                    $(".assigned").html(response["assigned"]);
                    $(".current").html(response["current"]);
                    $(".done").html(response["done"]);
                    $(".completed").html(response["completed"]);
                }
            });
        });

        function imgMarkAsCompleted_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: '6', devID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $.ajax({
                        url: '../ajax_calls/view_developer_tasks.php',
                        type: 'POST',
                        async: true,
                        data: {devID: <?php echo $_GET['id']; ?>},
                        success: function(response){
                            response = JSON.parse(response);
                            $("#nameAndWorkTime").html(response["nameTime"]);
                            $(".assigned").html(response["assigned"]);
                            $(".current").html(response["current"]);
                            $(".done").html(response["done"]);
                            $(".completed").html(response["completed"]);
                        }
                    });
                }
            });
        }

        function imgMarkAsOnHold_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: '3', devID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $.ajax({
                        url: '../ajax_calls/view_developer_tasks.php',
                        type: 'POST',
                        async: true,
                        data: {devID: <?php echo $_GET['id']; ?>},
                        success: function(response){
                            response = JSON.parse(response);
                            $("#nameAndWorkTime").html(response["nameTime"]);
                            $(".assigned").html(response["assigned"]);
                            $(".current").html(response["current"]);
                            $(".done").html(response["done"]);
                            $(".completed").html(response["completed"]);
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>