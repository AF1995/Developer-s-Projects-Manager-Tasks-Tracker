<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
</style>
<body>
    <div id = "login">
        <table>
            <tr>
                <td>Email:</td>
                <td><input type = "text"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type = "text"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = "button" value = "Login"></td>
            </tr>
            <tr>
                <td colspan = 2>No account? <a href = "signup.php">sign up</a> instead.</td>
            </tr>
        </table>
    </div>
    <div id = "errors"></div>
</body>
</html>