<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <style>
        #contentEditTasks table#editTask img{
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
    </style>

    <div id = "contentProjectName"></div>
    <div id = "contentAddNewTask"></div>
    <div id = "contentEditTasks"></div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../ajax_calls/edit_project_project_name.php',
                type: 'POST',
                async: true,
                data: {projectID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#contentProjectName").html(response + "<hr>");
                }
            });
            
            $.ajax({
                url: '../ajax_calls/edit_project_add_new_task.php',
                type: 'POST',
                async: true,
                data: {includeProject: 'false'},
                success: function(response){
                    $("#contentAddNewTask").html(response + "<hr>");
                }
            });

            $.ajax({
                url: '../ajax_calls/edit_project_edit_tasks.php',
                type: 'POST',
                async: true,
                data: {projectID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#contentEditTasks").html(response);
                    addNewTask_addEvents();
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

                    $.ajax({
                        url: '../ajax_calls/edit_project_edit_tasks.php',
                        type: 'POST',
                        async: true,
                        data: {projectID: <?php echo $_GET['id']; ?>},
                        success: function(response){
                            $("#contentEditTasks").html(response);
                            addNewTask_addEvents();
                        }
                    });
                }
            });
        }

        function addNewTask_addEvents(){
            $("#contentEditTasks select").on('change', function (e) {
                var valueSelected = this.value;
                var taskID = $(this).attr('id').split('_')[2];
                var newAssignedDeveloper = $(this).find('option:selected').attr("id").split("_")[3];

                $.ajax({
                    url: '../ajax_calls/update_assigned_developer.php',
                    type: 'POST',
                    async: true,
                    data: {taskID: taskID, newAssignedDeveloper: newAssignedDeveloper},
                    success: function (response){
                        $('#editTasks_feedback_' + taskID).html(response);
                    }
                });
            });

            $("#contentEditTasks table#editTask img").on( "click", function() {
                var taskID = $(this).attr('id').split('_')[3];
                
                $.ajax({
                    url: '../ajax_calls/archive_record.php',
                    type: 'POST',
                    async: true,
                    data: {tableName: "Tasks", id: taskID},
                    success: function(response){
                        $('#editTasks_feedback_' + taskID).html(response);
                        $('#editTasks_actions_' + taskID).html("...");
                        $('#editTasks_assignedDeveloper_' + taskID).html("...");
                    }
                });
            });
        }
    </script>
</body>
</html>