<div class="row">
	<div class="col s12 m4" style="text-align: center;">
		<div class="row">
			<div class="col s12" id="Main-AVATAR">
				<?php if ($_SESSION['avatar'] != ''): ?>
					<img src="<?=$_SESSION['avatar']?>"  class="materialboxed responsive-img hoverable main_content_cardss z-depth-3" width="650">
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
								<li><span style="width: 100%" id="edit_response" class="waves waves-effect waves-light">Изменить данные</span></li>
								<li><span style="width: 100%" data-target="AvaterModal" class="modal-trigger waves waves-effect waves-light">Изменить аватар</span></li>
								<li><span style="width: 100%" class="waves waves-effect waves-light" onclick="PaginationView('<?=$_SESSION['name'].'('.$_SESSION['login'].')';?>', '/profile/<?=$_SESSION['login']?>')">Посмотреть со стороны</span></li>
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
						<h4>Профиль <?=$_SESSION['login']?></h4>
						<h6><b>Имя: </b><span id="UserName"><?=$_SESSION['name']?></span> </h6>
						<?php if ($_SESSION['gender'] > 0): ?>
							<h6>
								<b>Пол: </b>
								<?php if ($_SESSION['gender'] == 1): ?>
									Мужской
								<?php else: ?>
									Женский
								<?php endif ?>
							</h6>
						<?php endif ?>
						<h6><b>Дата рождения: </b><?=$_SESSION['birthday']?></h6>
						<h6>
							<b>Группа: </b>
							<?

									if ($_SESSION['user_group'] == 0) {
										echo "Участник";
									}else if ($_SESSION['user_group'] == 1) {
										echo "Уважаемый анимешник";
									}else if ($_SESSION['user_group'] == 2) {
										echo "Модератор";
									}else if ($_SESSION['user_group'] == 3) {
										echo "Редактор";
									}else if ($_SESSION['user_group'] == 4) {
										echo "Админ";
									}

							?>
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
							<li class="tab"><a href="#watching">Мои избранные</a></li>
						</ul>
					</div>
					<div id="aboutUser" class="col s12">
						<div class="row">
							<div class="input-field col s12">
								<textarea id="aboutMySelf" class="materialize-textarea"><?=$_SESSION['about']?></textarea>
								<label for="aboutMySelf" class="<?if ($_SESSION['about']) echo 'active';?>">Расскажите немного о себе</label>
							</div>
							<div class="input-field col s12" style="text-align: right;">
								<button id="do-change-about" class="btn waves waves-effect waves-light">Сохранить</button>
							</div>
						</div>
					</div>
					<div id="watching" class="col s12">
						<ul class="collection">
						<?
							if ($_SESSION['watching']) {
								$watching = json_decode($_SESSION['watching'], true);
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
												<a data-my-value="<?=$anime?>" data-my-owner="numberOfMyAn<?=$anime?>" class="secondary-content do-delete-from-my-playlist"><i class="fa fa-times" aria-hidden="true"></i></a>
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
	<form id="FormOfAvatar" action="/profile/handle/ChangeAvatar/1" method="post" enctype="multipart/form-data">
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

		$(".do-delete-from-my-playlist").on("click", function () {
			var v = $(this).attr("data-my-value");
			var owner =  $(this).attr("data-my-owner");
			if (confirm("Вы уверены, что хотите удалить это аниме из вашего плейлиста?")) {
				$.ajax({
					url: "/profile/handle/deleteThis/1",
					method: "POST",
					cache: false,
					data: {"v":v},
					success: function() {
						$("#" + owner).remove();
						toast("Данное аниме удалено из ваших избранных");
					}
				});
			}
		});

		$("#edit_response").click(function() {
			var WindowEdit = window.open('/profile/editWindow', 'Редактирование', 'width=600,height=400');

			WindowEdit.onblur = function() {
				WindowEdit.close();
				PaginationView("kansai", "/profile");
			}
		});

	    $(".EditThisPLS").on("click", function () {
	    	if ($("#myFloatBTN-edit").attr("data-already-editing") == 1) {
	    		$(this).attr("contenteditable", "true");
	    		$("#AnimeTrTitleBtn").show();
	    		$(this).focus();
	    	}
	    });

	    $(".EditThisPLS").on("blur", function () {
	    	if ($("#myFloatBTN-edit").attr("data-already-editing") == 1) {
	    		$(this).attr("contenteditable", "false");
	    	}
	    });

		$("#myFloatBTN-edit").on("click", function () {
		    	if ($(this).attr("data-already-editing") == 0) {
		    		$(".editmyprofile").show();
		    		$(this).attr("data-already-editing", 1);
		    		toast ("Вы вошли в режим редактирования. Нажмите на тот элемент, который хотите радктировать");
		    	}else {
		    		$(".editmyprofile").hide();
		    		$(this).attr("data-already-editing", 0);
		    		toast ("Вы вышли из режима редактирования.");
		    	}
		    });

	    $("#do-change-avatar").click(function(){
	      $("#FormOfAvatar").ajaxForm({
	      	target: "#Main-AVATAR"
	      }).submit();
	    });
	    $("#do-change-about").on("click", function(){
	    	var text = $("#aboutMySelf").val();
	    	$.ajax({
	    		url: "/profile/handle/ChangeAbout/1",
	    		method: "POST",
	    		cache: false,
	    		data: {
	    			"text": text
	    		},
	    		success: function (){
	    			toast("Изменено");
	    		}
	    	});
	    });
	});
</script>