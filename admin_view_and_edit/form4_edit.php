<?php 
include '../header.php';

    $dept = $_SESSION["dept"];
    $sem = $_SESSION["sem"];
    $yr = $_SESSION["year"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Mark edit</title>
</head>
<body>
    
    <div class="container1" style="margin-left:18%; margin-bottom:1%; padding: 30px; ">
        <h2 style="margin-left: 33%;">COE ADMIN - EXTERNAL MARK EDIT</h2>
        <div class="top_details" style="margin-left: 420px; margin-bottom:20px;">
        <p> Department: <?php echo $dept ?> </p>
        <p> Semester: <?php echo $sem ?> </p>
        <p> Year: <?php echo $yr ?> </p>
        </div>


        <form action="adminedit_action.php" method="POST" autocomplete="off">

        <div class="container5" style="margin-left:3%">
        <table>
            <thead>
                <tr>    <!----table headers for the table--->
                    <th>NAME</th>
                    <th>REG_NO</th>
                    <th>SUBJECT</th>
                    <th>INTERNAL</th>
                    <th>EXTERNAL</th>
                    <th>TOTAL</th>
                </tr>
                <tbody>
                    <?php
            $sql = "SELECT s.sname,s.regno
            FROM u_student s
            JOIN u_prgm p ON s.prgm_id = p.prgm_id
            JOIN u_dept d ON p.dept_id = d.dept_id
            WHERE d.dept_id = '$dept' AND curr_sem = '$sem'";
            // SELECT regno, sname FROM u_student WHERE dept_id = '$dept_id' AND curr_sem = '$curr_sem'";
            $result = mysqli_query($conn, $sql);
            
            // iterate over each student and fetch course details
            while($row = mysqli_fetch_assoc($result)) {
              $regno = $row['regno'];
              $sname = $row['sname'];
              
              // fetch courses registered by the student
              $sql_courses = "SELECT ex.course_code, c.course_name, cr.internal_marks, external_marks, grade,total
                              FROM u_external_marks ex
                              inner join u_course_regn cr  on ex.course_code=cr.course_code
                              inner JOIN u_course c ON c.course_code = cr.course_code 
                              WHERE cr.regno = '$regno' AND cr.sem = '$sem'";
              $result_courses = mysqli_query($conn, $sql_courses);
              
              // iterate over each course and fetch exam and marks details
              while($row_courses = mysqli_fetch_assoc($result_courses)) {
                $course_code = $row_courses['course_code'];
                $course_name = $row_courses['course_name'];
                $internal_marks = $row_courses['internal_marks'];
                $external_marks = $row_courses['external_marks'];
                $grade = $row_courses['grade'];
                
                // calculate total marks
                $total =$row_courses['total'];
                // fetch external marks and grade
                // $sql_marks = "SELECT external_marks, grade,total
                //               FROM u_external_marks
                //               WHERE regno = '$regno' AND course_code = '$course_code'";
                // $result_marks = mysqli_query($conn, $sql_marks);
                // $row_marks = mysqli_fetch_assoc($result_marks);
                // $external_marks = $row_marks['external_marks'];
                // $grade = $row_marks['grade'];
                
                // calculate total marks
                // $total =$row_marks['total'];
                
                // display data in a table row
                echo "<tr>";
                echo "<td>$sname</td>";
                echo "<td>$regno</td>";
                echo "<td>$course_name</td>";
                echo "<td><input style='margin-left: 18px; padding: 2px 2px;' type='number' size='2' name='inter[]' value='".$internal_marks."' readonly></td>";
                echo "<td><input style='margin-left: 18px;  padding: 4px 4px;'  type='number' size='2' name='exter[]' value='".$external_marks."' oninput='add()'  min=0 max=60></td>";
                echo " <td><input style='margin-left: 7px; padding: 3px 4px;' type='number' size='2' name='total[]' value='".$total."'  min=0 max=100></td> ";
                echo "</tr>";
              }
            }
            
            // close database connection
            ?>
            
            </tbody>
            
        </table>
    </div>
    <!--commit button-->
                <div class="container6" style="margin-top: 0px;margin-left: 31%;">
                    <button>COMMIT</button>
                </div>
    
            </form>
            <!--go back button-->
            <form style="margin-top: 0px;margin-left: 48%;" action="form0.php">
                        <button>GO BACK</button>
            </form>
    </div>
    </div>
</body>
<script>   

    var a1 = document.getElementsByName("inter[]");
    var a2 = document.getElementsByName("exter[]");
    var a3 = document.getElementsByName("total[]");
    var arr1 = [];
    var arr2 = [];
    var sum = [];

    function add()
    {
    for (var i = 0; i < a1.length; i++) {
        arr1[i] = parseFloat(a1[i].value);
        arr2[i] = parseFloat(a2[i].value);

        sum[i] = arr1[i] + arr2[i];
        a3[i].value = sum[i];
    }
    console.log(sum);
}
</script>
</html>




