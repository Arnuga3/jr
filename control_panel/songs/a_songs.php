<?php
/*
Author: Arnis Zelcs
Created: 2/04/2016

Graded Unit Project - Web Portfolio for Jamie Rodden

Script: Create a content of a main gallery - acting
*/

//start session
session_start();
?>
<?php
if (isset($_SESSION["mrBoss"])) {
	$userID = $_SESSION["mrBoss"]["usr_ID"];
	
	//include an Object Related Mapping class for a database
	include ("../../db/db_ORM.php");
	//Create DB connection and get data from db
	$db = new dbConnection();
	$db->connect();

	$result = $db->select("media, music", "media.*, music.*", "media.usr_ID = $userID AND media.music_ID = music.music_ID");
	$db->close();
	
	//THIS CODE GETS UNIQUE NAMES OF FOLDERS AND SAVES THEM INTO INDEXED ARRAY
	$folders = array();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//Place all folder names into new array
			$folders[] = $row["music_folder"];
		}
	}
	//Save only unique names of folders
	$folder_list = array_unique($folders);
	//Remove all indexes with NULL value and move all unique values to the beginning of the array
	$folders_indexed = array();
	foreach ($folder_list as $i) {
		if ($i != NULL) {
			$folders_indexed[] = $i;
		}
	}
	//END

	echo "<!--SONGS-->
	<!--SUBNAV-->
	
	<nav class=\"bread_path\">
		<div class=\"bread nav-wrapper\">
			<div class=\"col s12\">
				<a href=\"#!\" class=\"breadcrumb\">Songs</a>
				<a href=\"#!\" class=\"breadcrumb\"></a>
			</div>
		</div>
	</nav>
	
	<div class=\"sub_nav hide-on-med-and-down\">
		<a class=\"z-depth-1 waves-effect waves-dark blue-grey lighten-1 disabled\" href=\"#\"><img class=\"pencil\" src=\"../img/cpIcons/arrow_undo.png\" /><span>back</span></a>
		<a class=\"sb_upload z-depth-1 waves-effect waves-dark\" href=\"#\"><img src=\"../img/cpIcons/sound_add.png\" /><span>add song(s)</span></a>
		<a class=\"z-depth-1 waves-effect waves-dark\" href=\"#\" onclick=\"checkIfCheckedEditSongs()\"><img src=\"../img/cpIcons/sound.png\" /><span>edit song(s)</span></a>
		<a class=\"z-depth-1 waves-effect waves-dark\" href=\"#\"  onclick=\"checkIfCheckedDelSongs()\"><img src=\"../img/cpIcons/sound_delete.png\" /><span>delete song(s)</span></a>
		<a class=\"z-depth-1 waves-effect waves-dark .modal-trigger-move\" href=\"#footer_modal\" onclick=\"checkIfChecked()\"><img src=\"../img/cpIcons/slide_sound.png\" /><span>move song(s)</span></a>
	</div>

	<div class=\"fixed-action-btn vertical click-to-toggle hide-on-large-only\" style=\"bottom: 24px; right: 24px;\">
		<a class=\"fire_dark btn-floating btn-large deep-orange darken-2\">
			<img class=\"pencil\" src=\"../img/cpIcons/pencil.png\" />
		</a>
		<ul>
			<li><span>add song(s)</span><a class=\"sb_upload btn-floating blue\"><img src=\"../img/cpIcons/sound_add.png\" /></a></li>
			<li><span>edit song(s)</span><a class=\"btn-floating green\" onclick=\"checkIfCheckedEditSongs()\"><img src=\"../img/cpIcons/sound.png\" /></a></li>
			<li><span>delete song(s)</span><a class=\"btn-floating blue\" onclick=\"checkIfCheckedDelSongs()\"><img src=\"../img/cpIcons/sound_delete.png\" /></a></li>
			<li><span>move song(s)</span><a class=\"btn-floating  .modal-trigger-move red\" href=\"#footer_modal\" onclick=\"checkIfChecked()\"><img src=\"../img/cpIcons/slide_sound.png\" /></a></li>
		</ul>
	</div>
	
	<div class=\"fixed-action-btn vertical click-to-toggle hide-on-large-only\" style=\"bottom: 24px; right: 84px;\">
		<a class=\"btn-floating btn-large yellow disabled\">
			<img class=\"pencil\" src=\"../img/cpIcons/arrow_undo.png\" />
		</a>
	</div>
	
	<div class=\"cp_content\">

		<p class=\"helperText infoMargin\"><img class=\"sm_info\" src=\"../img/cpIcons/information.png\" />Add, Edit or Remove albums or songs.</p>
		
		<div id=\"cpCont\" class=\"margTop margBotXL\">
		<a id=\"selectAllBtn\" class=\"waves-effect waves-light btn-flat blue-grey lighten-2 margLeft10 margBot\">check/uncheck all</a>";

			//Display folders
			foreach ($folders_indexed as $val) {
				echo "<!--Folder Row in Control Panel(image, name)-->
					<a class=\"folder flexVertCenter waves-effect waves-light\" href=\"#\">
						<div class=\"flexVertCenter\">
							<img class=\"margLeft10\" width=\"40\" src=\"../img/cpIcons/folder_image.png\" />
							<span class=\"margLeft infoText\">".$val."</span>
						</div>
					</a>";
			}
			mysqli_data_seek($result, 0);
			//Display photos without folders
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					if (!in_array($row["music_folder"], $folders_indexed)) {
						
					echo '<!--Image Row in Control Panel(checkbox, name, image)-->
						<div class="flexVertCenter imgRow">
							<input type="checkbox" class="filled-in checkbox-orange" id="'.$row["music_ID"].'" />
							<label for="'.$row["music_ID"].'">
								<div class="flexVertCenter">
									<div>
										<span class="infoText truncatedTitle absolute">'.$row["music_title"].'<span class="helperText2">'.$row["music_descr"].'</span></span>
									</div>
								</div>
							</label>
							<audio id="music" controls="controls">
								<source src="audio/'.$row["music_path"].'" type="audio/mpeg" />
								<source src="audio/'.$row["music_path"].'" type="audio/ogg" />
							</audio>
						</div>';
					}
				}
			}
			echo "<p id=\"error\"></p>";
	echo "</div>
	</div>";
	
			//FOOTER MODAL
			echo "<div id=\"footer_modal\" class=\"modal bottom-sheet\">
					<div class=\"modal-content col l8 offset-l2 margBotExtra\">
						<h5>Select a folder you want to move song(s) to:</h5>
						<ul>";
			//Footer modal
			foreach ($folders_indexed as $val) {
				echo "		<li><a class=\"foot_mod\" onclick=\"moveSongsAJAX('".$val."', getSelectedItems())\" href=\"#\">
								<div class=\"flexVertCenter\">
									<img class=\"margLeft10\" width=\"40\" src=\"../img/cpIcons/folder.png\" />
									<span class=\"margLeft infoText\">".$val."</span>
								</div>
							</a></li>";
			}
				echo "		<li><a class=\"foot_mod\" onclick=\"moveToNewAlbumSongs()\" href=\"#\">
								<div class=\"flexVertCenter\">
									<img class=\"margLeft10\" width=\"40\" src=\"../img/cpIcons/folder_add.png\" />
									<span class=\"margLeft infoText\">CREATE NEW ALBUM</span>
								</div>
							</a></li>
							<li><a class=\"foot_mod\" onclick=\"moveSongsAJAX('', getSelectedItems())\" href=\"#\">
								<div class=\"flexVertCenter\">
									<img class=\"margLeft10\" width=\"40\" src=\"../img/cpIcons/folder_go.png\" />
									<span class=\"margLeft infoText\">MAIN GALLERY (without album)</span>
								</div>
							</a></li>";
			echo "		</ul>
					</div>
				</div>";
			//FOOTER MODAL END
	
} else {
	//this is required to avoid a blank page when user is loggin out (session is closed) and press a back button, so user is just transfered to the index page
	header("Location: ../index.php");
}
?>