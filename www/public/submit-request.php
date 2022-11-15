<?php
require "../templates/header.php";
require_once "../config.php"; 
require "../public/public-navbar.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/PHPMailer.php';

$mail = new PHPMailer(true);

$sql2= "SELECT site_name FROM vaccination_site";

try {
    $stmt2=$pdo->prepare($sql2);
    $stmt2->execute();
    $siteresults=$stmt2->fetchAll();
}catch(Exception $ex) {
    echo($ex -> getMessage());
}

$requsername = "";
$first_name = "";
$middle_name = "";
$last_name = "";
$site_name = "";
$contact = "";
$password = password_hash("user123",PASSWORD_DEFAULT);
$account_type = "user";
$username_err = '';
$lname_err = '';
$mname_err = '';
$fname_err = '';
$username_err = '';
$site_err = '';
$contact_err = '';
$upload_err = '';

if(isset($_POST["submit"])) {
 
    if(empty(trim($_POST["first_name"]))){
        $fname_err = "Please fill in this form.";
    } else{
        $first_name = trim($_POST["first_name"]);
    }

    if(empty(trim($_POST["middle_name"]))){
        $mname_err = "Please fill in this form.";
    } else{
        $middle_name = trim($_POST["middle_name"]);
    }

    if(empty(trim($_POST["last_name"]))){
        $lname_err = "Please fill in this form.";
    } else{
        $last_name = trim($_POST["last_name"]);
    }


    if(empty(trim($_POST["requsername"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["requsername"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql1 = "SELECT id FROM user_account WHERE username = :requsername";
        
        if($stmt1 = $pdo->prepare($sql1)){
            // Bind variables to the prepared statement as parameters
            $stmt1->bindParam(":requsername", $param_username_user, PDO::PARAM_STR);
            
            // Set parameters
            $param_username_user = trim($_POST["requsername"]);
            
            // Attempt to execute the prepared statement
            if($stmt1->execute()){
                if($stmt1->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $requsername = trim($_POST["requsername"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt1);
        }
    }

    if(empty(trim($_POST["contact"]))){
        $contact_err = "Please fill in this form.";
    } else{
        $contact = trim($_POST["contact"]);
    }

    if(empty(trim($_POST["site_name"]))){
        $site_err = "Please fill in this form.";
    } else{
        $site_name = trim($_POST["site_name"]);
    }   

    if (!isset($_FILES["uploadfile"]["name"])) {
        $upload_err = 'form required.';
    } else {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];    
        $folder = "../admin/upload/".$filename;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
    }

    
    // Validate credentials
    if(empty($site_err) && empty($fname_err) && empty($username_err) && empty($lname_err) && empty($mname_err) && empty($contact_err) && (in_array($extension, ['png', 'jpg', 'jpeg']))) {

        //$imgContent = addslashes(file_get_contents($tempname)); 
    
        // Prepare an insert statement
        $sql = "INSERT INTO user_request (
                    first_name,
                    middle_name,
                    last_name,
                    username,
                    contact,
                    password,
                    account_type,
                    photoID,
                    site_name
                    ) VALUES (
                    :first_name,
                    :middle_name,
                    :last_name,
                    :requsername,
                    :contact,
                    :password,
                    :account_type,
                    '$filename',
                    :site_name
                    )";

        if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
        }


        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
            $stmt->bindParam(":middle_name", $param_middle_name, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
            $stmt->bindParam(":requsername", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":account_type", $param_account_type, PDO::PARAM_STR);
            $stmt->bindParam(":contact", $param_contact, PDO::PARAM_STR);
            $stmt->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
            
            // Set parameters
            $param_first_name = $first_name;
            $param_middle_name = $middle_name;
            $param_last_name = $last_name;
            $param_username = $requsername;
            $param_password = $password;
            $param_account_type = $account_type;
            $param_contact = $contact;
            $param_site_name = $site_name;
            
            // Attempt to execute the prepared statement

            if($stmt->execute()){
                // Redirect to login page
                
                echo "Request Sent.";
                try {
                    //$mail->SMTPDebug = 2;                                   
                    $mail->isSMTP(true);                                            
                    $mail->Host  = 'smtp.gmail.com;';                   
                    $mail->SMTPAuth = true;                         
                    $mail->Username = 'marcsahoy477@gmail.com';             
                    $mail->Password = 'tneqkmknokhbxakf';                       
                    $mail->SMTPSecure = 'tls';                          
                    $mail->Port  = 587;

                    $mail->setFrom('marcsahoy477@gmail.com', 'VacciTrack');       
                    $mail->addAddress('marcsahoy477@gmail.com');
                    //$mail->addAddress('receiver2@gfg.com', 'Name');
                    
                    $mail->isHTML(true);                                
                    $mail->Subject = 'Access Request';
                    $mail->Body = 'A user has requested access. <br> Click on the link below: <br> http://localhost/CVTS/public/index.php';
                    $mail->AltBody = 'A user has requested access.';
                    $mail->send();
                    echo "Mail has been sent successfully!";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}

?>

<div class="container-fluid" id="veri-con">
    <h1 style="text-align: center;">Request Access</h1>
    <hr>
    <br>

    <form enctype="multipart/form-data" method="POST" action="">
        <div class="row">
            <div class="form-group col">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
            </div>
            <div class="form-group col">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group col">
                <label>Middle Name</label>
                <input type="text" name="middle_name" class="form-control <?php echo (!empty($mname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middle_name; ?>">
                <span class="invalid-feedback"><?php echo $mname_err; ?></span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="form-group col">
                <label>Username</label>
                <input type="text" name="requsername" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $requsername; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group col">
                <label>Email Address</label>
                <input type="text" name="contact" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>">
                <span class="invalid-feedback"><?php echo $contact_err; ?></span>
            </div>
            <div class="form-group col">
                <label>Designated Site</label>
                <select name="site_name" placeholder="Vaccine" class="form-control <?php echo (!empty($site_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $site_name; ?>">
                    <option></option>
                    <?php foreach($siteresults as $output) {?>
                    <option><?php echo $output["site_name"];?></option>
                    <?php }?>
                </select>
                <span class="invalid-feedback"><?php echo $site_err; ?></span>
            </div>
        </div>
        <br>
        <label for="files">Photo of Identification Card(png/jpg/gif):</label><br>
        <input class="form-control <?php echo (!empty($upload_err)) ? 'is-invalid' : ''; ?>" type="file" name="uploadfile" value=""/>
        <span class="invalid-feedback"><?php echo $upload_err; ?></span>
        <div>
            <hr>
            <input class="form-control btn btn-primary" type="submit" name="submit" value="submit">
        </div>
        <?php 
            if(!empty($login_err)){
              echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
        ?>
    </form> 
</div>
<br>
<?php
require "../templates/publicfooter.php";
require "../templates/footer.php"; ?>