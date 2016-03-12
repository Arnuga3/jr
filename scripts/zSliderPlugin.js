$.fn.slider_z = function() {
	
	/*############### ADD CSS #################*/
	
	//number of images
	var imgAmount = $(this).children().length;
	var screenWidth = $(window).width();
	var screenHeight = $(window).height();
	//width of scrollbar (tested in chrome)
	var scrollBar = 20;
	//define gallery width variable
	var galleryWidth = 0;
	//width of controller
	var controllerHeight = 80;
	var currentOnScreen = 0;
	var afterTap = false;
	var scrollSpeed = 800;
	//var mouseScrollSpeed = 800;
	var imgArr = [];
	
	function Slide(left, width) {
		this.left = left;
		this.width = width;
	}
	
		
	//Set Controller
	$('.sliderControl').css({"position": "absolute", "background-color": "white", "z-index": "10",
	"padding-left": "20px", "width": screenWidth + "px", "height": controllerHeight + "px"});

	//Set the height of gallery to the window height minus controller width
	$(this).children().css({"height": (screenHeight - controllerHeight) + "px", "float": "left"});
	alert(screenHeight);
	alert(screenHeight - controllerHeight);
	
	//read the width of each picture and make up the gallery width
	$(this).children().each(function() {
		var width = $(this).width();
		galleryWidth += width;
	});
	
	//set the gallery container
	$(this).css({"width": galleryWidth + "px"});
	
	//add ids to images and place them in array
	$(this).children().each(function(ind, val) {
		
		var img = $(this).attr('id', img + (ind + 1));
		var leftPosition = $(this).position().left;
		var width = $(this).width();
		
		var imgPath = $(this).attr('src');
		$('.sliderControl').append("<img class='sd23423sdfsd' id='imgControl" + (ind + 1) + "' src='" + imgPath + "' />");

		imgArr.push(new Slide(leftPosition, width));
	});
	
		//set each image to the full width (vertical bar width problem - hidden but take up space)
	if ($("body").height() > $(window).height()) {
        var scrolls = scrollBar * imgAmount;
		galleryWidth += scrolls;
		//set the gallery container
		$(this).css({"width": galleryWidth + "px"});
    }

	
			/*////////////////////////////
			///////    CONTORLS    ///////
			////////////////////////////*/

//Position tracking after touchstart!!!!!!!!!!!!!!!!!!!!!!!!!!!!Use widths of slides to track the endtouch event and slide!!!!!!!!!!!
	/*	var leftOnTouchend = function() {
			var onLeft = $(this).offset().left;
			for (var i=0; i<imgArr.length; i++) {
				if (-onLeft < imgArr[i].left) {
					if (imgArr[i - 1].left != undefined && -onLeft > imgArr[i - 1].left) {
						currentOnScreen = i - 1;
						afterTap = true;
					}
				}
			}
		};
		this.bind("mousewheel", leftOnTouchend);*/
		
			
//Small picture scrolling control
	$(".sd23423sdfsd").on('click touchstart', function() {
		var id = $(this).attr('id');
		var num = parseInt(id.replace( /^\D+/g, ''));
		currentOnScreen = num;
		//center the image
		var widthDiff = screenWidth - imgArr[num - 1].width;
		var correction = widthDiff / 2;
		$('.sliderContainer').animate({scrollLeft: (imgArr[num - 1].left - correction) + "px"}, scrollSpeed);
	});

/*/Mouse scroll
	(function () {
		function scrollHorizontally(e) {
			e = window.event || e;
			var delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));		//Returns-1/1 depening on the way scrolled
			if (delta == -1) {
				
				if (currentOnScreen < imgAmount - 1) {
					currentOnScreen += 1;
				} else {
					currentOnScreen = 0;
					scrollSpeed = 500;
				}
				$('.sliderContainer').animate({scrollLeft: imgArr[currentOnScreen].left + "px"}, mouseScrollSpeed);
				
			} else {
				
				if (currentOnScreen == 0) {
					currentOnScreen = 3;
					scrollSpeed = 500;
				} else {
					if (afterTap) {
						afterTap = false;
					} else {
						currentOnScreen -= 1;
					}
				}
				$('.sliderContainer').animate({scrollLeft: imgArr[currentOnScreen].left + "px"}, mouseScrollSpeed);
				
			}
			e.preventDefault();
		}
		if (window.addEventListener) {
			// IE9, Chrome, Safari, Opera
			window.addEventListener("mousewheel", scrollHorizontally, false);
			// Firefox
			window.addEventListener("DOMMouseScroll", scrollHorizontally, false);
		} else {
			// IE 6/7/8
			window.attachEvent("onmousewheel", scrollHorizontally);
		}
	})();*/

//Rebuild the sliding panel on window resize	
	$(window).resize(function(){
		location.reload();
	});
	
};