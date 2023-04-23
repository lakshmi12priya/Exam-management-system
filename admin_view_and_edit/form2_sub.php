<?php 
include '../header.php';

$d=$_SESSION["dept"];
$s=$_SESSION["sem"];
$y=$_SESSION["year"];
?>
<!doctype html>
<html lang="en">
<head></head>
<link rel ="stylesheet" href="style1.css" type="text/css" media="all" />
<body>

<?php
$resultSet = mysqli_query($conn,"SELECT course_code,course_name from u_course where dept_id='$d'");
?>
<div id="opt_sub">
<form method="post" action="form3_login.php"> 
    <label for="subject">Choose Subject</label>
    <select id="sub" name="sub" >
        <?php while($row=mysqli_fetch_assoc($resultSet))
                {   
                    $sub=$row['course_name'];   
                echo "<option value='$row[course_code]'>" . $sub . "</option>" ;

                } ?>

    </select>
    <br><br>
    <button type="submit">Submit</button>
</form>
</div>
<!--go back button--><br><br>
<form style="margin-left: 43.5%;" action="form0.php">
    <button>GO BACK</button>
</form>

</html>


