<?php
    include 'header.php';
    include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form action="display.php" method="post">
<table>
    <tr>
        <th>Date</th>
        <th>Subject</th>
        <th>No.of students Enrolled</th>
        <!-- <th>quotient no.of rooms</th>
        <th>rem</th> -->
        <th>Room</th>
        <!-- <th>Faculty</th> -->
    </tr>
<?php
    // $GLOBALS['n']=10;
     $year =  $_POST['session_year'];
     $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
     $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];
    //  echo   $_SESSION['chosen_session'];
    $dets_query="Select ex_date,t.ex_session,t.course_code,course_name
           from exam_timetable t,u_course
           where t.course_code=u_course.course_code and t.ex_session='$_SESSION[chosen_session]'";
    $dets_run=mysqli_query($conn,$dets_query);
    while(($details=mysqli_fetch_assoc($dets_run)))
    {
        echo "<tr>
        <td>$details[ex_date]</td>
        <td>$details[course_name] </td>";
        // echo "$details[course_code] <br>";
        $course_code=$details['course_code'];
        $exam_session=$details['ex_session'];
        $count_query="Select count(*) as num  from u_external_marks where COURSE_CODE='$course_code' and session='$exam_session'";
        $count_r=mysqli_query($conn,$count_query);
        $count=mysqli_fetch_assoc($count_r);
        $no_of_students=$count['num'];
        echo "<td>$no_of_students</td>";
     
        // $quotient1=71/25;
        $quotient=intdiv(71,25); //no.of rooms
        // echo "<td> $quotient</td>";
        $remainder=71%25;
        // echo "<td>$remainder<br></td> ";
       
 
        $dept=$_POST['dept'];
        $faculty_q="Select count(*) as no_of_faculty, faculty_id,fname from u_faculty where dept_id='$_POST[dept]'";
        $faculty_r=mysqli_query($conn,$faculty_q);
        $room="select room_name,room_id from room";
        $room_q=mysqli_query($conn,$room);

        if($quotient<=1)
        {
            echo "<td>
            <label for='room'>Choose room</label>
            <input readonly value='Room 1'></input>";

            // <select name='room' id='room'>";
            // while(($room_r=mysqli_fetch_assoc($room_q)))
            // {
            //     echo "<option value='$room_r[room_name]'>$room_r[room_name]</option>";
            // }
           
            //  echo"</select><br>
            echo"<br>
            <label for='faculty'> Choose Faculty</label>
            <select name='faculty' id='faculty'>"; 
            $faculty=mysqli_fetch_assoc($faculty_r);            
            // while(($faculty=mysqli_fetch_assoc($faculty_r)))
            //     {
            //         echo "<option value='$faculty[fname]'>$faculty[fname]</option>";
            //     }
            for ($x=1; $x <=$faculty['no_of_faculty'] ; $x++) { 
                echo "<option value='$faculty[fname]'>Faculty".$x."</option>";
            }
            // for ($x=0; $x <$faculty['no_of_faculty'] ; $x++) { 
            //     echo "<input name=faculty_allocated value='Faculty ".$x."'>";
            // }
            echo " </select>
            </td>";
        }
        else
        {
            if($remainder<=5)
            {
                // echo "allocate in same room";
                $flag=0;
                echo "<td>";
                for($i=1;$i<=$quotient;$i++)
                {
                    // $room_start = $i * 25 ;
                    // $room_end = ($i) * 25;
                    $room="select room_name,room_id from room";
                    $room_q=mysqli_query($conn,$room);
                    echo "
                    <label for='room'>Choose room </label>
                    <input readonly value='Room".$i."'>";
                    // <select name='room' id='room'>";
                    // while(($room_r=mysqli_fetch_assoc($room_q)))
                    // {
                    //     echo "<option value='$room_r[room_name]'>$room_r[room_name]</option>";
                    // } </select>
                
                echo"      <br>  
                   
                    <label for='faculty'> Choose Faculty</label>
                    <select name='faculty' id='faculty'>";
                    $faculty_q="Select count(*) as no_of_faculty, faculty_id,fname from u_faculty where dept_id='$_POST[dept]'";
                    $faculty_r=mysqli_query($conn,$faculty_q); 
                    $faculty=mysqli_fetch_assoc($faculty_r);          
                    // while(($faculty=mysqli_fetch_assoc($faculty_r)))
                    //     {
                    //         echo "<option value='$faculty[fname]'>$faculty[fname]</option>";
                    //     }
                    for ($x=1; $x <=10 ; $x++) { 
                        echo "<option value='$faculty[fname]'>Faculty".$i."</option>";
                    }
                    echo " </select><br>";
                    // $students_in_room = 0;
                    // if ($i == $quotient - 1 && $remainder > 0) {
                    //     $students_in_room = $remainder;
                    // } else {
                    //     $students_in_room = 25;
                    // }
                    // echo "<span>Number of students in this room: $students_in_room</span><br><br>";
                    
                }
                echo "</td>";
            }
            else
            {
                $flag=1;
                // echo "Allocate in separate room <br>";
                echo "<td>";
                for($i=1;$i<=$quotient+1;$i++)
                {
                    // $room_start = $i * 25 + 1;
                    // $room_end = ($i + 1) * 25;
                    $room="select room_name,room_id from room";
                    $room_q=mysqli_query($conn,$room);
                    echo "
                    <label for='room'>Choose room</label>
                    <input readonly value='Room".$i."'>";
                    // <select name='room' id='room'>";
                    // while(($room_r=mysqli_fetch_assoc($room_q)))
                    // {
                    //     echo "<option value='$room_r[room_name]'>$room_r[room_name]</option>";
                    // }</select>
                   
                    echo"        
                    <br>
                    <label for='faculty'> Choose Faculty</label>
                    <select name='faculty' id='faculty'>";
                    $faculty_q="Select count(*) as no_of_faculty ,faculty_id,fname from u_faculty where dept_id='$_POST[dept]'";
                    $faculty_r=mysqli_query($conn,$faculty_q);       
                    $faculty=mysqli_fetch_assoc($faculty_r);     
                    // while(($faculty=mysqli_fetch_assoc($faculty_r)))
                    //     {
                    //         echo "<option value='$faculty[fname]'>$faculty[fname]</option>";
                    //     }
                    
                    for ($x=1; $x <=10 ; $x++) { 
                        echo "<option value='$faculty[fname]'>Faculty".$x."</option>";
                    }
                    echo " </select><br>";
                    // $students_in_room = 0;
                    // if ($i == $quotient - 1 && $remainder > 0) {
                    //     $students_in_room = $remainder;
                    // } else {
                    //     $students_in_room = 25;
                    // }
                    // echo "<span>Number of students in this room: $students_in_room</span><br><br>";
                }  
                echo "</td>";
            
            }
       
        }
    }
?>
</table>
<button class="btnn" type="submit">submit</button>
</form>
</body>
</html>

