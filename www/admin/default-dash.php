<?php
ob_start();
	require "../admin/connection/config.php";
	require "../admin/connection/common.php";
	require "../templates/header.php"; 
	require "../admin/dashboard-admin.php";
	require "../admin/templates/main-header.php"; ?>
<script>
    <?php require("../build/js/alt-dash.js");?>
</script>

<div id="reg-accounts" class="content-box">
		<h2>Dashboard</h2>

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
		                        <strong class='mx-1'>Success!</strong> User successfully deleted.
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

	<div class="row container-fluid">

		<div class="col-12 col-sm-6 col-md-3">
            <div class="card info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-map-marked-alt"></i></span>	
				
								<div class="card-body">
		            <h5><span class="card-title">Vaccination Facilities</span></h5>
		            <span class="info-box-number">
		            <h5 class="badge rounded-pill bg-secondary"><?php 
		                $location = $connection->query("SELECT * FROM vaccination_site")->rowCount();
		                echo number_format($location);
		              ?></h5>
		              <a href="../admin/vacc-site.php"><img class ="img-fluid card-img-top" src="../img/location.png" href="../admin/vacc-site.php" style="margin-left: auto; margin-right: auto; width:200px; height: 200px;display: block;"></a>
		            </span>
		        </div>
		      </div>
		    </div>
		        <div class="col-12 col-sm-6 col-md-3">
            <div class="card info-box">
		        <span class="info-box-icon bg-light elevation-1"><i class="fas fa-prescription-bottle-alt"></i></span>

              <div class="card-body">
                <h5><span class="card-title">Vaccine Listed</span></h5>
                <span class="info-box-number">
		            <h5 class="badge rounded-pill bg-secondary"><?php 
		                $vaccine = $connection->query("SELECT * FROM vaccine")->rowCount();
		                echo number_format($vaccine);
		              ?></h5>
		              <a href="../admin/vacc-name.php"><img class ="img-fluid card-img-top" src="../img/syringe.png" href="../admin/vacc-site.php" style="margin-left: auto; margin-right: auto; width:200px; height: 200px;display: block;"></a>
		            </span>
		        </div>
		      </div>
		    </div>

		    	<div class="col-12 col-sm-6 col-md-3">
            <div class="card info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class=""></i></span>
		        <div class="card-body">
		            <h5><span class="card-title">Listed Individuals</span></h5>
		            <span class="info-box-number">
		            <h5 class="badge rounded-pill bg-secondary"><?php 
		                $individual = $connection->query("SELECT * FROM public_user")->rowCount();
		                echo number_format($individual);
		              ?></h5>
		              <a href="../admin/user-accounts.php"><img class ="img-fluid card-img-top" src="../img/profile.png" href="../admin/vacc-site.php" style="margin-left: auto; margin-right: auto; width:200px; height: 200px;display: block;"></a>
		            </span>
		        </div>
    		</div>
		</div>

		<div class="col-12 col-sm-6 col-md-3">
            <div class="card info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class=""></i></span>
		        <div class="card-body">
		            <h5><span class="card-title">Access Requests</span></h5>
		            <span class="info-box-number">
		            <h5 class="badge rounded-pill bg-secondary"><?php 
		                $individual = $connection->query("SELECT * FROM user_request")->rowCount();
		                echo number_format($individual);
		              ?></h5>
		              <a href="../admin/user-accounts.php"><img class ="img-fluid card-img-top" src="../img/access-icon.png" href="../admin/vacc-site.php" style="margin-left: auto; margin-right: auto; width:200px; height: 200px;display: block;"></a>
		            </span>
		        </div>
    		</div>
		</div>

	</div>

<br>
	<div class="container-fluid">
		<div class="row g-0" style="background-color: lightgray; align-items: center; margin: auto; padding: 7px; border-radius: 4px;">
				<div class="col-md-8"><p style="font-size: 1.3vw; margin: auto; font-weight: bold; padding-left: 5px;" >Vaccination Site</p></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card mt-4">
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="pie_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mt-4 mb-4">
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row g-0" style="background-color: lightgray; align-items: center; margin: auto; padding: 7px; border-radius: 4px;">
				<div class="col-md-8"><p style="font-size: 1.3vw; margin: auto; font-weight: bold; padding-left: 5px;" >Vaccine</p></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card mt-4">
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="vacc_pie_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mt-4 mb-4">
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="vacc_bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>

</div>

<script type="text/javascript">
	
	$(document).ready(function(){

		makechart();

		function makechart()
		{
			$.ajax({
				url:"../user/data/graphdata.php",
				method:"POST",
				data:{action:'fetch'},
				dataType:"JSON",
				success:function(data)
				{
					var site_name = [];
					var total = [];
					var color = [];

					for(var count = 0; count < data.length; count++)
					{
						site_name.push(data[count].site_name);
						total.push(data[count].total);
						color.push(data[count].color);
					}

					var chart_data = {
						labels:site_name,
						datasets:[
							{
								label:'Records',
								backgroundColor:color,
								color:'#fff',
								data:total
							}
						]
					};

					var options = {
						responsive:true,
						scales:{
							yAxes:[{
								ticks:{
									min:0
								}
							}]
						}
					};

					var group_chart1 = $('#pie_chart');

					var graph1 = new Chart(group_chart1, {
						type:"pie",
						data:chart_data
					});



					var group_chart3 = $('#bar_chart');

					var graph3 = new Chart(group_chart3, {
						type:'bar',
						data:chart_data,
						options:options
					});
				}
			})
		}

		makechartvacc();

		function makechartvacc()
		{
			$.ajax({
				url:"../user/data/vaccdata.php",
				method:"POST",
				data:{action:'fetch'},
				dataType:"JSON",
				success:function(data)
				{
					var vaccine_name = [];
					var total = [];
					var color = [];

					for(var count = 0; count < data.length; count++)
					{
						vaccine_name.push(data[count].vaccine_name);
						total.push(data[count].total);
						color.push(data[count].color);
					}

					var chart_data = {
						labels:vaccine_name,
						datasets:[
							{
								label:'Records',
								backgroundColor:color,
								color:'#fff',
								data:total
							}
						]
					};

					var options = {
						responsive:true,
						scales:{
							yAxes:[{
								ticks:{
									min:0
								}
							}]
						}
					};

					var group_chart1 = $('#vacc_pie_chart');

					var graph1 = new Chart(group_chart1, {
						type:"pie",
						data:chart_data
					});



					var group_chart3 = $('#vacc_bar_chart');

					var graph3 = new Chart(group_chart3, {
						type:'bar',
						data:chart_data,
						options:options
					});
				}
			})
		}

	});

</script>

<?php 
require "../admin/templates/main-footer.php";
require "../templates/userfooter.php";
require "../templates/footer.php" ?>
