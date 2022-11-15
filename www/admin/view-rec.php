<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
    require "../templates/header.php"; 
    require "../user/dashboard-user.php";
    require "../admin/templates/main-header.php";

// Define variables and initialize with empty values
$id_number = trim($_GET['id']);

try {

	$connection=new PDO($dsn, $username_db, $password_db, $options);

	$sql="SELECT * FROM public_user WHERE id_number = $id_number";

	$statement = $connection->prepare($sql);
  	$statement->execute();
	$result = $statement->fetchAll();


} catch(PDOException $error){
	echo $sql . "<br>" . $error->getMessage();
}

try {

	$connection=new PDO($dsn, $username_db, $password_db, $options);

	$sql2="SELECT * FROM vaccination_record WHERE id_number = $id_number";

	$statement = $connection->prepare($sql2);
  	$statement->execute();
	$result2 = $statement->fetchAll();


} catch(PDOException $error){
	echo $sql2 . "<br>" . $error->getMessage();
}

try {

	$connection=new PDO($dsn, $username_db, $password_db, $options);

	$sql3="SELECT * FROM vaccination_record WHERE id_number = $id_number";

	$statement = $connection->prepare($sql3);
  	$statement->execute();
	$result3 = $statement->fetchAll();


} catch(PDOException $error){
	echo $sql3 . "<br>" . $error->getMessage();
}

try {

	$connection=new PDO($dsn, $username_db, $password_db, $options);

	$sql3="SELECT * FROM past_imm WHERE id_number = $id_number";

	$statement = $connection->prepare($sql3);
  	$statement->execute();
	$result3 = $statement->fetchAll();


} catch(PDOException $error){
	echo $sql3 . "<br>" . $error->getMessage();
}

?>
    <div id="reg-accounts">
    	<h2>Personal information: </h2>
                <!--Personal Info-->
        <div class="container-fluid" id="gencon">
			<?php foreach ($result as $row) : ?>
			<div class="row">
			    <h5 class="col-11">
			    	ID Number: <?php echo escape($row["id_number"]); ?>
			    	<br>
			    	Name: <?php echo escape($row["first_name"] . " " . $row["middle_name"] . " " . $row["last_name"]); ?>
			    </h5>
			    <div class="col-md-1">
			    	<button class="btn btn-secondary" type="button" onclick="window.print()" id="printButton">Print</button>
			    </div>
			</div>
			    <div class="row-view">
				  <div class="column-view">
				    <p>
				    	Date of Birth: <?php echo escape($row["birth_date"]); ?>
				    	<br>
				    	Sex: <?php echo escape($row["sex"]); ?>
				    	<br>
				    	Permanent Address: <?php echo escape($row["address_permanent"]); ?>
				    	<br>
				    	Current Address: <?php echo escape($row["address_current"]); ?>
				    </p>
				  </div>
				  <div class="column-view">
				  	<p>
				    	Contact Number: <?php echo escape($row["contact_number"]); ?>
				    	<br>
				    	Email Address: <?php echo escape($row["email_address"]); ?>
				    	<br>
				    	Mother's Maiden Name: <?php echo escape($row["mother_first_name"] . " " . $row["mother_middle_name"] . " " . $row["mother_last_name"]); ?>
				    	<br>
				    	Father's Name: <?php echo escape($row["father_first_name"] . " " . $row["father_middle_name"] . " " . $row["father_last_name"]); ?>
				    </p>

				  </div>
				</div>
				<?php endforeach; ?>  
			</div>

				<h2 class="viewpub">Vaccination Record: </h2>
				<div class="table-responsive table-hover" id="gencon">
					
					<table class="table table-stripped table-responsive" id="myTable">
					  <thead>
					    <tr>
					      <th>Vaccine</th>
					      <th>Dose</th>
					      <th>Date of Vaccination</th>
					      <th>Site Name</th>
					      <th>Serial Code</th>
					      <th>Remarks</th>
					    </tr>
					  </thead>
					  <tbody>
					  <?php foreach ($result2 as $row) : ?>
					    <tr>
					      <td><?php echo escape($row["vaccine_name"]); ?></td>
					      <td><?php echo escape($row["dose"]); ?></td>
					      <td><?php echo escape($row["vaccine_date"]); ?></td>
					      <td><?php echo escape($row["site_name"]); ?></td>
					      <td><?php echo escape($row["serial_code"]); ?></td>
					      <td><?php echo escape($row["remarks"]); ?></td>
					  </tr>
					  <?php endforeach; ?>
					  </tbody>
					</table>
				</div>

				<h2 class="viewpub">Past Immunizations: </h2>
				<div class="table-responsive table-hover" id="gencon">
					
					<table class="table table-stripped table-responsive" id="myTable">
					  <thead>
					    <tr>
					      <th>Vaccine</th>
					      <th>Year</th>
					    </tr>
					  </thead>
					  <tbody>
					  <?php foreach ($result3 as $row) : ?>
					    <tr>
					      <td><?php echo escape($row["past_vacc"]); ?></td>
					      <td><?php echo escape($row["vacc_year"]); ?></td>
					  </tr>
					  <?php endforeach; ?>
					  </tbody>
					</table>
				</div>
        </div>   

    <!-- Script to print the content of a div -->


<?php 
require "../templates/userfooter.php"; 
require "../templates/footer.php";?>

<script type="text/javascript">
	
window.onload = function() {
    document.getElementById("#printButton")
        .addEventListener("click", () => {
            const iframe = this.document.getElementById("#reg-accounts");
            console.log(iframe);
            console.log(window);
            var opt = {
                margin: 0,
                filename: 'myfile.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(iframe).set(opt).save();
        })
}

</script>