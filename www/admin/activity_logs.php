<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
  require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box"> 
	<div class="row g-0">
		<div class="col-11"><h2 class="tophead">Activity Logs</h2></div>
		<div class="col-1"><button onclick="window.open('../admin/generatedpdf_admin.php','_blank')" class="btn btn-primary bttnhead"> <i class='bx bx-printer' id="icon-bttn"></i>Save PDF</button>
		</div>
	</div>	

	<?php

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM activity_log";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $sql2 = "DELETE FROM activity_log
        WHERE date < DATE_ADD(NOW(),INTERVAL - 30 DAY)";

    $statement2 = $connection->prepare($sql2);
    $statement2->execute();

  } catch(PDOException $error) {
    echo $sql2 . "<br>" . $error->getMessage();
  }
?>

<div class="table-responsive table-hover" id="gencon">
	<table class="table table-stripped table-responsive table-bg" id="tablelogs">
	  <thead class="table-dark">
	    <tr>
	      <th>Username</th>
	      <th>Action</th>
	      <th>Date</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["username"]); ?></td>    
	      <td><?php echo escape($row["activity"]); ?></td>
	      <td><?php echo date("F j, Y, g:i a",strtotime($row["date"])); ?></td>
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