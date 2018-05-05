  <div class="row">
    <div class="col s12">
	  <ul id="tabs-swipe-demo" class="tabs">
	    <li class="tab col s4"><a class="active" href="#addNewAnime">Добавить аниме</a></li>
	    <li class="tab col s4"><a href="#cats">Жанры</a></li>
	    <?php if (User::Root(5)): ?>
	    	<li class="tab col s4"><a href="#users">Пользователи</a></li>
		<?php endif?>
	  </ul>
	  <div id="addNewAnime" style="margin-top: 20px;padding: 20px;" class="col s12 white">
        <div class="row">
	        <form class="col s12" action="/admin/handle/addNewAnime/1" method="post" enctype="multipart/form-data" id="addNewAnimeForm">
				<div class="row">
					<div class="col 12 m4">
						<img class="materialboxed responsive-img" id="poster-preview" src="">
					</div>
					<div class="col s12 m8">
					  <div class="file-field input-field">
					    <div class="btn">
					      <span>Постер</span>
					      <input type="file" name="image" id="uploadAvatar-input">
					    </div>
					    <div class="file-path-wrapper">
					      <input class="file-path validate" type="text">
					    </div>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 m4">
						<input id="tr_title" name="tr_title" type="text" class="validate">
						<label for="tr_title">Название на русском</label>
					</div>
					<div class="input-field col s12 m4">
						<input id="original_title" name="original_title" type="text" class="validate">
						<label for="original_title">Оригинальное название</label>
					</div>
					<div class="input-field col s12 m4">
						<input id="maxseries" name="maxseries" type="text" class="validate">
						<label for="maxseries">Максимум серий</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12 m4">
						<input id="yearOfCreated" name="yearOfCreated" type="text" class="validate">
						<label for="yearOfCreated">Год выпуска</label>
					</div>
					<div class="input-field col s12 m4">
						<input id="studio" type="text" name="studio" class="validate">
						<label for="studio">Студия</label>
					</div>
					<div class="input-field col s12 m4">
						<input id="director" type="text" name="director" class="validate">
						<label for="director">Режиссёр</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<ul class="collapsible" data-collapsible="accordion">
							<li>
							  <div class="collapsible-header"><i class="material-icons">filter_drama</i>Тип</div>
							  <div class="collapsible-body">
								<div class="row">
									<div class="col s12">
									  <div class="input-field col s12">
									    <select name="type">
											<option value="1">Аниме-сериал</option>
											<option value="2">Ова</option>
											<option value="3">Фильм</option>
											<option value="4">Анонс</option>
									    </select>
									  </div>
									</div>
							  </div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
						<ul class="collapsible" data-collapsible="accordion">
							<li>
							  <div class="collapsible-header"><i class="material-icons">filter_drama</i>Жанры</div>
							  <div class="collapsible-body">
								<div class="row" id="selectCategoriesForAnime">
								    <?
								    	$query = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_cats` ORDER BY `title` ASC");
								    	while ($row = mysqli_fetch_assoc($query)) {?>
									      <div id="catContainerOf<?=$row['title']?>" class="col s12 m6">
									      	<input type="checkbox" name="cats[<?=$row['title']?>]" id="<?=$row['title']?>" />
									      	<label for="<?=$row['title']?>" class="ttle"><?=$row['title']?></label>
									      </div>
								    	<?}
								    ?>
								</div>
							  </div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
					  <div class="row">
					    <div class="input-field col s12">
					      <textarea id="descriptions" name="descriptions" class="materialize-textarea"></textarea>
					      <label for="descriptions">Описание аниме</label>
					    </div>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col s12">
					  <div class="row" style="text-align: center;">
						<span id="do-add-new-anime" class="btn waves-effect waves-light">Добавить аниме</span>
					  </div>
					</div>
				</div>
	        </form>
		</div>
	  </div>
	  <div id="cats" style="margin-top: 20px;padding: 20px;" class="col s12 white">
		  <div id="categories" class="chips chips-placeholder"></div>
	  </div>
	  <?php if (User::Root(5)): ?>
	  <div id="users" style="margin-top: 20px;padding: 20px;" class="col s12 white">
	  	<ul class="collection">
	  		<span id="usersAppend">
<?
			$qUsers = mysqli_query(Mysql::connect(), "SELECT `id`, `login`, `user_group`, `avatar`, `name` FROM `users` WHERE `id` <> '$_SESSION[id]' ORDER BY `name` LIMIT 10");
			while ($row = mysqli_fetch_assoc($qUsers)){
			?>
			
				<li id="numberOfMyAn<?=$value?>" class="collection-item avatar waves-effect" style="width: 100%">
					<?php if ($row['avatar']): ?>
					<img onclick="PaginationView('<?=$row['name']."(".$row['login'].")";?>', '/profile/<?=$row['login']?>');" src="<?=$row['avatar']?>" alt="KANSAI" class="circle">
					<?php else:?>
						<img onclick="PaginationView('<?=$row['name']."(".$row['login'].")";?>', '/profile/<?=$row['login']?>');" src="/static/images/havenotavatar.jpg" alt="KANSAI" class="circle">
					<?php endif ?>
					<span onclick="PaginationView('<?=$row['login']?>', '/profile/<?=$row['login']?>');" class="title" style="font-weight: 500;
color: #56524f;cursor: pointer;"><?=$row['name'].'('.$row['login'].')'?></span>
					<p>
						<b>
							Группа:
						</b>	
						<?

								if ($row['user_group'] == 0) {
									echo "Участник";
								}else if ($row['user_group'] == 1) {
									echo "Уважаемый анимешник";
								}else if ($row['user_group'] == 2) {
									echo "Модератор";
								}else if ($row['user_group'] == 3) {
									echo "Редактор";
								}else if ($row['user_group'] == 4) {
									echo "Админ";
								}

						?>
					</p>
				</li>
			
			<?}echo "</span>";
		    if ( mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `users` WHERE `id` <> '$_SESSION[id]' ORDER BY `id` LIMIT 10, 10")) > 0 ){?>
		      <div id="loaderBtnContainer" class="col s12" style="margin-top: .5rem;">
		        <div id="LoaderOrUsers" onclick="LoaderOrUsers ($(this).attr('id'),$(this).attr('data-number'), $(this).attr('data-item'))" data-item="<?=$item?>" data-number="10" class="btn waves-effect waves-block" style="background: #fff; color: #2fb9f8">Загрузить ещё</div>
		      </div>
		    <?}

?>
	  	</ul>
	  </div>
	  <?endif?>
    </div>
  </div>
</div>

  <div id="animepostajaxmessage"></div>

<script>
	$(document).ready(function(){
		$('ul.tabs').tabs();
		$('.chips').material_chip();
		$('.collapsible').collapsible();
		$('select').material_select();
		$('.materialboxed').materialbox();

	    function handleFileSelect(evt) {
	        var file = evt.target.files;
	        var f = file[0];
	        if (!f.type.match('image.*')) {
	            toast("Выберите изображение");
	        }
	        else {
	          var reader = new FileReader();
	          reader.onload = (function(theFile) {
	              return function(e) {
	                $("#poster-preview").attr("src", e.target.result);
	              };
	          })(f);
	          reader.readAsDataURL(f);
	      }
	    }

	    $("#uploadAvatar-input").change(function(e){handleFileSelect(e)});

		$('.chips-placeholder').material_chip({
			placeholder: 'Напишите жанр',
			secondaryPlaceholder: '+Жанр',
		    data: [
		    <?
		    	$query = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_cats` ORDER BY `title` ASC");
		    	while ($row = mysqli_fetch_assoc($query)) {?>
				    {
				      tag: '<?=$row['title']?>',
				    },
		    	<?}
		    ?>
		    ],
		    minLength: 3,
		});

		$('#categories').on('chip.add', function(e, chip){
			$(this).hide();
			var title = chip.tag,
				chipc = this;
			$.ajax({
				url: "/admin/handle/addNewCat/1",
				method: "POST",
				cache: false,
				data: {catTitle: title},
				success: function(data) {
					if (data != "break") {
						$("#selectCategoriesForAnime").append('<div id="catContainerOf' + title + '" class="col s12 m6"><input type="checkbox" name="cats[' + title + ']" id="' + title + '" /><label for="' + title + '" class="ttle">' + title + '</label></div>');
					}
					$(chipc).show();
					$("#cats input").focus(); 
					if (data == "break") {
						toast("Такой жанр уже существует");
					}
				}
			});
		});

		$('#categories').on('chip.delete', function(e, chip){
			$(this).hide();
			var title = chip.tag,
				chipc = this;
			$.ajax({
				url: "/admin/handle/removeCat/1",
				method: "POST",
				cache: false,
				data: {catTitle: title},
				success: function() {
					$('#catContainerOf' + title + '').remove();
					toast('Жанр "' + title + '" удалён');
					$(chipc).show();
					$("#cats input").focus(); 
				}
			});
		});

	    $("#do-add-new-anime").click(function(){
	      $("#addNewAnimeForm").ajaxForm({
	      	target: "#animepostajaxmessage"
	      }).submit();
	    });
	});

    function LoaderOrUsers ( ID,number ) {
        var number = Number (number);
        $.ajax({
            url: '/admin/handle/loadUsers/1',
            method: 'POST',
            data: {"startFrom" : number},
            beforeSend: function() {
              $( "#" + ID).hide();
            }}).done(function(data){
              if ( data == "error" ) {
                $( "#" + ID).hide();
              }else {
                  $("#usersAppend").append(data);
                number += 10;
                number = String (number);
                $( "#" + ID).attr('data-number',number);
                $( "#" + ID).show();
              }
            });
    }
</script>