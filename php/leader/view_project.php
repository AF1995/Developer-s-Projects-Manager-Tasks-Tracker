<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id = "content"></div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/view_project.php',
                type: 'POST',
                async: true,
                data: {projectID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $("#content").html(response);
                }
            });
        });
    </script>
</body>
</html>