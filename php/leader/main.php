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
      <a href = "projects.php"><div class = "option">
        <h3>Projects</h3>
        <p>Manage your projects.<br>Create - Edit - Archive.</p>
      </div></a>
      <a href = "tasks.php"><div class = "option">
        <h3>Tasks</h3>
        <p>Manage your tasks.<br>See which tasks are assigned to who and check track their progress.<br>Create - Edit - Archive.</p>
      </div></a>
      <a href = "developers.php"><div class = "option">
        <h3>Developers</h3>
        <p>Check your own developers.<br>See how their tasks are distributed.</p>
      </div></a>
    </div>
</body>
</html>