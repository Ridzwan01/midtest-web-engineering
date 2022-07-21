<?php 

    if(isset($_POST['submit'])){
            
        include_once("dbconnect.php");

        $email = $_POST['email'];
        $name = $_POST['name'];
        $pass = sha1($_POST['pass']);
        $phnumber = $_POST['phnumber'];
        $address = $_POST['address'];

        $sqlregister = "INSERT INTO `tbl_user`(`user_email`, `user_name`, `user_phnumber`, `user_pass`, `user_address`) 
                        VALUES ('$email','$name','$phnumber','$pass','$address')";
        
        try {
            $conn->exec($sqlregister);
            if (file_exists($_FILES["image"]["tmp_name"]) || is_uploaded_file($_FILES["image"]["tmp_name"])) {
                $last_id = $conn->lastInsertId();
                uploadImage($last_id);
                echo "<script>alert('Success')</script>";
                echo "<script>window.location.replace('login.php')</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Failed')</script>";
            echo "<script>window.location.replace('register.php')</script>";
        }
    }

    function uploadImage($filename)
    {
        $target_dir = "../assets/image/";
        $target_file = $target_dir . $filename . ".png";
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="../js/image.js"></script>
    
    <title>Register</title>
</head>

<body>
    <header class="w3-center w3-header w3-cyan w3-padding-32">
        <h3><b>Register User</b></h3>
    </header>
    
    <div style="display: flex; justify-content:center">

        <div>
            <form class="w3-card w3-padding" action="register.php" method="post" enctype="multipart/form-data">
            <div class="w3-container w3-cyan">
                <h3>New Register</h3>
            </div>
            <div class="w3-container w3-center">
                <input type="file" name="image" id="imageId" onchange="loadFile(event)" accept="image/*">
                <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                <p><img id="output" width="200" /></p>
            </div>

                <p>
                    <label><b>Email</b></label>
                    <input class="w3-input w3-border w3-round" type="text" name="email" id="idemail" required>
                </p>

                <p>
                    <label><b>Name</b></label>
                    <input class="w3-input w3-border w3-round" type="text" name="name" id="idemail" required>
                </p>

                <p>
                    <label><b>No Telephone</b></label>
                    <input class="w3-input w3-border w3-round" type="text" name="phnumber" id="idemail" required>
                </p>
                
                <p>
                    <label><b>Password</b></label>
                    <input class="w3-input w3-border w3-round" type="password" name="pass" id="idpass" required>
                </p>
                
                <p>
                    <label><b>Address</b></label>
                    <textarea class="w3-input w3-border w3-round" type="text" name="address" rows="4" width="100%" required></textarea>
                </p>

                <p>
                    <input class=" w3-round" class="w3-round" type="submit" name="submit"><br><br><br>
                </p>
            </form>
        </div>
        
    </div>

    <footer class="w3-footer w3-center w3-cyan w3-bottom">
        <p>copyright MyTutor</p>
    </footer>    
</body>
</html>