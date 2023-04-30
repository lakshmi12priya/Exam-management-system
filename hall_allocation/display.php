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
    <link rel="stylesheet" href="../style.css">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
    </script>
</head>
<body>
<div id="makepdf">
    <br><br>
    <?php $sql="SELECT dept_name from u_dept where dept_id='$_SESSION[dept_id]'";
    $query=mysqli_query($conn,$sql); 
    $dept=mysqli_fetch_assoc($query);?>
    <h2 style="text-align:center;">Department: <?php echo "$dept[dept_name]"; ?></h2> 
    <h2 style="text-align:center;">Session: <?php echo "$_SESSION[chosen_session]"; ?></h2>
    <br><br>
    <table>
    <tr>
        <th>Date</th>
        <th>Subject</th>
        <th>Room</th>
        <th>Faculty</th>
    </tr>
<?php
    $dets_query="Select ex_date,t.ex_session,t.course_code,course_name,room_num,invigilator_id,no_of_students
           from exam_ROOMS t,u_course
           where t.course_code=u_course.course_code and u_course.dept_id='$_SESSION[dept_id]'";
    $dets_run=mysqli_query($conn,$dets_query);
    while(($details=mysqli_fetch_assoc($dets_run)))
    {
        echo "<tr>
        <td>$details[ex_date]</td>
        <td>$details[course_name] </td>
        <td>$details[room_num]</td>
        <td>$details[invigilator_id]</td>
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
    <div class="submit_dets">
        <button  class="submit_hall"><a href="allocate_final.php">Back</a></button>
    </div>
</body>
</html>
