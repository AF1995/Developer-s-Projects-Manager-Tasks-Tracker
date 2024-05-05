<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>

    <style>
        #content table img{
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
    </style>

    <div id = "content"></div>

    <script>
        $(document).ready(function (){
            $.ajax({
                url: '../ajax_calls/developer_view_my_tasks.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $("#content").html(response);
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
                            $("#content").html(response);
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
                            $("#content").html(response);
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
                            $("#content").html(response);
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
                            $("#content").html(response);
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>