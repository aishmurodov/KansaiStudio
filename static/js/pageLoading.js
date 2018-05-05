function PageLoading(event) {

	if (event == "off") {
		// var
		// 	images = document.images,
		// 	images_total = images.length,
		// 	images_loaded = 0,
		// 	perc = document.getElementById('preloaderPercent');

		// for (var i = 0; i < images_total; i++) {
		// 	images_clone = new Image();
		// 	images_clone.onload = img_loaded;
		// 	images_clone.onerror = img_loaded;
		// 	images_clone.src = images[i].src;
		// }

		// function img_loaded() {
		// 	images_loaded++;
		// 	perc.innerHTML = (((100 / images_total)*images_loaded)<<0) + '%';
		// 	if (images_loaded>=images_total) {
		// 		setTimeout (function () {
		// 	        $("#Preloader-wrapper").hide();
		// 	        $("#wrapper").fadeIn();
		// 	        $("#Preloader-wall > .left").css("width","0%");;
		// 	        $("#Preloader-wall > .right").css("width","0%");;

		// 	        setTimeout (function () {
		// 	        	$("#Preloader-wall").addClass("zi");
		// 	        }, 1000);
		// 	        perc.innerHTML='0%';
		//         }, 500);
		// 	}
		// }

		// if (images_total == 0) {
		// 	perc.innerHTML = '100%';
		// 	if (images_loaded>=images_total) {
		// 		setTimeout (function () {
		// 	        $("#Preloader-wrapper").hide();
		// 	        $("#wrapper").fadeIn();
		// 	        $("#Preloader-wall > .left").css("width","0%");;
		// 	        $("#Preloader-wall > .right").css("width","0%");;

		// 	        setTimeout (function () {
		// 	        	$("#Preloader-wall").addClass("zi");
		// 	        }, 1000);
		// 	        perc.innerHTML='0%';
		//         }, 500);
		// 	}
		// }
	}

	else if (event == "on") {
		// $("#Preloader-wall").removeClass("zi");
  //       $("#Preloader-wall > .left").css("width","");
  //       $("#Preloader-wall > .right").css("width","");
	 //    //$("#Preloader-wrapper").show();
	 //    $("#wrapper").hide();
	}
	
}