<?php
ob_start();
require "../user/dashboard-user.php";
require "../admin/templates/main-header.php";
// Include config file
      require_once "../config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                        <i class='bi-exclamation-octagon-fill'></i>
                                        <strong class='mx-1'>Error!</strong> Please enter a username.
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                </div>
                          </div>";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                        <i class='bi-exclamation-octagon-fill'></i>
                                        <strong class='mx-1'>Error!</strong> Username can only contain letters, numbers, and underscores
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                </div>
                          </div>";
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
                                                <strong class='mx-1'>Error!</strong> Something went wrong. Please try again.
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
        $password_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Please enter a password
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";   
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong>Password must have atleast 6 characters
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";   
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong>Please confirm password
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong>Password did not match
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";     
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement

        $sql = "UPDATE user_account SET username = :username, password = :password WHERE username = '$acc_username'";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            

            if($stmt->execute()){
                
                $page = '../templates/logout.php';
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.$page.'";';
                echo '</script>';
                exit;
            } else{
                echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 <strong class='mx-1'>Error!</strong> Something went wrong. Please try again.
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
}?>

    <div id="reg-accounts">
        <h2>Update Account</h2>
        <div class="reg_wrapper">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group col-7">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group col-7">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group col-7">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
    
                
                <div class="form-group" id="sub-pd">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                
            </form>
        </div>    
    </div>

<?php 
require "../templates/userfooter.php";
require "../templates/footer.php";?>