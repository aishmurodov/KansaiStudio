<?
	$Module = Form::formChars($Module, 1);
	if (isset($_SESSION) && $Module != $_SESSION['login'] && User::Root(5) && !isset($Param['view'])) {?>
	<script>
		PaginationView("Kansai", "/profile/adminView/user/<?=$Module?>");
	</script>	
	<?exit;}else
		$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `users` WHERE `login` = '$Module'"));
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
							<li class="tab"><a href="#watching">Избранные <?=$row['login']?></a></li>
						</ul>
					</div>
					<div id="aboutUser" class="col s12">
						<p>
							<?
								if ($row['about'])
									echo nl2br($row['about']);
								else 
									echo "Пользователь ничего не написал о себе!";
							?>
							

						</p>
					</div>
					<div id="watching" class="col s12">
						<ul class="collection">
						<?
							if ($row['watching']) {
								$watching = json_decode($row['watching'], true);
								foreach ($watching as $anime) {
									$anime = mb_substr($anime['anime'], 6);
									if (mysqli_num_rows(mysqli_query(Mysql::connect(), "SELECT `id` FROM `anime_post` WHERE `id` = '$anime'")) > 0) {
										$row_playlist = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT `poster`, `translated_title`, `status`, `type` FROM `anime_post` WHERE `id` = '$anime'"));
										?>
										
											<li id="numberOfMyAn<?=$anime?>" class="collection-item avatar waves-effect" style="width: 100%">
												<img onclick="PaginationView('<?=$row_playlist['translated_title']?>', '/anime/view/item/<?=$anime?>');" src="<?=$row_playlist['poster']?>" alt="<?=$row_playlist['translated_title']?>" class="circle">
												<span onclick="PaginationView('<?=$row_playlist['translated_title']?>', '/anime/view/item/<?=$anime?>');" class="title" style="font-weight: 500;
    color: #56524f;cursor: pointer;"><?=$row_playlist['translated_title']?></span>
												<p>
													<b>
														<?php if ($row_playlist['type'] < 2): ?>
															Статус:
														<?php else: ?>
															Тип:
														<?php endif ?>
													</b>
													<a onclick="PaginationSearch('<?=$row_playlist['status']?>', $(this).attr('href'));return false;" href="/search/type/q/<?=$row_playlist['status']?>"><?=$row_playlist['status']?></a>
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

<script>
	$(document).ready(function(){
		$('ul.tabs').tabs();
		$('.materialboxed').materialbox();
	});
</script>
<?php else: ?>
	<script>
		toast("Профиля <?=$Module?> не существует");
		Pagination("Главная", "/main");
	</script>
<?php endif ?>