<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
	require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box">

	<div class="row g-0">
		<div class="col-11"><h2 class="tophead">User Accounts</h2></div>
		<div class="col-1"><button onclick="document.location='../admin/user-accounts-reg.php'" class="btn btn-primary bttnhead"> <i class='bx bx-user-plus bx-sm' id="icon-bttn"></i>Add New</button></div>
	</div>	

	<?php

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM user_account WHERE id = :id";

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

  $sql = "SELECT * FROM user_account";

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
	      <th>Username</th>
	      <th>First Name</th>
	      <th>Middle Name</th>
	      <th>Last Name</th>
	      <th>Account</th>
	      <th>Designated Site</th>
	      <th>Date Added</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["username"]); ?></td>    
	      <td><?php echo escape($row["first_name"]); ?></td>
	      <td><?php echo escape($row["middle_name"]); ?></td>
	      <td><?php echo escape($row["last_name"]); ?></td>
	      <td><?php echo escape($row["account_type"]); ?></td>
	      <td><?php echo escape($row["site_name"]); ?></td>
	      <td><?php echo escape($row["date_added"]); ?> </td>
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


