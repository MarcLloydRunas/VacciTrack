<?php
ob_start();
require "../templates/header.php"; 
require "../admin/dashboard-admin.php";
require "../admin/templates/main-header.php";
?>
<script>
    <?php require("../build/js/alt-dash.js");?>
</script>

<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$site_name = "";
$site_name_err = $form_err = "";
$add_province = "";
$add_cit_mun = "";
$add_barangay = "";
$add_zipcode = "";
$site_address = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate site name
    if(empty(trim($_POST["site_name"]))){
        $site_name_err = "Enter vaccination site name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vaccination_site WHERE site_name = :site_name";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_site_name = trim($_POST["site_name"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $site_name_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> Vaccination site already exists.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
                } else{
                    $site_name = trim($_POST["site_name"]);
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
    
    //Address
    if(empty(trim($_POST["add_province"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $add_province = trim($_POST["add_province"]);
    }

    if(empty(trim($_POST["add_cit_mun"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $add_cit_mun = trim($_POST["add_cit_mun"]);
    }

    if(empty(trim($_POST["add_barangay"]))){
        $form_err = "Please fill in this form.";      
    } else{
        $add_barangay = trim($_POST["add_barangay"]);
    }

    if(empty(trim($_POST["add_zipcode"]))){
        $form_err = "Please fill in this form.";      
    } else{
        $account_type = trim($_POST["add_zipcode"]);
    }

    
    // Check input errors before inserting in database
    if(empty($site_name_err) && empty($form_err)) {


    	$site_address = $_POST['add_barangay'] . " , " . $_POST['add_cit_mun'] . " , " . $_POST['add_province'] . " , " . $_POST['add_zipcode'];

        
        // Prepare an insert statement
        $sql = "INSERT INTO vaccination_site (site_name, site_address) VALUES (:site_name, :site_address)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
            $stmt->bindParam(":site_address", $param_site_address, PDO::PARAM_STR);
            
            // Set parameters
            $param_site_name = $site_name;
            $param_site_address = $site_address;
            
            // Attempt to execute the prepared statement
            

            if($stmt->execute()){
                // Redirect to login page
                
                echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Vaccination site added.
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
        <h2>Add New Site</h2>
        <div class="reg_wrapper">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" name="site_name" class="form-control <?php echo (!empty($site_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $site_name; ?>">
                    <span class="invalid-feedback"><?php echo $site_name_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Province</label>
                    <input type="text" name="add_province" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $add_province; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                </div>
                <div class="form-group">
                    <label>City/Municipality</label>
                    <input type="text" name="add_cit_mun" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $add_cit_mun; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                </div>
                <!--Personal Info-->
                <div class="form-group">
                    <label>Barangay</label>
                    <input type="text" name="add_barangay" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $add_barangay; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Zip Code</label>
                    <input type="text" name="add_zipcode" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $add_zipcode; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                
                <div class="form-group" id="sub-pd">
                    <input type="submit" class="btn btn-primary" value="Submit">
                </div>
                
            </form>
        </div>    
    </div>

<?php 
require "../admin/templates/main-footer.php"; 
require "../templates/userfooter.php";
require "../templates/footer.php";?>