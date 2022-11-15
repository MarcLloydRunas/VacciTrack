<?php
ob_start();
require './public/searchID.php';
require "header.php";
require "./public/public-navbar.php";?>
<div class="container-fluid">
    <div class="container-fluid" id="logo-template">
      <img class="img-fluid proportion-login" id="placement" src="./img/VacciTrack_logo_3A.png" alt="VacciTrack Logo">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8" id="placement">
                <div class="input-group mb-3">
                    <form action="./public/searchID.php" id="idnumber" method="post">
                        <input type="text" name = "id_number" id="id_number" class="form-control input-text <?php echo (!empty($id_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $id_number; ?>"placeholder="Search for ID number...">
                        <div class="input-group-append">
                          <button class="btn btn-outline-warning btn-lg" id="searchforID" type="submit" name="searchID" value="searchId">
                            <i class="fa fa-search"></i>
                          </button>
                        </div>
                    </form>
                    <span class="invalid-feedback"><?php echo $id_number_err; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    require "./templates/publicfooter.php";
    require "./templates/footer.php";
?>