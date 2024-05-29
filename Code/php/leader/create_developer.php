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
    <title>Create Developer</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
    <link rel = "stylesheet" href = "../../css/form.css">
</head>
<style>
    .container .form .input-box p{
        text-align: left;
        color: red;
        margin-top: 5px;
        margin-left: 20px;
    }
    #feedback{
        text-align: center;
    }
</style>
<body>
    <section class="container">
        <header>Add Developer</header>
        <div class = "form">
            <div class = 'input-box'>
                <label for = 'txtFname'>First Name</label>
                <input type = 'text' placeholder = 'Enter first name' id = 'txtFname'>
                <p id = "feedback_fname"></p>
            </div>
            <div class = 'input-box'>
                <label for = 'txtLname'>Last Name</label>
                <input type = 'text' placeholder = 'Enter last name' id = 'txtLname'>
                <p id = "feedback_lname"></p>
            </div>
            <div class = 'input-box'>
                <label for = 'txtEmail'>Email</label>
                <input type = 'text' placeholder = 'Enter email' id = 'txtEmail'>
                <p id = "feedback_email"></p>
            </div>
            <div class = 'input-box'>
                <label for = 'txtPhone'>Phone</label>
                <input type = 'text' placeholder = 'Enter phone' id = 'txtPhone'>
                <p id = "feedback_phone"></p>
            </div>
            <div class = 'input-box'>
                <label for = 'txtHoursPerDay'>Hours Per Day</label>
                <input type = 'text' placeholder = 'Enter hours per day' id = 'txtHoursPerDay'>
                <p id = "feedback_hoursPerDay"></p>
            </div>
            
            <button onclick = "btnCreate_clicked()">Create</button>

            <p id = "feedback"></p>
        </div>
    </section>

    <script>
        function btnCreate_clicked(){
            $("#feedback").html("");
            $("#feedback_fname").html("");
            $("#feedback_lname").html("");
            $("#feedback_email").html("");
            $("#feedback_phone").html("");
            $("#feedback_hoursPerDay").html("");

            var fname = $("#txtFname").val().trim();
            var lname = $("#txtLname").val().trim();
            var email = $("#txtEmail").val().trim();
            var phone = $("#txtPhone").val().trim();
            var hoursPerDay = $("#txtHoursPerDay").val().trim();

            var accepted = true;

            if(hoursPerDay.length == 0){
                $("#feedback_hoursPerDay").html("Required");
                $("#txtHoursPerDay").focus();
                accepted = false;
            }
            if(email.length == 0){
                $("#feedback_email").html("Required");
                $("#txtEmail").focus();
                accepted = false;
            }
            if(lname.length == 0){
                $("#feedback_lname").html("Required");
                $("#txtLname").focus();
                accepted = false;
            }
            if(fname.length == 0){
                $("#feedback_fname").html("Required");
                $("#txtFname").focus();
                accepted = false;
            }
            if(!accepted) return;
            
            $.ajax({
                url: '../ajax_calls/create_developer.php',
                type: 'POST',
                async: true,
                data: {fname: fname, lname: lname, email: email, phone: phone, hoursPerDay: hoursPerDay},
                success: function(response){
                    var res = JSON.parse(response);
                    $("#feedback_fname").html(res['fname']);
                    $("#feedback_lname").html(res['lname']);
                    $("#feedback_email").html(res['email']);
                    $("#feedback_phone").html(res['phone']);
                    $("#feedback_hoursPerDay").html(res['hoursPerDay']);
                    $("#feedback").html(res['response']);

                    if(res['sendEmail'].length != 0){
                        email = res['sendEmail'].split(' ')[0];
                        var password = res['sendEmail'].split(' ')[1];
                        var subject = 'Registration Password Arrival Your TTT Account';
                        var message = "Hey " + fname + " " + lname + "! Your account was added on Team's Task Tracker, and we are here to deliver your password.\n\n";
                        message += "Your password is: " + password;

                        $.ajax({
                            url: '../ajax_calls/send_mail.php',
                            type: 'POST',
                            async: true,
                            data: {userMail: email, subject: subject, message: message, success: "Email was sent to developer."},
                            success: function(response){
                                $("#feedback").html($("#feedback").html() + "<br>" + response);
                            }
                        });
                    }
                }
            });
        }
    </script>
</body>
</html>