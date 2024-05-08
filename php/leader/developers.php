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
    <title>Developers</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel = "stylesheet" href = "../../css/table.css?refresh=<?php echo "0"; ?>">
</head>
<body>
    <div>
        <div class = "table_header">
            <p class = "table_title">Developers</p>
            <div>
                <input type = "text" id = "txtSearch" onkeyup = "txtSearch_keyUp()" placeholder = "Search">
                <button onclick = "btnAddNewDeveloper_clicked()">Add New</button>
            </div>
        </div>
        <div class = "table_section developers"></div>
    </div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/display_developers.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $(".developers").html(response);
                }
            });
        });

        function imgFireDeveloper_clicked(devID){
            $.ajax({
                url: '../ajax_calls/archive_record.php',
                type: 'POST',
                async: true,
                data: {tableName: "Developers", id: devID},
                success: function(response){
                    $("#displayDev_feedback_" + devID).html(response);
                    $("#displayDev_actions_" + devID).html("...");
                }
            });
        }

        function txtSearch_keyUp(){
            var search = $("#txtSearch").val()
            if(search.length == 0){
                $.ajax({
                    url: '../ajax_calls/display_developers.php',
                    type: 'POST',
                    async: true,
                    success: function(response){
                        $(".developers").html(response);
                    }
                });
                return;
            }

            $.ajax({
                url: '../ajax_calls/display_developers.php',
                type: 'POST',
                async: true,
                data: {search: search},
                success: function(response){
                    $(".developers").html(response);
                }
            });
        }

        function btnAddNewDeveloper_clicked(){
            window.location.href = "create_developer.php";
        }
    </script>
</body>
</html>