<?php 
	session_start();
  require "config.php";
  require "header.php";
	require "./admin/connection/config.php";
	require "./admin/connection/common.php";
  require "./public/public-navbar.php";
	require "./admin/templates/main-header.php";

try {
  $connection = new PDO($dsn, $username_db, $password_db, $options);

  $sql = "SELECT * FROM vaccine_schedule";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

try {
    $connection = new PDO($dsn, $username_db, $password_db, $options);

    $sql2 = "DELETE FROM vaccine_schedule
        WHERE end_date < DATE_ADD(NOW(),INTERVAL - 5 MINUTE)";

    $statement2 = $connection->prepare($sql2);
    $statement2->execute();

  } catch(PDOException $error) {
    echo $sql2 . "<br>" . $error->getMessage();
  }
?>

<div id="reg-accounts-public" class="content-box">
	<h2>Schedules for Vaccination</h2>
	<div class="table-responsive table-hover" id="pubsched">
		<table class="table table-stripped table-responsive" id="tablelogs">
		  <thead>
		    <tr>
		      <th>Vaccine</th>
		      <th>Dose</th>
		      <th>Target</th>
		      <th>Start</th>
		      <th>End</th>
		      <th>Designated Site</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach ($result as $row) : ?>
		  	<?php 
		  	$rawdate = ($row["start_date"]); 
		  	$finaldate = date("F j, Y, g:i a",strtotime($rawdate));
		  	?>
		    <tr>
		      <td><?php echo escape($row["vaccine_name"]); ?></td>    
		      <td><?php echo escape($row["dose"]); ?></td>
		      <td><?php echo escape($row["target"]); ?></td>
		      <td><?php echo escape($finaldate); ?></td>
		      <td><?php echo date("F j, Y, g:i a",strtotime($row["end_date"])); ?></td>
		      <td><?php echo escape($row["site_name"]); ?></td>
		    </tr>
		  <?php endforeach; ?>
		  </tbody>
		</table>	
	</div>
</div>

<?php 
require "./admin/templates/main-footer.php";
echo '<br><br><br><br><br><br><br>';
require "./templates/publicfooter.php";
require "./templates/footer.php" ?>