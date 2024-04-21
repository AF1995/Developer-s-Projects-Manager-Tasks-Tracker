<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
</style>
<body>
    <div id = "signup">
        <table>
            <tr>
                <td>Name:</td>
                <td><input type = "text"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type = "text"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type = "text"></td>
            </tr>
            <tr>
                <td>Confirm password:</td>
                <td><input type = "text"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = "button" value = "Signup"></td>
            </tr>
            <tr>
                <td colspan = 2>Already have an account? <a href = "login.php">Login</a>.</td>
            </tr>
        </table>
    </div>
    <div id = "errors"></div>
</body>
</html>