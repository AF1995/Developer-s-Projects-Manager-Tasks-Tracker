<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developers</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <style>
        #searchOrCreateDev, #developers{
            text-align: center;
        }
        #developers table{
            display: inline-block;
        }
        #developers table img{
            width: 25px;
            height: 25px;
            cursor: pointer;
        } 
    </style>

    <div id = "searchOrCreateDev">
        <label for = "txtSearch">Search: </label><input type = "text" id = "txtSearch" onkeyup = "txtSearch_keyUp()">
        <input type = 'button' value = "Create a New Developer Account" onclick = "btnCreateANewDeveloperAccount_clicked()">
    </div>

    <div id = "developers"></div>

    <script>
        $(document).ready(function(){
            $.ajax({
                url: '../ajax_calls/display_developers.php',
                type: 'POST',
                async: true,
                success: function(response){
                    $("#developers").html(response);
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
                        $("#developers").html(response);
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
                    $("#developers").html(response);
                }
            });
        }

        function btnCreateANewDeveloperAccount_clicked(){
            window.location.href = "create_developer.php";
        }
    </script>
</body>
</html>