
<?php 
$base_url = "/my_sms/student"; 
?> 

<div class="col-md-3 col-lg-2 min-vh-100 p-10 position-fixed start- pt-5 custom-sidebar "> 
<br>
    <div class="text-center text-white py-4 border-bottom sidebar-header"> 
        <h4>SMS Student</h4> 
    </div> 

    <div class="list-group list-group-flush"> 

        <a href="<?php echo $base_url; ?>/student_dashboard.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Dashboard 
        </a> 

        <a href="<?php echo $base_url; ?>/my_profile.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            My Profile 
        </a> 

        <a href="<?php echo $base_url; ?>/my_attendance.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Attendance 
        </a> 

        <a href="<?php echo $base_url; ?>/my_results.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            My Results
        </a> 

        <a href="<?php echo $base_url; ?>/my_fees.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Fees
        </a> 
        <a href="/my_sms/logout.php" 
           class="list-group-item list-group-item-action logout-link"> 
            Logout 
        </a> 

    </div> 

</div>

