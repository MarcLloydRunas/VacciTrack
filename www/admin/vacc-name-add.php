<?php
ob_start();
require "../templates/header.php"; 
      require "../admin/dashboard-admin.php";
      require "../admin/templates/main-header.php";

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$vaccine_name = "";
$doses = "";
$vaccine_name_err = "";
$form_err = "";
$vaccine_type = "";
$contraindications = "";
$ad_reactions = "";
$spec_precautions = "";
$dosage = "";
$inject_type = "";
$inject_site = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate site name
    if(empty(trim($_POST["vaccine_name"]))){
        $form_err = "Enter vaccine name.";
    } else{
        $vaccine_name = trim($_POST["vaccine_name"]);
    }  

    if(empty(trim($_POST["doses"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $doses = trim($_POST["doses"]);
    }

    if(empty(trim($_POST["vaccine_type"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $vaccine_type = trim($_POST["vaccine_type"]);
    }

    if(empty(trim($_POST["contraindications"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $contraindications = trim($_POST["contraindications"]);
    }

    if(empty(trim($_POST["ad_reactions"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $ad_reactions = trim($_POST["ad_reactions"]);
    }

    if(empty(trim($_POST["spec_precautions"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $spec_precautions = trim($_POST["spec_precautions"]);
    }

    if(empty(trim($_POST["dosage"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $dosage = trim($_POST["dosage"]);
    }

    if(empty(trim($_POST["inject_type"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $inject_type = trim($_POST["inject_type"]);
    }

    if(empty(trim($_POST["inject_site"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $inject_site = trim($_POST["inject_site"]);
    }

        if(empty($form_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO vaccine(
                    vaccine_name, 
                    doses,
                    vaccine_type,
                    contraindications,
                    ad_reactions,
                    spec_precautions,
                    dosage,
                    inject_type,
                    inject_site
                )VALUES(
                    :vaccine_name, 
                    :doses,
                    :vaccine_type,
                    :contraindications,
                    :ad_reactions,
                    :spec_precautions,
                    :dosage,
                    :inject_type,
                    :inject_site
                )";
             
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":vaccine_name", $param_vaccine_name, PDO::PARAM_STR);
                $stmt->bindParam(":doses", $param_doses, PDO::PARAM_STR);
                $stmt->bindParam(":vaccine_type", $param_vaccine_type, PDO::PARAM_STR);
                $stmt->bindParam(":contraindications", $param_contraindications, PDO::PARAM_STR);
                $stmt->bindParam(":ad_reactions", $param_ad_reactions, PDO::PARAM_STR);
                $stmt->bindParam(":spec_precautions", $param_spec_precautions, PDO::PARAM_STR);
                $stmt->bindParam(":dosage", $param_dosage, PDO::PARAM_STR);
                $stmt->bindParam(":inject_type", $param_inject_type, PDO::PARAM_STR);
                $stmt->bindParam(":inject_site", $param_inject_site, PDO::PARAM_STR);
                
                // Set parameters
                $param_vaccine_name = $vaccine_name;
                $param_doses = $doses;
                $param_vaccine_type = $vaccine_type;
                $param_contraindications = $contraindications;
                $param_ad_reactions = $ad_reactions;
                $param_spec_precautions = $spec_precautions;
                $param_dosage = $dosage;
                $param_inject_type = $inject_type;
                $param_inject_site = $inject_site;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Vaccine Added.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                      </div>
                      </div>";
                    //header("location: ../admin/vacc-name-add.php");
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
        <h2>Add Vaccine</h2>
        <div class="reg_wrapper">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                    <div class="form-group col">
                        <label for="vaccine_name">Vaccine Name</label>
                        <input type="text" name="vaccine_name" class="form-control <?php echo (!empty($vaccine_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vaccine_name; ?>"required>
                        <span class="invalid-feedback"><?php echo $vaccine_name_err; ?></span>
                    </div> 
                    <div class="form-group col">
                        <label for="doses">Number of Doses</label>
                            <input type="text" name="doses" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $doses; ?>"required>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div> 
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="vaccine_type">Type of Vaccine</label>
                        <select id="vaccine_type" name="vaccine_type" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vaccine_type; ?>"required>
                            <option></option>
                            <option value="Inactivated vaccine">Inactivated vaccine</option>
                            <option value="Live-attenuated vaccine">Live-attenuated vaccine</option>
                            <option value="Live-attenuated vaccine">Live-attenuated vaccine</option>
                            <option value="Messenger RNA (mRNA) vaccines">Messenger RNA (mRNA) vaccines</option>
                            <option value="Subunit, recombinant, polysaccharide, and conjugate vaccine">Subunit, recombinant, polysaccharide, and conjugate vaccine</option>
                            <option value="Toxoid vaccine">Toxoid vaccine</option>
                            <option value="Viral vector vaccine">Viral vector vaccine</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="dosage">Dosage</label>
                            <input type="text" name="dosage" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dosage; ?>"required>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="inject_type">Administration Route</label>
                        <select id="inject_type" name="inject_type" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inject_type; ?>"required>
                            <option></option>
                            <option value="Oral">Oral</option>
                            <option value="Intranasal">Intranasal</option>
                            <option value="Subcutaneous">Subcutaneous</option>
                            <option value="Intramuscular ">Intramuscular </option>
                            <option value="Intradermal">Intradermal</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    <div class="form-group col">
                        <label for="inject_site">Injection Site</label>
                        <select id="inject_site" name="inject_site" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inject_site; ?>"required>
                            <option></option>
                            <option value="Anterolateral thigh muscle">Anterolateral thigh muscle</option>
                            <option value="Deltoid muscle of arm">Deltoid muscle of arm</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                </div>
                <div class="row"> 
                    <div class="form-group col">
                        <label for="contraindications">Contraindications</label>
                            <textarea type="text" name="contraindications" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contraindications; ?>"required></textarea>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    <div class="form-group col">
                        <label for="ad_reactions">Adverse Reactions</label>
                            <textarea type="text" name="ad_reactions" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ad_reactions; ?>"required></textarea>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="spec_precautions">Special Precautions</label>
                            <textarea type="text" name="spec_precautions" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $spec_precautions; ?>"required></textarea>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    
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