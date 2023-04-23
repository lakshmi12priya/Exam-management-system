<?php
 include '../header.php';
$adid = $_POST['adid'];
$password = $_POST['password'];
//database connection
if($conn->connect_error) {
    die("Failed to connect: ".$conn->connect_error);
} else {
    $stmt = $conn->prepare("select * from admin where admid = ?");
    $stmt->bind_param("s",$adid);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
         $data = $stmt_result->fetch_assoc();
         if($data['password'] === $password) {
             echo "login successfull";
             header("Location: ../external_marks/ext_marks.php");
         } else {
             echo "invalid email or password";
         }
    } else {
        echo "<h2>Invalid email or password</h2>";
    }
}
?>
