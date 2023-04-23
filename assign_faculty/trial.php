<?php 
    session_start();
    $connection=NEW mysqli("localhost","laks","No","res");

    $dept = $_SESSION["dept"];
    $sem = $_SESSION["sem"];
    $yr = $_SESSION["year"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>External Mark edit</title>
    <style>
        .ptu-title__container {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin: 0 auto;
            max-width: 1000px;
            padding: 1rem;
        }
        .ptu-title__logo-header {
            display: contents;
        }
            .ptu-title__logo {
            height: 150px;
            width: 150px;
        }
            .ptu-title__first-letter{
            font-size:50px;
            color: brown;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            padding-top: 10px;
        }
        .ptu-title__collage-name-container {
            color: #69180d;
            text-align: center;
            width: 100%;
        }
        .ptu-title__collage-name {
            font-family: Poppins;
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        .ptu-title__place {
            font-family: Poppins;
            font-size: 18px;
            font-weight: 500;
            padding: 0;
        }
        
        label{
            letter-spacing: 0.8px;
            font-weight: bold;
            margin-left: 5%;
        }
        button
        {
            padding: 8px;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            background-color: #000;
        }
        button:hover
        {
            background-color: brown;   
        }
        select
        {
            padding: 4px 4px;
            border-radius: 10px;
        }
        .container3,.container4
        {
            margin-bottom: 12px;
            margin-left: 5%;
        }

        .container1
        {
            position: relative;
            width: 60%;
            height: auto;
            background-color: whitesmoke;
            padding: 20px;
            box-shadow: 0px 50px 50px rgba(0,0,0,0.3);
            border-radius: 14px;
        }
        .container1 h2
        {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            margin-left: 35%;
            padding: 0px 0px 20px 0px;
        }
        .container2
        {
            margin-left: 20%;
        }
        .container2 button
        {
            margin-left: 10%;
            margin-bottom: 30px;
        }
        .container3 select
        {
            margin-left: 8%;
        }
        .container4 select
        {
            margin-left: 4.9%;
        }
        table{
            margin-left: 150px;
        }
        table,tr,th
        {
            border: 1px solid black;
            padding: 5px;
        }
        .container6 button
        {
            margin: 20px;
            margin-left: 25%;
        }
        .top_details{
            font-family: 'Calibra';
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div>
        <section class="ptu-title__container">
        <div class="ptu-title__logo-header">
        <a href="https://www.ptuniv.edu.in/" style="text-decoration: none; width: 190px;"> 
        <img src="https://ptuniv.edu.in/images/old-approved-logo.png" class="ptu-title__logo" alt="Puducherry Technological University"> 
        </a>
        </div>
        <div class="ptu-title__collage-name-container">
        <h1 class="ptu-title__collage-name">
        <span class="ptu-title__first-letter">P</span>
        <span>UDUCHERRY </span>
        <span class="ptu-title__first-letter">T</span>
        <span>ECHNOLOGICAL </span>
        <span class="ptu-title__first-letter">U</span>
        <span>NIVERSITY</span>
        </h1>
        <h5 class="ptu-title__place">Puducherry,India</h5>
        </div>
        </section>
    </div>
    <div class="container1" style="margin-left:18%; margin-bottom:1%; padding: 30px; ">
        <h2 style="margin-left: 33%;">COE ADMIN - EXTERNAL MARK EDIT</h2>
        <div class="top_details" style="margin-left: 420px; margin-bottom:20px;">
        <p> Department: <?php echo $dept ?> </p>
        <p> Semester: <?php echo $sem ?> </p>
        <p> Year: <?php echo $yr ?> </p>
        </div>


        <form action="adminedit_action.php" method="POST" autocomplete="off">

        <div class="container5" style="margin-left:3%">
                        <table>
                            <thead>
                                <tr>    <!----table headers for the table--->
                                    <th>NAME</th>
                                    <th>REG_NO</th>
                                    <th>SUBJECT</th>
                                    <th>INTERNAL</th>
                                    <th>EXTERNAL</th>
                                    <th>TOTAL</th>
                                </tr>
                                <tbody>
                                    <?php
                           #table to enter marks by coe emplyee
                            $sql="SELECT student.name,student.Reg_No,external.EXTERNAL,external.INTERNAL,external.TOTAL,external.subject_code,ptu_subject.sub_name
                            FROM student 
                            JOIN external ON student.Reg_No=external.REGISTER_NO join ptu_subject on external.subject_code=ptu_subject.sub_code
                            WHERE external.SEMESTER='$sem' AND external.DEPARTMENT='$dept' 
                            AND student.Year_Of_Joining='$yr' ";

                            $result=mysqli_query($connection,$sql);
                            $count=-1;
                            // $n=[];
                           
                            if($result){
                                $_SESSION['ext_marks']=array();
                                foreach($result as $x)
                                {
                                    array_push($_SESSION['ext_marks'],array($x['Reg_No'],$x['name'],$x['subject_code'],$x['sub_name'],$x['INTERNAL'],$x['EXTERNAL']));
                                }
                                foreach($_SESSION['ext_marks'] as $i => $row){
                                    $count++;
                                    $name=$row[1];
                                    $reg=$row[0];
                                    // array_push($n,$reg);
                                    $internal=$row[4];
                                    $external=$row[5];
                                    $total=$row['TOTAL'];
                                    $sub=$row['sub_name'];
                                    $subcode=$row['subject_code'];
                                    echo '
                                    <tr>
                                        <th scope="row">'.$name.'</th>
                                        <th scope="row">'.$reg.'</th>
                                        <th scope="row">'.$sub.'</th>
                                        <td scope="row"><input style="margin-left: 18px; padding: 2px 2px;" type="number" size="2" name="inter[]" value="'.$internal.'" readonly></td>
                                        <td><input style="margin-left: 18px;  padding: 4px 4px;"  type="number" size="2" name="exter[]" value="'.$external.'" oninput="add()"   min=0 max=60></td>
                                        <td><input style="margin-left: 7px; padding: 3px 4px;" type="number" size="2" name="total[]" value="'.$total.'" ></td>
                                    </tr>';
                                    $_SESSION['subcode'] =$subcode;
                                }
                               
                                    
                                }
                                $_SESSION["count"]=$count;
                                $_SESSION["n"]=$n;
                                ?>
                                </tbody>
                            </thead>
                        </table>
                </div>
                    <!--commit button-->
                    <div class="container6" style="margin-top: 0px;margin-left: 31%;">
                        <button>COMMIT</button>
                    </div>
                    
            </form>
            <!--go back button-->
            <form style="margin-top: 0px;margin-left: 48%;" action="form0.php">
                        <button>GO BACK</button>
                    </form>
        </div>
    </div>
</body>
<script>   

    var a1 = document.getElementsByName("inter[]");
    var a2 = document.getElementsByName("exter[]");
    var a3 = document.getElementsByName("total[]");
    var arr1 = [];
    var arr2 = [];
    var sum = [];
    

    function add()
    {
    for (var i = 0; i < a1.length; i++) {
        arr1[i] = parseFloat(a1[i].value);
        arr2[i] = parseFloat(a2[i].value);

        sum[i] = arr1[i] + arr2[i];
        a3[i].value = sum[i];
    }
    console.log(sum);
}
</script>
</html>




