<?php
ob_start();
require "../config.php"; 

$passed_id = "";
$id_number = "";
$form_err = "";
$first_name = "";
$middle_name = "";
$last_name = "";
$birth_date = "";
$id_number_err = "";
$fname_err = "";
$lname_err = "";
$mname_err = "";
$birthdate_err = "";

require '../public/verify_form.php';
require "../public/public-navbar.php";
?>

<div class="container-fluid" id="veri-con">
    <h1 style="text-align: center;">Verification</h1>
    <form action="verify_form.php" method="POST">
      <input class="form-control <?php echo (!empty($id_number_err)) ? 'is-invalid' : ''; ?>" type="hidden" id="id_number" name="id_number" value="<?php echo $passed_id_number; ?>" >
      <span class="invalid-feedback"><?php echo $id_number_err; ?></span><br>
      <label for="first_name">First name:</label><br>
      <input class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" >
      <span class="invalid-feedback"><?php echo $fname_err; ?></span><br>
      <label for="middle_name">Middle name:</label><br>
      <input class="form-control <?php echo (!empty($mname_err)) ? 'is-invalid' : ''; ?>" type="text" id="middle_name" name="middle_name" value="<?php echo $middle_name; ?>" >
      <span class="invalid-feedback"><?php echo $mname_err; ?></span><br>
      <label for="last_name">Last name:</label><br>
      <input class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" >
      <span class="invalid-feedback"><?php echo $lname_err; ?></span><br><br>
      <label for="birth_date">Date of Birth:</label><br>
      <input class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>" type="date" id="birth_date" name="birth_date" value="<?php echo $birth_date; ?>" >
      <span class="invalid-feedback"><?php echo $birthdate_err; ?></span><br><br>
      <hr>
      <input class="form-control btn btn-primary" type="submit" name="verifyform" value="submit">

    </form> 
</div>
<?php 
require "../templates/publicfooter.php";
require "../templates/footer.php";
?>