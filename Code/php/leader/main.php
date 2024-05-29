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
    <title>Main</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        *{
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: "Poppins", sans-seris;
        }
        body{
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
          background: #f7f7f7;
        }

        #content{
          position: relative;
          display: flex;
          flex-direction: column;
          gap: 30px;
        }
        #content .box{
          position: relative;
          width: 400px;
          height: 100px;
          background: #fff;
          transition: 0.5s ease-in-out;
          cursor: pointer;
          box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.025);
        }
        #content .box:nth-child(1){
          transform: translateX(-70px);
        }
        #content .box:nth-child(3){
          transform: translateX(70px);
        }
        #content:hover .box:nth-child(1), #content:hover .box:nth-child(3){
          transform: translateX(0);
        }
        #content .box::before{
          content: '';
          position: absolute;
          width: 6px;
          height: 100%;
          background: var(--clr);
          transition: 0.5s ease-in-out;
        }
        #content .box:hover::before{
          width: 100%;
        }
        #content .box .option{
          position: relative;
          display: flex;
          align-items: center;
          height: 100%;
        }
        #content .box .option .icon{
          position: relative;
          min-width: 100px;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        #content .box .option .icon .bx{
          font-size: 2.5em;
          color: var(--clr);
          transition: 0.5s ease-in-out;
        }
        #content .box:hover .option .icon .bx{
          color: #fff;
        }
        #content .box .option .text h3{
          font-weight: 500;
          color: var(--clr);
          transition: 0.5s ease-in-out;
        }
        #content .box .option .text p{
          font-size: 0.9em;
          color: #999;
          transition: 0.5s ease-in-out;
        }
        #content .box:hover .option .text h3, #content .box:hover .option .text p{
          color: #fff;
        }
    </style>
<body>
  <div id = "content">
  <div class = "box" style = "--clr: #fc5f9b" onclick = "window.location.href = 'projects.php'">
      <div class = "option">
        <div class = "icon"><i class='bx bx-list-check' ></i></div>
        <div class = "text">
          <h3>Projects</h3>
          <p>Create, edit or archive your projects</p>
        </div>
      </div>
    </div>
    <div class = "box" style = "--clr: #a362ea" onclick = "window.location.href = 'tasks.php'">
      <div class = "option">
        <div class = "icon"><i class='bx bx-task' ></i></div>
        <div class = "text">
          <h3>Tasks</h3>
          <p>Create, edit, archive and track your tasks</p>
        </div>
      </div>
    </div>
    <div class = "box" style = "--clr: #0ed095" onclick = "window.location.href = 'developers.php'">
      <div class = "option">
        <div class = "icon"><i class='bx bxs-user-account'></i></div>
        <div class = "text">
          <h3>Developers</h3>
          <p>Add, archive, and track your developers</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>