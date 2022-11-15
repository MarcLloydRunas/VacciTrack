<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
?>
<?php require "../admin/templates/main-header.php"; ?>
<script>
    <?php require("../build/js/alt-dash.js");?>
</script>

<div id="reg-accounts" class="content-box">

	<div class="row g-0">
		<div class="col-11"><h2 class="tophead">Vaccination Schedule</h2></div>
		<div class="col-1"><button onclick="document.location='../admin/add-sched.php'" class="btn btn-primary bttnhead"> <i class='bx bx-bell-plus bx-sm' id="icon-bttn"></i>Add New</button></div>
	</div>	

	<?php

try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $sql2 = "DELETE FROM vaccine_schedule
        WHERE end_date < DATE_ADD(NOW(),INTERVAL - 5 MINUTE)";

    $statement2 = $connection->prepare($sql2);
    $statement2->execute();

  } catch(PDOException $error) {
    echo $sql2 . "<br>" . $error->getMessage();
  }

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM vaccine_schedule WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "<div class='container aligns-items-center justify-content-center' style='width:500px; position:absolute; top:-20px; left: 40%'>
                            <div class='container alert alert-success alert-dismissible d-flex align-items-center fade show' style='margin:-50px;'>
                                <i class='bi-check-circle-fill'></i>
                                    <strong class='mx-1'>Success!</strong> User successfully deleted
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                            </div>
                    </div>";

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

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

	<div class="table-responsive table-hover" id="pubsched">
		<table class="table table-stripped table-responsive" id="tablelogs">
		  <thead>
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

<?php 
require "../admin/templates/main-footer.php"; 
require "../templates/userfooter.php";
require "../templates/footer.php" ?>