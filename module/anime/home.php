<?
	$item = Form::formChars($Param['item'], 1);

	$row = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT * FROM `anime_post` WHERE `id` = '$item'"));
	$query = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_series` WHERE `anime_post` = $item ORDER BY `number`");
	$Row_series = mysqli_num_rows($query);
?>
<div id="AnimeViewContainer" class="row">
	<div class="col s12 m4" style="position: relative;">
		<div class="row" id="left-sticky-block">
			<div class="col s12" id="posterIMG">
				<img id="AnimePosterNo" class="materialboxed responsive-img hoverable main_content_cardss z-depth-3" width="650" src="<?=$row['poster']?>">
				<?php if (User::Root(4)): ?>
				<img id="AnimePosterCange" data-target="AnimePosterModal" class="modal-trigger responsive-img hoverable" style="display: none;" width="650" src="<?=$row['poster']?>">
				<?php endif ?>
			</div>
		</div>
	</div>
	<div id="left-side-article" class="col s12 m8 z-depth-2 hoverable" style="background: #fff">
		<div>
			<article style="background: #fff">
				<div style="padding: 5px;">
					<h4><span id="AnimeTrTitle" class="AnimeEditThisPls"><?=$row['translated_title']?></span>  <span id="AnimeTrTitleBtn" style="display: none;" class="animeEditBtnnn btn waves-effect">Сохранить</span>
					<?php if ($row['type'] < 3): ?>
						[<?
							$srs_count =  mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT `number` FROM `anime_series` WHERE `anime_post` = '$item' ORDER BY `number` DESC"));
							$srs_count = $srs_count['number'];
							if (!$srs_count) $srs_count = 0;
							if ($row['maxseries'] >= 1 && $srs_count > $row['maxseries']) $srs_count = $row['maxseries'];
							echo "$srs_count";
							?> из <span id="MaxSeriesText" class="AnimeEditThisPls"><?if ($row['maxseries'] >= 1) {echo $row['maxseries'];}else echo "XXX";?></span><span id="MaxSeriesTextBtn" style="display: none;" class="animeEditBtnnn btn waves-effect">Ок</span>]
					<?php endif ?>
					</h4>
					<p><span id="AnimeOriginTitle" class="AnimeEditThisPls"><?=$row['origin_title']?></span>  <span id="AnimeOriginTitleBtn" style="display: none;" class="animeEditBtnnn btn waves-effect">Сохранить</span></p>
				</div>
			</article>
			<article style="background: #fff">
				<div style="padding: 5px;">
					<?php if ($row['type'] != 4): ?>
						<div>
							<div id="votes-conteiner">
							<div id="votes">
							    <div class="ARating-container">
							      <div data-total-value="<?=$row['votes']?>" class="ARatingBackGround"></div>
							      <div class="ARatingStar"></div>
							    </div>
							</div>
								<div class="bottom_line top" data-total-value="<?=$row['votes']?>0"></div>
								<div class="bottom_line bottom" data-total-value="<?=$row['votes']?>0"></div>
						</div>
					<?php endif ?>
					<div>
						<b>
						<?php if ($row['type'] < 2): ?>
							Статус:
						<?php else: ?>
							Тип:
						<?php endif ?>
						</b> 
						<div class="chip" id="AnimeStatusnon" style="background: #2fb9f8; color: #fff">
							<a onclick="if ($('#data-admin-edit').attr('data-already-editing') == 0) {PaginationSearch('KANSAI', $(this).attr('href'));}return false;" href="/search/type/q/<?=urlencode($row['status'])?>" style="color: #fff"><?=$row['status']?></a>
						</div>
						<?php if (User::Root(4)): ?>
						<div class="chip dropdown-button" id="AnimeStatus" stopPropagation="true" data-activates='AnimeStatusUl' style="display: none;background: #2fb9f8; color: #fff">
							<?=$row['status']?>
						</div>
							<ul id='AnimeStatusUl' class='dropdown-content'>
								<li><a class="choose-anime_status" data-status="Онгоинг">Онгоинг</a></li>
								<li><a class="choose-anime_status" data-status="Завершен">Завершен</a></li>
								<li><a class="choose-anime_status" data-status="Фильм">Фильм</a></li>
								<li><a class="choose-anime_status" data-status="Ова">Ова</a></li>
								<li><a class="choose-anime_status" data-status="Анонс">Анонс</a></li>
							</ul>
						<?php endif ?>
					</div>
					<div>
						<b>Год выпуска: </b> <a onclick="if ($('#data-admin-edit').attr('data-already-editing') == 0) {PaginationSearch('Год выпуска', $(this).attr('href'));}return false;" href="/search/year/q/<?=urlencode($row['year'])?>"><span id="AnimeYear" class="AnimeEditThisPls"><?=$row['year']?></span></a> <span id="AnimeYearBtn" style="display: none;background: #2fb9f8;color: #fff" class="animeEditBtnnn waves-effect">Сохранить</span>
					</div>
					
					<div <?php if (!$row['studio']): ?> class="animeEditBtnnn" style="display: none" <?php endif?>>
						<b>Студия: </b> <a onclick="if ($('#data-admin-edit').attr('data-already-editing') == 0) {PaginationSearch('Студия', $(this).attr('href'));}return false;" href="/search/studio/q/<?=urlencode($row['studio'])?>"><span id="AnimeStudio" class="AnimeEditThisPls"><? if ( $row['studio'] ) echo $row['studio']; else echo 'Не указано'; ?></span></a> <span id="AnimeStudioBtn" style="display: none;background: #2fb9f8;color: #fff" class="animeEditBtnnn waves-effect">Сохранить</span>
					</div>
					<div <?php if (!$row['director']): ?> class="animeEditBtnnn" style="display: none" <?php endif?>>
						<b>Режиссёр: </b> 
						
						<?
							if (!User::Root(4)) {
								$directors = explode(",", $row['director']);

								if (count($directors) > 1) {
									$i = 1;
									foreach ($directors as $key => $value) {
										$value = trim($value);

										$valuehref = explode(" ", $value);

										$iv = 1;
										foreach ($valuehref as $key => $val) {
											if ($iv != 1) {
												$valuehref .= "+$val";
											}else {
												$valuehref = "$val";
											}
										$iv++;}
										?>
										<a onclick="PaginationSearch('Режисёр', $(this).attr('href'));return false;" href="/search/director/q/<?=urlencode($valuehref)?>">
										<?
											if ($i != 1) {
												echo ", $value";
											}else
												echo "$value";
										?>
										</a> 
									<?$i++;}
								}else {?>
								<a onclick="PaginationSearch('Режисёр', $(this).attr('href'));return false;" href="/search/director/q/<?=urlencode($row['director'])?>"><div id="AnimeDirector" class="AnimeEditThisPls ttle" style="display: inline-block;"><? if ( $row['director'] ) echo $row['director']; else echo 'Не указано'; ?></div></a> 
								<?}
							}else {?>
								<a onclick="if ($('#data-admin-edit').attr('data-already-editing') == 0) {PaginationSearch('Режисёр', $(this).attr('href'));}return false;" href="/search/director/q/<?=urlencode($row['director'])?>"><div id="AnimeDirector" class="AnimeEditThisPls ttle" style="display: inline-block;"><? if ( $row['director'] ) echo $row['director']; else echo 'Не указано'; ?></div></a> 
								<span id="AnimeDirectorBtn" style="display: none;background: #2fb9f8;color: #fff" class="animeEditBtnnn waves-effect">Сохранить</span>
							<?}

						?>
					</div>
					<div data-target="AnimeCatsModal" id="AnimeCatsTrigger" class="">
						<b>Жанры: </b> 
                    <span id="allCats"><?
                      $cats = explode(' |-| ', $row['cats']);
                      foreach ($cats as $key => $value) {?>
						<a onclick="if ($('#data-admin-edit').attr('data-already-editing') == 0) {PaginationSearch($(this).text(), $(this).attr('href'));}return false;" href="/search/cats/q/<?=urlencode($value)?>"><div class="chip hoverable"><?=$value?></div></a>
                      <?}
                      ?></span>
					</div>
					<div>
						<p><b>Описание: </b></p>
						<p id="AnimeDescription" class="AnimeEditThisPls"><?=nl2br($row['description'])?></p>
						<p><span id="AnimeDescriptionBtn" style="display: none;background: #2fb9f8;color: #fff" class="animeEditBtnnn btn waves-effect">Сохранить</span></p>
					</div>
					<?php if (User::Root(4)): ?>
					<div style="text-align: right;">
						<span id="delete-all-post" class="btn waves-effect">Удалить тайтл</span>
					</div>
					<?php endif ?>
				</div>
			</article>
			</div>
		</div>
		<div class="row">
			<div class="col s12">
			<?php if ($Row_series && $row['type'] != 4): ?>
			<article style="background: #fff" class="z-depth-2 hoverable">
				<div style="margin-top: 20px;">
					<div class="row">
						<div class="col s12">
					      <div class="video-container" id="video-container">
							<video poster="<?=$row['poster']?>" controls preload="metadata" src=""></video>
					      </div>
					      <div class="video-container" id="frame-container">
					      	<iframe src="" frameborder="0" allowfullscreen></iframe>
					      </div>
					      <div>
							<?php if ($row['type'] == 1 || $row['type'] == 2): ?>
						      	<div style="font-size: 16px;font-weight: 500">
									<div class="valign-wrapper z-depth-2 " data-position="bottom" data-delay="50" data-tooltip="Кол-во просмотров видео" style="padding: 5px;background-color: #2fb9f8;color: #fff;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
										Просмотров: <span id="count_view" style="margin-left: 5px;"></span>
									</div>
						      	</div>
								<?php endif ?>
					      </div>
						</div>
						<div <?if ($row['type'] <= 2) echo "style=\"margin-top: 20px;margin-bottom:20px;\"" ?> <?if ($row['type'] <= 2) echo "class=\"col s12 m8\"";?> <?if ($row['type'] > 2) echo "style=\"display:none\"";?>>
							<div class="row" style="margin: 0">
							  <div class="input-field col">
							    <select id="series">
							    <?
							    if (isset($_SESSION['id']))
						    		$userPlayList = json_decode($_SESSION['watching'], true);
							    while ($Row_seriesa = mysqli_fetch_assoc($query)) {?>
							      <option data-now="<?=$Row_seriesa['id']?>" 
									<?

										if (isset($_SESSION['id'])) {
											foreach ($userPlayList as $anime_watch) {
												if ($anime_watch['anime'] == "anime_$item") {
													if ( $anime_watch['last_serie'] == $Row_seriesa['number'] )
														echo "selected";
													break;
												} 
											}
										}

									?>
							       value="<?=$Row_seriesa['url']?>" data-frame="<?=$row['frame']?>"><?=$Row_seriesa['number']?> серия</option>
							   	<?}?>
							    </select>
							  </div>
						<?php //if ($row['tr_480p'] || $row['tr_720p'] || $row['tr_1080p']): ?>
								<div class="input-field col" style="text-align: center;"></div>
								<div class="input-field col" style="text-align: center;">
									<?php if ($row['tr_480p']): ?>
										<a style="display: inline-block;" class="torrentDownloadBTN" href="<?=$row['tr_480p']?>" download="[KANSAI]<?=$row['origin_title']. "_Torrent_480p.torrent"?>" target="_blank">
											<i class="fa fa-download" aria-hidden="true" target="_blank"></i>&nbsp;480p
										</a>
									<?php endif ?>
									<?php if ($row['tr_720p']): ?>
										<a style="display: inline-block;" class="torrentDownloadBTN" href="<?=$row['tr_720p']?>" download="[KANSAI]<?=$row['origin_title']. "_Torrent_720p.torrent"?>" target="_blank">
											<i class="fa fa-download" aria-hidden="true" target="_blank"></i>&nbsp;720p
										</a>
									<?php endif ?>
									<?php if ($row['tr_1080p']): ?>
										<a style="display: inline-block;" class="torrentDownloadBTN" href="<?=$row['tr_1080p']?>" download="[KANSAI]<?=$row['origin_title']. "_Torrent_1080p.torrent"?>" target="_blank">
											<i class="fa fa-download" aria-hidden="true" target="_blank"></i>&nbsp;1080p
										</a>
									<?php endif ?>
								</div>
						<?php //endif ?>
							</div>
						</div>
						<?php if (isset($_SESSION['id'])): ?>
							<div style="margin-top:	 20px;margin-bottom:20px;" <?if ($row['type'] > 2 && !$row['tr_480p'] && !$row['tr_720p']) echo "class=\"col s12\"";else echo "class=\"col s12 m4\"";?>>
								<div class="input-field col s12" style="text-align: right;">
									<button class="btn waves waves-light truncate" onclick="UserList(1, <?=$item?>);">В избранные</button>
								</div>
							</div>
						<?php endif ?>
					</div>
				</div>
			</article>
			<?php endif ?>
			<?php if (User::Root(4)): ?>
				<article style="background: #fff">
					<div style="margin-top: 20px;">
						<ul class="collapsible" data-collapsible="accordion">
							<li>
								<div class="collapsible-header"><i class="material-icons">add</i>Добавить серию</div>
								<div class="collapsible-body">
								  <ul class="collapsible" data-collapsible="accordion">
								    <li>
								      <div class="collapsible-header"><i class="material-icons">add</i>Добавить с прямой ссылкой</div>
								      <div class="collapsible-body">
										<div class="row">
											<ul class="collapsible" data-collapsible="accordion">
												<li>
													<div class="collapsible-header"><i class="fa fa-question" aria-hidden="true"></i>Как?</div>
													<div class="collapsible-body">
														<p>1. Зарегистрируйтесь на <a href="https://firebase.google.com/" target="_blank">firebase.google.com</a></p>
														<p>2. Зарегистрируйте там проект с названием Kansai</p>
														<p>3. На <a href="https://console.firebase.google.com/" target="_blank">
															console.firebase.google.com
														</a> выберите свой проект</p>
														<p>4. Откроектся консоль: пролистайте вниз и найдите пункт с названием <b>Storage</b> и нажмите "Начать"</p>
														<p>5. Откроется страница - перейдите на вкладку <b>"Правила"</b> и замените код на следующий: <p><pre>
			service firebase.storage {
			  match /b/{bucket}/o {
			    match /{allPaths=**} {
			      allow read, write
			    }
			  }
			}
			</pre></p> - нажмите опубликовать</p>
														<p>6. Вернитесь на вкладку <b>"Файлы"</b>, за тем нажмите <b>"Загрузить файл"</b> и выберите в открившимся окне видео</p>
														<p>7. После загрузки видео появится в списке. Нужно нажать на него, после чего откроется справа меню.</p>
														<p>8. Выберите пункт <b>"Расположение файла"</b> и скопируйте <b>Url</b>, он находтися ниже подпункта "Расположение в хранилище"</p>
														<p>9. Вернитесь на сайт: напишите номер серии и вставьте скопированную ссылку</p>
													</div>
												</li>
											</ul>
											<div class="input-field col s12">
												<input id="numberOfSerie" type="number" value="<?=$Row_series + 1?>" class="validate">
												<label for="numberOfSerie" class="active">Номер серии</label>
											</div>
											<div class="input-field col s12">
												<input id="urlForSerie" type="text" class="validate">
												<label for="urlForSerie">Ссылка на видео</label>
											</div>
											<div class="input-field col s12">
												<button id="do-add-new-serie" data-id="<?=$item?>" class="btn waves-effect waves-light"><i class="material-icons">add</i></button>
											</div>
										</div>
								      </div>
								    </li>
								    <li>
								      <div class="collapsible-header"><i class="material-icons">add</i>Добавить с ссылки на фрейм</div>
								      <div class="collapsible-body">
										<div class="row">
											<div class="input-field col s12">
												<input id="numberOfSerieIframe" type="number" value="<?=$Row_series + 1?>" class="validate">
												<label for="numberOfSerieIframe" class="active">Номер серии</label>
											</div>
											<div class="input-field col s12">
												<input id="urlForSerieIframe" type="text" class="validate">
												<label for="urlForSerieIframe">Ссылка ссылка на фрейм</label>
											</div>
											<div class="input-field col s12">
												<button id="do-add-new-serie-from-frame" data-id="<?=$item?>" class="btn waves-effect waves-light"><i class="material-icons">add</i></button>
											</div>
										</div>
								    </li>
								  </ul>
								</div>
							</li>
						</ul>
					</div>
				</article>
				<?php if ($Row_series): ?>
				<article style="background: #fff">
					<div style="margin-top: 20px;">
					  <ul class="collapsible" data-collapsible="accordion">
					    <li>
					      <div class="collapsible-header"><i class="material-icons">remove_circle</i>Удалить серию</div>
					      <div class="collapsible-body">
							<div class="row">
								<div class="col s12">
								  <div class="input-field col s12">
								    <select id="delseries">
								    <?
								    $query = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_series` WHERE `anime_post` = $item ORDER BY `number`");
								    while ($Row_seriesa = mysqli_fetch_assoc($query)) {?>
								      <option value="<?=$Row_seriesa['id']?>"><?=$Row_seriesa['number']?> серия</option>
								   	<?}?>
								    </select>
								  </div>
								</div>
								<div class="col s12">
									<button id="do-remove-serie" data-id="<?=$item?>" class="btn waves-effect waves-light"><i class="material-icons">remove_circle</i></button>
								</div>
							</div>
					      </div>
					    </li>
					  </ul>
					</div>
				</article>
				<?php endif ?>
				<article style="background: #fff">
					<div style="margin-top: 20px;">
					  <ul class="collapsible" data-collapsible="accordion">
					    <li>
					      <div class="collapsible-header"><i class="material-icons">add</i>Добавить/обновить торрент</div>
					      <div class="collapsible-body">
							<div class="row">
								<div class="col s12">
								  <ul class="collapsible" data-collapsible="accordion">
								    <li>
								      <div class="collapsible-header">480p</div>
								      <div class="collapsible-body">
										<div class="row">
											<div class="col s12">
											  <form action="/admin/handle/doSomeWorkWithTorrent/1/px/480" method="post" enctype="multipart/form-data" id="Form-torrent-480p">
											    <div class="file-field input-field col s12">
											      <div class="btn">
											        <span>480p</span>
											        <input type="file" name="torrent480">
											      </div>
											      <div class="file-path-wrapper">
											        <input class="file-path validate" type="text">
											      </div>
											    </div>
												<input type="hidden" name="item" value="<?=$item?>">
												<div class="input-field col s12">
													<button type="submit" class="btn waves-effect waves-light"><i class="material-icons">add</i></button>
												</div>
											  </form>
											</div>
										</div>
								      </div>
								    </li>
								    <li>
								      <div class="collapsible-header">720p</div>
								      <div class="collapsible-body">
										<div class="row">
											<div class="col s12">
											  <form action="/admin/handle/doSomeWorkWithTorrent/1/px/720" method="post" enctype="multipart/form-data" id="Form-torrent-720p">
											    <div class="file-field input-field col s12">
											      <div class="btn">
											        <span>720p</span>
											        <input type="file" name="torrent720">
											      </div>
											      <div class="file-path-wrapper">
											        <input class="file-path validate" type="text">
											      </div>
											    </div>
												<input type="hidden" name="item" value="<?=$item?>">
												<div class="input-field col s12">
													<button type="submit" class="btn waves-effect waves-light"><i class="material-icons">add</i></button>
												</div>
											  </form>
											</div>
										</div>
								      </div>
								    </li>
								    <li>
								      <div class="collapsible-header">1080p</div>
								      <div class="collapsible-body">
										<div class="row">
											<div class="col s12">
											  <form action="/admin/handle/doSomeWorkWithTorrent/1/px/1080" method="post" enctype="multipart/form-data" id="Form-torrent-720p">
											    <div class="file-field input-field col s12">
											      <div class="btn">
											        <span>1080p</span>
											        <input type="file" name="torrent1080">
											      </div>
											      <div class="file-path-wrapper">
											        <input class="file-path validate" type="text">
											      </div>
											    </div>
												<input type="hidden" name="item" value="<?=$item?>">
												<div class="input-field col s12">
													<button type="submit" class="btn waves-effect waves-light"><i class="material-icons">add</i></button>
												</div>
											  </form>
											</div>
										</div>
								      </div>
								    </li>
								  </ul>
								</div>
							</div>
					      </div>
					    </li>
					  </ul>
					</div>
				</article>
				<?php if ($row['tr_720p'] || $row['tr_480p']): ?>
				<article style="background: #fff">
					<div style="margin-top: 20px;">
					  <ul class="collapsible" data-collapsible="accordion">
					    <li>
					      <div class="collapsible-header"><i class="material-icons">remove_circle</i>Удалить торрент</div>
					      <div class="collapsible-body">
							<div class="row">
								<div class="col s12">
								  <div class="input-field col s12">
								    <select id="deleteTorrent">
										<?php if ($row['tr_480p']): ?>
											<option value="tr_480p">480p</option>
										<?php endif ?>
								    	<?php if ($row['tr_720p']): ?>
								    		<option value="tr_720p">720p</option>
								    	<?php endif ?>
								    	<?php if ($row['tr_1080p']): ?>
								    		<option value="tr_1080p">1080p</option>
								    	<?php endif ?>
								    </select>
								  </div>
								</div>
								<div class="col s12">
									<button id="do-remove-torrent" data-id="<?=$item?>" class="btn waves-effect waves-light"><i class="material-icons">remove_circle</i></button>
								</div>
							</div>
					      </div>
					    </li>
					  </ul>
					</div>
				</article>
				<?php endif ?>
			<?php endif ?>
			<?php if (isset($_SESSION['id'])): ?>
			<article style="background: #fff;padding: 0 5%;" class="z-depth-2 hoverable">
				<div style="margin-top: 20px;">
				  <div class="row">
				    <div class="col s12">
				      <div class="row" style="margin-bottom: 0">
				        <div class="input-field col s12">
				          <textarea id="textOfComment" class="materialize-textarea"></textarea>
				          <label for="textOfComment">Напишите комментарий</label>
				        </div>
				      </div>
				      <div class="row">
				        <div class="col s12 m8">
					      <input type="checkbox" id="issploiler" />
					      <label for="issploiler">Спойлер</label>
				        </div>
				        <div class="col s12 m4 right-align">
						  <button id="do-add-new-comment" class="btn waves-effect waves-light">Отправить</button>
				        </div>
				      </div>
				    </div>
				  </div>
				</div>
			</article>
			<?php endif ?>
			<article style="background: #fff" class="z-depth-2 hoverable">
				<div style="margin-top: 5px;">
					<ul class="collection">
						<span id="comments">
					<?
					if ($_SESSION['sortCommentByWhat'] == 'news') {
						$query_c = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$item' ORDER BY `id` DESC LIMIT 10");
					}else if ($_SESSION['sortCommentByWhat'] == 'olds') {
						$query_c = mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$item' ORDER BY `id` LIMIT 10");
					}

					if (mysqli_num_rows($query_c) > 0) {
						while ($row_c = mysqli_fetch_assoc($query_c)) {
							$row_c_user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `login`,`name`,`avatar` FROM `users` WHERE `id` = '$row_c[by_user]'"));

							?>
							<li id="commentNumber<?=$row_c['id']?>" class="collection-item avatar">
								<?php if ($row_c_user['avatar']): ?>
								<img onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" src="<?=$row_c_user['avatar']?>" alt="KANSAI" class="circle">
								<?php else:?>
									<img onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" src="/static/images/havenotavatar.jpg" alt="KANSAI" class="circle">
								<?php endif ?>

								
								<a onclick="PaginationView('<?=$row_c_user['name']."(".$row_c_user['login'].")";?>', '/profile/<?=$row_c_user['login']?>');" class="title" style="cursor: pointer;"><?=$row_c_user['name']."(".$row_c_user['login'].")";?></a>
								<p>
									<?php if ($row_c['spoiler'] == 1): ?>
									  <ul class="collapsible" data-collapsible="accordion">
									    <li>
									      <div class="collapsible-header"><i class="material-icons">error</i>Спойлер</div>
									      <div class="collapsible-body"><span><?=nl2br($row_c['text'])?></span></div>
									    </li>
									  </ul>
									<?php else: ?>
										<?=nl2br($row_c['text'])?>
									<?php endif ?></p>
									<p><small>Дата добавления: <?=$row_c['comt_date']?></small></p>
								<?php if (User::Root(3)): ?>
									<a onclick="DeleteComment ('commentNumber<?=$row_c['id']?>', $(this).attr('data-comment-id'))" data-comment-id="<?=$row_c['id']?>" class="secondary-content"><i class="fa fa-times" aria-hidden="true"></i></a>
								<?php endif ?>
							</li>
						<?}echo "</span>";
					    if ( mysqli_num_rows(mysqli_query($connect, "SELECT * FROM `anime_comments` WHERE `anime_post` = '$item' ORDER BY `id` DESC LIMIT 10, 10")) > 0 ){?>
					      <div id="loaderBtnContainer" class="col s12" style="margin-top: .5rem;">
					        <div id="loaderOFComments" onclick="LoaderOfComments ($(this).attr('id'),$(this).attr('data-number'), $(this).attr('data-item'))" data-item="<?=$item?>" data-number="10" class="btn waves-effect waves-block" style="background: #fff; color: #2fb9f8">Загрузить ещё</div>
					      </div>
					    <?}

					}else {?>
							<li class="collection-item">
								
								<span class="title">Комментариев нет</span>
							</li>
					<?}
					?>
					</ul>
				</div>
			</article>
			</div>
			</div>
		</div>

<?php if (User::Root(4)): ?>
<div id="adminFloatBtn" class="fixed-action-btn vertical click-to-toggle">
	<button style="background-color: #31b5f7" id="data-admin-edit" data-already-editing="0" class="btn-floating btn-large hoverable">
		<i class="fa fa-pencil" aria-hidden="true"></i>
	</button>
</div>

<div id="AnimeCatsModal" class="modal">
	<form id="forOfCats" action="/admin/handle/EditCats/1" method="post">
		<div class="modal-content">
		  <h4>Жанры</h4>
		  <p>
			<div class="row">
			    <?
			    	$queryCC = mysqli_query(Mysql::connect(), "SELECT * FROM `anime_cats` ORDER BY `title` ASC");
			    	while ($rowCC = mysqli_fetch_assoc($queryCC)) {
	                      $cats = explode(' |-| ', $row['cats']);
	                      foreach ($cats as $key => $value) {
	                      	if ($value == $rowCC['title']) {
	                      		$checked = "checked=\"checked\"";
	                      		break;
	                      	}else {
	                      		$checked = "";
	                      	}
	                      }
			    		?>
				      <div class="col s12 m4">
				      	<input type="checkbox" <?=$checked?> name="cats[<?=$rowCC['title']?>]" id="<?=$rowCC['title']?>" />
				      	<label for="<?=$rowCC['title']?>"><?=$rowCC['title']?></label>
				      </div>
			    	<?}
			    ?>
			    <input type="hidden" name="item" value="<?=$item?>">
		    </div>
		  </p>
		</div>
		<div class="modal-footer">
		  <a id="do-change-cats" class="modal-action modal-close waves-effect waves-green btn-flat">Сохранить</a>
		</div>
	</form>
</div>

<div id="AnimePosterModal" class="modal">
	<form id="FormOfPoster" action="/admin/handle/ChangePoster/1" method="post" enctype="multipart/form-data">
		<div class="modal-content">
			<h4>Изменить постер</h4>
			<p>
				<div class="row">
					<div class="col s12">
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
				<input type="hidden" name="item" value="<?=$item?>">
			</p>
		</div>
		<div class="modal-footer">
			<a id="do-change-poster" class="modal-action modal-close waves-effect waves-green btn-flat">Сохранить</a>
		</div>
	</form>
</div>
<?php else: ?>
	<div id="data-admin-edit" data-already-editing="0"></div>
<?php endif ?>
<div id="ajax-div"></div>
<script>plyr.setup();</script>
<script>
 $(document).ready(function(){
    $('.materialboxed').materialbox();
    $('select').material_select();
    $('.collapsible').collapsible();
    $('ul.tabs').tabs();
    $('.modal').modal();

    <?php if ($row['type'] != 4): ?>
	    var serie = $("#series").val();
	   
		$.ajax({
			url: "/anime/handle/return_serie/1",
			method: "POST",
			cache: false,
			data: {
				"src": serie
			},
			success: function (data) {
				if (data != "frame") {
					$(".plyr--setup").attr("src", serie);
					$("#frame-container").hide();
					$("#video-container").show();
				}else {
					$("#frame-container > iframe").attr("src", serie);
					$("#video-container").hide();
					$("#frame-container").show();
				}
			}
		});

		$.ajax({
			url: "/anime/handle/returnView/1",
			method: "POST",
			cache: false,
			data: {
				"item": '<?=$item?>',
				"src": serie
			},
			success: function (data) {
				$("#count_view").text(data);
			}
		});
	<?php endif?>

	<?php if ($row['type'] != 4): ?>
	    	$.ajax({
	    		url: "/anime/handle/view/1",
	    		method: "POST",
	    		cache: false,
	    		data: {
	    			"item": '<?=$item?>',
	    			"src": serie
	    		},
	    		success: function () {

	    		}
	    	});


	    	ARating(<?=$item?>);
	<?endif?>

    $("#series").change(function(){
    	var th = $(this).val();

    	$.ajax({
    		url: "/anime/handle/view/1",
    		method: "POST",
    		cache: false,
    		data: {
    			"item": '<?=$item?>',
    			"src": th
    		},
    		success: function () {
    			
    		}
    	});
    
    	var val = $(this).val();
    	$.ajax({
    		url: "/anime/handle/returnView/1",
    		method: "POST",
    		cache: false,
    		data: {
    			"item": '<?=$item?>',
    			"src": val
    		},
    		success: function (data) {
    			$("#count_view").text(data);
    		}
    	});

		$.ajax({
			url: "/anime/handle/return_serie/1",
			method: "POST",
			cache: false,
			data: {
				"src": val
			},
			success: function (data) {
				if (data != "frame") {
					$(".plyr--setup").attr("src", val);
					$("#frame-container").hide();
					$("#video-container").show();
				}else {
					$("#frame-container > iframe").attr("src", val);
					$("#video-container").hide();
					$("#frame-container").show();
				}
			}
		});
    });
    <?php if (User::Root(4)): ?>
    $("#delete-all-post").on("click", function () {
    	if (confirm('Вы действительно хотите удалить тайтл "<?=$row['translated_title']?>"?')) {
    		$.ajax({
    			url: "/admin/handle/deletePost/1",
    			method: "POST",
    			cache: false,
				data: {item: <?=$item?>},
				success: function() {
					Pagination("Главная", "/main");
				}
    		});
    	}
    });

    $("#do-add-new-serie").on("click",function(){
    	var frame = $("#urlForSerie").val(),
    		number = $("#numberOfSerie").val();
    	if (frame.length < 5 || number <1) {
    		toast("Заполните все поля");
    	}else{
    		$.ajax({
    			url: "/admin/handle/addNewSerie/1",
    			method: "POST",
    			cache: false,
				data: {frame: frame, number: number, for: <?=$item?>},
				success: function(data) {
					$("#urlForSerie").val("");
					$("#numberOfSerie").val(data);
				}
    		});
    	}

    });
    $("#do-add-new-serie-from-frame").on("click",function(){
    	var frame = $("#urlForSerieIframe").val(),
    		number = $("#numberOfSerieIframe").val();
    	if (frame.length < 5 || number <1) {
    		toast("Заполните все поля");
    	}else{
    		$.ajax({
    			url: "/admin/handle/addNewSerieIframe/1",
    			method: "POST",
    			cache: false,
				data: {frame: frame, number: number, for: <?=$item?>},
				success: function(data) {
					$("#urlForSerieIframe").val("");
					$("#numberOfSerieIframe").val(data);
				}
    		});
    	}

    });

    $("#do-remove-serie").on("click",function(){
    	if (confirm("Вы точно хотите удалить эту серию?")) {
    		var ser_id = $("#delseries").val();
			$.ajax({
				url: "/admin/handle/removeSerie/1",
				method: "POST",
				cache: false,
				data: {ser_id: ser_id, for: <?=$item?>},
				success: function() {
					Pagination("<?=$row['translated_title']?>", "/anime/view/item/<?=$item?>");
				}
			});
		}
    });

    $("#do-remove-torrent").on("click",function(){
    	if (confirm("Вы точно хотите удалить этот торрент?")) {
    		var torrent = $("#deleteTorrent").val();
			$.ajax({
				url: "/admin/handle/removeTorrent/1",
				method: "POST",
				cache: false,
				data: {torrent: torrent, of: <?=$item?>},
				success: function() {
					Pagination("<?=$row['translated_title']?>", "/anime/view/item/<?=$item?>");
				}
			});
		}
    });

    $("#data-admin-edit").on("click", function () {
    	if ($(this).attr("data-already-editing") == 0) {
    		$(".animeEditBtnnn").show();
    		$("#AnimeStatusnon").hide();
    		$("#AnimeStatus").show();
    		$("#AnimeCatsTrigger").addClass("modal-trigger");
    		$("#AnimePosterNo").hide();
    		$("#AnimePosterCange").show();
    		$(this).attr("data-already-editing", 1);
    		toast ("Вы вошли в режим редактирования. Нажмите на тот элемент, который хотите радктировать");
    	}else {
    		$("#AnimeStatus").hide();
    		$("#AnimeStatusnon").show();
    		$(".animeEditBtnnn").hide();
    		$("#AnimePosterCange").hide();
    		$("#AnimePosterNo").show();
    		$("#AnimeCatsTrigger").removeClass("modal-trigger");
    		$(this).attr("data-already-editing", 0);
    		toast ("Вы вышли из режима редактирования.");
    	}
    });

    $(".AnimeEditThisPls").on("click", function () {
    	if ($("#data-admin-edit").attr("data-already-editing") == 1) {
    		$(this).attr("contenteditable", "true");
    		$("#AnimeTrTitleBtn").show();
    		$(this).focus();
    	}
    });

    $(".AnimeEditThisPls").on("blur", function () {
    	if ($("#data-admin-edit").attr("data-already-editing") == 1) {
    		$(this).attr("contenteditable", "false");
    	}
    });

    function EditSmt (what, text) {
    	$.ajax({
    		url: "/admin/handle/editSmt/1",
    		method: "POST",
    		cache: false,
    		data: {
    			item: '<?=$item?>',
    			what: what,
    			text: $(text).text()
    		},
    		success: function(data) {
    			$(text).text(data);
    			toast("Изменено");
    		}
    	});
    }

    $("#AnimeTrTitleBtn").on("click", function(){
    	EditSmt ("translated_title", "#AnimeTrTitle");
    });

    $("#AnimeOriginTitleBtn").on("click", function(){
    	EditSmt ("origin_title", "#AnimeOriginTitle");
    });

    $("#AnimeStudioBtn").on("click", function(){
    	EditSmt ("studio", "#AnimeStudio");
    });

    $("#AnimeYearBtn").on("click", function(){
    	EditSmt ("year", "#AnimeYear");
    });

    $("#AnimeDirectorBtn").on("click", function(){
    	EditSmt ("director", "#AnimeDirector");
    });

    $("#AnimeDescriptionBtn").on("click", function(){
    	EditSmt ("description", "#AnimeDescription");
    });

    $("#MaxSeriesTextBtn").on("click", function(){
    	EditSmt ("maxseries", "#MaxSeriesText");
    });

    $(".choose-anime_status").on("click", function(){
    	$.ajax({
    		url: "/admin/handle/editSmt/1",
    		method: "POST",
    		cache: false,
    		data: {
    			item: '<?=$item?>',
    			what: "status",
    			text: $(this).attr("data-status")
    		},
    		success: function(data) {
    			$("#AnimeStatus").text(data);
    			$("#AnimeStatusnon").text(data);
    			toast("Изменено");
    		}
    	});
    });
    $("#do-change-cats").click(function(){
      $("#forOfCats").ajaxForm({
      	target: "#allCats"
      }).submit();
    });
    $("#do-change-poster").click(function(){
      $("#FormOfPoster").ajaxForm({
      	target: "#posterIMG"
      }).submit();
    });

    $("#do-add-torrent-480p").click(function(){
      $("#Form-torrent-480p").ajaxForm({
      	target: "#ajax-div"
      }).submit();
    });
    $("#do-add-torrent-720p").click(function(){
      $("#Form-torrent-720p").ajaxForm({
      	target: "#ajax-div"
      }).submit();
    });

    <?else :?>
    $(".animeEditBtnnn").remove();
    <?endif?>
    <?php if (isset($_SESSION['id'])): ?>
    $("#do-add-new-comment").on("click", function () {
    	var text = $("#textOfComment").val(),
    		issploiler = $("#issploiler").prop("checked");
    	
    	if (text.length < 10) {
    		toast("Текст комментария не может быть меньше 10 символов");
    	}else if (text.length > 200) {
    		toast("Текст комментария не может быть больше 200 символов");
    	}else{
	    	if (issploiler == true) {
	    		issploiler = "yes";
	    	}else {
	    		issploiler = "no";
	    	}
			$.ajax({
				url: "/profile/handle/addNewComment/1",
				method: "POST",
				cache: false,
				data: {issploiler: issploiler, text: text, anime_post: '<?=$item?>'},
				success: function(data) {
					$("#comments").html(data);
					toast("Комментарий успешно добавлен");
					$("#textOfComment").val("");
				}
			});
    	}
    });

	  $('.dropdown-button').dropdown({
	      inDuration: 300,
	      outDuration: 225,
	      constrainWidth: true,
	      hover: false, 
	      gutter: 0, 
	      belowOrigin: false, 
	      alignment: 'left', 
	      stopPropagation: false 
	    }
	  );
    <?endif?>
  });

 function LoadComments (event) {
	$.ajax({
		url: "/handler/loadComments",
		method: "POST",
		cache: false,
		data: {event: event, anime_post: '<?=$item?>'},
		success: function(data) {
			$("#comments").html(data);
			$("#loaderOFComments").attr("data-number", 10);
			$("#loaderOFComments").show();
		}
	});
 }

 <?php if (isset($_SESSION['id'])): ?>
 	function UserList (Option, anime_post) {
 		$.ajax({
 			url: "/profile/handle/UserOptions/1",
 			method: "POST",
 			cache: false,
 			data: {
 				"Option": Option,
 				"anime_post": anime_post
 			},
 			success: function (data) {
 				$("#ajax-div").html(data);
 			}
 		});
 	}
 <?endif?>

// (function(){ 
// var a = document.querySelector('#left-sticky-block'), b = null;  
// window.addEventListener('scroll', Ascroll, false);
// document.body.addEventListener('scroll', Ascroll, false); 
// function Ascroll() {
//   if (b == null) { 
//     var Sa = getComputedStyle(a, ''), s = '';
//     for (var i = 0; i < Sa.length; i++) { 
//       if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
//         s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
//       }
//     }
//     b = document.createElement('div');  
//     b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
//     a.insertBefore(b, a.firstChild);  
//     var l = a.childNodes.length;
//     for (var i = 1; i < l; i++) {  
//       b.appendChild(a.childNodes[1]);
//     }
//     a.style.height = b.getBoundingClientRect().height + 'px';  
//     a.style.padding = '0';
//     a.style.border = '0';  
//   }
//   if (a.getBoundingClientRect().top <= 72) { 
//     b.className = 'sticky-poster-anime';
//   } else {
//     b.className = 'non-poster-anime';
//   }
//   window.addEventListener('resize', function() {
//     a.children[0].style.width = getComputedStyle(a, '').width
//   }, false); 
// }
// })()
</script>

<?mysqli_query($connect, "UPDATE `anime_post` SET `view` = `view` + 1 WHERE `id` = '$item'");?>