<?php

	include ("../../db/db_ORM.php");
		
	//to make work htmlspecialchars() function
	header('Content-Type: text/plain');

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$filmID = test_input($_POST["filmID"]);
		
		$db = new dbConnection();
		$db->connect();	

		$db->delete("films", "film_tv_ID", $filmID);
		$db->delete("experience", "film_tv_ID", $filmID);
		$db->delete("ai_films", "ai_ID", $filmID);

		$db->close();
		
		echo "Deleted";
		
	} else {
		//Error message is displayed on the page if there is any
		echo "";
	}
?>