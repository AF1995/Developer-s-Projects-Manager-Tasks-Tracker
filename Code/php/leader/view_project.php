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
    <title>View Project</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link rel = "stylesheet" href = "../../css/table.css?refresh=<?php echo "0"; ?>">
</head>
<style>
    .table_header{
        justify-content: center;
    }
</style>
<body>
    <div>
        <div class = "table_header">
            <p class = "project_name"></p>
        </div>
        <div class = "table_section"></div>
    </div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/view_project.php',
                type: 'POST',
                async: true,
                data: {projectID: <?php echo $_GET['id']; ?>},
                success: function(response){
                    $(".project_name").html(response.split("-")[0])
                    $(".table_section").html(response.split("-")[1]);
                }
            });
        });
    </script>
</body>
</html>