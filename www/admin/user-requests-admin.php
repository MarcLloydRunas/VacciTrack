<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
    require "../config.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/SMTP.php';
    require '../PHPMailer-master/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    
    require "../admin/templates/main-header.php";
    ?>
<div id="reg-accounts" class="content-box">

    <div class="row g-0">
        <div class="col-11"><h2 class="tophead">Access Requests</h2></div>
        <div class="col-1"><button onclick="document.location='../admin/user-accounts-reg.php'" class="btn btn-primary bttnhead"> <i class='bx bx-user-plus bx-sm' id="icon-bttn"></i>Add New</button></div>
    </div>  

<?php


if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $id = $_GET["id"];
    $delphotoID = $_GET["photoID"];
    $maildenied = $_GET["denyaccess"];

    $filedir = "../admin/upload/";

    $sql2 = "DELETE FROM user_request WHERE id = :id";

    $statement2 = $connection->prepare($sql2);
    $statement2->bindValue(':id', $id);
    $statement2->execute();

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
        $mail->addAddress($maildenied);
        //$mail->addAddress('receiver2@gfg.com', 'Name');
        
        $mail->isHTML(true);                                
        $mail->Subject = 'Access Request';
        $mail->Body = 'Access request denied. <br> Click on the link below: <br> http://localhost/CVTS/public/index.php';
        $mail->AltBody = 'Access request denied.';
        $mail->send();
        echo "Mail has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    $success = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> User successfully deleted
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                    </div>";

    unlink($filedir.$delphotoID);
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

}


    if(isset($_GET['username'])){

        $aprphotoID = $_GET["photoIDapp"];
        $filedir = "../admin/upload/";

        $mailapproved = $_GET["approveaccess"];
        $sendusername = $_GET["senduser"];

        // Prepare a select statement
        $sql1 = "SELECT * FROM user_request WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql1)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_GET["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $username = $row["username"];
                        $password = $row["password"];
                        $account_type = $row["account_type"];
                        $first_name = $row["first_name"];
                        $middle_name = $row["middle_name"];
                        $last_name = $row["last_name"];
                        $site_name = $row["site_name"];

                        try  {
                            //$connection = new PDO($dsn, $username_db, $password_db, $options);
                            

                            $sql2 = "INSERT INTO  user_account (
                                                  username,
                                                  password,
                                                  first_name,
                                                  middle_name,
                                                  last_name,
                                                  site_name,
                                                  account_type
                                                 ) VALUES (
                                                  :username,
                                                  :password,
                                                  :first_name,
                                                  :middle_name,
                                                  :last_name,
                                                  :site_name,
                                                  :account_type
                                                 )";

                            if($stmt1 = $pdo->prepare($sql2)){
                                // Bind variables to the prepared statement as parameters
                                $stmt1->bindParam(":username", $param_username, PDO::PARAM_STR);
                                $stmt1->bindParam(":password", $param_password, PDO::PARAM_STR);
                                $stmt1->bindParam(":last_name", $param_last_name, PDO::PARAM_STR);
                                $stmt1->bindParam(":first_name", $param_first_name, PDO::PARAM_STR);
                                $stmt1->bindParam(":middle_name", $param_middle_name, PDO::PARAM_STR);
                                $stmt1->bindParam(":account_type", $param_account_type, PDO::PARAM_STR);
                                $stmt1->bindParam(":site_name", $param_site_name, PDO::PARAM_STR);
                                
                                // Set parameters
                                $param_username = $username;
                                $param_password = $password; 
                                $param_last_name = $last_name;
                                $param_first_name = $first_name;
                                $param_middle_name = $middle_name;
                                $param_account_type = $account_type;
                                $param_site_name = $site_name;
                                
                                // Attempt to execute the prepared statement
                                

                                if($stmt1->execute()){
                                  try {
                                    //$connection = new PDO($dsn, $username_db, $password_db, $options);

                                    $sql4 = "DELETE FROM user_request WHERE username = :username";

                                    $statement4 = $pdo->prepare($sql4);
                                    $statement4->bindValue(':username', $username);
                                    $statement4->execute();

                                    $success = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-check-circle-fill'></i>
                                                    <strong class='mx-1'>Success!</strong> User successfully deleted
                                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            </div>
                                    </div>";


                                  } catch(PDOException $error) {
                                    echo $sql4 . "<br>" . $error->getMessage();
                                  }

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
                                        $mail->addAddress($mailapproved);
                                        //$mail->addAddress('receiver2@gfg.com', 'Name');
                                        
                                        $mail->isHTML(true);                                
                                        $mail->Subject = 'Access Request';
                                        $mail->Body = 'Acces request approved <br> Username: '.$sendusername.'<br> Password: user123 <br> Click on the link below: <br> http://localhost/CVTS/public/index.php';
                                        $mail->AltBody = 'A user has requested access.';
                                        $mail->send();
                                        echo "Mail has been sent successfully!";
                                    } catch (Exception $e) {
                                        echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                                <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                        <i class='bi-exclamation-octagon-fill'></i>
                                                        <strong class='mx-1'>Error!</strong> Message could not be sent. Mailer Error: {$mail->ErrorInfo}
                                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                                </div>
                                          </div>";
                                    }

                                   echo "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                                <i class='bi-check-circle-fill'></i>
                                                    <strong class='mx-1'>Success!</strong> Account Updated.
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
                            
                        unlink($filedir.$aprphotoID);
                        } catch(PDOException $error) {
                            echo $sql2 . "<br>" . $error->getMessage();
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-danger alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                    <i class='bi-exclamation-octagon-fill'></i>
                                    <strong class='mx-1'>Error!</strong> Invalid username or password
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                      </div>";
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
    



try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM user_request";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
    

?>

    <div class="table-responsive table-hover" id="gencon">
    	<table class="table table-stripped table-responsive table-bg" id="tablelogs">
    	  <thead class="table-dark">
    	    <tr>
    	      <th>Username</th>
    	      <th>First Name</th>
    	      <th>Middle Name</th>
    	      <th>Last Name</th>
    	      <th>Email</th>
    	      <th>Designated Site</th>
    	      <th>Date Added</th>
              <th>testid</th>
              <th>ID</th>
    	      <th></th>
    	    </tr>
    	  </thead>
    	  <tbody>
    	  <?php foreach ($result as $row) : ?>
    	    <tr>
    	      <td><?php echo escape($row["username"]); ?></td>    
    	      <td><?php echo escape($row["first_name"]); ?></td>
    	      <td><?php echo escape($row["middle_name"]); ?></td>
    	      <td><?php echo escape($row["last_name"]); ?></td>
    	      <td><?php echo escape($row["contact"]); ?></td>
    	      <td><?php echo escape($row["site_name"]); ?></td>
    	      <td><?php echo escape($row["date_added"]); ?> </td>
              <td><?php echo escape($row["photoID"]); ?></td>
              <td>
                <button type="button"
                    class="viewbutton"
                    data-toggle="modal"
                    data-target="#exampleModal<?php echo ($row["photoID"]); ?>">
                    <i class='bx bx-show' id="icon-style"></i>
                </button>

                <div class="modal fade"
                    id="exampleModal<?php echo ($row["photoID"]); ?>"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                     
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                         
                            <!-- Add image inside the body of modal -->
                            <div class="modal-body">
                                <img id="image" class="imgsize" src="../admin/upload/<?php echo ($row["photoID"]); ?>" alt="Click on button" />
                            </div>
             
                            <div class="modal-footer">
                                <button type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal">
                                    Close
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
    	      <td>
    	      	<div class="dropdown" id="icon-style">
    					  <a class="dropbtn"><i class='bx bx-plus-circle nav_logo-icon' id="icon-style"></i></a>
    					<div class="dropdown-content">
    						  <a href="user-requests-admin.php?username=<?php echo escape($row["username"]) ?>&photoIDapp=<?php echo escape($row["photoID"]); ?>&approveaccess=<?php echo escape($row["contact"]); ?>&senduser=<?php echo escape($row["username"]); ?>"><i class='bx bx-show' id="icon-style"></i><br>Approve</a>
    						  <a href="user-requests-admin.php?id=<?php echo escape($row["id"]); ?>&photoID=<?php echo escape($row["photoID"]); ?>&denyaccess=<?php echo escape($row["contact"]); ?>"><i class='bx bx-trash' id="icon-style"></i><br>Deny</a>
    		  			</div>
    			</div>
              
    		  </td>
    	    </tr>
    	  <?php endforeach; ?>
    	  </tbody>
    	</table>	
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js">
    </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
    </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js">
    </script>


<?php 
require "../templates/userfooter.php";
require "../admin/templates/main-footer.php";
require "../templates/footer.php" ?>