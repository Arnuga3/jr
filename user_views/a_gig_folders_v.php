<?php
/*
Author: Arnis Zelcs
Created: 29/04/2016

Graded Unit Project - Web Portfolio for Jamie Rodden

Script: Generates a gig folder view part of the page
*/

	//to make htmlspecialchars() function work
	header('Content-Type: text/plain');
	
	function test_input($data) {
		
		//remove whitespaces at the beginning and end
		$data = trim($data);
		
		//remove slashes
		$data = stripslashes($data);
		
		//convert special characters into HTML entities
		$data = htmlspecialchars($data);
		return $data;
	}
	
	//get a folder name
	$folder = test_input($_GET["folder"]);

	//include an Object Related Mapping class for a database
	include ("../db/db_ORM.php");
	
	//create a new instance
	$db = new dbConnection();
	
	//connect to the database
	$db->connect();

	//get existing folders in db
	$res = $db->select("images", "*", "image_group = 'gig'");
	
	//that block of code get unique names of folders and save them into an indexed array
	$folders = array();
	if ($res->num_rows > 0) {
		while($row = $res->fetch_assoc()) {
			
			//place all folder names into a new array
			$folders[] = $row["image_folder"];
		}
	}
	//save only unique names of folders
	$folder_list = array_unique($folders);
	
	//remove all indexes with NULL value and move all unique values to the beginning of the array
	$folders_indexed = array();
	foreach ($folder_list as $i) {
		if ($i != NULL) {
			$folders_indexed[] = $i;
		}
	}
	$albums = $folders_indexed;
	
	//to rename a folder
	$escapedFolder = $db->escape($folder);
	
	//get all the photos of the selected album
	$result = $db->select("images", "*", "image_folder = '$escapedFolder'");
	
	//close the connection to the database
	$db->close();
	
	$photos = array();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			
			//place all photos into a new array
			$photos[] = $row;
		}
	}
	
	//back button to leave an album and go to a main gallery
	echo "<a class=\"u_act_p backLink\" href=\"#\">back</a>";
	echo "<div class=\"row\">";

	//display all the photos of the selected album
	foreach ($photos as $val) {
		echo "
		<div class=\"col s12 m6 valign-wrapper\">
			<div class=\"z-depth-2 valign-wrapper\">
				<img class=\"materialboxed valign\" width=\"100\" data-caption=\"".$val["image_descr"]."\" src=\"user_views/".$val["image_path"]."\" />
			</div>
			<p>".$val["image_title"]."</p>
		</div>";
	}
	echo "
		<div>
		<p id=\"error\"></p>";
	
?>