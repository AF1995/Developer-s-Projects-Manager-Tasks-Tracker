<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src = "../js/jquery-3.7.1.min.js"></script>
</head>
<style>
    #signup{
        background-color: red;
    }

    #signup table{
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
    <div id = "signup">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type = "text" id = "txtName"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type = "text" id = "txtEmail"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type = "text" id = "txtPassword"></td>
            </tr>
            <tr>
                <td>Confirm password:</td>
                <td><input type = "text" id = "txtConfirmPassword"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = "button" value = "Signup" onclick = "btnSignup_clicked()"></td>
            </tr>
            <tr>
                <td colspan = 2>Already have an account? <a href = "login.php">Login</a>.</td>
            </tr>
        </table>
    </div>
    <div id = "errors">

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
                    $("#errors").html(response);
                    window.location.href = "login.php";
                }
            });
        }
    </script>
</body>
</html>