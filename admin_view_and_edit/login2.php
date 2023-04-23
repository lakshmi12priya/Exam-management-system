<?php
include '../header.php';
$name = $_POST['name'];
$password = $_POST['password'];
$fname=$_SESSION["fname"];

//database connection
if($conn->connect_error) {
    die("Failed to connect: ".$conn->connect_error);
} else {
    $stmt = $conn->prepare("SELECT * from u_faculty where Faculty_Id = ? and fname='$fname' ");
    $stmt->bind_param("s",$name);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
         $data = $stmt_result->fetch_assoc();
         if($data['PASSWORD'] === $password) {
             echo "login successfull";
             header("Location: staffedit.php");
         } else {
             echo "Invalid email or password";
         }
    } else {
        echo "<h2>Invalid email or password</h2>";
    }
}
?>
