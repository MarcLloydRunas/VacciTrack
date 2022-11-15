<?php
session_start();
require 'config.php';


//$vaccine_name = $_POST['vaccine_name'];
$passed_vaccine_name_sex = $_SESSION['pass_vaccine_name_sex'];
	try
	{	
		$query = "
		SELECT sex, COUNT(sex) AS Total FROM vaccination_record WHERE (vaccine_name = '$passed_vaccine_name_sex' AND sex <> '') AND (dose = '1st dose' OR dose = 'booster') GROUP BY sex;
		";

		$result = $pdo->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'sex'		=>	$row["sex"],
				'total'			=>	$row["Total"],
				'color'			=>	'#' . rand(100000, 999999) . ''
			);
		}

		echo json_encode($data);
	}catch(Exception $ex) {
    echo($ex -> getMessage());
	}


?>