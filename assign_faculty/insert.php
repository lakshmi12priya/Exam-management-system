<?php
    include '../header.php';

    // echo "$_POST[facultyname]";
    // echo "$_POST[sub1]"; 
    if(isset($_POST['submit']))
    {
        // print_r($_SESSION['fac_course_array']);
        // $delete_query="Delete from u_fac_course";
        // $delete=mysqli_query($conn,$delete_query);
        foreach($_SESSION['fac_course_array'] as $i => $row)
        {
            //  echo "inside for";
            $row[2]=$_POST['sub1'.$i];
            $row[3]=$_POST['sub2'.$i];
            $row[4]=$_POST['sub3'.$i];
            $row[5]=$_POST['sub4'.$i];
            $row[6]=$_POST['sub5'.$i];
            // print_r($_SESSION['fac_course_array']);
           
            $insert_query="INSERT into u_fac_course(faculty_id,course_code1,course_code2,course_code3,course_code4,course_code5,session)
             values ('$row[0]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$_SESSION[session]')";
             $insert=mysqli_query($conn,$insert_query);
            //  if(mysqli_affected_rows($con) > 0){
            //         echo(":)</td></tr>");
            //     }
            //     else{
            //         echo(":(</td></tr>");
            //     }  
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
        </script>
    <title>Document</title>
</head>
<body>
<div id="makepdf">
<h3 style="text-align:center;">Department: 
            <?php
                $dept_q= $dept_query="Select dept_name,dept_id from u_dept where DEPT_ID='$_SESSION[dept_id]'";
                $dept_r=mysqli_query($conn,$dept_q);
                $dept=mysqli_fetch_assoc($dept_r);
                echo $dept['dept_name'];
         ?>
         <br>
         Session: <?php
         if($_SESSION['month']=='A'){
            $month='MAY';
         } 
         else{
            $month='NOVEMBER';  
         }
         echo "$month $_SESSION[year]"; ?>
        </h3>
         <br><br>
    <table>
        <tr>
            <th>Faculty Name</th>
            <th>Subject 1</th> 
            <th>Subject 2</th>
            <th>Subject 3</th>
            <th>Subject 4</th>
            <th>Subject 5</th>

        </tr>
        <?php
            $select_query="SELECT u_fac_course.faculty_id,fname,course_code1,course_code2,course_code3,course_code4,course_code5 from u_fac_course inner join
             u_faculty on u_fac_course.faculty_id=u_faculty.faculty_id";
            $select_r=mysqli_query($conn,$select_query);
            while($select=mysqli_fetch_assoc($select_r)){
                echo"
                <tr>
                <td>".$select['fname']."</td>
                <td>".$select['course_code1']."</td>
                <td>".$select['course_code2']."</td>
                <td>".$select['course_code3']."</td>
                <td>".$select['course_code4']."</td>
                <td>".$select['course_code5']."</td>
                </tr>" ;
            }
        ?>
    </table>
    </div>
    <button id="button">Download</button>
    <script>
        var button = document.getElementById("button");
        var makepdf = document.getElementById("makepdf");

        button.addEventListener("click", function () {
            html2pdf().from(makepdf).save();
        });
    </script> 
    <button class="back_button"><a href="dept.php">Back</a></button>
    </body>
</html>
    