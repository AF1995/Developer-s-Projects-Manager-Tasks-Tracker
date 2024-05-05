<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id = "content"></div>
    
    <script>
        $.ajax({
            url: '../ajax_calls/display_statistics.php',
            type: 'POST',
            asyc: true,
            success: function(response){
                $("#content").html(response);
            }
        });
    </script>
</body>
</html>