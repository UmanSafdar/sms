<?php
$base_url = "/my_sms/admin/";
?>

<div class="col-md-3 col-lg-2 bg-dark min-vh-100 p-0">

    <div class="text-center text-white py-4 border-bottom">
        <h4>SMS Admin</h4>
    </div>

    <div class="list-group list-group-flush">

        <a href="<?php echo $base_url; ?>admin_dashboard.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Dashboard
        </a>

        <a href="<?php echo $base_url; ?>students.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Students
        </a>

        <a href="<?php echo $base_url; ?>teachers.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Teachers
        </a>

        <a href="<?php echo $base_url; ?>classes.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Classes
        </a>

        <a href="<?php echo $base_url; ?>subjects.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Subjects
        </a>

        <a href="<?php echo $base_url; ?>fees.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Fees
        </a>

        <a href="<?php echo $base_url; ?>reports/reports_dashboard.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Reports
        </a>

        <a href="<?php echo $base_url; ?>settings.php"
           class="list-group-item list-group-item-action bg-dark text-white">
            Settings
        </a>

        <a href="/my_sms/logout.php"
           class="list-group-item list-group-item-action bg-danger text-white">
            Logout
        </a>

    </div>

</div>