<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
	require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box"> 

	<div class="row g-0">
        <div class="col-11"><h2 class="tophead">Listed Vaccines</h2></div>
        <div class="col-1"><button onclick="document.location='../admin/vacc-name-add.php'" class="btn btn-primary bttnhead"> <i class='bx bx-user-plus bx-sm' id="icon-bttn"></i>Add New</button></div>
   </div>  

<?php

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
	      <td><a href="../admin/vacc-view.php?vaccinename=<?php echo escape($row["vaccine_name"]); ?>"><i class='bx bx-show nav-logo' id="icon-style"></i></a></td>
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