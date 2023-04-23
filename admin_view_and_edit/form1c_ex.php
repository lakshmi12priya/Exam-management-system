<?php 
    include '../header.php';
    $_SESSION["dept"]=$_POST["dept"];
    $_SESSION["sem"]=$_POST["SEM"];
    $_SESSION["year"]=$_POST["YR"];
    $year =  $_POST['session_year'];
    $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
    $_SESSION['session'] = $formatted_year.$_POST['session_month'];
?>

<!DOCTYPE html>
<html lang="en">
<head></head>
<link rel="stylesheet" href="../style.css">
<body>




	<script>
        function exportTableToExcel(){
    /* Get the HTML data using Element by Id */
    var table = document.getElementById("tbldata");
 
    /* Declaring array variable */
    var rows =[];
 
      //iterate through rows of table
    for(var i=0,row; row = table.rows[i];i++){
        //rows would be accessed using the "row" variable assigned in the for loop
        //Get each cell value/column from the row
        column1 = row.cells[0].innerText;
        column2 = row.cells[1].innerText;
        column3 = row.cells[2].innerText;
        column4 = row.cells[3].innerText;
        column5 = row.cells[4].innerText;
 
    /* add a new records in the array */
        rows.push(
            [
                column1,
                column2,
                column3,
                column4,
                column5
            ]
        );
 
        }
        csvContent = "data:text/csv;charset=utf-8,";
         /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
        rows.forEach(function(rowArray){
            row = rowArray.join(",");
            csvContent += row + "\r\n";
        });
 
        /* create a hidden <a> DOM node and set its download attribute */
        var encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Student marks.csv");
        document.body.appendChild(link);
         /* download the data file named "Stock_Price_Report.csv" */
        link.click();
}

	</script>

    <div class="input-details">
        <?php 
            $dept_query="Select dept_id,dept_name from u_dept where dept_id='$_POST[dept]'";
            $dept_run=mysqli_query($conn,$dept_query);
            $dept=mysqli_fetch_assoc($dept_run);
        ?>
        DEPARTMENT:<?php echo $dept["dept_name"]; ?><br><br>
        YEAR: <?php echo $_POST["YR"]; ?><br><br>
		SEM: <?php echo $_POST["SEM"]; ?>
    </div>

    
    <div class="table-tb">
	<table id="tbldata">
		<thead>
			<tr> 
				<th>REGISTER_NUMBER</th>
				<th>NAME</th>
                  <th style="text-align: center">INTERNAL MARKS</th>
                   <th style="text-align: center">EXTERNAL MARKS </th>
                   <th style="text-align: center">SUBJECT</th>
                   <th style="text-align: center">GRADE </th>
                   <th style="text-align: center">TOTAL MARKS </th>

			</tr>
		</thead>
		<tbody>
<?php

// assuming database connection has been established already
// and department and semester values have been received from the form

$dept_id = $_POST['dept'];
$curr_sem = $_POST['SEM'];

// fetch student details
$sql = "SELECT s.sname,s.regno
FROM u_student s
JOIN u_prgm p ON s.prgm_id = p.prgm_id
JOIN u_dept d ON p.dept_id = d.dept_id
WHERE d.dept_id = '$dept_id' AND curr_sem = '$curr_sem'";
// SELECT regno, sname FROM u_student WHERE dept_id = '$dept_id' AND curr_sem = '$curr_sem'";
$result = mysqli_query($conn, $sql);

// iterate over each student and fetch course details
while($row = mysqli_fetch_assoc($result)) {
  $regno = $row['regno'];
  $sname = $row['sname'];
  
  // fetch courses registered by the student
//   $sql_courses = "SELECT c.course_code, c.course_name, cr.internal_marks
//                   FROM u_course c
//                   JOIN u_course_regn cr ON c.course_code = cr.course_code
//                   WHERE cr.regno = '$regno' AND cr.sem = '$curr_sem'";

  $sql_courses="  SELECT  c.internal_marks, e.external_marks, e.total, u_course.course_name ,c.course_code,e.grade
  FROM u_external_marks e JOIN u_student s ON e.regno = s.regno 
  JOIN u_course_regn c ON e.course_code = c.course_code 
  AND e.regno = c.regno JOIN u_course ON u_course.course_code = e.course_code 
  WHERE e.session = '$_SESSION[session]' AND c.regno = '$regno' AND c.sem = '$curr_sem'";

  $result_courses = mysqli_query($conn, $sql_courses);

  
  // iterate over each course and fetch exam and marks details
  while($row_courses = mysqli_fetch_assoc($result_courses)) {
    $course_code = $row_courses['course_code'];
    $course_name = $row_courses['course_name'];
    $internal_marks = $row_courses['internal_marks'];
    $external_marks = $row_courses['external_marks'];
    $grade = $row_courses['grade'];
    $total=$row_courses['total'];
    
    
    // display data in a table row
    echo "<tr>";
    echo "<td>$regno</td>";
    echo "<td>$sname</td>";
    echo "<td>$internal_marks</td>";
    echo "<td>$external_marks</td>";
    echo "<td>$course_name</td>";
    echo "<td>$grade</td>";
    echo "<td>$total</td>";
    echo "</tr>";
  }
}

?>

</tbody>

			</table><br><br>
			<button onclick="exportTableToExcel('tbldata','student-data')">DOWNLOAD AS EXCEL</button><br>
            <form action="form2_sub.php"><br>
            <button>EDIT INTERNALS</button>
            </form><br>
            <form action="form2_ext.php">
            <button>EDIT EXTERNALS</button>
            </form>
	</div>
		

</body>
</html>
		
