<?php
require('./admin/connection/config.php');

$sqlsched = "SELECT id, COUNT(id) AS Total FROM vaccine_schedule";

    try {
        $connection = new PDO($dsn, $username_db, $password_db, $options);

        $schednotif=$connection->prepare($sqlsched);
        $schednotif->execute();
        $countsched=$schednotif->fetchAll();
    }catch(Exception $ex) {
        echo($ex -> getMessage());
    }


$username = $password = "";
$username_err = $password_err = $login_err = "";
$account_type = "";
$id_number = "";
 
// Processing form data when form is submitted
if (isset($_POST['loginuser'])) {
     
        // Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $sql = "SELECT id, username, password, account_type, site_name FROM user_account WHERE username = :username";
            
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Check if username exists, if yes then verify password
                    if($stmt->rowCount() == 1){
                        if($row = $stmt->fetch()){
                            //$id_number = $row["id_number"];
                            $username = $row["username"];
                            $hashed_password = $row["password"];
                            $account_type = $row["account_type"];
                            $site_name = $row["site_name"];
                            if(password_verify($password, $hashed_password)){
                                // Password is correct, so start a new session                           
                                
                                // Redirect user to welcome page
                                if($account_type == "admin"){
                                
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["pass_id_number"] = $id_number;
                                    $_SESSION["pass_username"] = $username;
                                    $_SESSION["account_type"] = $account_type;
                                    $_SESSION["pass_site_name"] = $site_name; 

                                    ob_clean();
                                    header("location: ./admin/default-dash.php");
                                    exit;

                                }elseif($account_type == "user") {
                                
                                    // Store data in session variables
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["pass_username"] = $username;
                                    $_SESSION["account_type"] = $account_type;
                                    $_SESSION["pass_site_name"] = $site_name;  

                                    ob_clean();
                                    header("location: ./user/def-dash-user.php");
                                    exit;

                                }else{
                                    $username_err = "Invalid username or password!";
                                }
                            } else{
                                // Password is not valid, display a generic error message
                                $username_err = "Invalid username or password.";
                            }
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $username_err = "Invalid username or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                unset($stmt);
            }
        }
}?>  
<script>
    $(document).ready(function(){
        $("#showlog").click(function(){
        $("#openlog").fadeToggle("slow");
      });
    });   

</script>

<div class="navhead">
        <div class="col" id="dectop">
            <img id="logo-top" src="./img/VacciTrack_logo_3B.png" alt="Logo">
        </div>      
    <hr>
</div>

<div class="container-fluid" id="nav-icons">
    <div class="public-navbar">
        <button class="navbar-btn" id="showlog"><i class="bx bx-user-circle bx-sm" id="icnbx"></i></button>
        
        <br>
        <button type="button" class="navbar-btn" data-bs-toggle="tooltip" data-placement="left" title="Home" onclick="document.location='./index.php'"><i class="bx bx-home bx-sm" id="icnbx"></i></button>
        <br>
        <button class="notification navbar-btn" data-bs-toggle="tooltip" data-placement="left" title="Vaccination Schedules" onclick="document.location='./schedules.php'"><i class="bx bx-calendar-check bx-sm" id="icnbx"></i>
            <span class="badge">
                <?php foreach ($countsched as $row){
                    echo ($row["Total"]); 
                }?>
            </span>
        </button>
        <br>
        <button class="navbar-btn" data-bs-toggle="tooltip" data-placement="left" title="Request Access" onclick="document.location='./submit-request.php'"><i class="bx bx-user-plus bx-sm " id="icnbx"></i></button>
    </div>

    <div id="openlog">  
        <form action="" method="post" enctype="multipart/form-data">
        <div class="column-username">
          <input type="text" name="username" id="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : '';?>" value="<?php echo $username;?>" placeholder="username">
                <span class="invalid-feedback"><?php echo $username_err;?></span>
        </div>
        <div class="column-password">
          <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : '';?>" placeholder="password">
                <span class="invalid-feedback"><?php echo $password_err;?></span>
        </div>
        <div class="column-login">
          <input type="submit" class="btn btn-primary" name="loginuser" id="btn_login" value="Login">
        </div>
    </div> 

</div>

<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>

<?php require "./templates/footer.php";?>