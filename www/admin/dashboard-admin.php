<?php
ob_start();
session_start();
if(isset($_SESSION["loggedin"]) != true){
    header("location: ../index.php");
    exit;
}

require "../templates/header.php"; 

$acc_username = "";

if (isset($_SESSION['pass_username'])) {
    $acc_username = $_SESSION['pass_username'];
}else{
    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> No username found.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
}

if (isset($_SESSION['pass_site_name'])) {
    $pass_site_name = $_SESSION['pass_site_name'];
}else{
     echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> No vaccination site found.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
}?>

<div class="dashbody" id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle" onclick="openEnt()"> <img id="logo-top" src="../img/VacciTrack_logo_3B.png" alt="Logo"></i> </div>
        <div class="header_img"> <?php echo $pass_site_name;  ?> </div>
    </header>
    <Scrollbar>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <p href="#" class="nav_logo"> <i class='bx bx-user-circle nav_logo-icon'></i> <span class="nav_logo-name"><?php echo $acc_username; ?></span> </p>
            <div class="nav_list"> 
                <a href="../admin/default-dash.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>

                <!-- <nav class="sidebar">
                    <ul class="nav flex-column" id="nav_accordion">
                        <li class="nav-item has-submenu">
                            <a class="nav_link" href="#"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Accounts</span>  </a>
                            <ul class="submenu collapse">
                                <li class="sublink"><a href="../admin/user-accounts.php" class="nav_link sub_link">
                                        <i class='bx bx-group nav_icon'></i> <span class="nav_name">Users</span> </a> 
                                </li>
                                <li class="sublink"><a href="../admin/user-accounts-reg.php" class="nav_link sub_link"> 
                                        <i class='bx bx-user-plus nav_icon'></i> <span class="nav_name">Add User</span> </a>
                                </li>
                                <li class="sublink"><a href="../admin/user-requests-admin.php" class="nav_link sub_link"> 
                                        <i class='bx bx-user-check nav_icon'></i> <span class="nav_name">Access Requests</span> </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav> -->
                <hr class="sidebar_line">

                <a href="../admin/user-accounts.php" class="nav_link sub_link">
                    <i class='bx bx-group nav_icon'></i> <span class="nav_name">Users</span> </a> 

                <a href="../admin/user-accounts-reg.php" class="nav_link sub_link"> 
                    <i class='bx bx-user-plus nav_icon'></i> <span class="nav_name">Add User</span> </a>

                <a href="../admin/user-requests-admin.php" class="nav_link sub_link"> 
                    <i class='bx bx-user-check nav_icon'></i> <span class="nav_name">Access Requests</span> </a>

                <hr class="sidebar_line">
            
                <a href="../admin/vacc-site.php" class="nav_link"> 
                    <i class='bx bx-map-pin nav_icon'></i> <span class="nav_name">Vaccination Sites</span> </a> 
                <a href="../admin/vacc-name.php" class="nav_link"> 
                    <i class='bx bx-injection nav_icon'></i> <span class="nav_name">List of Vaccines</span> </a> 
                <a href="../admin/list_sched.php" class="nav_link"> 
                    <i class='bx bx-calendar-check nav_icon'></i> <span class="nav_name">Vaccination Dates</span> </a> 
                <a href="../admin/admin_statistics.php" class="nav_link"> 
                    <i class='bx bx-stats nav_icon'></i> <span class="nav_name">Statistics</span> </a>  
                
                <hr class="sidebar_line">

                <a href="../admin/update_account.php" class="nav_link sub_link"> 
                    <i class='bx bx-message-square-edit nav_icon'></i> <span class="nav_name">Update Account</span> </a> 

                <a href="../admin/activity_logs.php" class="nav_link sub_link"> 
                    <i class='bx bx-notepad nav_icon'></i> <span class="nav_name">Activity Logs</span> </a> 

                <!-- <nav class="sidebar">
                    <ul class="nav flex-column" id="nav_accordion">
                        <li class="nav-item has-submenu">
                            <a class="nav_link" href="#"> <i class='bx bx-customize nav_icon'></i> <span class="nav_name">Settings</span>  </a>
                            <ul class="submenu collapse">
                                <li class="sublink"><a href="../admin/update_account.php" class="nav_link sub_link">
                                        <i class='bx bx-message-square-edit nav_icon'></i> <span class="nav_name">Update Account</span> </a> 
                                </li>
                                <li class="sublink"><a href="../admin/activity_logs.php" class="nav_link sub_link"> 
                                        <i class='bx bx-notepad nav_icon'></i> <span class="nav_name">Activity Logs</span> </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav> -->

            </div>
            </div> <a href="../templates/logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
</div>

<script>
    $(function(){
        $('a').each(function(){
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); 
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function(){
      document.querySelectorAll('.sidebar .nav_link').forEach(function(element){
        
        element.addEventListener('click', function (e) {

          let nextEl = element.nextElementSibling;
          let parentEl  = element.parentElement;    

            if(nextEl) {
                e.preventDefault(); 
                let mycollapse = new bootstrap.Collapse(nextEl);
                
                if(nextEl.classList.contains('show')){
                  mycollapse.hide();
                } else {
                    mycollapse.show();
                    // find other submenus with class=show
                    var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                    // if it exists, then close all of them
                    if(opened_submenu){
                      new bootstrap.Collapse(opened_submenu);
                    }
                }
            }
        }); // addEventListener
      }) // forEach
    }); 
        
</script>
<?php require "../templates/footer.php"; ?>