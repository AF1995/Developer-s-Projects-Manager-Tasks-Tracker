<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src = "../js/jquery-3.7.1.min.js"></script>
</head>
<style>
    #login{
        background-color: red;
    }

    #login table{
        margin: auto;
        border: 1px black solid;
        background-color: green;
    }

    #errors{
        background-color: yellow;
        text-align: center;
    }
</style>
<body>
    <div id = "login">
        <table>
            <tr>
                <td>Email:</td>
                <td><input type = "text" id = "txtEmail"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type = "text" id = "txtPassword"></td>
            </tr>
            <tr>
                <td>Login as:</td>
                <td>
                    <input type = "radio" id = "lblLeader" name = "userType" checked value = "leader">
                    <label for = "lblLeader">Leader</label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type = "radio" id = "lblDeveloper" name = "userType" value = "developer">
                    <label for="lblDeveloper">Developer</label>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type = "button" value = "Login" onclick = "btnLogin_clicked()"></td>
            </tr>
            <tr>
                <td colspan = 2>No account? <a href = "signup.php">sign up</a> instead.</td>
            </tr>
        </table>
    </div>
    <div id = "errors"></div>

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
                                success: function(){
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