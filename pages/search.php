<?
	
	$query = urldecode(Form::formChars($Param['q'], 1));

	$Module = Form::formChars($Module, 1);

	$Module = ($Module == "type") ? $Module = "status" : $Module;
	
	Give_Me_Cards ("search", "SELECT * FROM `anime_post` WHERE `$Module` LIKE '%%$query%%' ORDER BY `view` DESC", $query);