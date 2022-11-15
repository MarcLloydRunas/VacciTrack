<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../user/dashboard-user.php";
?>
<?php require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box">  

	<h2>Vaccination Sites</h2>

<?php

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM vaccination_site";

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
	      <th>Vaccination Site</th>
	      <th>Address</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["site_name"]); ?></td>    
	      <td><?php echo escape($row["site_address"]); ?></td>
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