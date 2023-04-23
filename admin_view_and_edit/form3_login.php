<?php
// session_start();
include '../header.php';
$_SESSION["sub"]=$_POST["sub"];
$sub=$_POST["sub"];
?>

<!DOCTYPE html>
<html lang="en">
<head></head>
<link rel ="stylesheet" href="style1.css" type="text/css" media="all" />
<body>


<div>
<br>
<h1 style="text-align:center; color:darkred;"> EDIT INTERNALS - STAFF LOGIN </h1>
<?php 
    $sub=$_SESSION["sub"];

    //using u_fac_course
    // $res="SELECT f.fname, c.course_name
    // FROM u_faculty f
    // INNER JOIN u_fac_course fc ON f.faculty_id = fc.faculty_id
    // INNER JOIN u_course c ON fc.course_code = c.course_code
    // WHERE c.course_code = '$sub'";

    //using u_course_regn
    $res="SELECT u_faculty.fname, u_course.course_name
    FROM u_course_regn
    JOIN u_faculty ON u_course_regn.faculty_id = u_faculty.faculty_id
    JOIN u_course ON u_course_regn.course_code = u_course.course_code
    WHERE u_course_regn.course_code = '$sub'";
    $result=mysqli_query($conn,$res);
    $row=mysqli_fetch_assoc($result);
    ?>

<div class="dept-selection">
<?php echo "Subject Code: ".$sub. "<br><br>";
      echo "Subject Name: ".$row['course_name']. "<br><br>";
      echo "Faculty Name: ".$row["fname"]. "<br><br>";   
      $_SESSION["fname"]=$row["fname"];
      ?>

<form method="post" action="login2.php">

<label for="name">ENTER FACULTY ID: </label>
<input type="text" name="name" id="name" maxlength="100" autocomplete="off"><br><br>
<label for="dept">ENTER YOUR PASSWORD: </label>
<input type="password" name="password" id="password" maxlength="100" placeholder="10-digit number">
<br><br>
<input type="submit" name="submit" id="submit" value="SUBMIT">
</div>

