$(document).ready(function () {
	//collapse menu button for materialize
	$(".button-collapse").sideNav({
			edge: 'left',
			closeOnClick: true
	});	
	// Initialize collapsible (uncomment the line below if you use the dropdown variation)
	$('.collapsible').collapsible();
	
		
	//set the height of the side menu once, then changed on window resize event (resize() function)
	$('#contField').height($(window).height() - 85 );
	
	//reload the main eventlisteners
	reloadEvents();
});



//////////////////////////////
////RELOAD EVENT LISTENERS////
//////////////////////////////
function reloadEvents() {
	
	
////////////
////MAIN////
////////////

	$('.preload346').hide();
	
	//parallax
	$('.parallax').parallax();
	
	//materialbox
	$('.materialboxed').materialbox();
	
	//modal
	$('.modal-trigger').leanModal();
	$('.modal-trigger-move').leanModal();
	
	//footer modal in CP
	$('.foot_mod').click(function() {
		$('#footer_modal').closeModal();
	});
	
	//characterCounter
	$('input#showrl_title, textarea#showrl_description, textarea#showrl_path').characterCounter();
	
	
//////////////////////	
////DARK BG EFFECT////
//////////////////////
	
	//to make bg darker when mobile menu is open
	$('.fire_dark').click(function() {
		$('#dark').css({'opacity':'0.9', 'z-index':'200'});
		$('#dark').toggle();
		if ($('#dark').css('display') == 'block') {
			disableScroll();
		} else {
			enableScroll();
		}
	});
	
	//remove the darken bg and enable scrolling
	$('.a_act_p, .sb_delete, .sb_upload').click(function() {
		if ($('#dark').css('display') == 'block') {
			enableScroll();
			$('#dark').toggle();
		}
	});
	
	//check/uncheck all checkboxes event
	$('#selectAllBtn').click(function() {
		if ($("input[type='checkbox']").is( ":checked" )) {
			$("input[type='checkbox']").prop({
			  checked: false
			});
		} else {
			$("input[type='checkbox']").prop({
			  checked: true
			});
		}
	});

	
////////////
////MENU////
////////////

	//SHOWREEL
	$('.a_shwrl').click(function() {
		$('#mainContent').load('../control_panel/a_showreel.php', function() {
			reloadEvents();
			//This hardcoding is used to fix unexpected result with the materialize forms loaded using AJAX
			//focus(does the job)
			$('input:first').focus();
			//focus and unfocus
			$('textarea').focus().blur();
			//scroll to the top of the page
			$('body').scrollTop(0);
		});
	});

	//ACTING PHOTOS
	$('.a_act_p').click(function() {
		//load part of the page using ajax (folders with photos and photos without folders)
		$('#mainContent').load('../control_panel/a_act_photos.php', function() {
			//assign event listeners to new loaded elements
			reloadEvents();
			
			//FOLDERS
			$('.folder').click(function() {
				//load the images of selected folder using ajax and assign event listeners to them
				var selectedFolder = $(this);
				var folderName = selectedFolder.find('span').text();
				//escape the string before passing it in url
				var noSpaceName = encodeURIComponent(folderName);
				$('#mainContent').load("../control_panel/a_act_folders.php?folder=" + noSpaceName, function() {
					reloadEvents();
				});
			});
			
			//UPLOAD SCREEN
			photosUploadScr(0);
		});
	});

	
///////////////	
////SUBMENU////
///////////////
	
	//RENAME BTN 
	$('.sb_rename').click(function() {
		var newName = prompt('Enter new name for the album:');
		if (newName != "" && newName != undefined) {
			renameAlbumAJAX(newName, $('.sb_rename_folder').text(), 'sysRenamearnuga3');
		}
	});

}


//LOADS PHOTOS FIRST SCREEN
function photosLoad(typeNr) {
	
	var afterLoadTypeURL = ["../control_panel/a_act_photos.php", "../control_panel/a_gig_photos.php"];
	
	//load part of the page using ajax (folders with photos and photos without folders)
	$('#mainContent').load(afterLoadTypeURL[typeNr], function() {
		reloadEvents();
		photosUploadScr(typeNr);
	});
}

//LOADS PHOTOS IN FOLDER
function photosLoadFolder(typeNr, folderNoSpace) {
	
	var folderTypeURL = ["../control_panel/a_act_folders.php?folder=", "../control_panel/a_gig_folders.php?folder="];
	
	$('#mainContent').load(folderTypeURL[typeNr] + folderNoSpace, function() {
		reloadEvents();
	});
}

//LOADS THE UPLOAD SCREEN
function photosUploadScr(typeNr) {
	
	var uplTypeURL = ["../control_panel/a_files_upload.php", "../control_panel/a_files_upload.php"];
	
	//UPLOAD BTN
	$('.sb_upload').click(function() {
		//load the file upload part of the page using ajax and assign event listeners
		$('#mainContent').load(uplTypeURL[typeNr], function() {
			reloadEvents();
			
			$('#submitFormUpl').click(function() {
				$('.preload346').show();
			});
			
			//0 is acting
			fileUploadSubm(typeNr);
		});
	});
}

//PHOTOS UPLOAD
function fileUploadSubm(typeNr) {
	
	var uplTypeURL = ["../php_tasks/file_upload_act.php", "../php_tasks/file_upload_gig.php"];
	
	//submission of the files to upload, using formData object and jQuery ajax function
	$('#fileUploadForm').on('submit', function(e) {
		//prevent default form submission
		e.preventDefault();
		
		var formData = new FormData();
		
		//add the album name to the formData object(accessed using $_POST in PHP file)
		formData.append('album_name', document.getElementById('file_upl_alb_name').value);
		
		//for each entry, add to formdata to later access via $_FILES["file" + i]
		for (var i = 0, len = document.getElementById('file').files.length; i < len; i++) {
			formData.append("file" + i, document.getElementById('file').files[i]);
		}
		
		//send formdata to server-side
		$.ajax({
			url: uplTypeURL[typeNr], // php file
			type: 'post',
			data: formData,
			dataType: 'html', // return html from php file
			async: true,
			processData: false,  // tell jQuery not to process the data
			contentType: false,   // tell jQuery not to set contentType
			success : function() {
				//on success load the acting pictures part of the page again with new album and/or files
				photosLoad(typeNr);
			},
			error : function(request) {
				console.log(request.responseText);
			}
		});
	});
}


//resize the height of the side menu on big screens dynamically as it is fixed and scroll need to be allowed to access all links
function resize() {
	$('#contField').height($(window).height() - 85 );
}

function checkIfChecked() {
	if ($('input:checked').length > 0) {
		$('#footer_modal').openModal();
		enableScroll();
	} else {
		alert("Please select photo(s) before moving!");
	}
}

function checkIfCheckedDel() {
	if ($('input:checked').length > 0) {
		deletePhotosAJAX($('.bread span').text(), getSelectedPhotos(), 0);
	} else {
		alert("Please select photo(s) you want to delete!");
	}
}



///////////////////////////
/////Disable scrolling/////
///////////////////////////

/*
left: 37, up: 38, right: 39, down: 40
spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
*/

var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;  
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
}
//End of Disable scrolling