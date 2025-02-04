<?php
/*
Author: Arnis Zelcs
Created: 13/03/2016

Graded Unit Project - Web Portfolio for Jamie Rodden

Script: SlidingGallery class
*/

	//include a class
	include("CL_Page.php");
	
	//SlidingGallery class, inherit from a main page class
	class SlidingGallery extends Page {
		
		//main method
		public function displayPage() {
			echo "<!DOCTYPE HTML>";
			echo "<html>\n";
			echo "<head>\n";
			$this->displayPageInfo();
			$this->connectCSS();
			echo "</head>\n";
			echo "<body>\n";
			$this->displayLoading();
			$this->displayNavbar();
			$this->displaySlidingGallery();
			$this->connectJS();
			echo "</body>\n";
			echo "</html>";
		}
		
		//connect external files and resources
		public function connectCSS() {
?>
			<!--GOOGLE Fonts-->
			<link href='https://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
			<link href='https://fonts.googleapis.com/css?family=Noto+Sans' rel='stylesheet' type='text/css'>
			<link href='https://fonts.googleapis.com/css?family=Montez' rel='stylesheet' type='text/css'>
			
			<!--Import materialize.css-->
			<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
			<link type="text/css" rel="stylesheet" href="frameworks/materialize-v0.97.5/materialize/css/materialize.min.css"  media="screen,projection"/>
			
			<!--Was here as Materialize suggestion-->
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
			
			<!--Font Awesome Icons, Styles-->
			<link type="text/css" rel="stylesheet" href="frameworks/font-awesome-4.4.0/css/font-awesome.min.css" />
			
			<!--JQ-UI-->
			<link type ="text/css" rel="stylesheet" href="frameworks/jquery-ui-1.11.4/jquery-ui.theme.min.css">

			<!--Css-->
			<link type="text/css" rel="stylesheet" href="css/styles.css" />
<?php
		}
		//add preloader
		public function displayLoading() {
?>
			<div class="preload345">
				<div class="preloader-wrapper active">
					<div class="spinner-layer spinner-red-only">
						<div class="circle-clipper left">
							<div class="circle"></div>
						</div><div class="gap-patch">
							<div class="circle"></div>
						</div><div class="circle-clipper right">
							<div class="circle"></div>
						</div>
					</div>
			  </div>
		  </div>
<?php
		}
		//add sliding gallery
		public function displaySlidingGallery() {
?>
			<div class="sliderContainer">
				<div class="sliderImages">
					<img id="img1" src="img/1.jpg" />
					<img id="img3" src="img/3.jpg" />
					<img id="img5" src="uploaded_photos/6.jpg" />
					<img id="img4" src="img/4.jpg" />
				</div>
				<div class="sliderControl"></div>
			</div>
<?php
		}
		//add scripts and libraries + sliding gallery plugin
		public function connectJS() {
			echo "
			<!--Materialize requires jQuery, so first to include jQuery, than Materialize js file-->
			<script type=\"text/javascript\" src=\"frameworks/jquery-2.1.4.min.js\"></script>
			<script type=\"text/javascript\" src=\"frameworks/materialize-v0.97.5/materialize/js/materialize.min.js\"></script>
			<script src=\"frameworks/jquery-ui-1.11.4/jquery-ui.min.js\"></script>
			<!--Scripts-->
			<script src=\"scripts/zSliderCall.js\"></script>	<!--REQUIRE FOR SLIDING GALLERY-->
			<script src=\"scripts/zSliderPlugin.js\"></script>	<!--REQUIRE FOR SLIDING GALLERY-->
			<script src=\"scripts/zScript.js\"></script>
			";
		}
	}
?>
