<?php
ob_start();
	//session_start();
	require "../config.php";
	require "../templates/header.php"; 
	require "../user/dashboard-user.php";

	$sql= "SELECT vaccine_name FROM vaccine";

	try {
	    $stmt=$pdo->prepare($sql);
	    $stmt->execute();
	    $results=$stmt->fetchAll();
	}catch(Exception $ex) {
	    echo($ex -> getMessage());
	}
	$vaccine_name = '';

	if (isset($_POST['vaccine_name_sex'])) {
	    $vaccine_name_sex = $_POST['vaccine_name_sex'];
	    $vaccine_name_age = $_POST['vaccine_name_age'] ?? '';
	    $_SESSION['pass_vaccine_name_sex'] = $vaccine_name_sex;
	}

	if (isset($_POST['vaccine_name_age'])) {
	    $_SESSION['pass_vaccine_name_age'] = '';
	    $vaccine_name_age = $_POST['vaccine_name_age'];
	    $vaccine_name_sex = $_POST['vaccine_name_sex'] ?? '';
	    $_SESSION['pass_vaccine_name_age'] = $vaccine_name_age;
	}

	//$vaccine_name_age = $request->old('vaccine_name_age');

	require "../admin/templates/main-header.php";
?>

<div id="reg-accounts" class="content-box stats">

	<h2 class="stathead">Statistics</h2>

<div class="table-responsive table-hover" id="gencon">

		<div class="container-fluid">
			<div class="row g-0" style="background-color: lightgray; align-items: center; margin: auto; padding: 7px; border-radius: 4px;">
				<div class="col-md-8"><p style="font-size: 1.3vw; margin: auto; font-weight: bold; padding-left: 5px;" >Age</p></div>
				<div class="col-md-1"><p style="font-size: 1.1vw; margin: 0;" >Vaccine:</p></div>
				<div class="col-md-3">
					<form name="change_vacc_age" id="change_vacc_age" method="POST" action="">
				          <div class="col-5">
					          <select id="vaccine_name_age" name="vaccine_name_age" class="form-control-sm" onchange="this.form.submit()" >
					          <option>

					          	<?php 

					          	if (!isset($_SESSION['pass_vaccine_name_age'])) {
									echo 'choose';
								} else {
									echo $_SESSION['pass_vaccine_name_age'];
								}

					          	?>
					          		
					          </option>
					          <?php foreach($results as $output) {?>
					          <option><?php echo $output["vaccine_name"];?></option> 
					          <?php }?>
					          </select>
					     </div>
		            </form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card mt-4">	
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="age_pie_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mt-4 mb-4">
						
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="age_bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid">
			<div class="row g-0" style="background-color: lightgray; align-items: center; margin: auto; padding: 7px; border-radius: 4px;">
				<div class="col-md-8"><p style="font-size: 1.3vw; margin: auto; font-weight: bold; padding-left: 5px;" >Sex</p></div>
				<div class="col-md-1"><p style="font-size: 1.1vw; margin: 0;" >Vaccine:</p></div>
				<div class="col-md-3">
					<form name="change_vacc_sex" id="change_vacc_sex" method="POST" action="">
			            	<div class="col-5">
				               <select id="vaccine_name_sex" name="vaccine_name_sex" class="form-control-sm" value="<?php echo $vaccine_name_sex; ?>" onchange="this.form.submit()" >
				               <option>
				               	<?php 

					          	if (!isset($_SESSION['pass_vaccine_name_sex'])) {
									echo 'choose';
								} else {
									echo $_SESSION['pass_vaccine_name_sex'];
								}

					          	?>
				               </option>
				               <?php foreach($results as $output) {?>
				               <option><?php echo $output["vaccine_name"];?></option>
				               <?php }?>
				               </select>
				        	</div>
	               	</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card mt-4">
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="sex_pie_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mt-4 mb-4">
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="sex_bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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
	</div>

</div>

<?php 
require "../templates/userfooter.php";
require "../templates/footer.php";?>

<script type="text/javascript">
	
	$(document).ready(function(){

	makeagechart();

	function makeagechart()
	{
		$.ajax({
			url:"../user/data/agedata.php",
			method:"POST",
			data:{action:'fetch'},
			dataType:"JSON",
			success:function(data)
			{
				var age = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					age.push(data[count].age);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:age,
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

				var group_chart1 = $('#age_pie_chart');

				var graph1 = new Chart(group_chart1, {
					type:"pie",
					data:chart_data
				});



				var group_chart3 = $('#age_bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		})
	}

	makesexchart();

	function makesexchart()
	{
		$.ajax({
			url:"../user/data/sexdata.php",
			method:"POST",
			data:{action:'fetch'},
			dataType:"JSON",
			success:function(data)
			{
				var sex = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					sex.push(data[count].sex);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:sex,
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

				var group_chart1 = $('#sex_pie_chart');

				var graph1 = new Chart(group_chart1, {
					type:"pie",
					data:chart_data
				});



				var group_chart3 = $('#sex_bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		})
	}

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