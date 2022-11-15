<?php
    session_start();
	include_once('../admin/connection/config.php');

	$conn = new PDO($dsn, $username_db, $password_db, $options);

	$userData = count($_POST["past_vacc"]);
	
	if ($userData > 0) {
	    for ($i=0; $i < $userData; $i++) { 
		if (trim($_POST['past_vacc'] != '') && trim($_POST['vacc_year'] != '')) {
			$first_name = $_POST["first_name"];
			$past_vacc = $_POST["past_vacc"][$i];
			$vacc_year = $_POST["vacc_year"][$i];
			$query = "INSERT INTO past_imm (first_name,past_vacc,vacc_year) VALUES ('$first_name','$past_vacc','$vacc_year')";
			$statement3 = $conn->prepare($query);
    		$statement3->execute();
		}
	    }
	    echo "Data inserted successfully";
	}else{
	    echo "Please Enter user name";
	}

?>