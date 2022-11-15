<?php
require 'config.php';

	try
	{
		$query = "
		SELECT site_name, COUNT(site_name) AS Total FROM vaccination_record WHERE (dose = '1st dose' OR dose = 'booster') GROUP BY site_name;
		";

		$result = $pdo->query($query);

		$data = array();

		foreach($result as $row)
		{
			$data[] = array(
				'site_name'		=>	$row["site_name"],
				'total'			=>	$row["Total"],
				'color'			=>	'#' . rand(100000, 999999) . ''
			);
		}

		echo json_encode($data);
	}catch(Exception $ex) {
    echo($ex -> getMessage());
	}


?>