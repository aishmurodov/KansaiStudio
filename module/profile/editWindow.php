<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta charset="UTF-8">
	<title><?=$_SESSION['name'].'('.$_SESSION['login'].')';?></title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css"  media="screen,projection"/>
</head>
<body>
  <div class="row" style="margin-right: 0;">
  	<div class="col s12" style="background: #fff">
	  	<div class="col s12"><h3>Редактирование</h3></div>
	    <div class="col s12">
	      <div class="row">
	        <div class="input-field col s12 m12">
	        	<i class="material-icons prefix">person</i>
	          <input id="Username" type="text" value="<?=$_SESSION['name']?>" class="validate">
	          <label for="Username">Имя</label>
	        </div>
	        <div class="input-field col s12 m12">
	        	<i class="material-icons prefix">email</i>
	          <input id="email" type="email" value="<?=$_SESSION['email']?>" class="validate">
	          <label for="email">Email</label>
	        </div>
	      </div>
		<?php if ($_SESSION['network'] == "Kansai"): ?>
			  <hr>
		      <div class="row">
		        <div class="input-field col s12 m12">
					<i class="material-icons prefix">lock_outline</i>
					<input id="old_password" type="password" class="validate">
					<label for="old_password">Старый пароль</label>
		        </div>
		        <div class="input-field col s12 m12">
					<i class="material-icons prefix">lock_outline</i>
					<input id="new_password" type="password" class="validate">
					<label for="new_password">Новый пароль</label>
		        </div>
		      </div>
		      <hr>
		<?php endif ?>
	      <div class="row">
			  <div class="input-field col s12 m12">
			  	<i class="material-icons prefix">wc</i>
			    <select id="gender">
					<option value="0" <?if ($_SESSION['gender'] == '0') echo "selected";?>>Не скажу</option>
					<option value="1" <?if ($_SESSION['gender'] == '1') echo "selected";?>>Мужской</option>
					<option value="2" <?if ($_SESSION['gender'] == '2') echo "selected";?>>Женский</option>
			    </select>
			    <label>Пол</label>
			  </div>
			  <div class="input-field col s12 m12">
			  	<i class="material-icons prefix">date_range</i>
				<input id="birthday" type="text" class="datepicker" value="<?=$_SESSION['birthday']?>">
				<label for="birthday">Дата рождения</label>
			  </div>
	      </div>
	      <div class="row">
	      	<div class="col s12" style="text-align: center;">
	      		<button id="do-register-user" class="btn waves-effect waves-light">Отредактировать</button>
	      	</div>
	      </div>
      </div>
    </div>
  </div>
  <div id="ajaxDiv"></div>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
	<script>
	    function toast (text) {
	      Materialize.toast(text, 3000);
	    }
		$(document).ready(function() {
			Materialize.updateTextFields();
			$('select').material_select();
			  $('.datepicker').pickadate({
			    selectMonths: true, 
			    selectYears: 100, 
			    today: "",
			    clear: 'Очистить',
			    close: 'Ок',
			    closeOnSelect: true 
			  });

			  $("#do-register-user").on("click", function () {
			  	var Username = $("#Username").val(),
			  	email = $("#email"),
			  	<?php if ($_SESSION['network'] == "Kansai"): ?>
			  	old_password = $("#old_password").val(),
			  	new_password = $("#new_password").val(),
			  	<?php endif?>
			  	gender = $("#gender").val(),
			  	birthday = $("#birthday").val();
			  	if (email.hasClass("invalid")) {
			  		toast("Напишите правильный E-mail");
			  	}else {
			  		$.ajax({
			  			url: '/profile/handle/editMyProfileFromNewWindow/1',
			  			method: "POST",
			  			data: {
							"Username": Username,
							"email": email.val(),
							<?php if ($_SESSION['network'] == "Kansai"): ?>
							"old_password": old_password,
							"new_password": new_password,
							<?php endif?>
							"gender": gender,
							"birthday": birthday
			  			},
			  			success: function (data) {
			  				$("#ajaxDiv").html(data);
			  			}
			  		});
			  	}
			  });
		});
	</script>
</body>
</html>