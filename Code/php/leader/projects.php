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
    <title>Projects</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel = "stylesheet" href = "../../css/table.css?refresh=<?php echo "0"; ?>">
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
</style>
<body>

    <div class = "projects_table">
        <div class = "table_header">
            <p>Projects</p>
            <p id = "feedback"></p>
            <div>
                <input type = "text" placeholder = "Search / Create" id = "txtSearch">
                <button onclick = "btnCreateProject_clicked()">Create Project</button>
            </div>
        </div>
        <div class = "table_section"></div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../ajax_calls/display_projects.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $(".table_section").html(response);
                }
            });
        });

        $('#txtSearch').keyup(function(){
            var filter = $("#txtSearch").val().trim();

            if(filter.length == 0)
                $.ajax({
                    url: '../ajax_calls/display_projects.php',
                    type: 'POST',
                    async: true,
                    success: function(response){
                        $(".table_section").html(response);
                    }
                });

            $.ajax({
                url: '../ajax_calls/filter_projects.php',
                type: 'POST',
                async: true,
                data: {filter: filter},
                success: function (response){
                    $(".table_section").html(response);
                } 
            });
        });

        function btnCreateProject_clicked(){
            $("#feedback").html("");

            var newProjectName = $("#txtSearch").val().trim();

            if(newProjectName.length == 0){
                $("#feedback").html("No project name was given");
                return;
            }

            $.ajax({
                url: '../ajax_calls/add_new_project.php',
                type: 'POST',
                async: true,
                data: {projectName: newProjectName},
                success: function (response){
                    $("#feedback").html(response);

                    $.ajax({
                        url: '../ajax_calls/display_projects.php',
                        type: 'POST',
                        async: true,
                        success: function(response){
                            $("table_section").html(response);
                        }
                    });
                }
            });
        }

        function imgArchiveProject_clicked(projectID){
            $.ajax({
                url: '../ajax_calls/archive_record.php',
                type: 'POST',
                async: true,
                data: {tableName: "Projects", id: projectID},
                success: function(response){
                    $('#viewProjects_feedback_' + projectID).html(response);
                    $('#viewProjects_actions_' + projectID).html("...");
                }
            });
        }
    </script>
</body>
</html>