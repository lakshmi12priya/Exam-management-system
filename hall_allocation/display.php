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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
    </script>
</head>
<div class="makepdf">
<table>
    <tr>
        <th>Date</th>
        <th>Subject</th>
        <th>Room</th>
        <th>Faculty</th>
    </tr>
<?php
    $dets_query='Select ex_date,t.ex_session,t.course_code,course_name
           from exam_timetable t,u_course
           where t.course_code=u_course.course_code';
    $dets_run=mysqli_query($conn,$dets_query);
    while(($details=mysqli_fetch_assoc($dets_run)))
    {
        echo "<tr>
        <td>$details[ex_date]</td>
        <td>$details[course_name] </td>";
        $room=$_POST['room'];
        $faculty=$_POST['faculty'];
        echo "
        <td>$room</td>
        <td>$faculty</td>
        </tr>";
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
</html>