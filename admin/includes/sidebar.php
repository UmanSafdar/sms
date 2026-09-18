
<?php 
$base_url = "/my_sms/admin/"; 
?> 

<div class="col-md-3 col-lg-2 min-vh-100 p-10 position-fixed start- pt-5 custom-sidebar "> 
<br>
    <div class="text-center text-white py-4 border-bottom sidebar-header"> 
        <h4>SMS Admin</h4> 
    </div> 

    <div class="list-group list-group-flush"> 

        <a href="<?php echo $base_url; ?>admin_dashboard.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Dashboard 
        </a> 

        <a href="<?php echo $base_url; ?>students.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Students 
        </a> 

        <a href="<?php echo $base_url; ?>teachers.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Teachers 
        </a> 

        <a href="<?php echo $base_url; ?>classes.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Classes 
        </a> 

        <a href="<?php echo $base_url; ?>subjects.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Subjects 
        </a> 

        <a href="<?php echo $base_url; ?>fees.php" 
           class="list-group-item list-group-item-action sidebar-link"> 
            Fees 
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

