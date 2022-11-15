<?php

//data.php
session_start();

$connect = new PDO("mysql:host=localhost;dbname=cvts_db", "root", "");

//$vaccine_name = $_POST['vaccine_name'];
$passed_vaccine_name_age = $_SESSION['pass_vaccine_name_age'];

	try
	{
		
		$query = "
		SELECT current_age, COUNT(current_age) AS Total FROM vaccination_record WHERE (vaccine_name = '$passed_vaccine_name_age') AND (dose = '1st dose' OR dose = 'booster') AND (current_age <> '') GROUP BY current_age ORDER BY current_age DESC LIMIT 5
		";

		$result = $connect->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'age'		=>	$row["current_age"],
				'total'		=>	$row["Total"],
				'color'		=>	'#' . rand(100000, 999999) . ''
			);
		}

		echo json_encode($data);
	}catch(Exception $ex) {
    echo($ex -> getMessage());
	}


?>
