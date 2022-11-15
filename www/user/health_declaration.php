<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../user/dashboard-user.php";
?>
<?php require "../admin/templates/main-header.php"; ?>
<script>
    <?php require("../build/js/alt-dash.js");?>
</script>


<div id="reg-accounts" class="content-box">

		<h2>Health Declaration</h2>
	<?php

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM health_declaration";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql2 = "SELECT * FROM vaccination_record";

  $statement = $connection->prepare($sql2);
  $statement->execute();

  $result2 = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql2 . "<br>" . $error->getMessage();
}
?>

<h3 class="healthdectop">Personal Data</h3>
<div class="table-responsive table-hover" id="gencon">
	<table class="table table-stripped table-responsive table-bg" id="myTable">
	  <thead class="table-dark">
	    <tr>
	      <th>ID Number</th>
	      <th>Name</th>
	      <th style="word-wrap: break-word; max-width: 150px;">Conditions</th>
	      <th>Medical Allergies</th>
	      <th>Tobacco History</th>
	      <th>Illegal Drugs</th>
	      <th>Alcohol Consumption</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["id_number"]); ?></td>    
	      <td><?php echo escape($row["first_name"] . " " . $row["last_name"]); ?></td>
	      <td style="word-wrap: break-word; max-width: 150px;"><?php echo escape($row["conditions"]); ?></td>
	      <td><?php echo escape($row["medical_allergies"]); ?></td>
	      <td><?php echo escape($row["tobacco_history"]); ?></td>
	      <td><?php echo escape($row["illegal_drugs"]); ?> </td>
	      <td><?php echo escape($row["alcohol_consumption"]); ?> </td>
	    </tr>
	  <?php endforeach; ?>
	  </tbody>
	</table>	
</div>

<h3 class="healthdectop">Vaccinations</h3>
<div class="table-responsive table-hover" id="gencon">
	<table class="table table-stripped table-responsive table-bg" id="myTable2">
	  <thead class="table-dark">
	    <tr>
	      <th>ID Number</th>
	      <th>Name</th>
	      <th style="word-wrap: break-word; max-width: 150px;">Symptoms</th>
	      <th>Medications</th>
	      <th>Pregnancy Status</th>
	      <th>Date Updated</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result2 as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["id_number"]); ?></td>    
	      <td><?php echo escape($row["first_name"] . " " . $row["last_name"]); ?></td>
	      <td style="word-wrap: break-word; max-width: 150px;"><?php echo escape($row["symptoms"]); ?></td>
	      <td><?php echo escape($row["medications"]); ?></td>
	      <td><?php echo escape($row["pregnant"]); ?></td>
	      <td><?php echo escape($row["vaccine_date"]); ?> </td>
	    </tr>
	  <?php endforeach; ?>
	  </tbody>
	</table>	
</div>

<?php 
require "../admin/templates/main-footer.php"; 
require "../templates/userfooter.php";
require "../templates/footer.php" ?>

<script type="text/javascript">

	$(document).ready(function () {
	  $('#myTable').DataTable();
	  $('.dataTables_length').addClass('bs-select');
	});

	$(document).ready(function () {
	  $('#myTable2').DataTable();
	  $('.dataTables_length').addClass('bs-select');
	});

	
</script>