
<?php 
$base_url = "/my_sms/teacher/"; 
?> 

<div class="col-md-3 col-lg-2 min-vh-100 p-10 position-fixed start- pt-5 custom-sidebar "> 
<br>
    <div class="text-center text-white py-4 border-bottom sidebar-header"> 
        <h4>SMS Teacher</h4> 
    </div> 

    <div class="list-group list-group-flush"> 

        <a href="<?php echo $base_url; ?>teacher_dashboard.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Dashboard 
        </a> 

        <a href="<?php echo $base_url; ?>profile.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            My Profile 
        </a> 

        <a href="<?php echo $base_url; ?>classes.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            My Classes 
        </a> 

        <a href="<?php echo $base_url; ?>students.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Students 
        </a> 

        <a href="<?php echo $base_url; ?>attendance.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Attendance
        </a> 

        <a href="<?php echo $base_url; ?>marks.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Marks 
        </a> 

        <a href="<?php echo $base_url; ?>reports/reports_dashboard.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Reports 
        </a> 

        <a href="<?php echo $base_url; ?>settings/settings.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Settings 
        </a> 

        <a href="/my_sms/logout.php" 
           class="list-group-item list-group-item-action logout-link"> 
            Logout 
        </a> 

    </div> 

</div>

