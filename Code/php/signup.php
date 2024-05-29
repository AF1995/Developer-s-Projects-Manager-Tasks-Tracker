<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src = "../js/jquery-3.7.1.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }
    body{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: seagreen;
        background: url("../images/login_background.jpg") no-repeat;
        background-size: cover;
        background-position: center;
    }

    #content{
        width: 420px;
        background: transparent;
        color: #fff;
        border-radius: 10px;
        padding: 30px 40px;
        border: 2px solid rgba(255, 255, 255, .2);
        backdrop-filter: blur(20px);
        box-shadow: 0 0 10 rgba(0, 0, 0, .2);
    }
    #content h1{
        font-size: 36px;
        text-align: center;
    }
    #content .input-box{
        position: relative;
        width: 100%;
        height: 50px;
        margin: 30px 0;
    }
    .input-box input{
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid rgba(255, 255, 255, .2);
        border-radius: 40px;
        font-size: 16px;
        color: #fff;
        padding: 20px 45px 20px 20px;
    }
    .input-box input::placeholder{
        color: #fff;
    }
    .input-box i{
        position: absolute;
        right: 20px;
        top: 25%;
        transform: translateY(-25);
        font-size: 20px;
    }
    #content #btnSignup{
        width: 100%;
        height: 45px;
        background: #fff;
        border: none;
        outline: none;
        border-radius: 40px;
        box-shadow: 0 0 10px rbga(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }
    #content .login{
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
    }
    #content .login p a{
        color: #fff;
        text-decoration: none;
        font-weight: 600;
    }
    #content .login p a:hover{
        text-decoration: underline;
    }
    #content #errors{
        text-align: center;
        font-weight: 600;
    }
</style>
<body>
<div id = "content">
        <h1>Signup</h1>
        <div class = "input-box">
            <input type = "text" placeholder = "Name" id = "txtName">
            <i class = "bx bxs-user"></i>
        </div>
        <div class = "input-box">
            <input type = "text" placeholder = "Email" id = "txtEmail">
            <i class='bx bx-envelope'></i>
        </div>
        <div class = "input-box">
            <input type = "password" placeholder = "Password" id = "txtPassword">
            <i class='bx bxs-lock-alt' ></i>
        </div>
        <div class = "input-box">
            <input type = "password" placeholder = "Repeat Password" id = "txtConfirmPassword">
            <i class='bx bxs-lock-alt' ></i>
        </div>
        <input type = "button" value = "Signup" onclick = "btnSignup_clicked()" id = "btnSignup">
        <div class = "login">
            <p>Already have an account? <a href = "login.php">Login</a></p>
        </div>
        <div id = "errors"></div>
    </div>

    <script>
        function btnSignup_clicked()
        {
            $("#errors").html("");
                
            var name = $("#txtName").val();
            var email = $("#txtEmail").val();
            var password = $("#txtPassword").val();
            var confirmPassword = $("#txtConfirmPassword").val();

            /* Input validation... */
            if(!name || !email || !password || !confirmPassword){
                $("#errors").html("All fields are required.");
                return;
            }

            $.ajax({
                url: 'ajax_calls/signup.php',
                type: 'POST',
                async: true,
                data: {name: name, email: email, password: password, confirmPassword: confirmPassword},
                success: function(response){
                    if(response == "")
                        window.location.href = "login.php";
                    else $("#errors").html(response);
                }
            });
        }
    </script>
</body>
</html>