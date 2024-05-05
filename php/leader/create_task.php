<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id = "addTask"></div>
    
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/edit_project_add_new_task.php',
                type: 'POST',
                async: true,
                data: {includeProject: 'true'},
                success: function(response){
                    $("#addTask").html(response);
                }
            });
        });

        function btnAddNewTask_clicked(){
            $("#feedbackAddNewTask").html('');
            var projectID = $("#cboProjects_addNewTask").find('option:selected').attr("id").split("_")[3];
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
                data: {projectID: projectID, assignedDeveloper: assignedDeveloper, taskName: taskName, hours: hours, minutes: minutes, seconds: seconds},
                success: function(response){
                    $("#feedbackAddNewTask").html(response);
                }
            });
        }
    </script>
</body>
</html>