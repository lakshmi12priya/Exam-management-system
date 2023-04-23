<?php 
include '../header.php';
$year =  $_POST['session_year'];
$formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
$_SESSION['session'] = $formatted_year.$_POST['session_month'];
$_SESSION['year']=$_POST['session_year'];
$_SESSION['month']=$_POST['session_month'];

$_SESSION['dept_id']=$_POST['dept'];
?>
<html>
    <style>
        select{
            width: 20rem;
        }
    </style>
    <form method="post" action="insert.php">
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
            $faculty_q="Select faculty_id,fname from u_faculty where dept_id='$_SESSION[dept_id]'";
            $faculty=mysqli_query($conn,$faculty_q);
            $_SESSION['fac_course_array'] = array();

            foreach($faculty as $x)
            {
                array_push(
                    $_SESSION['fac_course_array'], 
                    array($x['faculty_id'],$x['fname'] ,-1,-1,-1,-1,-1)
                );
            }  
                // $facultyname=;
                
                foreach($_SESSION['fac_course_array'] as $i => $row)
                {
                    echo "  <tr>
                    <td>".$row[1]."</td>";
                    $subject_q="Select course_code, course_name from u_course where dept_id='$_POST[dept]'";
                    $subject=mysqli_query($conn,$subject_q);
                    echo "
                    <td>
                    <select name='sub1".$i."' id='sub1'>
                    <option>None</option>";
                        while(($sub=mysqli_fetch_assoc($subject)))
                        {
                            echo "<option value='$sub[course_code]'>$sub[course_name]</option>";
                        }
                        echo " </select>
                                </td>";
                    
                        $subject=mysqli_query($conn,$subject_q);
                        echo "
                        <td>
                        <select name='sub2".$i."' id='sub2'>
                        <option>None</option>";

                            while(($sub=mysqli_fetch_assoc($subject)))
                            {
                                echo "<option value='$sub[course_code]'>$sub[course_name]</option>";
                            }
                            echo " </select>
                                    </td>";
                
                  
                    $subject=mysqli_query($conn,$subject_q);
                    echo "
                    <td>
                        <select name='sub3".$i."' id='sub3'>
                        <option>None</option>";
                            while(($sub=mysqli_fetch_assoc($subject)))
                            {
                                echo "<option value='$sub[course_code]".$i."'>$sub[course_name]</option>";
                            }
                            echo " </select>
                                    </td>";
                    $subject=mysqli_query($conn,$subject_q);
                    echo "
                    <td>
                    <select name='sub4".$i."' id='sub4'>
                    <option>None</option>";
                        while(($sub=mysqli_fetch_assoc($subject)))
                        {
                            echo "<option value='$sub[course_code]".$i."'>$sub[course_name]</option>";
                        }
                        echo " </select>
                                </td>";
                    $subject=mysqli_query($conn,$subject_q);
                    echo "
                    <td>
                    <select name='sub5".$i."' id='sub5'>
                    <option>None</option>";
                        while(($sub=mysqli_fetch_assoc($subject)))
                        {
                            echo "<option value='$sub[course_code]".$i."'>$sub[course_name]</option>";
                        }
                        echo " </select>
                                </td>";
                    echo "</tr>";
                } 
                
                
        ?>
    <br>
    </table>
        <button name="submit" type="submit">Submit</button>
    </form>

</html>
