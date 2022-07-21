<?php 

    if(isset($_POST['submit'])){
            
        include 'dbconnect.php';

        $email = $_POST['email'];
        $pass = sha1($_POST['pass']);
        $sqllogin = "SELECT * FROM tbl_user where user_email = '$email' AND user_pass = '$pass'";
        $stmt = $conn->prepare($sqllogin);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();

        if($number_of_rows > 0){
            session_start();
            $_SESSION["sessionid"] = session_id();
            echo "<script>alert('Login Success');</script>";
            echo "<script> window.location.replace('index.php')</script>";
        }else{
            echo "<script>alert('Login Failed');</script>";
            echo "<script> window.location.replace('login.php')</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="../js/login.js" defer></script>

    <title>Login</title>
</head>

<body>
    <header class="w3-center w3-header w3-cyan w3-padding-32">
        <h3><b>User Login Page</b></h3>
    </header>
    
    <div style="display: flex; justify-content:center">

        <div class="w3-container w3-card w3-margin">
            <form class="w3-padding" name="loginForm" action="login.php" method="post">
                <div class="w3-container w3-cyan">
                    <h3>Login</h3>
                </div>

                <p>
                    <label><b>Email</b></label><br>
                    <input type="text" name="email" id="idemail"><br>
                </p>
                
                <p>
                    <label><b>Password</b></label><br>
                    <input type="password" name="pass" id="idpass"><br>
                </p>
                
                <p>
                    <a href="register.php" style="color:blue">Sign Up</a>
                </p>

                <p>
                    <input class="w3-check" type="checkbox" id="idremember" onclick="rememberMe()"> 
                    <label>Remember Me</label>
                </p>

                <p>
                    <input type="submit" name="submit" id="idsubmit"><br>
                </p>
            </form>
        </div>
    </div>

    <footer class="w3-footer w3-center w3-cyan w3-bottom">
        <p>copyright MyTutor</p>
    </footer>    
</body>
</html>