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

	<h2>Records</h2>

	<?php

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $id = $_GET["id"];

    $sql = "SELECT FROM vaccination_record WHERE id_number = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM vaccination_record";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>


<div class="table-responsive table-hover" id="gencon">
	<table class="table table-stripped table-responsive table-bg" id="myTable">
	  <thead class="table-dark">
	    <tr>
	      <th>ID Number</th>
	      <th>Name</th>
	      <th>Vaccine Name</th>
	      <th>Dose</th>
	      <th>Date of Vaccination</th>
	      <th>Site</th>
	      <th>Remarks</th>
	      <th>Update</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : 
	  	?>
	    <tr>
	      <td><?php echo escape($row["id_number"]); ?></td>    
	      <td><?php echo escape($row["first_name"] . " " . $row["last_name"]); $_SESSION['pass_first_name'] = $row["first_name"];?></td>
	      <td><?php echo escape($row["vaccine_name"]); ?></td>
	      <td><?php echo escape($row["dose"]); ?></td>
	      <td><?php echo escape($row["vaccine_date"]); ?></td>
	      <td><?php echo escape($row["site_name"]); ?></td>
	      <td><?php echo escape($row["remarks"]); ?> </td>
	      <td>
	      	<div class="dropdown" id="icon-style">

					  <a class="dropbtn"><i class='bx bx-plus-circle nav_logo-icon' id="icon-style"></i></a>
					  <div class="dropdown-content">
						  <a href="../user/add-rec.php?id=<?php echo escape($row["id_number"]) ?>&fname=<?php echo escape($row["first_name"]) ?>&mname=<?php echo escape($row["middle_name"]) ?>&lname=<?php echo escape($row["last_name"]) ?>"><i class='bx bx-edit' id="icon_style"></i><br>Update</a>
						  <a href="../admin/view-rec.php?id=<?php echo escape($row["id_number"]); ?>"><i class='bx bx-show' id="icon_style"></i><br>View</a>
		  			</div>
		  		</div>
	      </td>
	    </tr>
	      
	  <?php endforeach; ?>
	  </tbody>
	</table>	
</div>
</div>


<?php 
require "../templates/userfooter.php";
require "../templates/footer.php" ?>

<script type="text/javascript">

	$(document).ready(function () {
	  $('#myTable').DataTable();
	  $('.dataTables_length').addClass('bs-select');
	});

	
</script>