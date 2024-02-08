<?php
session_start();
include("db.php");

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $query = "SELECT * FROM password_reset WHERE token = '$token' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Token is valid, allow password reset
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve token and user email from the form
            $token = $_POST['token'];
            $userEmail = $_POST['userEmail'];

            // Assuming the user submits a form with a new password
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Check if the new password matches the confirmation
            if ($newPassword == $confirmPassword) {
                // Get user email from the password_reset table
                $row = mysqli_fetch_assoc($result);
                $userEmail = $row['user_email'];

                // Update password in userdata table
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE userdata SET Password = '$hashedPassword' WHERE Email = '$userEmail'";
                mysqli_query($con, $updateQuery);

                // Remove the used token from the password_reset table
                $deleteQuery = "DELETE FROM password_reset WHERE token = '$token'";
                mysqli_query($con, $deleteQuery);

                echo "<script type='text/javascript'> alert('Password reset successfully.')</script>";
            } else {
                echo "<script type='text/javascript'> alert('New password and confirmation do not match.')</script>";
            }
        }
    } else {
        // Token is invalid or expired, show an error message
        echo "<script type='text/javascript'> alert('Invalid or expired token.')</script>";
    }
} else {
    // Token is not provided, redirect to an error page or handle accordingly
    echo "<script type='text/javascript'> alert('Token not provided.')</script>";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <h1 id="title">Reset Password</h1>
            <form method="POST">
                <!-- Add an input field for the user's email -->
                <div class="input-field">
                    <i class="fa fa-envelope email"></i>
                    <input type="email" name="userEmail" placeholder="Your Email" required><br><br>
                </div>
                <!-- Add input fields for the new password and confirmation -->
                <div class="input-field">
                    <i class="fa fa-lock lock"></i>
                    <input type="password" name="newPassword" placeholder="New Password" required><br><br>
                </div>
                <div class="input-field">
                    <i class="fa fa-lock lock"></i>
                    <input type="password" name="confirmPassword" placeholder="Confirm Password" required><br><br>
                </div>
                <div class="btn-field">
                    <button type="submit" id="resetBtn">Reset Password</button><br><br>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
