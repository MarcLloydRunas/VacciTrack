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

	<div class="row g-0">
		<div class="col-11"><h2 class="tophead">Personal Data</h2></div>
		<div class="col-1"><button onclick="document.location='../user/add-entry.php'" class="btn btn-primary bttnhead"> <i class='bx bx-user-plus' id="icon-bttn"></i>Add New</button></div>
	</div>	
	<?php

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM public_user";

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
	      <th>Date of Birth</th>
	      <th>Sex</th>
	      <th>Current Address</th>
	      <th>Contact Number</th>
	      <th>Email Address</th>
	      <th>Date Added</th>
	      <th>Edit</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["id_number"]); ?></td>    
	      <td><?php echo escape($row["first_name"] . " " . $row["last_name"]); ?></td>
	      <td><?php echo escape($row["birth_date"]); ?></td>
	      <td><?php echo escape($row["sex"]); ?></td>
	      <td><?php echo escape($row["address_current"]); ?></td>
	      <td><?php echo escape($row["contact_number"]); ?></td>
	      <td><?php echo escape($row["email_address"]); ?></td>
	      <td><?php echo escape($row["date_added"]); ?> </td>
	      <td>
	      	<div class="dropdown" id="icon-style">
					  <a class="dropbtn"><i class='bx bx-plus-circle nav_logo-icon' id="icon-style"></i></a>
					  <div class="dropdown-content">
					  <a href="../user/add-rec.php?id=<?php echo escape($row["id_number"]) ?>&fname=<?php echo escape($row["first_name"]) ?>&mname=<?php echo escape($row["middle_name"]) ?>&lname=<?php echo escape($row["last_name"]) ?>"><i class='bx bx-edit nav-logo' id="icon_style"></i><br>Update</a>
					  <a href="../admin/view-rec.php?id=<?php echo escape($row["id_number"]); ?>"><i class='bx bx-show' id="icon_style"></i><br>View</a>
	  			</div>
	      </td>
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

	
</script>