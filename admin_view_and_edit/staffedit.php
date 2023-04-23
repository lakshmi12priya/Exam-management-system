<?php 
include '../header.php';
    $dept = $_SESSION["dept"];
    $sem = $_SESSION["sem"];
    $yr = $_SESSION["year"];
    $sub=$_SESSION["sub"];
    $fname=$_SESSION["fname"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Mark edit</title>
    
</head>
<body>
    <div>
    <div class="container1" style="margin-left:18%; margin-bottom:1%; padding: 30px; ">
        <h2 style="margin-left: 33%;">FACULTY - INTERNAL MARK EDIT</h2>
        <div class="top_details" >
        <p> Department: <?php echo $dept ?> </p>
        <p> Semester: <?php echo $sem ?> </p>
        <p> Year: <?php echo $yr ?> </p>
        <p> Subject Code: <?php echo $sub ?> </p>
        <p> Faculty Name: <?php echo $fname ?> </p>
        </div>

        <form action="staffedit_action.php" method="POST" autocomplete="off">

        <div class="container5" style="margin-left:3%">
                        <table>
                            <thead>
                                <tr>    <!----table headers for the table--->
                                    <th>NAME</th>
                                    <th>REG_NO</th>
                                    <th>INTERNAL</th>
                                    <th>EXTERNAL</th>
                                    <th>TOTAL</th>
                                </tr>
                                <tbody>
                                    <?php
                           #table to enter marks by coe emplyee
                           

                            $sql="SELECT e.regno, s.sname, c.internal_marks, e.external_marks, e.total
                            FROM u_external_marks e
                            INNER JOIN u_student s ON e.regno = s.regno
                            INNER JOIN u_course_regn c ON e.regno = c.regno AND e.course_code = c.course_code
                            WHERE e.course_code = '$_SESSION[sub]' AND e.session = '$_SESSION[session]'";

                            $result=mysqli_query($conn,$sql);
                            $_SESSION['int_marks_array'] = array();

            
                            // print_r($get_enrolled_students);
                            foreach($result as $stud_details){
                                // echo("Inside foreach");
                                array_push(
                                    $_SESSION['int_marks_array'], 
                                    array($stud_details['regno'], $stud_details['sname'], $stud_details['internal_marks'], $stud_details['external_marks'],$stud_details['total'])
                                );
                            }
$c=0;
                            foreach($_SESSION['int_marks_array'] as $i => $row){
                                // to display the regno(stored at row[0]) and the name of each student(stored at row[1])
                                echo("
                                <tr>
                                <td>".$row[0]."</td>
                                <td>".$row[1]."</td>
                                ");
                
                                //
                                echo("
                                <td><input type = 'number' min = 0 max = 40 name = 'int_marks".$i."' value='".$row[2]."' oninput='add()' id='int_marks'></td>
                                <td><input type = 'number' min = 0 max = 100 name = 'ext_marks".$i."' value='".$row[3]."' readonly id='ext_marks'></td>
                                <td><input type = 'number' min = 0 max = 100 name = 'total".$i."' value='".$row[4]."' readonly id='total'></td>
                                </tr>
                                ");
                                $c=$c+1;
                            }
                            

                            // if($result){
                            //     while($row=mysqli_fetch_assoc($result)){
                            //         $count++;
                            //         $name=$row['sname'];
                            //         $reg=$row['regno'];
                            //         array_push($n,$reg);
                            //         $internal=$row['internal_marks'];
                            //         $external=$row['external_marks'];
                            //         $total=$row['total'];
                            //         echo '
                            //         <tr>
                            //             <th scope="row">'.$name.'</th>
                            //             <th scope="row">'.$reg.'</th>
                            //             <td><input type="text" size="2" name="inter" value=" '.$internal.'" oninput="add()" min=0 max=40></td>
                            //             <td scope="row"><input style="margin-left: 18px; padding: 4px 4px;" type="text" size="2" name="exter" value="'.$external.'" readonly></td>
                            //             <td><input style="margin-left: 7px; padding: 3px 4px;" type="text" size="2" name="total" value="'.$total.'" ></td>
                            //         </tr>';      
                            //         }
                            //     }
    
                                ?>
                                </tbody>
                            </thead>
                        </table>
                </div>
                    <!--commit button-->
                   <?php $submit_btn_style = 'margin: 1rem auto; background-color: black;';
            echo("<input type = 'submit' name='submit_marks_attendance' class='submit_marks_attendance' style=".$submit_btn_style.">");
                    ?>
            </form>
            <!--go back button-->
            <form style="margin-top: 0px;margin-left: 48%;" action="form0.php">
                        <button>GO BACK</button>
                    </form>
        </div>
    </div>
</body>
<script>   

    var a1 = document.getElementsByName("int_marks''");
    var a2 = document.getElementsByName("ext_marks");
    var a3 = document.getElementsByName("total");
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




