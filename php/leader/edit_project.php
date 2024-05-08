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
    <title>Edit Project</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link rel = "stylesheet" href = "../../css/form.css">
</head>
<style>
    .container hr{
        border-bottom: 1px dotted;
        background-color: rgb(130, 106, 251);
        outline: none;
        border-radius: 100%;
        margin: 20px 0;
    }

    .container .form .column .txtEstimatedTime{
        width: 65px;
    }
</style>
<body>
    <section class="container">
        <header>Edit Project</header>
        <div class = "form" id = "contentProjectName"></div>
        <hr>
        <header>Add Task</header>
        <div class = "form" id = "contentAddNewTask"></div>
    </section>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../ajax_calls/edit_project_project_name.php',
                type: 'POST',
                async: true,
                data: {projectID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#contentProjectName").html(response);
                }
            });
            
            $.ajax({
                url: '../ajax_calls/edit_project_add_new_task.php',
                type: 'POST',
                async: true,
                data: {includeProject: 'false'},
                success: function(response){
                    $("#contentAddNewTask").html(response);
                }
            });
        });

        function btnConfirmName_clicked(){
            $("#feedbackProjectName").html('');
            var newProjectName = $("#txtProjectName").val().trim();
            if(newProjectName.length == 0)
            {
                $("#feedbackProjectName").html("Project Name can't be empty.");
                return;
            }

            $.ajax({
                url: '../ajax_calls/update_project_name.php',
                type: 'POST',
                async: true,
                data: {newProjectName: newProjectName, projectID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#feedbackProjectName").html(response);
                }
            });
        }

        function btnAddNewTask_clicked(){
            $("#feedbackAddNewTask").html('');
            var taskName = $("#txtTaskName").val().trim();
            var assignedDeveloper = $("#cboDevs_addNewTask").find('option:selected').attr("id").split("_")[3];
            var hours = $("#txtHours").val();
            var minutes = $("#txtMinutes").val();
            var seconds = $("#txtSeconds").val();

            if(taskName.length == 0){
                $("#feedbackAddNewTask").html('Task Name is required.');
                return;
            }

            $.ajax({
                url: '../ajax_calls/add_new_task.php',
                type: 'POST',
                async: true,
                data: {projectID: <?php echo $_GET['id']; ?>, assignedDeveloper: assignedDeveloper, taskName: taskName, hours: hours, minutes: minutes, seconds: seconds},
                success: function(response){
                    $("#feedbackAddNewTask").html(response);
                }
            });
        }
    </script>
</body>
</html>