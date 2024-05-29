
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
    <title>View Task</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link rel = "stylesheet" href = "../../css/table.css?refresh=<?php echo "0"; ?>">
</head>
<style>
    .table_header{
        justify-content: center;
        font-size: 16;
    }
    #task_general_info{
        text-align: center;
        font-weight: 600;
        padding: 20px;
        background: #f6f9fc;
        color: #8493a5;
    }
</style>
<body>
    <p id = "task_general_info">
        <span id = "taskNameAndDate"></span> - <span id = "totalWorkTime"></span>
    </p>
    
    <div>
        <div class = "table_header">
            <p>Events</p>
        </div>
        <div class = "table_section tasksEvents"></div>
    </div>

    <div>
        <div class = "table_header">
            <p>Work Time per Developer</p>
        </div>
        <div class = "table_section workTime"></div>
    </div>
    
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
                    $(".tasksEvents").html(response);
                }
            });

            $.ajax({
                url: '../ajax_calls/view_task_work_time.php',
                type: "POST",
                async: true,
                data: {taskID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $(".workTime").html(response.split("-")[0]);
                    $("#totalWorkTime").html(response.split("-")[1]);
                }
            });
        });
    </script>
</body>
</html>