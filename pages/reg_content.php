  <div class="row" style="margin-right: 0;">
  	<div class="col s12" style="background: #fff">
	  	<div class="col s12"><h3>Регистрация</h3></div>
	    <div class="col s12">
	      <div class="row">
	        <div class="input-field col s12 m6">
	        	<i class="material-icons prefix">account_circle</i>
	          <input id="login" type="text" class="validate">
	          <label for="login">Никнейм</label>
	        </div>
	        <div class="input-field col s12 m6">
	        	<i class="material-icons prefix">person</i>
	          <input id="Username" type="text" class="validate">
	          <label for="Username">Имя</label>
	        </div>
	      </div>
	      <div class="row">
	        <div class="input-field col s12 m6">
	        	<i class="material-icons prefix">email</i>
	          <input id="email" type="email" class="validate">
	          <label for="email">Email</label>
	        </div>
	        <div class="input-field col s12 m6">
				<i class="material-icons prefix">lock_outline</i>
				<input id="password" type="password" class="validate">
				<label for="password">Password</label>
	        </div>
	      </div>
	      <div class="row">
			  <div class="input-field col s12 m6">
			  	<i class="material-icons prefix">wc</i>
			    <select id="gender">
			      <option value="0" selected>Не скажу</option>
			      <option value="1">Мужской</option>
			      <option value="2">Женский</option>
			    </select>
			    <label>Пол</label>
			  </div>
			  <div class="input-field col s12 m6">
			  	<i class="material-icons prefix">date_range</i>
				<input id="birthday" type="text" class="datepicker">
				<label for="birthday">Дата рождения</label>
			  </div>
	      </div>
	      <div class="row">
	      	<div class="col s12" style="text-align: center;">
	      		<button id="do-register-user" class="btn waves-effect waves-light">Зарегистрироваться</button>
	      	</div>
	      </div>
      </div>
    </div>
  </div>
 <script>
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
	  	var login = $("#login").val(),
	  	Username = $("#Username").val(),
	  	email = $("#email"),
	  	password = $("#password").val(),
	  	gender = $("#gender").val(),
	  	birthday = $("#birthday").val();

	  	if (login.length > 0 && Username.length > 0 && email.length > 0 && password.length > 0 && gender.length > 0 && birthday.length > 0) {
		  	if (email.hasClass("invalid")) {
		  		toast("Напишите правильный E-mail");
		  	}else {
		  		$.ajax({
		  			url: '/handler/register',
		  			method: "POST",
		  			data: {
						"login": login,
						"Username": Username,
						"email": email.val(),
						"password": password,
						"gender": gender,
						"birthday": birthday
		  			},
		  			success: function (data) {
		  				$("#ajaxDiv").html(data);
		  			}
		  		});
		  	}
		}else {
			toast("Заполните все поля");
		}
	  });
  });
 </script>