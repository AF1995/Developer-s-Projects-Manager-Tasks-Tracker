<?php 
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != "developer")
        header("Location: ../login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    body{
        display: flex;
        justify-content: center;
        align-content: center;
        min-height: 100vh;
        background: #111;
    }

    h1{ 
        background-color: #03a9f4;
        color: #fff;
        padding: 10px 20px;
        margin: 20px 0 0 0;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom: 1px dotted #fff;
    }

    .list{
        position: relative;
        background: #fff;
        width: 100%;
        border-radius: 30px;
    }
    .list h2{
        background: #03a9f4;
        color: #fff;
        padding: 10px 20px;
        font-weight: 600;
    }
    .list ul{
        position: relative;
        padding: 20px;
    }
    .list ul li{
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;    
        list-style: none;
        padding: 15px 0;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }
    .list ul li:last-child{
        border: none;
    }
    .list ul li:hover{
        color: #03a9f4;
    }    
</style>
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

        function toggleVisibility(li){
            var arrow = $("#block_" + li.split("_")[1]).text();
            if(arrow == "▼"){
                $("." + li).css("display", "none");
                $("#block_" + li.split("_")[1]).text("▶");
            }
            else if(arrow == "▶"){
                $("." + li).css("display", "flex");
                $("#block_" + li.split("_")[1]).text("▼");
            }
        }
    </script>
</body>
</html>