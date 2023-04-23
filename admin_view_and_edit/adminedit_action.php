<?php 
$c=$_SESSION['count'];
$sem=$_SESSION['sem'];
$dept=$_SESSION['dept'];
$n=$_SESSION['n'] ;
$sub=$_SESSION['sub'] ;
$inter=$_POST['inter'];
$exter=$_POST['exter'];
$total=$_POST['total'];
?>
<!doctype html>
<head>
        <!-- Bootstrap CSS -->
      <title>Successful!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b1f6ad3c45.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
      $connection=NEW mysqli("localhost","laks","No","res");
        $i=0;
      for($i=0;$i<=$c;$i++)
      { 
        $g=0;
        $qu="UPDATE EXTERNAL SET EXTERNAL='$exter[$i]' where REGISTER_NO='$n[$i]' and SEMESTER='$sem' and SUBJECT_CODE='$sub'";
        $qu2="UPDATE EXTERNAL SET TOTAL='$total[$i]' where REGISTER_NO='$n[$i]' and SEMESTER='$sem' and SUBJECT_CODE='$sub'";
        $result=mysqli_query($connection,$qu);
        $result=$connection->query($qu2);
        if($total[$i]<50 || $exter[$i]<24)
        {   $g='F'; }
        else if($total[$i]>=50 && $total[$i]<55 && $exter[$i]>=24)
        {   $g='E'; }
        else if($total[$i]>=55 && $total[$i]<60 && $exter[$i]>=24)
        {   $g='D'; }
        else if($total[$i]>=60 && $total[$i]<70 && $exter[$i]>=24)
        {   $g='C'; }
        else if($total[$i]>=70 && $total[$i]<80 && $exter[$i]>=24)
        {   $g='B'; }
        else if($total[$i]>=80 && $total[$i]<90 && $exter[$i]>=24)
        {   $g='A'; }
        else if($total[$i]>=90 && $total[$i]<=100 && $exter[$i]>=24)
        {   $g='S'; }
        $qu3="UPDATE EXTERNAL SET GRADE='$g' where REGISTER_NO='$n[$i]' and SEMESTER='$sem' and SUBJECT_CODE='$sub'";
        $result=$connection->query($qu3);

      }
      ?>
      <br><br><br>
  <div class="container">
  <div class="alert alert-success" role="alert" style="font-family:'Arial';text-align:center">
  <i class="fa-solid fa-circle-check" style="height: 60px;"></i>
   Marks have been successfully entered. 
 </div> 
  </div>
  <form style="margin-top: 0px;margin-left: 43.5%;" action="form0.php">
                        <button>GO BACK</button>
                    </form>
    </body>
    </html>
