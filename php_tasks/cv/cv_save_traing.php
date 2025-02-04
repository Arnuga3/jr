<?php
/*
Author: Arnis Zelcs
Created: 3/05/2016

Graded Unit Project - Web Portfolio for Jamie Rodden

Script: Save a training record
*/

	//include an Object Related Mapping class for a database
	include ("../../db/db_ORM.php");
		
	//to make work htmlspecialchars() function
	header('Content-Type: text/plain');

	//Test input for special characters, slashes, white spaces
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		//get values
		$trainingID = test_input($_POST["trainingID"]);
		$trainingIDVal = test_input($_POST["trainingIDVal"]);
		
		$db = new dbConnection();
		$db->connect();
		
		$escID = $db->escape($trainingID);
		$escValue = $db->escape($trainingIDVal);
		
		$db->customQuery("UPDATE training SET training = '$escValue' WHERE training_ID = $escID");
		$db->close();
		
		echo "Saved";
		
	} else {
		//Error message is displayed on the page if there is any
		echo "Error";
	}
	
?>