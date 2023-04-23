<?php
  include '../header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<form method="post" action="form1c_ex.php" class='get_session_form'>

  <label for="dept">Choose Department: </label>
    <select name="dept" id="dept">
      <?php
          $dept_query="Select dept_id,dept_name from u_dept";
          $dept_run=mysqli_query($conn,$dept_query);
          while(($dept=mysqli_fetch_assoc($dept_run)))
          {
              echo "<option value='$dept[dept_id]'>$dept[dept_name]</option>";
          }
      ?>
    </select>
<br><br>
<div class="input_session">
    <label>Enter Session</label>

                <label for="session_month">Month:</label>
                <select name="session_month" id="session_month">
                    <option value="A">May</option>
                    <option value="B">November</option>
                </select>

                <label for="session_year">Year:</label>
                <input type="number" name="session_year" id="session_year">
            </div>
<br>
<label for="yr">SELECT A YEAR:</label>
<div class="dropdn">
  <select name="YR" id="YR" size="1">
    <option value="2022">2022</option>
    <option value="2021">2021</option>
    <option value="2020">2020</option>
    <option value="2019">2019</option>
    <option value="2018">2018</option>    
    </select>
</div>
  <br><br>
<label for="sem">SELECT A SEM:</label>
<div class="dropdn">
  <select name="SEM" id="SEM" size="1">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
  </select>
</div>
  <br><br>
  <input type="submit" name="submit" id="submit" value="SUBMIT">
  </body>
  <style>


    
.dept-selection {
    font-family:"Trebuchet MS";
    font-size:25px;
    text-align: center;
    padding: 100px;
}
.dropdn {
  display: inline-block;  
  position: relative;
    
}
#DEPT {
  width:80px;
  height:50px;
  text-align:center;
}
input[type = submit] {
            border: 1;
            text-decoration: none;
            cursor: pointer;
            font-family:"Trebuchet MS";
            font-size:18px;
            width:100px;
            height:50px;
         }
</style>