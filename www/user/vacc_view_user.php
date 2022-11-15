<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
    require "../templates/header.php"; 
    require "../user/dashboard-user.php";
    require "../admin/templates/main-header.php";
?>

<?php

// Define variables and initialize with empty values
$fetch_vaccine_name = ($_GET['vaccinename']);

try {

	$connection=new PDO($dsn, $username_db, $password_db, $options);

	$sql="SELECT * FROM vaccine WHERE vaccine_name = '$fetch_vaccine_name'";

	$statement = $connection->prepare($sql);
  	$statement->execute();
	$result = $statement->fetchAll();


} catch(PDOException $error){
	echo $sql . "<br>" . $error->getMessage();
}

?>
    <div id="reg-accounts">
    	<?php foreach ($result as $row) : ?>
    		<h2><?php echo escape($row["vaccine_name"]); ?></h2>
                <!--Personal Info-->
        <div class="container-fluid">
			    <div class="row-view">
				  <div class="column-view">
				    <p class="form-control">
				    	<b>Type:</b> <?php echo escape($row["vaccine_type"]); ?>
				    	<br>
				    	<b>Number of Doses:</b> <?php echo escape($row["doses"]); ?>
				    	<br>
				    	<b>Adverse Reactions:</b> <?php echo escape($row["ad_reactions"]); ?>
				    	<br>
				    	<b>Contraindications:</b> <?php echo escape($row["contraindications"]); ?>
				    </p>
				  </div>
				  <div class="column-view">
				  	<p class="form-control">
				    	<b>Administration Route:</b> <?php echo escape($row["inject_type"]); ?>
				    	<br>
				    	<b>Administration Site:</b> <?php echo escape($row["inject_site"]); ?>
				    	<br>
				    	<b>Dosage:</b> <?php echo escape($row["dosage"]); ?>
				    	<br>
				    	<b>Special precautions:</b> <?php echo escape($row["spec_precautions"]); ?>
				    </p>
				  </div>
				</div>
				<?php endforeach; ?>  
        </div>   
    </div>

<?php require "../admin/templates/main-footer.php"; ?>

<?php require "../templates/footer.php";?>