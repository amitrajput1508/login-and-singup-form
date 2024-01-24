<?php
require_once "db.php"; 


function checkLogin($email, $password, $con) {
    
    $stmt = $con->prepare("SELECT * FROM userdata WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script type='text/javascript'> alert('Successfully logged in!'); window.location='index.php';</script>";
        exit();       
    } else {
        echo "<script type='text/javascript'> alert('Incorrect email or password. Please try again.'); window.location='login.php'</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["Email"];
    $password = $_POST["Password"];

    $loginResult = checkLogin($email, $password, $con);
}
?>


<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <?php
     if(isset($loginResult))
     {
        echo "<script>alert('{$loginResult}');</script>";;
        
     }
     ?>
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
            <h1 id="title">Log In</h1>
            <?php
            if(isset($loginResult))
            {
                echo "<p>{$loginResult}</p>";
            }
            ?>
            <form method="POST">
                <div class="input-field">
                    <i class="fa fa-envelope email"></i>
                    <input type="email" name="Email" placeholder="Email"><br><br>
                </div>
                <div class="input-field">
                    <i class="fa fa-lock lock"></i>
                    <input type="password" name="Password" placeholder="Password">
                </div>
                <div class="link-box" id="ForgotPassword">
                    <p>Forgot password<a href="resetpass.php">Click Here!</a></p><br><br>
                </div>
                <div class="btn-field">
                    <button type="submit" id="LoginBtn">Log In</button><br><br>
                </div>
                <div class="link-field" id="Signup">
                    <p>Don't have an account?<a href="signup.php">SignUp</a></p>
                    <div class="with">
                        <p>__________Login With__________</p>
                    </div>
                    <div class="icon" title="Google">
                    <button><i class="fa-brands fa-google"></i></button>
                    </div>

                    <div class="icon" title="Github">
                        <button><i class="fa-brands fa-github"></i></button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</body>
</html>
