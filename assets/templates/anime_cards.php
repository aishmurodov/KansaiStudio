<?
	
	function return_paginate_anime ($count, $active, $url, $get_params = []) {
		foreach ($get_params as $key => $value) 
			if (!$value)
				unset($get_params[$key]);

		$paginate = '<div class="col s12">';
		$paginate .= '<ul id="anime_paginate" class="pagination">';
			if ($count > 1) {
				$paginate.= ($count > 1 ? '<li class="'.($active == 1 ? 'disabled' : '').' paginate-back waves-effect"><a href="'.$url.'?'. http_build_query($get_params) .'&page='.(($active - 1) > 0 ? $active - 1 : 1).'" onclick="Pagination(\'Главная\',$(this).attr(\'href\'));return false;"><i class="fa fa-chevron-left"></i></a></li>' : '');
				$paginate.= ($count > 1 ? '<li class="'.($active == $count ? 'disabled' : '').' paginate-forward waves-effect"><a href="'.$url.'?'. http_build_query($get_params) .'&page='.(($active + 1) <= $count ? $active + 1 : $count).'" onclick="Pagination(\'Главная\',$(this).attr(\'href\'));return false;"><i class="fa fa-chevron-right"></i></a></li>' : '');
				for ($i = 1; $i <= $count; $i++) {
					$paginate.= '<li class="'.($i == $active ? 'active' : '').' waves-effect"><a href="'.$url.'?'. http_build_query($get_params) .'&page='.$i.'" onclick="Pagination(\'Главная\',$(this).attr(\'href\'));return false;">'.$i.'</a></li>';
				}
			}
		$paginate.= '</ul>';
		$paginate.= '</div>';
		return $paginate;

	}

	function Anime_Cards($row) {?>
              <div class="col s12 main_content_cardss carrd" style="">
				<div class="row" style="overflow: hidden;background-color: #fff;border-radius: 5px;margin-bottom: 0">
					<div onclick="PaginationView('<?=$row['translated_title']?>', '/anime/view/item/<?=$row['id']?>');" class="col s12 m5 z-depth-4 shadow-demo" style="height: 320px;background-size: cover;background-position: center center;position: relative;cursor: pointer;padding: 0">
						<img src="<?=$row['poster']?>" style="width: 100%;height: 100%" alt="">
						<div class="valign-wrapper " data-position="bottom" data-delay="50" data-tooltip="Кол-во просмотров поста" style="position: absolute;left: 0;bottom: 0;padding: 5px;background-color: #2fb9f8;color: #fff;border-top-right-radius: 5px;-webkit-box-shadow: 3px -2px 5px 0px rgba(0,0,0,0.75);-moz-box-shadow: 3px -2px 5px 0px rgba(0,0,0,0.75);box-shadow: 3px -2px 5px 0px rgba(0,0,0,0.75);">
							<i class="material-icons dp48">remove_red_eye</i>
							<?=$row['view']?>
						</div>
					</div>
					<div class="col s12 m7">
						<div class="row main_cart_right_side" style="padding-top: 15px;padding-bottom: 20px;overflow: auto;background-color: #fff;margin-bottom: 0;">
							<div class="col s12">
								<a onclick="PaginationView('<?=$row['translated_title']?>', '/anime/view/item/<?=$row['id']?>'); return false;" href="/anime/view/item/<?=$row['id']?>" style="overflow: hidden;font-weight: 700;text-decoration: none;font-size: 24px;color: #333;word-wrap: break-word;">
									<?=$row['translated_title']?>
										<?php if ($row['type'] < 3): ?>
											[<?
												$srs_count =  mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT `number` FROM `anime_series` WHERE `anime_post` = '$row[id]' ORDER BY `number` DESC"));
												$srs_count = $srs_count['number'];
												if (!$srs_count) $srs_count = 0;
												if ($row['maxseries'] >= 1 && $srs_count > $row['maxseries']) $srs_count = $row['maxseries'];
												echo "$srs_count";
											?> из <?
												if ($row['maxseries'] >= 1) {
													echo $row['maxseries'];
												}else 
													echo "XXX";
											?>]
										<?php endif ?>
									</a>
								<div style="font-size: 16px;font-weight: 500;color: #56524f;"><?=$row['origin_title']?></div>
								<?php if ($row['type'] != 4): ?>
									<div id="votes">
										<?
											$votes = $row['votes'];

											for ($i=1; $i < 11; $i++) { ?>
												<span data-value="<?=$i?>" style="font-size: 1.7em;
												<?
													if ($i == 1) echo "color: #2fb9f8";
													else if ($i == 2) echo "color: #37aff7";
													else if ($i == 3) echo "color: #3da5f5";
													else if ($i == 4) echo "color: #3ea3f5";
													else if ($i == 5) echo "color: #469cf5";
													else if ($i == 6) echo "color: #469bf5";
													else if ($i == 7) echo "color: #4897f4";
													else if ($i == 8) echo "color: #4b94f3";
													else if ($i == 9) echo "color: #4e8ff3";
													else if ($i == 10) echo "color: #4f8ef3";
												?>
												" title="Рейтинг: <?=$votes?> из 10">
													<?	
														 if ($votes >= $i) {
															echo '<i class="fa fa-star" aria-hidden="true"></i>';
														}else if ($votes < $i) {
															if ($votes > 1 && $votes < 2) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 2 && $votes < 3) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 3 && $votes < 4) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 4 && $votes < 5) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 5 && $votes < 6) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 6 && $votes < 7) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 7 && $votes < 8) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 8 && $votes < 9) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else if ($votes > 9 && $votes < 10) {
																echo '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
															}else {
																echo '<i class="fa fa-star-o" aria-hidden="true"></i>';
															}
															$votes = 0;
														}
													?></span>
											<?}
										?>
									</div>
								<?php endif ?>
								<div style="height: 34px;overflow: hidden;">
								<?
								$cats = explode(' |-| ', $row['cats']);
								$cnt = 0;
								foreach ($cats as $key => $value) {?>
									<?php if ($cnt < 6): ?>
									<a title="<?=$value?>" onclick="PaginationSearch($(this).text(), $(this).attr('href'));return false;" href="/search/cats/q/<?=urlencode($value)?>"><div class="chip hoverable truncate" style="border-radius: 0;padding: 0 10px;line-height: 18px;margin-bottom: 5px;margin-right: 5px;max-width: 101px"><?=$value?></div></a>
									<?php endif ?>
								<?$cnt++;}?>
								</div>
							</div>
							<div class="col s12" style="margin-top: 5px;font-size: 14px;">
								<b>Год выпуска: </b> <a onclick="PaginationSearch('Год выпуска', $(this).attr('href'));return false;" href="/search/year/q/<?=urlencode($row['year'])?>"><?=$row['year']?></a>
							</div>
							<div class="col s12">
								<p style="font-size: 14px;"><?=nl2br($row['description'])?></p>
							</div>
						</div>
					</div>
				</div>
              </div>
	<?}