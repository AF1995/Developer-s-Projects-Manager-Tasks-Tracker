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
    <title>Tasks</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel = "stylesheet" href = "../../css/table.css?time=<?php echo "0"; ?>">
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        font-family: 'Poppins', sans-serif;
    }
    
    #filter h1{
        text-align: center;
    }
    #filter table{
        border: 1px solid rgba(132, 147, 165, .2);
        padding: 20px 10px;
        border-radius: 10px;
    }
    #filter table thead tr th{
        border-bottom: 1px solid #8493a5;
    }
    #filter table tr td{
        vertical-align: top;
        padding: 10px;
    }
    #filter table tr th{
        padding: 10px;
    }
    #filter table tr td:first-child{
        text-align: center;
    }
    #filter table tr td:last-child{
        vertical-align: inherit;
    }
    #filter table tr td:nth-child(2){
        text-align: right;
    }
    #filter table input{
        padding: 6px 12px;
        margin: 0 10p;
        outline: none;
        border: 1px solid #0298cf;
        border-radius: 6px;
        color: #0298cf;
    }
    [type|="checkbox"]{
        width: 16px;
        height: 16px;
    }
</style>
<body>    
    <div>
        <div class = "table_header">
            <p class = "table_title">Tasks</p>
            <div id = "filter">
                <h1>Filter</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Active</th>
                            <th>Filter By</th>
                            <th>Filter Value</th>
                        </tr>
                    </thead>
                    <tbody>
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
                    <tbody>
                </table>
            </div>
            <div class = "table_button">
                <button class = "create_new_task" onclick = "btnCreateNewTask_clicked()">Create New Task</button>
            </div>
        </div>
        <div class = "table_section"></div>
    </div>

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
                    $(".table_section").html(response);
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
                        $(".table_section").html(response);
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
                    $(".table_section").html(response);
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