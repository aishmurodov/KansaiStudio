<?
	$Module = Form::formChars(urldecode($Module), 1);
	$words = $Module;

	if ( $words === "" ) exit;
	
	Give_Me_Cards ("search", "SELECT * FROM `anime_post` WHERE (`translated_title` LIKE '%%$words%%' OR `origin_title` LIKE '%%$words%%' OR `studio` LIKE '%%$words%%' OR `cats` LIKE '%%$words%%' OR `description` LIKE '%%$words%%') ORDER BY `view` DESC", $words);