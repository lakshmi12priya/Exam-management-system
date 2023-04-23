<?php 
include '../header.php';
?>
<!doctype html>
<html lang="en">
<head>
    <title>COE Login</title>
    <link rel="stylesheet" href="../style.css">

</head>
<style>
.form-center {
  display:flex;
  justify-content: center;
}
.form-center {
  width:400px;
  margin: 0 auto;
}
</style>
<body>
<div>
<br>
<h1 style="text-align:center; color:darkred;"> EDIT EXTERNALS - COE LOGIN </h1>
<br>
<br>

<div class="form-center ">

<form method="post" action="loginext.php">
    <label for="name">ENTER COE LOGIN ID: </label>
    <input type="text" name="adid" id="adid" maxlength="100" autocomplete="off"><br><br>
    <label for="dept">ENTER YOUR PASSWORD: </label>
    <input type="password" name="password" id="password" maxlength="100" placeholder="10-digit number">
    <br><br>
    <input type="submit" name="submit" id="submit" value="SUBMIT">
</form>
</div> 
</body>


</html>

