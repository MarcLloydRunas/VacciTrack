<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../user/dashboard-user.php";
	require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box"> 

<h2>Vaccination Schedule</h2>

<?php

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM vaccine_schedule";

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
		      <th>Dose</th>
		      <th>Target</th>
		      <th>Start</th>
		      <th>End</th>
		      <th>Designated Site</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach ($result as $row) : ?>
		  	<?php 
		  	$rawdate = ($row["start_date"]); 
		  	$finaldate = date("F j, Y, g:i a",strtotime($rawdate));
		  	?>
		    <tr>
		      <td><?php echo escape($row["vaccine_name"]); ?></td>    
		      <td><?php echo escape($row["dose"]); ?></td>
		      <td><?php echo escape($row["target"]); ?></td>
		      <td><?php echo escape($finaldate); ?></td>
		      <td><?php echo date("F j, Y, g:i a",strtotime($row["end_date"])); ?></td>
		      <td><?php echo escape($row["site_name"]); ?></td>
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