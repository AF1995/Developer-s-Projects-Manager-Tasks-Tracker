<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    #content .usertype{
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        margin: -15px 0 15px;
    }
    #content .usertype label input{
        accent-color: #333;
        margin-right: 3px;
    }
    #content #btnLogin{
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
    #content .signup{
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
    }
    #content .signup p a{
        color: #fff;
        text-decoration: none;
        font-weight: 600;
    }
    #content .signup p a:hover{
        text-decoration: underline;
    }
    #content #errors{
        text-align: center;
        font-weight: 600;
    }
</style>
<body>

    <div id = "content">
        <h1>Login</h1>
        <div class = "input-box">
            <input type = "text" placeholder = "Email" id = "txtEmail">
            <i class = "bx bxs-user"></i>
        </div>
        <div class = "input-box">
            <input type = "password" placeholder = "Password" id = "txtPassword">
            <i class='bx bxs-lock-alt' ></i>
        </div>
        <div class = "usertype">
            <label><input type = "radio" id = "lblLeader" name = "userType" checked value = "leader"> Leader</label>
            <label><input type = "radio" id = "lblDeveloper" name = "userType" value = "developer"> Developer</label>
        </div>
        <input type = "button" value = "Login" onclick = "btnLogin_clicked()" id = "btnLogin">
        <div class = "signup">
            <p>Don't have an account? <a href = "signup.php">Signup</a></p>
        </div>
        <div id = "errors"></div>
    </div>

    <script>
        function btnLogin_clicked()
        {
            var email = $("#txtEmail").val();
            var password = $("#txtPassword").val();
            var userType = $("input[name='userType']:checked").val();

            if(!email || !password)
            {
                $('#errors').html("All fields are required.");
                return;
            }

            $.ajax({
                url: 'ajax_calls/login.php',
                type: 'POST',
                async: true,
                data: {email: email, password: password, userType: userType},
                success: function(response){
                    response = JSON.parse(response);
                    if(response["found"] == "no")
                        $("#errors").html(response["feedback"]);
                    else {
                        if(userType == "leader"){
                            $.ajax({
                                url: 'ajax_calls/initialize_session.php',
                                type: 'POST',
                                async: true,
                                data: {userType: "leader", id: response['id'], userName: response['userName']},
                                success: function(response){
                                    window.location.href = "leader/main.php";
                                }
                            });
                        }
                        else if(userType == "developer"){
                            $.ajax({
                                url: 'ajax_calls/initialize_session.php',
                                type: 'POST',
                                async: true,
                                data: {userType: "developer", id: response['id'], fname: response['fname'], lname: response['lname']},
                                success: function(){
                                    window.location.href = "developer/main.php";
                                }
                            });
                        }
                    }

                }
            });
        }
    </script>
</body>
</html>