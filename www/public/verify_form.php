<?php
ob_start();
ob_clean();
require "./header.php";
session_start();
if(isset($_SESSION['pass_id'])){
    //It exists. We can now use it.
    $passed_id = $_SESSION['pass_id'];
} else{
    echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                        <i class='bi-exclamation-octagon-fill'></i>
                        <strong class='mx-1'>Error!</strong> Your ID number is invalid. Please try again.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>
          </div>";
}

if (isset($_POST['verifyform'])) {

    if(empty(trim($_POST["id_number"]))){
        $id_number_err = "Please enter your first name.";
    } else{
        $id_number = trim($_POST["id_number"]);
    }
 
    if(empty(trim($_POST["first_name"]))){
        $fname_err = "Please enter your first name.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["middle_name"]))){
        $mname_err = "Please enter your first name.";
    } else{
        $middle_name = trim($_POST["middle_name"]);
    }

    if(empty(trim($_POST["last_name"]))){
        $lname_err = "Please enter your first name.";
    } else{
        $last_name = trim($_POST["last_name"]);
    }

    if(empty(trim($_POST["birth_date"]))){
        $birthdate_err = "Please enter your first name.";
    } else{
        $birth_date = trim($_POST["birth_date"]);
    }
    
    // Validate credentials
    if(empty($id_number_err) && empty($fname_err) && empty($mname_err) && empty($lname_err) && empty($birthdate_err)){
        // Prepare a select statement
        $sql = "SELECT id_number,first_name,middle_name,last_name,birth_date FROM public_user WHERE id = $passed_id";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
            
            // Set parameters
            $passed_id_number = trim($_POST["id_number"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id_number = $row["id_number"];
                        $first_name_p = $row["first_name"];
                        $middle_name_p = $row["middle_name"];
                        $last_name_p = $row["last_name"];
                        $birth_date_p = $row["birth_date"];

                        //$_SESSION["pass_id_number"] = $id_number;

                        if($first_name_p == $first_name AND $middle_name_p == $middle_name AND $last_name_p == $last_name AND $birth_date_p == $birth_date){

                            header("location: ./public-view.php");
                            exit;
                        }else{
                             echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 <strong class='mx-1'>Error!</strong> Entry does not match.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                                  </div>";
                            
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                        echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Username does not exist.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                              </div>";


                }
            } else{
               echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
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