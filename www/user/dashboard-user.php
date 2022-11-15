<?php
session_start();
if(isset($_SESSION["loggedin"]) != true){
    header("location: ../index.php");
    exit;
}
$acc_username = "";

if (isset($_SESSION['pass_username'])) {
    $acc_username = $_SESSION['pass_username'];
}else{
    $acc_username = "no username found";
}
if (isset($_SESSION['account_type'])) {
    $account_type = $_SESSION['account_type'];
}else{
     echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Username does not exist.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                              </div>";

}

if (isset($_SESSION['pass_site_name'])) {
    $pass_site_name = $_SESSION['pass_site_name'];
}else{
     echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Vaccination site not found.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                              </div>";

}
require "../templates/header.php"; ?>
<div class="dashbody" id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle" onclick="openEnt();"> <img id="logo-top" src="../img/VacciTrack_logo_3B.png" alt="Logo"></i> </div>
        <div class="header_img"> <?php echo $pass_site_name;  ?> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <p href="#" class="nav_logo"> <i class='bx bx-user-circle nav_logo-icon'></i> <span class="nav_logo-name"><?php echo $acc_username;?></span> </p>
            <div class="nav_list"> 
                <a href="../user/def-dash-user.php" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a> 

                <!-- <nav class="sidebar">
                    <ul class="nav flex-column" id="nav_accordion">
                        <li class="nav-item has-submenu">
                            <a class="nav_link" href="#"> <i class='bx bx-clipboard nav_icon'></i> <span class="nav_name">Records</span>  </a>
                            <ul class="submenu collapse">
                                <li class="sublink"><a href="../user/entries.php" class="nav_link sub_link">
                                        <i class='bx bx-group nav_icon'></i> <span class="nav_name">Personal Data</span> </a> 
                                </li>
                                <li class="sublink"><a href="../user/update-rec.php" class="nav_link sub_link"> 
                                        <i class='bx bx-injection nav_icon'></i> <span class="nav_name">Vaccinations</span> </a>
                                </li>
                                <li class="sublink"><a href="../user/health_declaration.php" class="nav_link sub_link"> 
                                        <i class='bx bx-plus-medical nav_icon'></i> <span class="nav_name">Health Declaration</span> </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav> -->
                <a href="../user/entries.php" class="nav_link"> 
                    <i class='bx bx-group nav_icon'></i> <span class="nav_name">Personal Data</span> </a>
                <a href="../user/update-rec.php" class="nav_link"> 
                    <i class='bx bx-injection nav_icon'></i> <span class="nav_name">Vaccinations</span> </a>
                <a href="../user/health_declaration.php" class="nav_link"> 
                    <i class='bx bx-plus-medical nav_icon'></i> <span class="nav_name">Health Declaration</span> </a> 

                <hr class="sidebar_line">

                <a href="../user/update_account_user.php" class="nav_link sub_link"> 
                    <i class='bx bx-message-square-edit nav_icon'></i> <span class="nav_name">Update Account</span> </a> 

                <a href="../user/activity_logs_user.php" class="nav_link sub_link"> 
                    <i class='bx bx-notepad nav_icon'></i> <span class="nav_name">Activity Logs</span> </a> 
                
                <!-- <nav class="sidebar">
                    <ul class="nav flex-column" id="nav_accordion">
                        <li class="nav-item has-submenu">
                            <a class="nav_link" href="#"> <i class='bx bx-customize nav_icon'></i> <span class="nav_name">Settings</span>  </a>
                            <ul class="submenu collapse">
                                <li class="sublink"><a href="../user/update_account_user.php" class="nav_link sub_link">
                                        <i class='bx bx-message-square-edit nav_icon'></i> <span class="nav_name">Update Account</span> </a> 
                                </li>
                                <li class="sublink"><a href="../user/activity_logs_user.php" class="nav_link sub_link"> 
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
                $(this).addClass('active'); $(this).parents('li').addClass('active');
            }
        });
    });    
</script>
<?php require "../templates/footer.php"; ?>