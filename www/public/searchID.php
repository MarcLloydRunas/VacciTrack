<?php
session_start();
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'cvts_db');
 
 require ('./config.php');
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}

$id_number = "";
$id_number_err = "";
if (isset($_POST['searchID'])) {
    //if($_SERVER["REQUEST_METHOD"] == "POST"){
     
        if(empty(trim($_POST["id_number"]))){
            $id_number_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                    <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                            <i class='bi-exclamation-octagon-fill'></i>
                                            <strong class='mx-1'>Error!</strong> Your ID number is invalid. Please try again.
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>
                              </div>";
        } else{
            $id_number = trim($_POST["id_number"]);

        }
       
        // Validate credentials
        if(empty($id_number_err)){
            // Prepare a select statement
            $sql1 = "SELECT id,id_number FROM public_user WHERE id_number = :id_number";
           
            if($stmt1 = $pdo->prepare($sql1)){
                // Bind variables to the prepared statement as parameters
                $stmt1->bindParam(":id_number", $param_id_number, PDO::PARAM_STR);
               
                // Set parameters
                $param_id_number = trim($_POST["id_number"]);
               
                // Attempt to execute the prepared statement
                if($stmt1->execute()){
                    // Check if username exists, if yes then verify password
                    if($stmt1->rowCount() == 1){
                        if($row = $stmt1->fetch()){
                            //session_start();
                            $id = $row["id"];
                            $id_number = $row["id_number"];
                            //session_start();

                            $_SESSION["pass_id"] = $id;
                            $_SESSION["pass_id_number"] = $id_number;
                            echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                        <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                            <i class='bi-check-circle-fill'></i>
                                                <strong class='mx-1'>Success!</strong> Please enter the required credentials below.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                                </div>";
                            header("location: verification.php");
                            exit;
                        }
                    } else{
                        echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                    <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                            <i class='bi-exclamation-octagon-fill'></i>
                                            <strong class='mx-1'>Error!</strong> Your ID number is invalid. Please try again.
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>
                              </div>";
                    }
                } else{
                   echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-10px; left:0; right:0'>
                                        <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-exclamation-octagon-fill'></i>
                                                 < <strong class='mx-1'>Error!</strong> Something went wrong. Please try again.
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>
                        </div>";
                }

                // Close statement
                unset($stmt1);
            }
        }
       
        // Close connection
        unset($pdo);
    //}else{
        echo '';
    //}
}?>