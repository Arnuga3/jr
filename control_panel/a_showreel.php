<?php
/*
Author: Arnis Zelcs
Created: 1/04/2016

Graded Unit Project - Web Portfolio for Jamie Rodden

Script: Showreel part - generate an HTML and send back as response
*/

//start session
session_start();
?>
<?php

//if session is on
if (isset($_SESSION["mrBoss"])) {
	$userID = $_SESSION["mrBoss"]["usr_ID"];
	
	include ("../db/db_ORM.php");
	//Create DB connection and get data from db
	$db = new dbConnection();
	$db->connect();
	//Get a showreel video information
	$result = $db->select("media, video", "media.*, video.*", "media.usr_ID = $userID AND media.video_ID = video.video_ID AND video.video_group = 'showreel' LIMIT 1");
	$db->close();
	
	//Only one record is expected, just another check for an error
	if ($result->num_rows == 1) {
		while($row = $result->fetch_assoc()) {
			$data = $row;
		}
		
		//response
		echo "<!--SHOWREEL GROUP-->
			<!--SUBNAV-->
			
			<nav class=\"bread_path\">
				<div class=\"bread nav-wrapper\">
					<div class=\"col s12\">
						<a href=\"#!\" class=\"breadcrumb\">Showreel</a>
						<a href=\"#!\" class=\"breadcrumb\"></a>
					</div>
				</div>
			</nav>
			
			<!-- Showreel SAVE button, LOGIC: Toast is shown on a screen for 2 sec with SAVED message, AJAX is updating a record in DB, page is refreshed to apply changes-->
			<div class=\"sub_nav hide-on-med-and-down\">
				<a class=\"waves-effect waves-dark z-depth-1\" onclick=\"saveShowreelData()\"><img src=\"../img/cpIcons/diskette.png\" /><span>save</span></a>
			</div>
			
			<div class=\"fixed-action-btn hide-on-large-only\" style=\"bottom: 24px; right: 24px;\">
				<a class=\"btn-floating btn-large waves-effect waves-light deep-orange darken-2\" onclick=\"saveShowreelData()\"><img class=\"pencil\" src=\"../img/cpIcons/diskette.png\" /></a>
			</div>
			
			<div class=\"cp_content margBotXL\">
					
				<p class=\"helperText infoMargin\"><img class=\"sm_info\" src=\"../img/cpIcons/information.png\" />Only one video is available here. It will be displayed on a showreel page.</p>
				
				<div class=\"pad10\">
					<p class=\"infoText margTop\">Video preview</p>
					<div class=\"row\">
						<div class=\"col s12 l10\">
							<div class=\"video-container margTop\">
								<iframe width=\"853\" height=\"480\" src=\"".$data["video_path"]."\" frameborder=\"0\" allowfullscreen></iframe>
							</div>
						</div>
					</div>
					
					<p class=\"infoText margTop\">Video information</p>
					
					<form id=\"showreel\">

						<div class=\"input-field\">
							<input id=\"showrl_title\" type=\"text\" name=\"showrl_title\" class=\"validate\" length=\"100\" value=\"".str_replace('"',"&quot;", $data["video_title"])."\"/>
							<label for=\"showrl_title\">video title</label>
						</div>
						<div class=\"input-field\">
							<textarea id=\"showrl_description\" name=\"showrl_description\" class=\"materialize-textarea\" length=\"255\">".$data["video_descr"]."</textarea>
							<label id=\"matr_descrLb\" for=\"showrl_description\">video description</label>
						</div>
						<div class=\"input-field\">
							<textarea id=\"showrl_path\" type=\"text\" name=\"showrl_path\" class=\"materialize-textarea\" length=\"255\">".str_replace('"',"&quot;", $data["video_path"])."</textarea>
							<label id=\"matr_descrLb\" for=\"showrl_path\">video path</label>
						</div>
						
						<div id=\"error\"></div>
					</form>
				</div>
			</div>";
		
	} else {
		echo "Error: one record is expected";
	}
} else {
	//this is required to avoid a blank page when user is loggin out (session is closed) and press a back button, so user is just transfered to the index page
	header("Location: ../index.php");
}
?>