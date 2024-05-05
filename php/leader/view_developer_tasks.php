<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Developer's Tasks</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <style>
        #nameAndWorkTime{
            text-align: center;
        }
        #nameAndWorkTime table{
            display: inline-block;
        }
        #nameAndWorkTime table img{
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
    </style>

    <div id = "nameAndWorkTime"></div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/view_developer_tasks.php',
                type: 'POST',
                async: true,
                data: {devID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#nameAndWorkTime").html(response);
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
                            $("#nameAndWorkTime").html(response);
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
                            $("#nameAndWorkTime").html(response);
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>