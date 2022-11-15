<?php
ob_start();
    require "../templates/header.php"; 
    require "../admin/dashboard-admin.php";
    require "../admin/templates/main-header.php";
    require "../admin/connection/config.php";

    require_once "../config.php";

$sql1= "SELECT vaccine_name FROM vaccine";

try {
    $stmt1=$pdo->prepare($sql1);
    $stmt1->execute();
    $results=$stmt1->fetchAll();
}catch(Exception $ex) {
    echo($ex -> getMessage());
}

$sql11= "SELECT site_name FROM vaccination_site";

try {
    $stmt11=$pdo->prepare($sql11);
    $stmt11->execute();
    $siteresult=$stmt11->fetchAll();
}catch(Exception $ex) {
    echo($ex -> getMessage());
}

try {
        $connection = new PDO($dsn, $username_db, $password_db, $options);

        $sql2 = "DELETE FROM vaccine_schedule
            WHERE end_date < DATE_ADD(NOW(),INTERVAL - 5 MINUTE)";

        $statement2 = $connection->prepare($sql2);
        $statement2->execute();

    } catch(PDOException $error) {
    echo $sql2 . "<br>" . $error->getMessage();
  }   

// Define variables and initialize with empty values
$vaccine_name = "";
$dose = "";
$target = "";
$start_date = "";
$end_date = "";
$site_name = "";
$subcategory = "";
$target_err = "";

//errors
$vaccine_name_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate site name
    if(empty(trim($_POST["vaccine_name"]))){
        $form_err = "Enter vaccine name.";
    } else{
        $vaccine_name = trim($_POST["vaccine_name"]);
    }  

    if (isset($_REQUEST['dose'])) {
        $dose=implode(", ", $_REQUEST['dose']);
    }elseif(empty($dose)){
        $dose_err = "Please fill in this checkbox";
    }else{
        $error = "checkbox error";
    }

    if (isset($_REQUEST['target'])) {
        $target=implode(", ", $_REQUEST['target']);
    }elseif(empty($target)){
        $target_err = "Please fill in this checkbox";
    }else{
        $error = "checkbox error";
    }

    if(empty(trim($_POST["start_date"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $start_date = trim($_POST["start_date"]);
    }

    if(empty(trim($_POST["end_date"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $end_date = trim($_POST["end_date"]);
    }

    if(empty(trim($_POST["site_name"]))){
        $form_err = "Please fill in this form.";     
    } else{
        $site_name = trim($_POST["site_name"]);
    }


        if(empty($form_err) && empty($dose_err) && empty($target_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO vaccine_schedule(
                    vaccine_name, 
                    dose,
                    target,
                    start_date,
                    end_date,
                    site_name
                    )VALUES(
                    :vaccine_name, 
                    :dose,
                    :target,
                    :start_date,
                    :end_date,
                    :site_name
                )";
             
            if($stmt = $pdo->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":vaccine_name", $param_vaccine_name, PDO::PARAM_STR);
                $stmt->bindParam(":dose", $param_dose, PDO::PARAM_STR);
                $stmt->bindParam(":target", $param_target, PDO::PARAM_STR);
                $stmt->bindParam(":start_date", $param_start_date, PDO::PARAM_STR);
                $stmt->bindParam(":end_date", $param_end_date, PDO::PARAM_STR);
                $stmt->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
                
                // Set parameters
                $param_vaccine_name = $vaccine_name;
                $param_dose = $dose;
                $param_target = $target;
                $param_start_date = $start_date;
                $param_end_date = $end_date;
                $param_site_name = $site_name;
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Redirect to login page
                    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> Schedule added.
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
        <h2>Vaccination Schedule</h2>
        <div class="reg_wrapper">
            
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                    <div class="form-group col">
                        <label for="vaccine_name">Vaccine</label>
                        <select id="vaccine_name" name="vaccine_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $vaccine_name; ?>"required>
                            <option></option>
                            <?php foreach($results as $output) {?>
                            <option><?php echo $output["vaccine_name"];?></option>
                            <?php }?>
                        </select>
                    </div>  
                    <div class="form-group col">
                        <label for="site_name">Designated Site</label>
                        <select id="site_name" name="site_name" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $site_name; ?>"required>
                            <option></option>
                            <?php foreach($siteresult as $output) {?>
                            <option><?php echo $output["site_name"];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="start_date">Start</label>
                            <input type="datetime-local" name="start_date" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $start_date; ?>"required>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div>
                    <div class="form-group col">
                        <label for="end_date">End</label>
                            <input type="datetime-local" name="end_date" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $end_date; ?>"required>
                            <span class="invalid-feedback"><?php echo $form_err; ?></span>
                    </div> 
                </div>
                <div class="row"> 
                    <div class="form-group col">
                        <label for="dose" class="doseradio <?php echo (!empty($dose_err)) ? 'is-invalid' : ''; ?>">Dose</label>
                        <span class="invalid-feedback"><?php echo $dose_err; ?></span>
                        <div class="row row-pd">
                            <div class="col">
                                <input type="checkbox" class="btn-check" name="dose[]" value="1st dose" id="btn-check-19-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-19-outlined">1st dose</label> 
                            </div>
                            <div class="col">
                                <input type="checkbox" class="btn-check" name="dose[]" value="2nd dose" id="btn-check-20-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-20-outlined">2nd dose</label>  
                            </div>
                            <div class="col">
                                <input type="checkbox" class="btn-check" name="dose[]" value="3rd dose" id="btn-check-21-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-21-outlined">3rd dose</label>  
                            </div>
                            <div class="col">
                                <input type="checkbox" class="btn-check" name="dose[]" value="4th dose" id="btn-check-22-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-22-outlined">4th dose</label>  
                            </div>
                        </div>
                        <div class="row row-pd">
                            <div class="col-3">
                                <input type="checkbox" class="btn-check" name="dose[]" value="5th dose" id="btn-check-23-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-23-outlined">5th dose</label> 
                            </div>
                            <div class="col-3">
                                <input type="checkbox" class="btn-check" name="dose[]" value="booster" id="btn-check-24-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-24-outlined">booster</label>  
                            </div>
                            <div class="col-3">
                                <input type="checkbox" class="btn-check" name="dose[]" value="All" id="btn-check-25-outlined" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="btn-check-25-outlined">All</label>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">   
                            <label for="target" class="doseradio <?php echo (!empty($target_err)) ? 'is-invalid' : ''; ?>">Category</label>
                            <span class="invalid-feedback"><?php echo $target_err; ?></span>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="At birth" id="btn-check-1-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-1-outlined">At birth</label> 
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="6-10-14 weeks" id="btn-check-2-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-2-outlined">6-10-14 weeks</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="14 weeks" id="btn-check-3-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-3-outlined">14 weeks</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="60 years old" id="btn-check-4-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-4-outlined">60 years old</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="9 and 12 months" id="btn-check-5-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-5-outlined">9 and 12 months</label> 
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Grade 1 and 7" id="btn-check-6-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-6-outlined">Grade 1 and 7</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="6-10 weeks" id="btn-check-7-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-7-outlined">6-10 weeks</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="9 months" id="btn-check-8-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-8-outlined">9 months</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Child-bearing women" id="btn-check-9-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-9-outlined">Child-bearing women</label> 
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Td1: As soon as possible in pregnancy" id="btn-check-10-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-10-outlined">Td1: As soon as possible in pregnancy</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Td2: 4 weeks after Td1" id="btn-check-11-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-11-outlined">Td2: 4 weeks after Td1</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Td3: 6 months after Td2" id="btn-check-12-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-12-outlined">Td3: 6 months after Td2</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Td4: 1 year after Td3" id="btn-check-13-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-13-outlined">Td4: 1 year after Td3</label> 
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Td5: 1 year after Td4" id="btn-check-14-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-14-outlined">Td5: 1 year after Td4</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="Female: 9-14 years old" id="btn-check-15-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-15-outlined">Female: 9-14 years old</label>  
                                </div>
                                <div class="col">
                                    <input type="checkbox" class="btn-check" name="target[]" value="60 years old and above" id="btn-check-16-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-16-outlined">60 years old and above</label>  
                                </div>
                            </div>
                            <div class="row row-pd">
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="target[]" value="11-18 years old" id="btn-check-17-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-17-outlined">11-18 years old</label> 
                                </div>
                                <div class="col-3">
                                    <input type="checkbox" class="btn-check" name="target[]" value="19 years old and above" id="btn-check-18-outlined" autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="btn-check-18-outlined">19 years old and above</label>  
                                </div>
                            </div>

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