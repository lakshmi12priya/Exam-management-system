<?php
    include '../header.php';
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
        $display_date = date('d-m-Y', strtotime($details['ex_date']));

        echo "<tr>
        <td>$display_date</td>
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
        $num_rooms=intdiv($no_of_students,25); //no.of rooms
        // echo "<td> $quotient</td>";
        $remainder=$no_of_students%25;
        // echo "<td>$remainder<br></td> ";
       
 
        $dept_id=$_POST['dept'];
        $faculty_q="Select count(*) as no_of_faculty, faculty_id,fname from u_faculty where dept_id='$_POST[dept]'";
        $faculty_r=mysqli_query($conn,$faculty_q);
        $room="select room_name,room_id from room";
        $room_q=mysqli_query($conn,$room);

        if($num_rooms<=1)
        {
            $invigilator_query = mysqli_query($conn, "SELECT * FROM u_faculty WHERE DEPT_ID='$dept_id' ORDER BY FACULTY_ID");
        $invigilators = array();
        // $faculties_array = array();
        $invigilator_idx = 0;

        while ($invigilator_row = mysqli_fetch_array($invigilator_query)) {
            $invigilator_id = $invigilator_row['FACULTY_ID'];
            array_push($invigilators, $invigilator_id);
            // $faculties_array[]=$invigilator_row['FACULTY_ID'];
        }
        echo "<td>";
            $room_num = $dept_id . "_room1" ;

            // Allocate invigilator for the room
            // $invigilator_id = $invigilators[($i-1) % count($invigilators)];
            // $invigilator_id=$faculties_array[array_rand($faculties_array)];
            $invigilator_id = $invigilators[$invigilator_idx % count($invigilators)];
            $invigilator_idx++;
            echo "Room: $room_num
            Faculty : $invigilator_id<br>";
            // Insert exam room and invigilator into database
            // mysqli_query($conn, "INSERT INTO exam_rooms (course_code, ex_date, session, exam_type, ex_session, 
            //                     room_num, invigilator_id) VALUES ('$course_code', '$ex_date', '$session', 
            //                     '$exam_type', '$ex_session', '$room_num', '$invigilator_id')");
        
        echo "</td>";
        }
        else
        {
            if($remainder<=5)
            {
                $invigilator_query = mysqli_query($conn, "SELECT * FROM u_faculty WHERE DEPT_ID='$dept_id' ORDER BY FACULTY_ID");
                $invigilators = array();
                // $faculties_array = array();
                $invigilator_idx = 0;
        
                while ($invigilator_row = mysqli_fetch_array($invigilator_query)) {
                    $invigilator_id = $invigilator_row['FACULTY_ID'];
                    array_push($invigilators, $invigilator_id);
                    // $faculties_array[]=$invigilator_row['FACULTY_ID'];
                }
                echo "<td>";
                for ($i = 1; $i <= $num_rooms; $i++) {
                    $room_num = $dept_id . "_room" . $i;
        
                    // Allocate invigilator for the room
                    // $invigilator_id = $invigilators[($i-1) % count($invigilators)];
                    // $invigilator_id=$faculties_array[array_rand($faculties_array)];
                    $invigilator_id = $invigilators[$invigilator_idx % count($invigilators)];
                    $invigilator_idx++;
                    echo "Room: $room_num
                    Faculty : $invigilator_id<br>";
                    // Insert exam room and invigilator into database
                    // mysqli_query($conn, "INSERT INTO exam_rooms (course_code, ex_date, session, exam_type, ex_session, 
                    //                     room_num, invigilator_id) VALUES ('$course_code', '$ex_date', '$session', 
                    //                     '$exam_type', '$ex_session', '$room_num', '$invigilator_id')");
                }
                echo "</td>";
            }
            else
            {
                $flag=1;
                // echo "Allocate in separate room <br>";
                $invigilator_query = mysqli_query($conn, "SELECT * FROM u_faculty WHERE DEPT_ID='$dept_id' ORDER BY FACULTY_ID");
                $invigilators = array();
                // $faculties_array = array();
                $invigilator_idx = 0;
        
                while ($invigilator_row = mysqli_fetch_array($invigilator_query)) {
                    $invigilator_id = $invigilator_row['FACULTY_ID'];
                    array_push($invigilators, $invigilator_id);
                    // $faculties_array[]=$invigilator_row['FACULTY_ID'];
                }
                echo "<td>";
                for ($i = 1; $i <= $num_rooms+1; $i++) {
                    $room_num = $dept_id . "_room" . $i;
        
                    // Allocate invigilator for the room
                    // $invigilator_id = $invigilators[($i-1) % count($invigilators)];
                    // $invigilator_id=$faculties_array[array_rand($faculties_array)];
                    $invigilator_id = $invigilators[$invigilator_idx % count($invigilators)];
                    $invigilator_idx++;
                    echo "Room: $room_num
                    Faculty : $invigilator_id<br>";
                    // Insert exam room and invigilator into database
                    // mysqli_query($conn, "INSERT INTO exam_rooms (course_code, ex_date, session, exam_type, ex_session, 
                    //                     room_num, invigilator_id) VALUES ('$course_code', '$ex_date', '$session', 
                    //                     '$exam_type', '$ex_session', '$room_num', '$invigilator_id')");
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

