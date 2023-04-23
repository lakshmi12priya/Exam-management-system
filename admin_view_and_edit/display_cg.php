<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Department and semester filter
$dept_id = "your_department_id";
$curr_sem = "your_current_semester";

// Get the courses registered by the students in the specified department and semester
$sql_courses = "SELECT course_code, course_name FROM u_course WHERE dept_id = '$dept_id'";
$result_courses = $conn->query($sql_courses);

// Store the courses in an array
$courses = array();
if ($result_courses->num_rows > 0) {
    while ($row = $result_courses->fetch_assoc()) {
        $courses[$row['course_code']] = $row['course_name'];
    }
}

// Get the students in the specified department and semester
$sql_students = "SELECT regno, sname FROM u_student WHERE dept_id = '$dept_id' AND curr_sem = '$curr_sem'";
$result_students = $conn->query($sql_students);

// Display the table headers
echo "<table>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>Reg No</th>";
foreach ($courses as $course_code => $course_name) {
    echo "<th>$course_name<br>(Internal / External / Total)</th>";
}
echo "</tr>";

// Fetch and display the marks for each student
if ($result_students->num_rows > 0) {
    while ($row = $result_students->fetch_assoc()) {
        // Get the internal marks for the student in each course
        $regno = $row['regno'];
        $sql_internal = "SELECT course_code, internal_marks FROM u_course_regn WHERE regno = '$regno' AND sem = '$curr_sem'";
        $result_internal = $conn->query($sql_internal);
        $internal_marks = array();
        if ($result_internal->num_rows > 0) {
            while ($row_internal = $result_internal->fetch_assoc()) {
                $internal_marks[$row_internal['course_code']] = $row_internal['internal_marks'];
            }
        }

        // Get the external marks and grade for the student in each course
        $sql_external = "SELECT course_code, external_marks, grade FROM u_external_marks WHERE regno = '$regno'";
        $result_external = $conn->query($sql_external);
        $external_marks = array();
        $grades = array();
        if ($result_external->num_rows > 0) {
            while ($row_external = $result_external->fetch_assoc()) {
                $external_marks[$row_external['course_code']] = $row_external['external_marks'];
                $grades[$row_external['course_code']] = $row_external['grade'];
            }
        }

        // Calculate the total marks for the student in each course
        $total_marks = array();
        foreach ($courses as $course_code => $course_name) {
            if (isset($internal_marks[$course_code]) && isset($external_marks[$course_code])) {
                $total_marks[$course_code] = $internal_marks[$course_code] + $external_marks[$course_code];
            } else {
                $total_marks[$course_code] = "-";
            }
        }

        // Display the marks for the student
        echo "<tr>";
        echo "<td>"
