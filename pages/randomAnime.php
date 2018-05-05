            <div class="col s12" style="background: #fff;">
              <div style="padding: 15px">
                <div class="row">
                  <div class="col s12">
                    <div style="font-weight: 700;text-decoration: none;font-size: 24px;color: #333;word-wrap: break-word;">Случайное аниме</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12">
<?
                  $Mysql_rand_anime = new Mysql();
                  $connect_rand_anime = $Mysql_rand_anime->connect();

                  $query_rand_anime = mysqli_query($connect_rand_anime, "SELECT `id`, `translated_title`, `poster`, `origin_title`, `votes`,`view` FROM `anime_post` WHERE `type` <> 4 ORDER BY RAND() LIMIT 1,1");

                  $row_rand_anime = mysqli_fetch_assoc($query_rand_anime);
?>

					<div style="font-weight: 700;text-decoration: none;font-size: 20px;color: #333;word-wrap: break-word;"><?=$row_rand_anime['translated_title']?></div>
					<div style="font-size: 16px;font-weight: 500;color: #56524f;"><?=$row_rand_anime['origin_title']?></div>
					<div style="position: relative;text-align: center;margin: 15px 0;">
						<img src="<?=$row_rand_anime['poster']?>" alt="<?=$row_rand_anime['translated_title']?>" class="responsive-img" style="width: 100%">
						<div class="valign-wrapper " data-position="bottom" data-delay="50" data-tooltip="Кол-во просмотров поста" style="position: absolute;left: 0;bottom: 0;padding: 5px;background-color: #2fb9f8;color: #fff;border-top-right-radius: 10px;-webkit-box-shadow: 3px -2px 5px 0px rgba(0,0,0,0.75);-moz-box-shadow: 3px -2px 5px 0px rgba(0,0,0,0.75);box-shadow: 3px -2px 5px 0px rgba(0,0,0,0.75);">
							<i class="material-icons dp48">remove_red_eye</i>
						<?=$row_rand_anime['view']?>
						</div>
					</div>
					<div style="    text-align: center;">
                    <?
                      $votes = $row_rand_anime['votes'];

                      for ($i=1; $i < 11; $i++) { ?>
                        <span data-value="<?=$i?>" style="font-size: 1.5em" title="Рейтинг: <?=$votes?> из 10" data-already="0" class="votes_anime">
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
                    <div><a class="btn waves-effect" href="/anime/view/item/<?=$row_rand_anime['id']?>" onclick="PaginationView('<?=$row_rand_anime['translated_title']?>', '/anime/view/item/<?=$row_rand_anime['id']?>'); return false;" style="width: 100%;">Смотреть сейчас</a></div>
                  </div>
                </div>
              </div>
            </div>