<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../user/dashboard-user.php";
  require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box"> 

<h2>Listed Vaccines</h2>

<?php

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM vaccine WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                    <i class='bi-check-circle-fill'></i>
                        <strong class='mx-1'>Success!</strong> Vaccine successfully deleted
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>
        </div>";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM vaccine";

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
	      <th>Vaccine</th>
	      <th>Doses</th>
	      <th>Type</th>
	      <th>Dosage</th>
	      <th> </th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["vaccine_name"]); ?></td> 
	      <td><?php echo escape($row["doses"]); ?></td>    
	      <td><?php echo escape($row["vaccine_type"]); ?></td>
				<td><?php echo escape($row["dosage"]); ?></td>	      
	      <td><a href="../user/vacc_view_user.php?vaccinename=<?php echo escape($row["vaccine_name"]); ?>"><i class='bx bx-show nav-logo' id="icon-style"></i></a></td>
	    </tr>
	  <?php endforeach; ?>
	  </tbody>
	</table>	
</div>
</div>


<?php 
require "../templates/userfooter.php";
require "../admin/templates/main-footer.php"; 
require "../templates/footer.php" ?>