<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
</head>
<body>
<style>
        #options{
            text-align: center;
        }
        .option{
            display: inline-block;
            border: 1px solid black;
            text-align: center;
            color: black;
            padding: 0;
            margin: 20px;
            width: 20%;
            height: 150px;
        }
        .option h3{
            border-bottom: dashed 1px black;
            margin: 0;
            padding: 10px;
        }
        .option p{
            margin: 0;
            padding: 10px;
        }
    </style>
    <div id = "options">
      <a href = "tasks.php"><div class = "option">
        <h3>Tasks</h3>
        <p>Manage your tasks.<br>Check your newly assigned tasks as well as the progress of your existing tasks along with the finished tasks.</p>
      </div></a>
      <a href = "statistics.php"><div class = "option">
        <h3>Statistics</h3>
        <p>See your overall statistics in this company. Details like total working time as well as per task and per project.</p>
      </div></a>
    </div>
</body>
</html>