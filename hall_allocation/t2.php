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
        <th>Room</th>
        <th>Faculty</th>
    </tr>
<?php
    $year =  $_POST['session_year'];
    $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
    $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];
    $dets_query="Select ex_date,t.ex_session,t.course_code,course_name
           from exam_timetable t,u_course
           where t.course_code=u_course.course_code and t.ex_session='$_SESSION[chosen_session]'";
    $dets_run=mysqli_query($conn,$dets_query);
    $assigned_faculties = array();
    while(($details=mysqli_fetch_assoc($dets_run)))
    {
        $display_date = date('d-m-Y', strtotime($details['ex_date']));

        echo "<tr>
        <td>$display_date</td>
        <td>$details[course_name] </td>";
        $course_code=$details['course_code'];
        $exam_session=$details['ex_session'];
        $count_query="Select count(*) as num  from u_external_marks where COURSE_CODE='$course_code' and session='$exam_session'";
        $count_r=mysqli_query($conn,$count_query);
        $count=mysqli_fetch_assoc($count_r);
        $no_of_students=$count['num'];
        echo "<td>$no_of_students</td>";
        $num_rooms=intdiv($no_of_students,25);
        $remainder=$no_of_students%25;
        $dept_id=$_POST['dept'];
        $faculty_q="Select count(*) as no_of_faculty, faculty_id,fname from u_faculty where dept_id='$_POST[dept]'";
        $faculty_r=mysqli_query($conn,$faculty_q);
        $room="select room_name,room_id from room";
        $room_q=mysqli_query($conn,$room);
        echo "<td>";
        for ($i = 1; $i <= $num_rooms; $i++) {
            $room_num = $dept_id . "_room" . $i;
            echo "$room_num<br>";
        }
        echo "</td>";
        echo "<td>";
        $assigned_faculties_for_exam = array();
        for ($i = 1; $i <= $num_rooms; $i++) {
            $invigilator_query = mysqli_query($conn, "SELECT * FROM u_faculty WHERE DEPT_ID='$dept_id' ORDER BY RAND()");
            while ($invigilator_row = mysqli_fetch_array($invigilator_query)) {
                $invigilator_id = $invigilator_row['FACULTY_ID'];
                if (!in_array($invigilator_id, $assigned_faculties_for_exam) && !in_array($invigilator_id, $assigned_faculties)) {
                    echo "<input type='checkbox' name='faculty[]' value='$invigilator_id'>". $invigilator_row['FNAME']."<br>";
                    array_push($assigned_faculties_for_exam, $invigilator_id);
                    array_push($assigned_faculties, $invigilator_id);
                    break;
    }
}
}
echo "</td>";
echo "</tr>";
}
?>

</table>
<input type="submit" name="submit" value="submit">
</form>
</body>
</html>