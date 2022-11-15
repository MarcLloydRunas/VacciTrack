<?php
ob_start();
session_start();
	require "config.php";
	require "./admin/connection/config.php";
	require "./admin/connection/common.php";
    require "./public/public-navbar.php"; 
    require "header.php";
    require "./admin/templates/main-header.php";

$id_number = "";
if(isset($_SESSION['pass_id_number'])){
    //It exists. We can now use it.
    $id_number = $_SESSION['pass_id_number'];
} else{
    echo "<div class='container aligns-items-center justify-content-center' style='width:500px;'>
		        <div class='container alert alert-danger alert-dismissible d-flex p-3  align-items-center fade show aligns-items-center justify-content-center' style='margin:-50px;'>
		              <i class='bi-exclamation-octagon-fill'></i>
		              <strong class='mx-1'>Error!</strong> Your ID number is invalid.
		              <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
		        </div>
		 </div>";
}

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

	$sql3="SELECT * FROM past_imm WHERE id_number = $id_number";

	$statement = $connection->prepare($sql3);
  	$statement->execute();
	$result3 = $statement->fetchAll();

} catch(PDOException $error){
	echo $sql3 . "<br>" . $error->getMessage();
}
?>
    <div id="reg-accounts-public">
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
				    	Mother's Maiden Name: <?php echo escape($row["mother_first_name"] . " " . $row["mother_middle_name"] . " " . $row["mother_last_name"]); ?>
				    	<br>
				    	Father's Name: <?php echo escape($row["father_first_name"] . " " . $row["father_middle_name"] . " " . $row["father_last_name"]); ?>
				    </p>
				  </div>
				  <div class="column-view">
				  	<p>
				    	Contact Number: <?php echo escape($row["contact_number"]); ?>
				    	<br>
				    	Email Address: <?php echo escape($row["email_address"]); ?>
				    	<br>
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

<?php 
require "./admin/templates/main-footer.php";
require "./templates/userfooter.php";
require "./templates/footer.php";?>

<script type="text/javascript">
	
window.onload = function() {
    document.getElementById("#download")
        .addEventListener("click", () => {
            const iframe = this.document.getElementById("#reg-accounts-public");
            console.log(iframe);
            console.log(window);
            var opt = {
                margin: -5,
                filename: 'myfile.pdf',
                image: { type: 'jpg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(iframe).set(opt).save();
        })
}

</script>