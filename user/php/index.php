<?php 
    session_start();
    if (!isset($_SESSION['sessionid'])) {
        echo "<script>alert('Session is not available Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }

    include_once("dbconnect.php");

    if (isset($_POST["submit"])) {
        $operation = $_POST['submit'];
        if ($operation == 'Submit') {
            $search = $_POST['valuesearch'];
            $sqlsubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
        }
    }
    
    if (!isset($sqlsubject)){
        $sqlsubject = "SELECT * FROM tbl_subjects";
    }

    $results_per_page = 10;
        if (isset($_GET['pageno'])) {
            $pageno = (int)$_GET['pageno'];
            $page_first_result = ($pageno - 1) * $results_per_page;
        } else {
            $pageno = 1;
            $page_first_result = 0;
        }

    /*$sqlsubject = "SELECT * FROM tbl_subjects";*/

    $stmt = $conn->prepare($sqlsubject);
    $stmt -> execute();
    
    $number_of_result = $stmt -> rowCount();	
    $number_of_page = ceil($number_of_result/$results_per_page);
    $sqlsubject = $sqlsubject . " LIMIT $page_first_result , $results_per_page";
    $stmt = $conn->prepare($sqlsubject);
    $stmt -> execute();
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com.ajax.libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../js/menu.js" defer></script>
        <link rel="stylesheet" href="../css/style.css">
        <title>MyTutor</title>
        
        <script>
            function sideMenu(){
                var x = document.getElementById("idsidebar");
                if(x.className.indexOf("w3-show") == -1){
                    x.className += " w3-show";
                }else{
                    x.className = x.className.replace(" w3-show", "");
                }
            }
        </script>
    </head>

    <body>
        <div class="w3-cyan">    
            <div class="w3-bar">
                <a class="w3-bar-item w3-button w3-hide-small" href="index.php">Courses</a>
                <a class="w3-bar-item w3-button w3-hide-small" href="tutor.php">Tutors</a>
                <a class="w3-bar-item w3-button w3-hide-small" href="#">Subscription</a>
                <a class="w3-bar-item w3-button w3-hide-small" href="#">Profile</a>
                <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="sideMenu()">&#9776</a> 
                
            <div id="idsidebar" class="w3-bar-block w3-hide w3-hide-large w3-hide-medium">
                <a class="w3-bar-item w3-button " href="index.php">Courses</a>
                <a class="w3-bar-item w3-button " href="tutor.php">Tutors</a>
                <a class="w3-bar-item w3-button " href="#">Subscription</a>
                <a class="w3-bar-item w3-button " href="#">Profile</a>
            </div>
        </div>
        <div class="w3-margin w3-grid-template">
            <?php
                $i = 0;
                foreach($rows as $subjects) {
                    $i++;
                    $subject_id = $subjects['subject_id'];
                    $subject_name = $subjects['subject_name'];
                    $subject_description = $subjects['subject_description'];
                    $subject_price = number_format((float)$subjects['subject_price'], 2, '.', '');
                    $tutor_id = $subjects['tutor_id'];
                    $subject_sessions = $subjects['subject_sessions'];
                    $subject_rating = $subjects['subject_rating'];
                    echo "<div class='w3-card-4 w3-round' style='margin:4px'><header class='w3-container w3-cyan'><h5><b>$subject_name</b></h5></header>";
                    echo "<a href='' style='text-decoration: none;'> <img class='w3-image' src=../../user/assets/courses/$subject_id.png" 
                        . " style='width:100%;height:200px'></a><hr>";
                    echo "<div class='w3-container'><p><br>Price: RM $subject_price<br><p>
                        <button><a href='subjectdetails.php?submit=details&subject_id=$subject_id'><p>Details</p></button>
                    </div></div>";
                }
            ?>
        </div>
        <br>
        <div>
        <?php
            $num = 1;
            if ($pageno == 1) {
                $num = 1;
            } else if ($pageno == 2) {
                $num = ($num) + 10;
            } else {
                $num = $pageno * 10 - 9;
            }
            echo "<div class='w3-container w3-row'>";
            echo "<center>";
            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<a href = "index.php?pageno=' . $page . '" style=
                    "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $pageno . " )";
            echo "</center>";
            echo "</div>";
        ?>
        </div><br><br><br><br>
        <footer class="w3-footer w3-center w3-cyan w3-bottom">
            <p>copyright mytutor</p>
        </footer> 
    </body>
</html>