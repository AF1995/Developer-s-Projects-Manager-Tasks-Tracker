<?php 
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != "developer")
        header("Location: ../login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel = "stylesheet" href = "../../css/table.css?refresh=<?php echo "0"; ?>">
</head>
<body>
    <div>
        <div class = "table_header">
            <p class = "table_title">Assigned Tasks</p>
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
        $(document).ready(function (){
            $.ajax({
                url: '../ajax_calls/developer_view_my_tasks.php',
                type: 'POST',
                async: true,
                success: function(response){
                    response = JSON.parse(response);
                    $(".assigned").html(response['assigned']);
                    $(".current").html(response['current']);
                    $(".done").html(response['done']);
                    $(".completed").html(response['completed']);
                }
            });
        });

        function imgStartTask_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: '4', devID: <?php echo $_SESSION['id']; ?>},
                success: function (response){
                    $.ajax({
                        url: '../ajax_calls/developer_view_my_tasks.php',
                        type: 'POST',
                        async: true,
                        success: function(response){
                            response = JSON.parse(response);
                            $(".assigned").html(response['assigned']);
                            $(".current").html(response['current']);
                            $(".done").html(response['done']);
                            $(".completed").html(response['completed']);
                        }
                    });
                }
            });
        }

        function imgPauseTask_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: '3', devID: <?php echo $_SESSION['id']; ?>},
                success: function (response){
                    $.ajax({
                        url: '../ajax_calls/developer_view_my_tasks.php',
                        type: 'POST',
                        async: true,
                        success: function(response){
                            response = JSON.parse(response);
                            $(".assigned").html(response['assigned']);
                            $(".current").html(response['current']);
                            $(".done").html(response['done']);
                            $(".completed").html(response['completed']);
                        }
                    });
                }
            });
        }

        function imgResume_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: '4', devID: <?php echo $_SESSION['id']; ?>},
                success: function (response){
                    $.ajax({
                        url: '../ajax_calls/developer_view_my_tasks.php',
                        type: 'POST',
                        async: true,
                        success: function(response){
                            response = JSON.parse(response);
                            $(".assigned").html(response['assigned']);
                            $(".current").html(response['current']);
                            $(".done").html(response['done']);
                            $(".completed").html(response['completed']);
                        }
                    });
                }
            });
        }

        function imgDone_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: '5', devID: <?php echo $_SESSION['id']; ?>},
                success: function (response){
                    $.ajax({
                        url: '../ajax_calls/developer_view_my_tasks.php',
                        type: 'POST',
                        async: true,
                        success: function(response){
                            response = JSON.parse(response);
                            $(".assigned").html(response['assigned']);
                            $(".current").html(response['current']);
                            $(".done").html(response['done']);
                            $(".completed").html(response['completed']);
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>