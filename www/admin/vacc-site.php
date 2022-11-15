<?php
ob_start(); 
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
	require "../admin/templates/main-header.php"; ?>

<div id="reg-accounts" class="content-box"> 

	<div class="row g-0">
        <div class="col-11"><h2 class="tophead">Vaccination Sites</h2></div>
        <div class="col-1"><button onclick="document.location='../admin/new-vacc-site.php'" class="btn btn-primary bttnhead"> <i class='bx bx-user-plus bx-sm' id="icon-bttn"></i>Add New</button></div>
   </div>  

<?php

if (isset($_GET["id"])) {
  try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $id = $_GET["id"];

    $sql = "DELETE FROM vaccination_site WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $success = "Site successfully deleted";

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

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
	      <th>Update</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php foreach ($result as $row) : ?>
	    <tr>
	      <td><?php echo escape($row["site_name"]); ?></td>    
	      <td><?php echo escape($row["site_address"]); ?></td>
	      <td><a href="../admin/site-update.php?siteedit=<?php echo escape($row["id"]); ?>"><i class='bx bx-edit nav-logo' id="icon-style"></i></a></td>
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