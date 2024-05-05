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
        #createNewTask{
            text-align: center;
            margin-bottom: 30px;
        }
        #filter{
            text-align: center;
        }
        #filter table{
            display: inline-block;
        }

        #tasks{
            text-align: center;
        }
        #tasks table{
            margin: auto;
        }
        #tasks img{
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
    </style>
    <div id = 'createNewTask'>
        <input type = "button" value = "Create New Task" onclick = "btnCreateNewTask_clicked()">
    </div>
    <div id = "filter">
        <h3>Filter:</h3>
        <table>
            <tr>
                <th>Active</th>
                <th>Filter By</th>
                <th>Filter Value</th>
            </tr>
            <tr>
                <td><input type = "checkbox" id = "chkTaskName" name = "chkTaskName" onchange = "triggerFilter()"></td>
                <td>Task name:</td>
                <td><input type = "text" id = "txtTaskName" onkeyup = "triggerFilter()"></td>
            </tr>
            <tr>
                <td><input type = "checkbox" id = "chkProjectName" onchange = "triggerFilter()"></td>
                <td>Project name:</td>
                <td><input type = "text" id = "txtProjectName" onkeyup = "triggerFilter()"></td>
            </tr>
            <tr>
                <td><input type = "checkbox" id = "chkStatus" onchange = "triggerFilter()"></td>
                <td>Status:</td>
                <td id = "filter_status"></td>
            </tr>
            <tr>
                <td><input type = "checkbox" id = "chkDeveloper" onchange = "triggerFilter()"></td>
                <td>Developer:</td>
                <td id = "filter_developer"></td>
            </tr>
        </table>
    </div>
    
    <div id = "tasks"></div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/tasks_dispaly_statuses.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $("#filter_status").html(response);
                }
            });

            $.ajax({
                url: '../ajax_calls/tasks_display_developers.php',
                type: 'POST',
                async: true,
                data: {},
                success: function(response){
                    $("#filter_developer").html(response);
                }
            });

            $.ajax({
                url: '../ajax_calls/display_tasks.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $("#tasks").html("<h3>Tasks:</h3>" + response);
                }
            });
        });

        function btnCreateNewTask_clicked(){
            window.location.href = "create_task.php";
        }

        function triggerFilter(){
            var isActive_taskName = $("#chkTaskName:checked").val() == "on";
            var isActive_projectName = $("#chkProjectName:checked").val() == "on";
            var isActive_status = $("#chkStatus:checked").val() == "on";
            var isActive_developer = $("#chkDeveloper:checked").val() == "on";
            
            if(!isActive_taskName && !isActive_status && !isActive_projectName && !isActive_developer){ // No active filters...
                $.ajax({
                    url: '../ajax_calls/display_tasks.php',
                    type: 'POST',
                    async: true,
                    success: function(response){
                        $("#tasks").html("<h3>Tasks:</h3>" + response);
                    }
                });
                return;
            }

            var taskName = $("#txtTaskName").val();
            var projectName = $("#txtProjectName").val();

            var statusesElements = $('.filter_status');
            var statuses = {};
            for(var i = 0; i < statusesElements.length; ++i)
                statuses[statusesElements[i].id] = statusesElements[i].checked;

            var developersElements = $('.filter_developer');
            var developers = {};
            for(var i = 0; i < developersElements.length; ++i)
                developers[developersElements[i].id] = developersElements[i].checked;

            $.ajax({
                url: '../ajax_calls/filter_tasks.php',
                type: 'POST',
                async: true,
                data: {isActive_taskName: isActive_taskName, isActive_projectName: isActive_projectName, isActive_status: isActive_status, isActive_developer: isActive_developer, taskName: taskName, projectName: projectName, statuses: JSON.stringify(statuses), developers: JSON.stringify(developers)},
                success: function(response){
                    $("#tasks").html("<h3>Tasks:</h3>" + response);
                }
            });
        }

        function imgSetTaskAsCompleted_clicked(taskID, devID){
            if(!devID)
                devID = 0;
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: "6", devID: devID},
                success: function(response){
                    if(response == "done")
                        triggerFilter();
                }
            });
        }

        function imgSetTaskAsOnHold_clicked(taskID, devID){
            if(!devID)
                devID = 0;
            $.ajax({
                url: '../ajax_calls/update_task_status.php',
                type: 'POST',
                async: true,
                data: {taskID: taskID, statusID: "3", devID: devID},
                success: function(response){
                    if(response == "done")
                        triggerFilter();
                }
            });
        }

        function imgArchiveTask_clicked(taskID){
            $.ajax({
                url: '../ajax_calls/archive_record.php',
                type: 'POST',
                async: true,
                data: {tableName: "Tasks", id: taskID},
                success: function(response){
                    $('#viewTasks_feedback_' + taskID).html(response);
                    $('#viewTasks_actions_' + taskID).html("...");
                }
            });
        }
    </script>
</body>
</html>