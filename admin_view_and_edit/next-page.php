<?php
if(isset($_POST["selected_date"]) && isset($_POST["format"])){
  $selected_date = $_POST["selected_date"];
  $format = $_POST["format"];
  
  $date = date_create_from_format("Y-m", $selected_date);
  $formatted_date = date_format($date, $format);
  echo $formatted_date;
  // send the formatted date to another page or perform other actions
}
?>
