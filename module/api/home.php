<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>API</title>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
  	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  	<style>
  		html, body, .valign-wrapper {
  			width: 100%;
  			height: 100%;
  			background: linear-gradient(-45deg,#7956ec,#2fb9f8);
  			background-attachment: fixed;
  			background-size: cover;
  			background-position: center center;
  			color: #fff;
  		}

		::-webkit-scrollbar-button {
		background-repeat:no-repeat;
		width:100%;
		height: 5px;
		}

		::-webkit-scrollbar-track {
		background-color: inherit;
		}

		::-webkit-scrollbar-thumb {
		-webkit-border-radius: 5px;
		border-radius: 5px;
		background: linear-gradient(-45deg,#7956ec,#2fb9f8);
		background-size: cover;
		background-position: center center;
		transition: all.25s;
		}

		::-webkit-scrollbar-thumb:active{

		}

		::-webkit-resizer{
		background-image:url('');
		background-repeat:no-repeat;
		width:4px;
		height: 5px;
		}

		::-webkit-scrollbar{
		width: 4px;
		height: 5px;
		transition: all.25s;
		}

  		.content {
  			background-color: #fff;
  			border-radius: 5px;
  			color: #333;
  		}
  	</style>
</head>
<body>
	<div class="valign-wrapper">
		<div class="container">
			<div class="row">
				<div class="col s12 m12 content">
					<ul>
						<li>There is api of Kansai Studio.</li>
						<li>Сhoose any item from the presented menu: </li>
						<ol>1. <a href="/api/getposts/count/5">Getposts</a> with count you need</ol>
						<ol>2. <a href="/api/getitem/item/1">Getitem</a> with item you need</ol>
						<ol>3. <a href="/api/getseries/count/5">Getseries</a> with count you need</ol>
						<ol>4. <a href="/api/getitemseries/item/1">Getitemseries</a> with item you need</ol>
						<li><small>You can change the parameters by changing the number in the address bar</small></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<?
	// exit("You need to write the required parameter")