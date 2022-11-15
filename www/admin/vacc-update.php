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
$vacc_id = "";

$vacc_id = ($_GET['vaccineedit']);

try {
  $sql1 = "SELECT * FROM vaccine WHERE id = '$vacc_id'";

  $statement = $pdo->prepare($sql1);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql1 . "<br>" . $error->getMessage();
}

  foreach($result as $row){
    $vaccine_name = $row["vaccine_name"];
    $doses = $row["doses"];
    $vaccine_type = $row["vaccine_type"];
    $contraindications = $row["contraindications"];
    $ad_reactions = $row["ad_reactions"];
    $spec_precautions = $row["spec_precautions"];
    $dosage = $row["dosage"];
    $inject_type = $row["inject_type"];
    $inject_site = $row["inject_site"];
  }
 
// Processing form data when form is submitted
if (isset($_POST['save_changes'])) {
 
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
            $sql = "UPDATE vaccine SET vaccine_name = '$vaccine_name', 
                            doses = $doses, 
                            vaccine_type = '$vaccine_type', 
                            contraindications = '$contraindications',
                            ad_reactions = '$ad_reactions',
                            spec_precautions = '$spec_precautions',
                            dosage = '$dosage',
                            inject_type = '$inject_type',
                            inject_site = '$inject_site' 
                        WHERE id = '$vacc_id'";
             
            if($stmt = $pdo->prepare($sql)){
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Changes Saved.
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
        <h2>Update Vaccine Information</h2>
        <div class="reg_wrapper">
            
            <form action="" method="post">
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
                            <option><?php echo $vaccine_type; ?></option>
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
                            <option><?php echo $inject_type; ?></option>
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
                        <select id="inject_site" name="inject_site" class="form-control" value="<?php echo $inject_site; ?>" required>
                            <option><?php echo $inject_site; ?></option>
                            <option value="Anterolateral thigh muscle">Anterolateral thigh muscle</option>
                            <option value="Deltoid muscle of arm">Deltoid muscle of arm</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                </div>
                <div class="row"> 
                    <div class="form-group col">
                        <label for="contraindications">Contraindications</label>
                            <textarea type="text" name="contraindications" class="form-control" value="<?php echo $contraindications; ?>" required><?php echo $contraindications;?></textarea>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    <div class="form-group col">
                        <label for="ad_reactions">Adverse Reactions</label>
                            <textarea type="text" name="ad_reactions" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ad_reactions; ?>"required><?php echo $ad_reactions; ?></textarea>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="spec_precautions">Special Precautions</label>
                            <textarea type="text" name="spec_precautions" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $spec_precautions; ?>"required><?php echo $spec_precautions; ?></textarea>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    
                </div>
                
                <div class="form-group" id="sub-pd">
                    <input type="submit" name="save_changes" class="btn btn-primary" value="Submit">
                </div>
            </form>
        </div>    
    </div>

<?php 
require "../templates/userfooter.php";
require "../admin/templates/main-footer.php";
require "../templates/footer.php";?>