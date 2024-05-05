<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <style>
        #search{
            text-align: center;
            margin-bottom: 30px;
        }

        #projects{
            text-align: center;
        }
        #projects table{
            margin: auto;
        }
        #projects img{
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
    </style>

    <div id = "search">
        Search: <input type = "text" id = "txtSearch">
        <input type = "button" value = "Create Project" onclick = "btnCreateProject_clicked()">
        <p id = "feedback"></p>
    </div>

    <div id = "projects"></div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../ajax_calls/display_projects.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $("#projects").html(response);
                    img_archive_addEvent();
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
                        $("#projects").html(response);
                        img_archive_addEvent();
                    }
                });

            $.ajax({
                url: '../ajax_calls/filter_projects.php',
                type: 'POST',
                async: true,
                data: {filter: filter},
                success: function (response){
                    $("#projects").html(response);
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
                            $("#projects").html(response);
                            img_archive_addEvent();
                        }
                    });
                }
            });
        }

        function img_archive_addEvent(){
            $("#projects table img").on( "click", function() {
                if(!($(this).attr('id').startsWith("projects_img_archive_")))
                    return;
                var projectID = $(this).attr('id').split('_')[3];
                
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
            });
        }
    </script>
</body>
</html>