<?php
include '../header.php';


?>
<html>
    <div class="dept">
    <form action="assign_faculty.php" method="post" class="get_session_form">
        <label for="dept">Department</label>
        <select name="dept" id="dept">
        <?php
            $dept_query="Select dept_name,dept_id from u_dept";
            $dept=mysqli_query($conn,$dept_query);
            while(($dep=mysqli_fetch_assoc($dept)))
            {
                echo "<option value='$dep[dept_id]'>$dep[dept_name]</option>";
            }
        ?>
        </select>
        <br>
        <!-- <label for="session">Session</label> -->
        <br>
        <label>Enter Session</label>

        <label for="session_month">Month:</label>
        <select name="session_month" id="session_month">
            <option value="A">May</option>
            <option value="B">November</option>
        </select>

        <label for="session_year">Year:</label>
        <input type="number" name="session_year" id="session_year">
        <div class="submit_dets">
        <button type="submit" class="submit_hall">Submit</button>
        </div>
    </form>
    </div>
    
</html>

