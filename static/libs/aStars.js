function giveMeStars(k) {
	$(".aStars_content").html("");
	for (var i = 1; i <= 10; i++) {
	 	if (k >= i) {
			$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="1" class="aStar votes_anime"><i class="fa fa-star"></i></span>');
		}else if (k < i) {
			if (k > 1 && k < 2) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 2 && k < 3) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 3 && k < 4) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 4 && k < 5) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 5 && k < 6) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 6 && k < 7) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 7 && k < 8) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 8 && k < 9) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else if (k > 9 && k < 10) {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0.5" class="aStar votes_anime"><i class="fa fa-star-half-o"></i></span>');
			}else {
				$(".aStars_content").append('<span data-value="'+i+'" onmouseenter="giveMeStars('+i+')" style="font-size: 1.7em" data-already="0" class="aStar votes_anime"><i class="fa fa-star-o"></i></span>');
			}
			k = 0;
		}
	}
}