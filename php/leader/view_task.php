<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Task</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <h3 id = "taskNameAndDate"></h3>
    
    <div id = "tasksEvents"></div>

    <div id = "workTime"></div>
    
    <script>
        $(document).ready(function (){
            $.ajax({
                url: '../ajax_calls/view_task_name_and_date.php',
                type: "POST",
                async: true,
                data: {taskID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#taskNameAndDate").html(response);
                }
            });

            $.ajax({
                url: '../ajax_calls/view_task_tasks_events.php',
                type: "POST",
                async: true,
                data: {taskID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#tasksEvents").html("<h3>Events:</h3>" + response);
                }
            });

            $.ajax({
                url: '../ajax_calls/view_task_work_time.php',
                type: "POST",
                async: true,
                data: {taskID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#workTime").html(response);
                }
            });
        });
    </script>
</body>
</html>