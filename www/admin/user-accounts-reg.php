<?php 
ob_start();
require "../templates/header.php"; 
require "../admin/dashboard-admin.php";
require "../admin/templates/main-header.php";

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$first_name = "";
$middle_name = "";
$last_name = "";
$account_type = "";
$site_name = "";

$sql11= "SELECT site_name FROM vaccination_site";

try {
    $stmt11=$pdo->prepare($sql11);
    $stmt11->execute();
    $siteresult=$stmt11->fetchAll();
}catch(Exception $ex) {
    echo($ex -> getMessage());
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM user_account WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> This username is already taken.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> Something went wrong. Please try again later.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //Personal Information
    if(empty(trim($_POST["last_name"]))){
        $password_err = "Please enter your last name.";     
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    if(empty(trim($_POST["first_name"]))){
        $password_err = "Please enter your first name.";     
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["middle_name"]))){
        $password_err = "Please enter your middle name.";     
    } else{
        $middle_name = trim($_POST["middle_name"]);
    }

    if(empty(trim($_POST["account_type"]))){
        $password_err = "Please enter account type.";     
    } else{
        $account_type = trim($_POST["account_type"]);
    }

    if(empty(trim($_POST["site_name"]))){
        $password_err = "Please enter a designated site.";     
    } else{
        $site_name = trim($_POST["site_name"]);
    }

    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user_account (username, password, last_name, first_name, middle_name, account_type, site_name) VALUES (:username, :password, :last_name, :first_name, :middle_name, :account_type, :site_name)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":middle_name", $param_middle_name, PDO::PARAM_STR);
            $stmt->bindParam(":account_type", $param_account_type, PDO::PARAM_STR);
            $stmt->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_last_name = $last_name;
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_account_type = $account_type;
            $param_site_name = $site_name;
            
            // Attempt to execute the prepared statement
            

            if($stmt->execute()){
                // Redirect to login page
                
               echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Account created.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                    </div>";
            } else{
                echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> Something went wrong. Please try again later.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>



    <div id="reg-accounts">
        <h2>Add New User</h2>
        <div class="reg_wrapper">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group col-9">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" autocomplete="off"required>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group col-9">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"required>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group col-9">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>"required>
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <!--Personal Info-->
                <div class="form-group col-9">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>"required>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group col-9">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>"required>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group col-9">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middle_name; ?>"required>
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group col-9">
                    <label for="account_type">Account</label>
                    <select id="account_type" name="account_type" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $account_type; ?>"required>
                    <option></option>
                    <option value="admin">admin</option>
                    <option value="user">user</option>
                    </select>
                </div>
                <div class="form-group col-9">
                    <label for="site_name">Designated Site</label>
                        <select id="site_name" name="site_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $site_name; ?>"required>
                            <option></option>
                            <?php foreach($siteresult as $output) {?>
                            <option><?php echo $output["site_name"];?></option>
                            <?php }?>
                        </select>
                </div>
                
                <div class="form-group" id="sub-pd">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                
            </form>
        </div>    
    </div>

<?php
require "../templates/userfooter.php";
require "../admin/templates/main-footer.php";
require "../templates/footer.php";?>