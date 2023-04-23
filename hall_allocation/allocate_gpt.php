<?php

// Database connection details
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the number of students appearing for the subject
$subject = "subject_name";
$department = "department_name";
$sql = "SELECT COUNT(*) AS num_students FROM exam_table WHERE subject='$subject' AND department='$department'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$num_students = $row['num_students'];

// Calculate the number of rooms required
$num_rooms = ceil($num_students / 25);

// Allocate exam rooms
for ($i = 1; $i <= $num_rooms; $i++) {
    // Check if there are enough students in the current room
    $sql = "SELECT COUNT(*) AS num_students FROM exam_table WHERE subject='$subject' AND department='$department' AND room_number=$i";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $num_students_in_room = $row['num_students'];

    if ($num_students_in_room < 5) {
        // Allocate the students to another room
        $sql = "UPDATE exam_table SET room_number=$i WHERE subject='$subject' AND department='$department' AND room_number<>$i LIMIT " . (25 - $num_students_in_room);
        $conn->query($sql);
    } else {
        // Allocate the students to this room
        $sql = "UPDATE exam_table SET room_number=$i WHERE subject='$subject' AND department='$department' AND room_number IS NULL LIMIT 25";
        $conn->query($sql);
    }
}

// Allocate invigilators to each room
$sql = "SELECT DISTINCT room_number FROM exam_table WHERE subject='$subject' AND department='$department'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $room_number = $row['room_number'];

    // Fetch a list of available invigilators
    $sql = "SELECT invigilator_id FROM invigilator_table WHERE is_available=1";
    $invigilator_result = $conn->query($sql);

    if ($invigilator_result->num_rows > 0) {
        // Assign an invigilator to the room
        $invigilator_row = $invigilator_result->fetch_assoc();
        $invigilator_id = $invigilator_row['invigilator_id'];

        $sql = "UPDATE exam_table SET invigilator_id=$invigilator_id WHERE subject='$subject' AND department='$department' AND room_number=$room_number";
        $conn->query($sql);

        // Mark the invigilator as unavailable
        $sql = "UPDATE invigilator_table SET is_available=0 WHERE invigilator_id=$invigilator_id";
        $conn->query($sql);
    } else {
        echo "Error: No available invigilators for room $room_number";
    }
}

// Close the database connection
$conn->close();

?>
