<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Developer</title>
    <script src = "../../js/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div id = "form">
        <table>
            <tr>
                <td><label for = "txtFname">First Name:</label></td>
                <td><input type = "text" id = "txtFname"></td>
                <td id = "feedback_fname"></td>
            </tr>
            <tr>
                <td><label for = "txtLname">Last Name:</label></td>
                <td><input type = "text" id = "txtLname"></td>
                <td id = "feedback_lname"></td>
            </tr>
            <tr>
                <td><label for = "txtEmail">Email:</label></td>
                <td><input type = "text" id = "txtEmail"></td>
                <td id = "feedback_email"></td>
            </tr>
            <tr>
                <td><label for = "txtPhone">Phone:</label></td>
                <td><input type = "text" id = "txtPhone"></td>
                <td id = "feedback_phone"></td>
            </tr>
            <tr>
                <td><label for = "txtHoursPerDay">Hours Per Day:</label></td>
                <td><input type = "text" id = "txtHoursPerDay"></td>
                <td id = "feedback_hoursPerDay"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = "button" value = "Create" onclick = "btnCreate_clicked()"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan = 3 id = "feedback"></td>
            </tr>
        </table>
    </div>

    <script>
        function btnCreate_clicked(){
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