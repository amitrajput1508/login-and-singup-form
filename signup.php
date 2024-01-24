<?php
session_start();
include("db.php");

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['Full_Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone_Number'];
    $pass = $_POST['Password'];
    $cpass = $_POST['Confirm_Password'];

    if (!empty($email) && !empty($pass) && !is_numeric($email)) {
        // Check if password and confirm password match
        if ($pass != $cpass) {
            echo "<script type='text/javascript'> alert('Password and Confirm Password do not match. Please try again.')</script>";
        } else {
            $query = "INSERT INTO userdata(Full_Name, Email, Phone_Number, Password, Confirm_Password) 
                      VALUES ('$name', '$email', '$phone', '$pass', '$cpass');";

            if (mysqli_query($con, $query)) {
                $to = $email;
                $subject = 'Welcome to Amico';
                $message = 'Thank you for signing up on Amico! We are excited to have you on board.';

                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'rajputamit1508@gmail.com'; 
                $mail->Password = 'drve gkaz sune xolp';   
                $mail->SMTPSecure = 'tls'; 
                $mail->Port = 587; 

                $mail->setFrom('rajputamit1508@gmail.com', 'Amico');
                $mail->addAddress($to);
                
                $mail->Subject = $subject;
                $mail->Body = $message;

                if ($mail->send()) {
                    echo "<script type='text/javascript'> alert('Successful Register. Welcome email sent.')</script>";
                } else {
                    echo "<script type='text/javascript'> alert('Error sending welcome email')</script>";
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
            } else {
                echo "<script type='text/javascript'> alert('Error registering user')</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SignUp</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <!-- Add icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">

        <div class="menu">
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About</a></li>
              <li><a href="#">Service</a></li>
              <li><a href="#">Contact</a></li>
          </ul>
          </div>
          
          <div class="login-signup">
            <button><a href="login.php">LogIn</a></button>
          </div>
        
        <div class="form-box">
            <h1 id="title">Sign Up</h1>
            <form method="POST">
                <div class="input-group">
                    <div class="input-field" id="nameField">
                        <i class="fa fa-user user" ></i>
                        <input type="text" name="Full_Name" placeholder="Full Name"><br><br>
                    </div>

                    <div class="input-field">
                        <i class="fa fa-envelope email"></i>
                        <input type="email" name="Email" placeholder="Email"><br><br>
                    </div>

                    <div class="input-field">
                        <i class="fa fa-phone phone"></i>
                        <input type="text" name="Phone_Number" placeholder="Phone Number"><br><br>
                    </div>

                    <div class="input-field">
                        <i class="fa fa-lock lock"></i>
                        <input type="password" name="Password" placeholder="Password"><br><br>
                    </div>

                    <div class="input-field" id="lockField">
                        <i class="fa fa-lock lock"></i>
                        <input type="password" name="Confirm_Password" placeholder="Confirm Password"><br><br>
                    </div>

                    <div class="btn-field">
                        <button type="submit" id="signupBtn">Sign Up</button><br><br>
                    </div>

                    <div class="link-field" id="LogIn">
                        <p>Already have an account?<a href="login.php">Log in here</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
