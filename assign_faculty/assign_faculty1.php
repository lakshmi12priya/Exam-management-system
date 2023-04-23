<?php 
include 'header.php';
include 'gtitle.php';
include 'connection.php';

?>
<html>
    <style>
        table,td,th{
        border:1px solid black;
        padding: 10px;
        width: 2rem;
        }
    </style>
    <form method="post" action="insert.php">
    <table>
        <tr>
            <th>Subject</th>
            <th>Faculty</th> 
           
</tr>
    <?php 
        $faculty_q="Select faculty_id,fname from u_faculty";
        $faculty=mysqli_query($con,$faculty_q);
        // $row=mysqli_fetch_assoc($faculty);

        $subject_q="Select course_code, course_name from u_course";
        $subject=mysqli_query($con,$subject_q);
        $_SESSION['fac_course_array'] = array();

        foreach($subject as $x)
        {

            array_push(
                $_SESSION['fac_course_array'], 
                array($x['course_code'],$x['course_name'], -1)
            );
        }
        foreach($_SESSION['fac_course_array'] as $i => $row)
        {

                // $facultyname=$x['fname'];
                echo "  <tr>
                <td>".$row[1]."</td>";
            echo "
            <td>
            <select name='sub1".$i."' id='sub1'>
            <option>None</option>";
                    while(($fac=mysqli_fetch_assoc($faculty)))
                    {
                        echo "<option value='$fac[faculty_id]'>$fac[fname]</option>";
                    }
                    echo " </select>
                            </td>";
    
    echo "</tr>";
        }
        

    ?>
    <br>
    </table>
    <button type="submit">Submit</button>
    </form>

</html>
