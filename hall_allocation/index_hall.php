<?php
    include 'connection.php';
    session_start();
    include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall allocation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <form action="allocate_final.php" method="post" class='get_session_form'>
        <div class="input_dept">
        <label for="dept">Choose Department: </label>
        <select name="dept" id="dept">
            <?php
                $dept_query='Select dept_id,dept_name from u_dept';
                $dept_run=mysqli_query($conn,$dept_query);
                while(($dept=mysqli_fetch_assoc($dept_run)))
                {
                    echo "<option value='$dept[dept_id]'>$dept[dept_name]</option>";
                }
            ?>
        </select>
        </div>
        <div class="input_session">
            <div class="label_session">
                <label>Enter Session</label>
            </div>

            <div class="label_session_month">
                <label for="session_month">Month:</label>
            </div>
            <select name="session_month" id="session_month">
                <option value="A">May</option>
                <option value="B">November</option>
            </select>

            <div class="label_session_year">
                <label for="session_year">Year:</label>
            </div>
            <input type="number" name="session_year" id="session_year">
        </div>
        <!-- <label for="session">Choose Session: </label>
        <select name="session" id="session">
            <option value="">Choose session</option>
            <option value="fn">Forenoon</option>
            <option value="an">Afternoon</option>
        </select> -->
        <!-- <br>
        
        <label for="session">Choose Sem Type: </label>
        <select name="session" id="session">
            <option value="">Choose sem type</option>
            <option value="even">Even</option>
            <option value="odd">Odd</option>
        </select> -->
        <br> <br> <br> <br><br>
        <div class="submit_dets">
        <button type="submit" class="submit_hall">Submit</button>
        </div>
    </form>
</body>
</html>