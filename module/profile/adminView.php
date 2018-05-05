<?
	$user = Form::formChars($Param['user'], 1);
	if ($user == $_SESSION['login']) {?>
	<script>
		Pagination("Kansai", "/profile");
	</script>	
	<?exit;
	}

	$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `users` WHERE `login` = '$user'"));
	$uid = $row['id'];
?>
<?php if ($row): ?>
<div class="row">
	<div class="col s12 m4" style="text-align: center;">
		<div class="row">
			<div class="col s12" id="Main-AVATAR">
				<?php if ($row['avatar'] != ''): ?>
					<img src="<?=$row['avatar']?>"  class="materialboxed responsive-img hoverable main_content_cardss z-depth-3" width="650">
				<?php else: ?>
					<img src="/static/images/havenotavatar.jpg"  class="materialboxed responsive-img hoverable main_content_cardss z-depth-3" width="650">
				<?php endif ?>
			</div>
			<div class="col s12">
				<div>
					<article style="cursor: pointer;">
						<div style="margin-top: 20px;">
							<button style="width: 100%"  class='dropdown-button btn' data-activates='optionsforUsers'>Опции</button>
							<ul id='optionsforUsers' class='dropdown-content'>
								<li><span style="width: 100%" data-target="AvaterModal" class="modal-trigger waves waves-effect waves-light">Изменить аватар</span></li>
								<li><span style="width: 100%" class="waves waves-effect waves-light" onclick="PaginationView('<?=$row['name'].'('.$row['login'].')';?>', '/profile/<?=$row['login']?>/view/1')">Посмотреть со стороны</span></li>
							</ul>	
						
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
	<div class="col s12 m8">
		<article style="background-color: #fff">
			<div style="padding: 5px;">
				<div class="row">
					<div class="col s12">
						<h4>Профиль <?=$row['login']?></h4>
						<h6><b>Имя: </b><span id="UserName"><?=$row['name']?></span> </h6>
						<?php if ($row['gender'] > 0): ?>
							<h6>
								<b>Пол: </b>
								<?php if ($row['gender'] == 1): ?>
									Мужской
								<?php else: ?>
									Женский
								<?php endif ?>
							</h6>
						<?php endif ?>
						<h6><b>Дата рождения: </b><?=$row['birthday']?></h6>
						<h6>
							<b>Группа: </b>
							<div class="dropdown-button" id="userGroups" stopPropagation="true" data-activates='userGroupsUl' style="display: inline-block;">
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
							</div>
							<ul id='userGroupsUl' class='dropdown-content'>
								<li><a class="choose-userGroup" data-group="0">Участник</a></li>
								<li><a class="choose-userGroup" data-group="1">Уважаемый анимешник</a></li>
								<li><a class="choose-userGroup" data-group="2">Модератор</a></li>
								<li><a class="choose-userGroup" data-group="3">Редактор</a></li>
								<li><a class="choose-userGroup" data-group="4">Админ</a></li>
							</ul>
						</h6>
					</div>
				</div>
			</div>
		</article>
		<article style="background-color: #fff">
			<div style="padding: 5px;">
				<div class="row">
					<div class="col s12">
						<ul class="tabs">
							<li class="tab"><a class="active" href="#aboutUser">О себе</a></li>
							<li class="tab"><a href="#watching">Мои избранные (<?=$row['login']?>)</a></li>
						</ul>
					</div>
					<div id="aboutUser" class="col s12">
						<div class="row">
							<div class="input-field col s12">
								<textarea id="aboutMySelf" class="materialize-textarea"><?=$row['about']?></textarea>
								<label for="aboutMySelf" class="<?if ($row['about']) echo 'active';?>">Расскажите немного о себе</label>
							</div>
							<div class="input-field col s12" style="text-align: right;">
								<button id="do-change-about" class="btn waves waves-effect waves-light">Сохранить</button>
							</div>
						</div>
					</div>
					<div id="watching" class="col s12">
						<ul class="collection">
						<?
							if ($row['watching']) {
								$watching = json_decode($row['watching'], true);
								foreach ($watching as $anime) {
									$anime = mb_substr($anime['anime'], 6);
									if (mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `anime_post` WHERE `id` = '$anime'")) > 0) {
										$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT `poster`, `translated_title`, `status`, `type` FROM `anime_post` WHERE `id` = '$anime'"));
										?>
										
											<li id="numberOfMyAn<?=$anime?>" class="collection-item avatar waves-effect" style="width: 100%">
												<img onclick="PaginationView('<?=$row['translated_title']?>', '/anime/view/item/<?=$anime?>');" src="<?=$row['poster']?>" alt="<?=$row['translated_title']?>" class="circle">
												<span onclick="PaginationView('<?=$row['translated_title']?>', '/anime/view/item/<?=$anime?>');" class="title" style="font-weight: 500;
    color: #56524f;cursor: pointer;"><?=$row['translated_title']?></span>
												<p>
													<b>
														<?php if ($row['type'] < 2): ?>
															Статус:
														<?php else: ?>
															Тип:
														<?php endif ?>
													</b>
													<a onclick="PaginationSearch('<?=$row['status']?>', $(this).attr('href'));return false;" href="/search/type/q/<?=$row['status']?>"><?=$row['status']?></a>
												</p>
											</li>
										
										<?
									}

							?>
							<?}
						}else {
							echo "<li class=\"collection-item\"><span class=\"title\">Плейлист пуст</span></li>";
						}

						?>
						</ul>
					</div>
				</div>
			</div>
		</article>
	</div>
</div>

<!-- <div id="myFloatBTN" class="fixed-action-btn vertical click-to-toggle">
	<button style="background-color: #515f71" id="myFloatBTN-edit" data-already-editing="0" class="btn-floating btn-large hoverable">
		<i class="material-icons">create</i>
	</button>
</div> -->

<div id="AvaterModal" class="modal">
	<form id="FormOfAvatar" action="/profile/handle/ChangeAvatarAdmin/1" method="post" enctype="multipart/form-data">
		<div class="modal-content">
			<h4>Изменить аватар</h4>
			<p>
				<div class="row">
					<div class="col s12">
					  <div class="file-field input-field">
					    <div class="btn">
					      <span>Аватар</span>
					      <input type="file" name="image" id="uploadAvatar-input">
					    </div>
					    <div class="file-path-wrapper">
					      <input class="file-path validate" type="text">
					    </div>
					  </div>
					</div>
				</div>
			</p>
		</div>
		<div class="modal-footer">
			<a id="do-change-avatar" class="modal-action modal-close waves-effect waves-green btn-flat">Сохранить</a>
		</div>
		<input type="hidden" name="uid" value="<?=$uid?>">
	</form>
</div>
<script>
	$(document).ready(function(){
		$('ul.tabs').tabs();
		$('.modal').modal();
		$('.materialboxed').materialbox();
		$('.dropdown-button').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrainWidth: true,
			hover: false, 
			gutter: 0, 
			belowOrigin: false, 
			alignment: 'left', 
			stopPropagation: false 
		});

	    $("#do-change-avatar").click(function(){
	      $("#FormOfAvatar").ajaxForm({
	      	target: "#Main-AVATAR"
	      }).submit();
	    });
	    $("#do-change-about").on("click", function(){
	    	var text = $("#aboutMySelf").val();
	    	$.ajax({
	    		url: "/profile/handle/ChangeAboutAdmin/1",
	    		method: "POST",
	    		cache: false,
	    		data: {
	    			"text": text,
	    			"uid": '<?=$uid?>'
	    		},
	    		success: function (){
	    			toast("Изменено");
	    		},
	    		error: function () {
	    			toast("Ошибка");
	    		}
	    	});
	    });
	    $(".choose-userGroup").on("click", function () {
	    	var gr = $(this).attr("data-group");
	    	$.ajax({
	    		url: "/admin/handle/changeUserGroup/1",
	    		method: "POST",
	    		cache: false,
	    		data: {
	    			uid: '<?=$uid?>',
	    			gr: gr
	    		},
	    		success: function (data) {
	    			$("#userGroups").html(data);
	    			toast("Изменено");
	    		},
	    		error: function () {
	    			toast("Ошибка");
	    		}
	    	});
	    });
	});
</script>
<?php else: ?>
	<script>
		toast("Профиля <?=$Module?> не существует");
		Pagination("Главная", "/main");
	</script>
<?php endif ?>