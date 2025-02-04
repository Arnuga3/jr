<?php
/*
Author: Arnis Zelcs
Created: 2/05/2016

Graded Unit Project - Web Portfolio for Jamie Rodden

Script: Delete a training record
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
		
		//Get values from the Personal Details and Contacts sections
		$name = test_input($_POST["name"]);
		$equity = test_input($_POST["equity"]);
		$email = test_input($_POST["email"]);
		$height = test_input($_POST["height"]);
		$chest = test_input($_POST["chest"]);
		$waist = test_input($_POST["waist"]);
		$inside_leg = test_input($_POST["inside_leg"]);
		$eyes = test_input($_POST["eyes"]);
		$hair = test_input($_POST["hair"]);
		$build = test_input($_POST["build"]);
		$playing_age = test_input($_POST["playing_age"]);
		
		//create an new db object
		$db = new dbConnection();
		//open a db connection
		$db->connect();
		//escape, surround in single quotes and save values into array
		$values = $db->prepareArray($name, $equity, $email, $height, $chest, $waist, $inside_leg, $eyes, $hair, $build, $playing_age);
		//update record
		$db->update("cv", "cv_name, cv_equity, cv_email, cv_height, cv_chest, cv_waist, cv_inside_leg, cv_eyes, cv_hair, cv_build, cv_playing_age", $values, "cv_ID", 1);
		$db->close();
		
		echo "Saved";
	} else {
			
		//Error message is displayed on the page if there is any
		echo "Error";
	}


	
?>