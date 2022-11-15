<?php
ob_start(); 
      //session_start();
      require "../templates/header.php"; 
      require "../user/dashboard-user.php";
      require "../admin/templates/main-header.php";

// Include config file
require_once "../config.php";

$sql= "SELECT vaccine_name FROM vaccine";

try {
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $results=$stmt->fetchAll();
}catch(Exception $ex) {
    echo($ex -> getMessage());
}

$sql= "SELECT site_name FROM vaccination_site";

try {
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
    $siteresults=$stmt->fetchAll();
}catch(Exception $ex) {
    echo($ex -> getMessage());
}

// Define variables and initialize with empty values

//personal info
$id_number = abs( crc32( uniqid() ) );
$form_err = "";
$dec_id_number = $id_number;
$last_name = "";
$first_name = "";
$middle_name = "";
$suffixes = "";
$birth_date = "";
$sex = "";
$address_permanent = "";
$address_current = "";
$contact_number = "";
$email_address = "";
$mother_last_name = "";
$mother_first_name = "";
$mother_middle_name = "";
$father_last_name = "";
$father_first_name = "";
$father_middle_name = "";

//health declaration
$conditions = "";
$medical_allergies = "";
$tobacco_history = "";
$illegal_drugs = "";
$alcohol_consumption = "";
$conditions_err = "";

//activity logs
$activity = "";
$username = "";

//errors personal data
$lastname_err = "";
$firstname_err = "";
$middlename_err = "";
$birthdate_err = "";
$sex_err = "";
$perm_err = "";
$current_err = "";
$contact_err = "";
$email_err = "";
$motherl_err = "";
$motherf_err = "";
$motherm_err = "";
$fatherf_err = "";
$fatherl_err = "";
$fatherm_err = "";

//errors health declaration
$conditions_err = "";
$medical_allergies_err = "";
$tobacco_history_err = "";
$illegal_drugs_err = "";
$alcohol_consumption_err = "";

if (isset($_SESSION["pass_username"])) {
    $username = $_SESSION["pass_username"];
    //$username = trim($_POST["username"]);
}else{
    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                        <i class='bi-exclamation-octagon-fill'></i>
                        <strong class='mx-1'>Error!</strong> Username not found.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>
          </div>";
}

if(isset($_SESSION["pass_site_name"])) {
    $site_name = $_SESSION["pass_site_name"];
} else {
    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                        <i class='bi-exclamation-octagon-fill'></i>
                        <strong class='mx-1'>Error!</strong> Vaccination Site name is not defined.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>
          </div>";
}

 
// Processing form data when form is submitted

// Personal Info
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    //Personal Information
    if(empty(trim($_POST["last_name"]))){
        $lastname_err = "Please fill in this form.";     
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    if(empty(trim($_POST["first_name"]))){
        $firstname_err = "Please fill in this form.";     
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["middle_name"]))){
        $middlename_err = "Please fill in this form.";     
    } else{
        $middle_name = trim($_POST["middle_name"]);
    }

    $suffixes = trim($_POST["suffixes"]);

    if(empty(trim($_POST["birth_date"]))){
        $birthdate_err = "Please fill in this form.";     
    } else{
        $birth_date = trim($_POST["birth_date"]);
    }

    if(empty(trim($_POST["sex"]))){
        $sex_err = "Please fill in this form.";     
    } else{
        $sex = trim($_POST["sex"]);
    }

    if(empty(trim($_POST["address_permanent"]))){
        $perm_err = "Please fill in this form.";     
    } else{
        $address_permanent = trim($_POST["address_permanent"]);
    }

    if(empty(trim($_POST["address_current"]))){
        $current_err = "Please fill in this form.";     
    } else{
        $address_current = trim($_POST["address_current"]);
    }

    if(empty(trim($_POST["contact_number"]))){
        $contact_err = "Please fill in this form.";     
    } else{
        $contact_number = trim($_POST["contact_number"]);
    }

    if(empty(trim($_POST["email_address"]))){
        $email_err = "Please fill in this form.";     
    } else{
        $email_address = trim($_POST["email_address"]);
    }

    if(empty(trim($_POST["mother_last_name"]))){
        $motherl_err = "Please fill in this form.";     
    } else{
        $mother_last_name = trim($_POST["mother_last_name"]);
    }

    if(empty(trim($_POST["mother_first_name"]))){
        $motherf_err = "Please fill in this form.";     
    } else{
        $mother_first_name = trim($_POST["mother_first_name"]);
    }

    if(empty(trim($_POST["mother_middle_name"]))){
        $motherm_err = "Please fill in this form.";     
    } else{
        $mother_middle_name = trim($_POST["mother_middle_name"]);
    }

    if(empty(trim($_POST["father_last_name"]))){
        $fatherl_err = "Please fill in this form.";     
    } else{
        $father_last_name = trim($_POST["father_last_name"]);
    }

    if(empty(trim($_POST["father_first_name"]))){
        $fatherf_err = "Please fill in this form.";     
    } else{
        $father_first_name = trim($_POST["father_first_name"]);
    }

    if(empty(trim($_POST["father_middle_name"]))){
        $fatherm_err = "Please fill in this form.";     
    } else{
        $father_middle_name = trim($_POST["father_middle_name"]);
    }

    $dec_last_name = $last_name;
    $dec_first_name = $first_name;
    $dec_middle_name = $middle_name;
    $dec_suffixes = $suffixes;

    //health declaration
    if (isset($_REQUEST['disease'])) {
        $conditions=implode(", ", $_REQUEST['disease']);
    }elseif(empty($conditions)){
        $conditions_err = "Please fill in this checkbox";
    }else{
        $error = "checkbox error";
    }

    if(empty($_POST["medical_allergies"])){
        $medical_allergies_err = "Please fill in this form.";     
    } else{
        $medical_allergies = $_POST["medical_allergies"];
    }

    if(empty($_POST["tobacco_history"])){
        $tobacco_history_err = "Please fill in this form.";     
    } else{
        $tobacco_history = $_POST["tobacco_history"];
    }

    if(empty($_POST["illegal_drugs"])){
        $illegal_drugs_err = "Please fill in this form.";     
    } else{
        $illegal_drugs = $_POST["illegal_drugs"];
    }
    
    if(empty($_POST["alcohol_consumption"])){
        $alcohol_consumption_err = "Please fill in this form.";     
    } else{
        $alcohol_consumption = $_POST["alcohol_consumption"];
    }

    //activity logs

    $activity = "Added a new record for " . $first_name . " " . $last_name . " at " . $site_name;

    // Check input errors before inserting in database
    if(empty($lastname_err) && empty($firstname_err) && empty($middlename_err) && empty($birthdate_err) && empty($sex_err) && empty($perm_err) && empty($current_err) && empty($contact_err) && empty($email_err) && empty($motherl_err) && empty($motherf_err) && empty($motherm_err) && empty($fatherl_err) && empty($fatherf_err) && empty($fatherm_err) && empty($medical_allergies_err) && empty($tobacco_history_err) && empty($illegal_drugs_err) && empty($alcohol_consumption_err)) {
        
        // Prepare an insert statement
        $sql1 = "INSERT INTO public_user (
                    id_number,
                    last_name,
                    first_name,
                    middle_name,
                    suffixes,
                    birth_date,
                    sex,
                    address_permanent,
                    address_current,
                    contact_number,
                    email_address,
                    mother_last_name,
                    mother_first_name,
                    mother_middle_name,
                    father_last_name,
                    father_first_name,
                    father_middle_name
                    ) 
                VALUES (
                    :id_number,
                    :last_name,
                    :first_name,
                    :middle_name,
                    :suffixes,
                    :birth_date,
                    :sex,
                    :address_permanent,
                    :address_current,
                    :contact_number,
                    :email_address,
                    :mother_last_name,
                    :mother_first_name,
                    :mother_middle_name,
                    :father_last_name,
                    :father_first_name,
                    :father_middle_name
                    )";
        // Prepare an insert statement
        $sql2 = "INSERT INTO health_declaration (
                        id_number,
                        last_name, 
                        first_name, 
                        middle_name, 
                        suffixes,
                        conditions,
                        medical_allergies,
                        tobacco_history,
                        illegal_drugs,
                        alcohol_consumption
                        ) 
                    VALUES (
                        :dec_id_number,
                        :dec_last_name, 
                        :dec_first_name, 
                        :dec_middle_name, 
                        :dec_suffixes,
                        :conditions,
                        :medical_allergies,
                        :tobacco_history,
                        :illegal_drugs,
                        :alcohol_consumption
                        )";

        $sql3 = "INSERT INTO activity_log (username, activity) VALUES (:username,:activity)";

         
        if($stmt = $pdo->prepare($sql1)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id_number", $param_id_number, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":middle_name", $param_middle_name, PDO::PARAM_STR);
            $stmt->bindParam(":suffixes", $param_suffixes, PDO::PARAM_STR);
            $stmt->bindParam(":birth_date", $param_birth_date, PDO::PARAM_STR);
            $stmt->bindParam(":sex", $param_sex, PDO::PARAM_STR);
            $stmt->bindParam(":address_permanent", $param_address_permanent, PDO::PARAM_STR);
            $stmt->bindParam(":address_current", $param_address_current, PDO::PARAM_STR);
            $stmt->bindParam(":contact_number", $param_contact_number, PDO::PARAM_STR);
            $stmt->bindParam(":email_address", $param_email_address, PDO::PARAM_STR);
            $stmt->bindParam(":mother_last_name", $param_mother_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":mother_first_name", $param_mother_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":mother_middle_name", $param_mother_middle_name, PDO::PARAM_STR);
            $stmt->bindParam(":father_last_name", $param_father_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":father_first_name", $param_father_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":father_middle_name", $param_father_middle_name, PDO::PARAM_STR);

            
            // Set parameters
            $param_id_number = $id_number;
            $param_last_name = $last_name;
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_suffixes = $suffixes;
            $param_birth_date = $birth_date;
            $param_sex = $sex;
            $param_address_permanent = $address_permanent;
            $param_address_current = $address_current;
            $param_contact_number = $contact_number;
            $param_email_address = $email_address;
            $param_mother_last_name = $mother_last_name;
            $param_mother_first_name = $mother_first_name;
            $param_mother_middle_name = $mother_middle_name;
            $param_father_last_name = $father_last_name;
            $param_father_first_name = $father_first_name;
            $param_father_middle_name = $father_middle_name;

            // Attempt to execute the prepared statement
            if ($stmt->execute()){
                echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Entry saved.
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

        if($stmt = $pdo->prepare($sql2)){
            $stmt->bindParam(":dec_id_number", $param_dec_id_number, PDO::PARAM_STR);
            $stmt->bindParam(":dec_last_name", $param_dec_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":dec_first_name", $param_dec_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":dec_middle_name", $param_dec_middle_name, PDO::PARAM_STR);
            $stmt->bindParam(":dec_suffixes", $param_dec_suffixes, PDO::PARAM_STR);
            $stmt->bindParam(":conditions", $param_conditions, PDO::PARAM_STR);
            $stmt->bindParam(":medical_allergies", $param_medical_allergies, PDO::PARAM_STR);
            $stmt->bindParam(":tobacco_history", $param_tobacco_history, PDO::PARAM_STR);
            $stmt->bindParam(":illegal_drugs", $param_illegal_drugs, PDO::PARAM_STR);
            $stmt->bindParam(":alcohol_consumption", $param_alcohol_consumption, PDO::PARAM_STR);

            $param_dec_id_number = $dec_id_number;
            $param_dec_last_name = $dec_last_name;
            $param_dec_first_name = $dec_first_name;
            $param_dec_middle_name = $dec_middle_name;
            $param_dec_suffixes = $dec_suffixes;
            $param_conditions = $conditions;
            $param_medical_allergies = $medical_allergies;
            $param_tobacco_history = $tobacco_history;
            $param_illegal_drugs = $illegal_drugs;
            $param_alcohol_consumption = $alcohol_consumption;

            // Attempt to execute the prepared statement
            if ($stmt->execute()){
               echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Entry saved.
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

        if($stmt = $pdo->prepare($sql3)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":activity", $param_activity, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_activity = $activity;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Activity saved.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                    </div>";    
            }else{
                 echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-exclamation-octagon-fill'></i>
                                <strong class='mx-1'>Error!</strong> Not working log.
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                  </div>";
            }
            // Close statement
            unset($stmt);
        }

    }else{
        echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-exclamation-octagon-fill'></i>
                                <strong class='mx-1'>Error!</strong> Something went wrong.
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                  </div>";
    }
    
    // Close connection
    unset($pdo);
}
?>
    <div id="reg-accounts">
        <h2>Add New User</h2>
        <div class="reg_wrapper">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <!--Personal Info-->
                <fieldset id="field-pd">
                    <legend class="subpads">Personal Data</legend>
                    <hr>
                    <div class="row">
                        <div class="form-group col">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name" class="form-control <?php echo (!empty($middlename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middle_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $middlename_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>Suffix</label>
                            <input type="text" name="suffixes" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $suffixes; ?>">
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Date of Birth</label>
                            <input type="date" name="birth_date" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $birth_date; ?>" required>
                            <span class="invalid-feedback"><?php echo $birthdate_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label for="sex">Sex</label>
                            <select id="sex" name="sex" class="form-control <?php echo (!empty($sex_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $sex; ?>" required>
                            <option> </option>    
                            <option value="male">male</option>
                            <option value="female">female</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Permanent Address</label>
                            <input type="text" name="address_permanent" class="form-control <?php echo (!empty($perm_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address_permanent; ?>" required>
                            <span class="invalid-feedback"><?php echo $perm_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>Current Address</label>
                            <input type="text" name="address_current" class="form-control <?php echo (!empty($current_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address_current; ?>" required>
                            <span class="invalid-feedback"><?php echo $current_err; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Contact number</label>
                            <input type="text" name="contact_number" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact_number; ?>" required>
                            <span class="invalid-feedback"><?php echo $contact_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>Email Address</label>
                            <input type="text" name="email_address" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email_address; ?>" required>
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>
                    </div>
                </fieldset id="field-pd">
                <!--Mother-->
                <fieldset class="marg-field">
                    <legend><h5>Mother's Maiden Name</h5></legend>
                    <div class="row">
                        <div class="form-group col">
                            <label>Last Name</label>
                            <input type="text" name="mother_last_name" class="form-control <?php echo (!empty($motherl_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mother_last_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $motherl_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>First Name</label>
                            <input type="text" name="mother_first_name" class="form-control <?php echo (!empty($motherf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mother_first_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $motherf_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>Middle Name</label>
                            <input type="text" name="mother_middle_name" class="form-control <?php echo (!empty($motherm_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mother_middle_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $motherm_err; ?></span>
                        </div>
                    </div>
                </fieldset>
                <!--Father-->
                <fieldset class="marg-field">
                    <legend>Father's Name</legend>
                    <div class="row">
                        <div class="form-group col">
                            <label>Last Name</label>
                            <input type="text" name="father_last_name" class="form-control <?php echo (!empty($fatherl_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $father_last_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $fatherl_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>First Name</label>
                            <input type="text" name="father_first_name" class="form-control <?php echo (!empty($fatherf_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $father_first_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $fatherf_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label>Middle Name</label>
                            <input type="text" name="father_middle_name" class="form-control <?php echo (!empty($fatherm_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $father_middle_name; ?>" required>
                            <span class="invalid-feedback"><?php echo $fatherm_err; ?></span>
                        </div>
                    </div>
                </fieldset>
                <!--Health Declaration-->
                <fieldset class="marg-field">
                    <legend class="subpads">Health Declaration</legend>
                    <hr>
                    <div class="row d-grid gap-2">
                        <div class="form-group">   
                            <p>Check on all the conditions that apply to the individual or to any of their immediate relatives:</p>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="AIDS/ ARC/ HIV+" id="btn-check-1-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-1-outlined">AIDS/ARC/HIV+</label> 
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Chronic Fatigue" id="btn-check-2-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-2-outlined">Chronic Fatigue</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Hepatitis" id="btn-check-3-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-3-outlined">Hepatitis</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Pacemaker" id="btn-check-4-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-4-outlined">Pacemaker</label>  
                                </div>
                            </div>  
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Anxiety/ Stress/ Depression" id="btn-check-5-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-5-outlined">Anxiety/Stress/Depression</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Cleft Palate" id="btn-check-6-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-6-outlined">Cleft Palate</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="High Blood Pressure" id="btn-check-7-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-7-outlined">High Blood Pressure</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Pancreas" id="btn-check-8-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-8-outlined">Pancreas</label>  
                                </div>
                            </div> 
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Arthritis" id="btn-check-9-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-9-outlined">Arthritis</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Colitis" id="btn-check-10-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-10-outlined">Colitis</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="High Cholesterol/ triglycerides" id="btn-check-11-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-11-outlined">High Cholesterol/triglycerides</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Paralysis" id="btn-check-12-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-12-outlined">Paralysis</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Asthma/ Emphysema/ COPD" id="btn-check-13-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-13-outlined">Asthma/Emphysema/COPD</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Connective Tissue Disorder" id="btn-check-14-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-14-outlined">Connective Tissue Disorder</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Immune Disorder" id="btn-check-15-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-15-outlined">Immune Disorder</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Pituitary/ Adrenal" id="btn-check-16-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-16-outlined">Pituitary/Adrenal</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Back/ Spine/ Neck" id="btn-check-17-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-17-outlined">Back/Spine/Neck</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Diabetes" id="btn-check-18-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-18-outlined">Diabetes</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Infertility" id="btn-check-19-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-19-outlined">Infertility</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Pneumonia" id="btn-check-20-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-20-outlined">Pneumonia</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Bipolar" id="btn-check-21-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-21-outlined">Bipolar</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Down's Syndrome" id="btn-check-22-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-22-outlined">Down's Syndrome</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Intestine" id="btn-check-23-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-23-outlined">Intestine</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Reproductive System" id="btn-check-24-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-24-outlined">Reproductive System</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Birth Defect /Congenital Abnormality" id="btn-check-25-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-25-outlined">Birth Defect/Congenital Abnormality</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Ears/ Eyes/ Throat" id="btn-check-26-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-26-outlined">Ears/Eyes/Throat</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Joint Replacement" id="btn-check-27-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-27-outlined">Joint Replacement</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Sickle Cell Anemia" id="btn-check-28-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-28-outlined">Sickle Cell Anemia</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Blood Disorder/ Hemophilia" id="btn-check-29-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-29-outlined">Blood Disorder/Hemophilia</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Eating Disorders" id="btn-check-30-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-30-outlined">Eating Disorders</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Kidney/ Bladder/ Urinary" id="btn-check-31-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-31-outlined">Kidney/Bladder/Urinary</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Skin Disorders" id="btn-check-32-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-32-outlined">Skin Disorders</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Bones/ Joints/ Muscles" id="btn-check-33-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-33-outlined">Bones/Joints/Muscles</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Emphysema/ Pulmonary" id="btn-check-34-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-34-outlined">Emphysema/Pulmonary</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Liver/ Spleen/ Pancreas" id="btn-check-35-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-35-outlined">Liver/Spleen/Pancreas</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Stomach/ Esophagus/ Digestion" id="btn-check-36-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-36-outlined">Stomach/Esophagus/Digestion</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Brain" id="btn-check-37-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-37-outlined">Brain</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Endocrine/ Metabollic" id="btn-check-38-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-38-outlined">Endocrine/Metabollic</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Lungs/ Respiratory" id="btn-check-39-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-39-outlined">Lungs/ Respiratory</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Stroke" id="btn-check-40-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-40-outlined">Stroke</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Cancer" id="btn-check-41-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-41-outlined">Cancer</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Epilepsy/ Seizure" id="btn-check-42-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-42-outlined">Epilepsy/Seizure</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Lupus" id="btn-check-43-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-43-outlined">Lupus</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Substance Abuse" id="btn-check-44-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-44-outlined">Substance Abuse</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Paralysis" id="btn-check-45-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-45-outlined">Paralysis</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Gallbladder Disease" id="btn-check-46-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-46-outlined">Gallbladder Disease</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Mental/ Emotional/ Nervous" id="btn-check-47-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-47-outlined">Mental/Emotional/Nervous</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Thyroid" id="btn-check-48-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-48-outlined">Thyroid</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Cardiovascular" id="btn-check-49-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-49-outlined">Cardiovascular</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Gerd" id="btn-check-50-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-50-outlined">Gerd</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Migraines" id="btn-check-51-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-51-outlined">Migraines</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Transplant" id="btn-check-52-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-52-outlined">Transplant</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Carpal Tunnel" id="btn-check-53-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-53-outlined">Carpal Tunnel</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Growth Disorder" id="btn-check-54-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-54-outlined">Growth Disorder</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Multiples Clerosis" id="btn-check-55-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-55-outlined">Multiples Clerosis</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Paralysis" id="btn-check-56-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-56-outlined">Paralysis</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Central Nervous Disorder" id="btn-check-57-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-57-outlined">Central Nervous Disorder</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Heart Attack/ Chest Pain" id="btn-check-58-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-58-outlined">Heart Attack/Chest Pain</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Muscular Condition" id="btn-check-59-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-59-outlined">Muscular Condition</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Tumor" id="btn-check-60-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-60-outlined">Tumor</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Cerebral Palsy" id="btn-check-61-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-61-outlined">Cerebral Palsy</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Heart Disorder" id="btn-check-62-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-62-outlined">Heart Disorder</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Neurological" id="btn-check-63-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-63-outlined">Neurological</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Venereal" id="btn-check-64-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-64-outlined">Venereal</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Circulatory Disorder" id="btn-check-65-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-65-outlined">Circulatory Disorder</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Heart Murmur" id="btn-check-66-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-66-outlined">Heart Murmur</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="Nervous System" id="btn-check-67-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-67-outlined">Nervous System</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="disease[]" value="" id="btn-check-68-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-68-outlined">Others</label>  
                                </div>
                            </div>
                                    
                        </div>
                    </div>
                    
                    <!-- snip end -->
                    <div class="row">
                        <div class="form-group">
                            <p>Does the individual have any medication allergies?</p>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="medical_allergies" value="Yes" id="btn-check-78-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-78-outlined">Yes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="medical_allergies" value="No" id="btn-check-79-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-79-outlined">No</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="medical_allergies" value="Unsure" id="btn-check-80-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-80-outlined">Unsure</label>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <p>Does the individual have a history in taking tobacco?</p>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="tobacco_history" value="Yes" id="btn-check-81-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-81-outlined">Yes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="tobacco_history" value="No" id="btn-check-82-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-82-outlined">No</label>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <p>Does the individual have a history in taking illegal drugs?</p>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="illegal_drugs" value="Yes" id="btn-check-83-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-83-outlined">Yes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="illegal_drugs" value="No" id="btn-check-84-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-84-outlined">No</label>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <p>Does the individual have a histroy in alcohol addiction?</p>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="alcohol_consumption" value="Yes" id="btn-check-85-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-85-outlined">Yes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="alcohol_consumption" value="No" id="btn-check-86-outlined" autocomplete="off"  required>
                                    <label class="btn btn-outline-secondary" for="btn-check-86-outlined">No</label>  
                                </div>
                            </div>
                        </div>
                    </div>

                
                </fieldset>

                <hr>
                
                <div class="form-group" id="sub-pd">
                    <input type="submit" class="btn btn-primary col-3" value="Submit">
                </div>
                
            </form>
        </div>    
    </div>

<?php 
require "../templates/userfooter.php";
require "../templates/footer.php";?>