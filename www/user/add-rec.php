<?php
ob_start();
    require "../admin/connection/config.php";
    require "../admin/connection/common.php";
    require "../templates/header.php"; 
    require "../user/dashboard-user.php";
    require "../admin/templates/main-header.php";

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    // Include config file
    require_once "../config.php";

$sqlvacc= "SELECT vaccine_name FROM vaccine";

try {
    $vaccstmt=$pdo->prepare($sqlvacc);
    $vaccstmt->execute();
    $results=$vaccstmt->fetchAll();
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
$id_number = "";
$first_name = "";
$middle_name = "";
$last_name = "";
$form_err = "";
$vaccine_name = "";
$dose = "";
$serial_code = "";
$site_name = "";
$remarks = "";
$activity = "";
$username = "";
$dose_err = "";
$duplicate_err = "";

$symptoms = "";
$medications = "";
$pregnant = "";

$symptoms_err = "";
$medications_err = "";
$pregnant_err = "";

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
                                <strong class='mx-1'>Error!</strong> Vaccination site undefined.
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                  </div>";
}


$passed_id = "";
$passed_fname = "";
$passed_mname = "";
$passed_lname = "";
$id_number_sess = "";
$missing_dose = "";

if(isset($_GET['id'])){
    //It exists. We can now use it.
    $passed_id = $_GET['id'];

    $sql4 = "SELECT * FROM public_user WHERE id_number = '$passed_id'"; 
    try {
        $chartstmt=$pdo->prepare($sql4);
        $chartstmt->execute();

        if($row = $chartstmt->fetch()){

            $sex = $row['sex'];
            $birth_date = $row['birth_date'];
            $suffixes = $row['suffixes'];
            $rec_id_number = $row['id_number'];

            $today = date("Y-m-d");
            $calAge = date_diff(date_create($birth_date), date_create($today));
            $age = $calAge->format('%y');
            //echo $age;
            //echo 'Age is '.$age->format('%y') . "<br>";

        }


    }catch(Exception $ex) {
        echo($ex -> getMessage());
    }
} else{
    //It does not exist.
    //$passed_id = $_GET['id'];
}
if(isset($_GET['fname'])){
    //It exists. We can now use it.
    $passed_fname = $_GET['fname'];
} else{
    //It does not exist.
    //echo 'fname';
}
if(isset($_GET['mname'])){
    //It exists. We can now use it.
    $passed_mname = $_GET['mname'];
} else{
    //It does not exist.
    //echo 'mname';
}
if(isset($_GET['lname'])){
    //It exists. We can now use it.
    $passed_lname = $_GET['lname'];
} else{
    //echo 'lname';
}

$activity = "Added a new record for " . $passed_fname . " " . $passed_lname . " at " . $site_name; 
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["first_name"]))){
        $first_name = $passed_fname;   
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["middle_name"]))){
        $middle_name = $passed_mname;     
    } else{
        $middle_name = trim($_POST["middle_name"]);
    }

    if(empty(trim($_POST["last_name"]))){
        $last_name = $passed_lname;    
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    if(empty(trim($_POST["dose"]))){
        $dose_err = "Empty form.";
    }else{
        $dose = trim($_POST["dose"]);
    }

    if(empty(trim($_POST["vaccine_name"]))){
        $vacc_err = "Please fill in this form.";     
    } else{
        $vaccine_name = trim($_POST["vaccine_name"]);
    }

    if(empty(trim($_POST["serial_code"]))){
        $serial_err = "Please fill in this form.";      
    } else{
        $serial_code = trim($_POST["serial_code"]);
    }

    if(empty(trim($_POST["site_name"]))){
        $site_err = "Please fill in this form.";      
    } else{
        $site_name = trim($_POST["site_name"]);
    }

    if(empty(trim($_POST["remarks"]))){
        $remarks_err = "Please fill in this form.";      
    } else{
        $remarks = trim($_POST["remarks"]);
    }

    if (isset($_REQUEST['symptoms'])) {
        $symptoms=implode(", ", $_REQUEST['symptoms']);
    }elseif(empty($symptoms)){
        $symptoms_err = "Please fill in this checkbox";
    }else{
        $symptoms_err = "checkbox error";
    }

    if(empty($_POST["medications"])){
        $medications_err = "Please fill in this form.";     
    } else{
        $medications = $_POST["medications"];
        echo $medications;
    }

    if(empty($_POST["pregnant"])){
        $pregnant_err = "Please fill in this form.";     
    } else{
        $pregnant = $_POST["pregnant"];
    }

    if(!empty($vaccine_name) && !empty($dose)) {

        $sql1 = "SELECT * FROM vaccination_record WHERE vaccine_name = '$vaccine_name' AND dose = '$dose' AND id_number = '$passed_id'";
        
        $stmt1 = $pdo->prepare($sql1);
            // Bind variables to the prepared statement as parameters
        $stmt1->execute();

        $sql3 = "SELECT dose from vaccination_record WHERE dose = '1st dose' AND vaccine_name = '$vaccine_name' AND id_number = '$passed_id'";
        
        $stmt3 = $pdo->prepare($sql3);
            // Bind variables to the prepared statement as parameters
        $stmt3->execute();

        $sql5 = "SELECT dose from vaccination_record WHERE dose = '2nd dose' AND vaccine_name = '$vaccine_name' AND id_number = '$passed_id'";
        
        $stmt5 = $pdo->prepare($sql5);
            // Bind variables to the prepared statement as parameters
        $stmt5->execute();

        $sql6 = "SELECT dose from vaccination_record WHERE dose = '3rd dose' AND vaccine_name = '$vaccine_name' AND id_number = '$passed_id'";
        
        $stmt6 = $pdo->prepare($sql6);
            // Bind variables to the prepared statement as parameters
        $stmt6->execute();

        $sql7 = "SELECT dose from vaccination_record WHERE dose = '4th dose' AND vaccine_name = '$vaccine_name' AND id_number = '$passed_id'";
        
        $stmt7 = $pdo->prepare($sql7);
            // Bind variables to the prepared statement as parameters
        $stmt7->execute();

        if($stmt1->rowCount() > 0 ){
            $duplicate_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Duplicate Record. Please enter a new record.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";
            echo $duplicate_err;
        }elseif(($stmt3->rowCount() == 0) && ($dose == '2nd dose')){
            $missing_dose = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Missing dose record. Please enter a new record.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";

        }elseif(($stmt5->rowCount() == 0) && ($dose == '3rd dose')){
            $missing_dose = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Missing dose record. Please enter a new record.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";

        }elseif(($stmt6->rowCount() == 0) && ($dose == '4th dose')){
            $missing_dose = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Missing dose record. Please enter a new record.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";

        }elseif(($stmt7->rowCount() == 0) && ($dose == '5th dose')){
            $missing_dose = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Missing dose record. Please enter a new record.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";

        }else{
            $dose = trim($_POST["dose"]);
            $vaccine_name = trim($_POST["vaccine_name"]);
        }
        unset($stmt1);
        unset($stmt3);
        unset($stmt5);
        unset($stmt6);
        unset($stmt7);
    }

    // Check input errors before inserting in database
    if(empty($form_err) && empty($dose_err) && empty($duplicate_err) && empty($missing_dose) && empty($pregnant_err) && empty($medications_err) && empty($symptoms_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO vaccination_record (id_number, first_name, middle_name, last_name, suffixes, sex, current_age, vaccine_name, dose, serial_code, site_name, remarks, symptoms, medications, pregnant) VALUES ('$rec_id_number', :first_name, :middle_name, :last_name, '$suffixes', '$sex', '$age', :vaccine_name, :dose, :serial_code, :site_name, :remarks, '$symptoms', '$medications', '$pregnant')";

        $sql2 = "INSERT INTO activity_log (username, activity) VALUES (:username,:activity)";

        //$sql8 = "UPDATE health_declaration SET medications = '$medications', symptoms = '$symptoms', pregnant = '$pregnant' WHERE id_number = '$rec_id_number'";

        $conn = new PDO($dsn, $username_db, $password_db, $options);

        $userData = count($_POST["past_vacc"]);
        
        if ($userData > 0) {
            for ($i=0; $i < $userData; $i++) { 
            if (trim($_POST['past_vacc'] != " ") && trim($_POST['vacc_year'] != " ")) {
                $first_name = $_POST["first_name"];
                $past_vacc = $_POST["past_vacc"][$i];
                $vacc_year = $_POST["vacc_year"][$i];
                $query = "INSERT INTO past_imm (id_number,first_name,past_vacc,vacc_year) VALUES ('$passed_id','$first_name','$past_vacc','$vacc_year')";
                $statement3 = $conn->prepare($query);
                $statement3->execute();
            }
            }
        }else{
             echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                        <i class='bi-exclamation-octagon-fill'></i>
                        <strong class='mx-1'>Error!</strong> Please Enter user name.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>
          </div>";
        }
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //$stmt->bindParam(":id_number", $param_id_number, PDO::PARAM_STR);
            $stmt->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":middle_name", $param_middle_name, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":vaccine_name", $param_vaccine_name, PDO::PARAM_STR);
            $stmt->bindParam(":dose", $param_dose, PDO::PARAM_STR);
            $stmt->bindParam(":serial_code", $param_serial_code, PDO::PARAM_STR);
            $stmt->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
            $stmt->bindParam(":remarks", $param_remarks, PDO::PARAM_STR);
            
            // Set parameters
            //$param_id_number = $id_number;
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_last_name = $last_name;
            $param_vaccine_name = $vaccine_name;
            $param_dose = $dose;
            $param_serial_code = $serial_code;
            $param_site_name = $site_name;
            $param_remarks = $remarks;
            
            // Attempt to execute the prepared statement

            if($stmt->execute()){
                // Redirect to login page
                 echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Record updated.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                    </div>";

            } else{
               echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Something went wrong. Please try again.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                    </div>";
            }

            // Close statement
            unset($stmt);
        }

        if($stmt = $pdo->prepare($sql2)){
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
                                    <strong class='mx-1'>Success!</strong> Data saved.
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
                                <strong class='mx-1'>Error!</strong> Not working.
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                        </div>
                  </div>";
    }
    
    // Close connection
    unset($pdo);
}

?>
    <div id="reg-accounts">
        <h2>Update Record</h2>
        <div class="reg_wrapper">
             
            <div>
                <h4>ID Number: <?php echo $passed_id; ?></h4>
                <h4>Name: <?php echo $passed_fname . " " . $passed_mname . " " . $passed_lname; ?></h4>
            </div>
            <br>
        </div>
            <h2 class="viewpub">Health Declaration Form</h2>
        <form action="" method="POST" name="add_immunization" id="add_immunization">
        <div class="reg_wrapper">
            <!-- snipped symptoms -->
                    <div class="row">
                        <div class="form-group">   
                            <p>Check on all the symptoms that the individual is experiencing:</p>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Fever/ chills" id="btn-check-69-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-69-outlined">Fever/Chills</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Headache" id="btn-check-71-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-71-outlined">Headache</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Cough" id="btn-check-72-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-72-outlined">Cough</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Colds" id="btn-check-73-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-73-outlined">Colds</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Sore Throat" id="btn-check-500-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-500-outlined">Sore Throat</label>  
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Myalgia" id="btn-check-75-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-75-outlined">Myalgia</label>  
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Rashes" id="btn-check-300-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-300-outlined">Rashes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Fatigue" id="btn-check-301-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-301-outlined">Fatigue</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Weakness" id="btn-check-74-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-74-outlined">Weakness</label>  
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Loss of smell/ taste" id="btn-check-302-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-302-outlined">Loss of Smell/Taste</label>  
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Diarrhea" id="btn-check-88-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-88-outlined">Diarrhea</label>  
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="symptoms[]" value="Breathing Difficulty" id="btn-check-89-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-89-outlined">Breathing Difficulty</label>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <p>Is the individual currently taking any medications?</p>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="medications" value="Yes" id="btn-check-90-outlined" autocomplete="off" required>
                                    <label class="btn btn-outline-secondary" for="btn-check-90-outlined">Yes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="medications" value="No" id="btn-check-91-outlined" autocomplete="off" required>
                                    <label class="btn btn-outline-secondary" for="btn-check-91-outlined">No</label>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <p>Is the individual currently undergoing pregnancy?</p>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="pregnant" value="Yes" id="btn-check-92-outlined" autocomplete="off" required>
                                    <label class="btn btn-outline-secondary" for="btn-check-92-outlined">Yes</label>  
                                </div>
                                <div class="col-3">
                                    <input type="radio" class="btn-check" name="pregnant" value="No" id="btn-check-93-outlined" autocomplete="off" required>
                                    <label class="btn btn-outline-secondary" for="btn-check-93-outlined">No</label>  
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <br>
            <h2 class="viewpub">Vaccination</h2>
            <div class="reg_wrapper">

                <!--select statement-->
                   
                <div class="form-group">
                    <input type="hidden" name="first_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $passed_fname; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                </div>   
                <div class="form-group">
                    <input type="hidden" name="middle_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $passed_mname; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                </div>   
                <div class="form-group">
                    <input type="hidden" name="last_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $passed_lname; ?>">
                    <span class="invalid-feedback"><?php echo $form_err; ?></span>
                </div>
                
                <h5>Past Immunizations</h5>

                  <div class="row no-gutters">
                    <div class="col-md-1"></div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <div name="add_immunization" id="add_immunization" method="post">
                            <table class="table" id="dynamic_field">
                              <tr>
                                <td>
                                    <select name="past_vacc[]" placeholder="Vaccine" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $past_vacc; ?>">
                                    <option></option>
                                    <?php foreach($results as $output) {?>
                                    <option><?php echo $output["vaccine_name"];?></option>
                                    <?php }?>
                                    </select>
                                </td>
                                <td><input type="number" maxlength="4" name="vacc_year[]" placeholder="Year" class="form-control vacc_year"/></td>
                                <td><button type="button" name="add" id="add" class="btn btn-primary">Add More</button></td>  
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    <div class="col-md-1"></div>
                  </div>

                <div class="row row-pd">  
                    <div class="form-group col">
                        <label for="vaccine_name">Vaccine</label>
                        <select id="vaccine_name" name="vaccine_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vaccine_name; ?>" required>
                        <option></option>
                        <?php foreach($results as $output) {?>
                        <option><?php echo $output["vaccine_name"];?></option>
                        <?php }?>
                        </select>
                    </div>

                    <div class="form-group col">
                        <label for="dose">Dose</label>
                        <select id="dose" name="dose" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dose; ?>"required >
                        <option></option>
                        <option value="1st dose">1st dose</option>
                        <option value="2nd dose">2nd dose</option>
                        <option value="3rd dose">3rd dose</option>
                        <option value="4th dose">4th dose</option>
                        <option value="5th dose">5th dose</option>
                        <option value="booster">booster</option>
                        </select>
                    </div>
                    <div class="form-group col">
                        <label for="route_ad">Administration Route</label>
                        <select id="route_ad" name="route_ad" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $route_ad; ?>"required>
                        <option></option>
                        <option value="Oral">Oral</option>
                        <option value="Subcuteneous">Subcutaneous</option>
                        <option value="Intramuscular">Intramuscular</option>
                        <option value="Intradermal">Intradermal</option>
                        </select>
                    </div>
                </div>  
                <div class="row row-pd">
                    <div class="form-group col">
                        <label>Serial Code</label>
                        <input type="text" name="serial_code" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $serial_code; ?>">
                        <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    <div class="form-group col">
                            <label for="site_name">Vaccination Site</label>
                            <input type="text" name="site_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $site_name; ?>" readonly>
                        <span class="invalid-feedback"><?php echo $form_err; ?></span>
                        </div>
                        <div class="form-group col">
                            <label for="remarks">Status</label>
                            <select id="remarks" name="remarks" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $remarks; ?>"required>
                            <option></option>
                            <option value="ongoing">ongoing</option>
                            <option value="complete">complete</option>
                            </select>
                        </div>
                    </div>
                
                <div class="form-group" id="sub-pd">
                    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Submit">
                </div>

                
                                
        </form>
        <!-- </div> -->
    </div>

<?php
require "../admin/templates/main-footer.php";
require "../templates/userfooter.php"; 
require "../templates/footer.php";?>

<script type="text/javascript">
  $(document).ready(function(){

    var i = 1;

    $("#add").click(function(){
      i++;
      $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="past_vacc[]" placeholder="Vaccine" class="form-control name_list"/></td><td><input type="text" name="vacc_year[]" placeholder="Year" class="form-control name_email"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
    });

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
    });

  });
</script>