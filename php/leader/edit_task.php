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
    <title>Edit Task</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link rel = "stylesheet" href = "../../css/form.css">
</head>
<style>
    .container .form .column .txtEstimatedTime{
        width: 65px;
    }
</style>
<body>
    <section class="container">
        <header>Edit Task</header>
        <div class = "form" id = "editTask"></div>
    </section>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/edit_task_display.php',
                type: 'POST',
                async: true,
                data: {taskID: <?php echo $_GET['id'] ?>},
                success: function(response){
                    $("#editTask").html(response);
                }
            });
        });

        function btnSave_clicked(){
            var taskName = $("#txtTaskName").val().trim();
            var projectID = $("#cboProjets").find('option:selected').attr("id").split("_")[2];
            var developerID = $("#cboDevelopers").find('option:selected').attr("id").split("_")[2];
            var estimatedHours = $("#txtEstimatedHours").val();
            var estimatedMinutes = $("#txtEstimatedMinutes").val();
            var estimatedSeconds = $("#txtEstimatedSeconds").val();

            if(taskName.length == 0){
                $("#feedback").html("Task Name can't be empty");
                $("#txtTaskName").focus();
                return;
            }

            $.ajax({
                url: '../ajax_calls/edit_task.php',
                type: 'POST',
                async: true,
                data: {taskID: <?php echo $_GET['id'] ?>, taskName: taskName, projectID: projectID, developerID: developerID, estimatedHours: estimatedHours, estimatedMinutes: estimatedMinutes, estimatedSeconds: estimatedSeconds},
                success: function(response){
                    $("#feedback").html(response);
                }
            });
        }
    </script>
</body>
</html>