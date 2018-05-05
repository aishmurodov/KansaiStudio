<!DOCTYPE html>
<html lang="ru" dir="left" prefix="og: https://ogp.me/ns#" xmlns:fb="https://ogp.me/ns/fb#">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент.</title>
<?
$last_anime = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT `translated_title`,`poster`,`description` FROM `anime_post` ORDER BY `updatedIn` DESC, `id` DESC"));
?>
  <meta property="og:title" content="KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент">
  <meta property="og:description" content="<?=mb_strimwidth($last_anime['description'], 0, 100, '...')?>">
  <meta property="og:image" content="https://createpro.site/static/images/kansaiLogo.png" />
  <meta property="og:image:url" content="https://createpro.site/static/images/kansaiLogo.png" />
  <meta property="og:type" content="website">
  <meta property="og:url" content= "<?="$_SERVER[HTTP_X_FORWARDED_PROTO]://$_SERVER[SERVER_NAME]".$_SERVER['REQUEST_URI']?>">
  <meta property="og:site_name" content= "Kansai Studio">
  <meta name="description" content="KANSAI - студия озвучания. Мы познакомим вас с миром кино Японии, Кореи, а также других стран Азии. Смотреть аниме онлайн в хорошем качестве и скачать торрент.">
  <link rel="shortcut icon" href="/static/images/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="/static/css/materialize.css">
  <link rel="stylesheet" href="/static/css/chosen.css">
  <link rel="stylesheet" href="/static/css/player.css">
  <link rel="stylesheet" href="/static/css/ARating.css?version=1337&6">
  <!--[if lt IE 9]>
    <script src="/static/libs/html5shiv.min.js"></script>
  <![endif]-->
</head>
<body>
  <div style="display: block;" id="wrapper">
    <header id="header">
    <?php if (User::Root(4)): ?>
    <div id="headerLogo" style="
        position: relative;
        display:  block;
        width:  100%;
        height: 100px;
        background-image: url(/static/images/bg-logo.jpg);
        background-repeat:  no-repeat;
        background-size: cover;
        background-position: 50%;
    ">
      <div>
        <?php if (!isset($_SESSION['id'])): ?>
          <span class="lginHead" onclick="OpenModal('modalOfLogin');">Вход</span>
          <span class="reginnHead" onclick="Pagination('Регистрация', '/register');return false;">Регистрация</span>
        <?php else:  ?>
          <?php if (User::Root(4)): ?>
            <span id="adminheader">
              <?
              $menu = (!User::Root(5)) ? $Menu['editor'] : $Menu['Admin'];

              foreach ($menu as $key => $value): ?>
                <a href="/<?=$key?>" class="reginnHead" onclick="Pagination($(this).text(),$(this).attr('href'));return false;"><?=$value?></a>
              <?php endforeach ?>
            </span>
          <?php endif ?>
          <a onclick="PaginationView('Профиль', $(this).attr('href'));return false;" href="/profile"><span class="lginHead"><?=$_SESSION['login']?></span></a>
          <a onclick="if (!confirm('Вы точно хотите выйти из аккаунта?')) return false;" href="/handler/logout" class="reginnHead">Выйти</a>
        <?php endif ?>
      </div>
    </div>
    <?php endif ?>
      <div id="Menu">
        <nav class="nav-extended" style="top: 0">
          <div class="nav-wrapper container">
            <span class="descmenu">
            <a href="/main" onclick="Pagination($(this).text(),$(this).attr('href'));return false;" class="brand-logo" style="color: rgba(0,0,0,0);background: url(/static/images/logo-white.png);background-repeat: no-repeat;-webkit-background-size: 100%;
    background-size: 100%;">Kansai</a>
            <span id="searchPlace">
              <span id="targetSearch" href="#"><i class="fa fa-search" style="font-size: 24px" aria-hidden="true"></i></span>
              <div id="srch">
                <input id="inputOfSearchInMenu" type="text" placeholder="Поиск" style="margin-bottom: 0;">
                <div id="resultsDesc"></div>
              </div>
            </span>
            <a href="#" data-activates="mobile-demo" class="button-collapse" style="font-size: 24px"><i class="fa fa-bars" aria-hidden="true"></i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
              <span id="descmenu">
                <?php foreach ($Menu['User'] as $key => $value): ?>
                  <li><a class="menu_nav_hyper_a" href="/<?=$key?>" onclick="Pagination($(this).text(),$(this).attr('href'));return false;"><?=$value?></a></li>
                <?php endforeach ?>
                <?php if (!isset($_SESSION['id'])): ?>
                  <li><a class="menu_nav_hyper_a" onclick="OpenModal('modalOfLogin');">Вход</a></li>
                  <li><a class="menu_nav_hyper_a" onclick="Pagination('Регистрация', '/register');return false;" href="/register">Регистрация</a></li>
                <?php else: ?>
                  <?php if (!User::Root(4)): ?>
                    <li><a class="menu_nav_hyper_a" onclick="PaginationView('Профиль', $(this).attr('href'));return false;" href="/profile">
                        <?
                          $avatar = ($_SESSION['avatar'] != '') ? $_SESSION['avatar'] : "/static/images/havenotavatar.jpg";
                        ?>
                        <img id="header_avatar_img" src="<?= $avatar ?>" alt=" " style="height:  34px;width:  34px;border-radius: 50%;transform: translate(-10px,12px);">
                        <?
                          if ($_SESSION['network'] == "Kansai") {
                           echo $_SESSION['login'];
                          }else {
                            echo $_SESSION['name'];
                          }
                        ?>
                      </a>
                    </li>
                    <li><a class="menu_nav_hyper_a" onclick="if (!confirm('Вы точно хотите выйти из аккаунта?')) return false;" href="/handler/logout" class="reginnHead">Выйти</a></li>
                  <?php endif ?>
                <?php endif ?>
              </span>
            </ul>
          </span>
            <ul class="side-nav" id="mobile-demo">
          <li class="logo"><a href="/main" onclick="Pagination($(this).text(),$(this).attr('href'));return false;" class="brand-logo" style="color: rgba(0,0,0,0);background: url(/static/images/logo.png);background-repeat: no-repeat;-webkit-background-size: 100%;
    background-size: 100%;">Kansai</a></li>
          <li><a style="color: rgba(0,0,0,0);">Kansai</a></li>
          <li style="position: relative;">
               <div style="text-align: center;width: 100%"><input id="MobileSearch" type="text" placeholder="Введите запрос..."></div>
                <span id="MobileSearchResult" style="
                    background:  #2fb9f8;
                    position:  relative;
                    width:  100%;
                    height:  auto;
                    left: 0;
                    bottom:  0;
                "></span>
          </li>
          <span id="mbmenu">
                <?php foreach ($Menu['User'] as $key => $value): ?>
                  <li><a href="/<?=$key?>" onclick="Pagination($(this).text(),$(this).attr('href'));return false;"><?=$value?></a></li>
                <?php endforeach ?>
                <?php if (User::Root(5)): ?>
                  <?php foreach ($Menu['Admin'] as $key => $value): ?>
                  <li><a href="/<?=$key?>" onclick="Pagination($(this).text(),$(this).attr('href'));return false;"><?=$value?></a></li>
                  <?php endforeach ?>
                <?php endif ?>
               <?php if (!isset($_SESSION['id'])): ?>
                  <li><a onclick="OpenModal('modalOfLogin');">Вход</a></li>
                  <li><a onclick="Pagination('Регистрация', '/register');return false;" href="/register">Регистрация</a></li>
                <?php else: ?>
                  <?php if (!User::Root(5)): ?>
                    <li><a onclick="PaginationView('Профиль', $(this).attr('href'));return false;" href="/profile"><?=$_SESSION['login']?></a></li>
                    <li><a onclick="if (!confirm('Вы точно хотите выйти из аккаунта?')) return false;" href="/handler/logout" class="reginnHead">Выйти</a></li>
                  <?php endif ?>
                <?php endif ?>
          </span>
            </ul>
          </div>
          <div id="loading" class="progress">
            <div class="indeterminate" id="prg" style="display: none;"></div>
          </div>
        </nav>
      </div>
    </header>
      <main>
        <div class="row container">
          <div id="articleBlock" class="col s12 m8">
          <div id="content" style="margin-top: 30px;"></div>
        </div>
        <div id="adsBlock" class="col s12 m4" style="margin-top: 30px;">
          <div style="border-radius: 5px;">
            <div class="z-depth-2 hoverable">
              <div id="randomAnime" class="row" style="margin-bottom: 0;">
                <? include 'randomAnime.php'; ?>
              </div>
              <div class="row">
                <div style="background: #fff;border-radius: 5px;">
                  <div style="text-align:center;padding-left: 15px;padding-right: 15px;padding-bottom: 15px;padding-top:0;">
                      <div class="row" style="margin-bottom: 0;">
                        <div class="col s12">
                          <p style="font-weight:700;text-decoration:none;font-size:24px;color:#333;word-wrap:break-word;">Социальные ссылки</p>
                        </div>
                      </div>
                      <div class="row" style="margin-bottom: 0;">
                        <div class="col s12">
                          <a href="https://vk.com/kansai_official" class="socials_hypers" title="<?=Config::title();?>" style="width: 48px;height: 48px;background: url(/static/images/svg/vk.svg) no-repeat;display: inline-block;margin-left: 20px;" target="_blank"></a>
                          <a href="https://www.youtube.com/user/studiokansai/videos" class="socials_hypers" title="<?=Config::title();?>" style="width: 48px;height: 48px;background: url(/static/images/svg/youtube.svg) no-repeat;display: inline-block;margin-left: 20px;" target="_blank"></a>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>  
          <div class="row" style="border-radius: 5px;">
            <div class="col s12 z-depth-1 hoverable" style="background: #fff;">
              <div class="row" style="padding: 15px 0">
                <div class="col s12" style="font-weight: 700;text-decoration: none;font-size: 24px;color: #333;word-wrap: break-word;">Облако жанров</div>
                <div class="col s12">
                  <?
                    $cats = [];
                    $query = mysqli_query(Mysql::connect(), "SELECT `title` FROM `anime_cats` ORDER BY `title` ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $count = mysqli_fetch_assoc(mysqli_query(Mysql::connect(), "SELECT COUNT(`id`) AS `count` FROM `anime_post` WHERE `cats` LIKE '%%$row[title]%%'"));
                        echo '<a title="'.$row['title'].'('.$count['count'].')" onclick="PaginationSearch($(this).text(), $(this).attr(\'href\'));return false;" href="/search/cats/q/'.urlencode($row['title']).'"><div class="chip hoverable" style="border-radius: 0;padding: 0 10px;margin-bottom: 5px;margin-right: 5px;">'.$row['title'].'('.$count['count'].')</div></a>';
                      $cats[] = $row;
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>

<!--           <div class="row" style="border-radius: 5px;">
            <div class="col s12 z-depth-2 hoverable" style="background: #fff;">
              <div class="row" style="padding: 15px 0">
                <div class="col s12" style="font-weight: 700;text-decoration: none;font-size: 24px;color: #333;word-wrap: break-word;">Подобрать аниме</div>
                <div class="col s12">
                  <form action="/filter" method="get">
                    <div class="row">
                      <div class="input-field col s12">
                          <div style="color: #333;font-weight: 400;">Выбрать жанры</div>
                          <select required="" name="selected_category[]" multiple="">
                            <?
                              // $selected = 'selected';
                              // foreach ($cats as $cat) {
                              //   $cat['title'] = System::mb_strtoupper_first($cat['title']);
                              //   echo '<option '.$selected.' value="'.$cat['title'].'">'.$cat['title'].'</option>';
                              //   $selected = '';
                              // }
                            ?>
                          </select>
                      </div>
                      <div class="input-field col s12">
                          <div style="color: #333;font-weight: 400;">Тип аниме</div>
                          <select required="" name="selected_type[]" multiple="">
                            <option selected value="1">Сериал</option>
                            <option value="3">Фильм</option>
                            <option value="2">Ова</option>
                          </select>
                      </div>
                      <div class="input-field col s12">
                          <div style="color: #333;font-weight: 400;">Статус аниме</div>
                          <select required="" name="selected_status[]">
                            <option selected value="1">Не учитывать</option>
                            <option value="Онгоинг">Онгоинг</option>
                            <option value="Завершен">Завершен</option>
                            <option value="Анонс">Анонс</option>
                          </select>
                      </div>
                      <div class="input-field col s12">
                        <div style="color: #333;font-weight: 400;">Год</div>
                        <div class="row">
                          <div class="col">
                            <input required="" type="number" name="selected_year[min]" min="2014" value="2014" placeholder="От">
                          </div>
                          <div class="col">
                            <input required="" type="number" name="selected_year[max]" min="2014" max="<?//date('Y')?>" value="<?//date('Y')?>" placeholder="До">
                          </div>
                        </div>
                      </div>
                      <div class="input-field col s12">
                          <div style="color: #333;font-weight: 400;">Сортировать по</div>
                          <select required="" name="selected_order[]">
                            <option selected value="1">Рейтингу</option>
                            <option value="2">Алфавиту(А-Я)</option>
                            <option value="3">Алфавиту(Я-А)</option>
                            <option value="4">Колличеству просмотров</option>
                            <option value="5">По дате (сначала новые)</option>
                            <option value="6">По дате (сначала старые)</option>
                          </select>
                      </div>
                      <div class="input-field col s12">
                        <button type="submit" name="do-search-by-filer" style="width: 100%;" class="btn btn-wawes">Искать</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div> -->

        </div>
      </main>

        <footer class="page-footer">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="white-text">KANSAI STUDIO</h5>
                <p class="grey-text text-lighten-4">
                  KANSAI - студия озвучания. <br>
                  Мы познакомим вас с миром кино Японии, Кореи, а также других стран Азии. <br>
                  Мы покажем вам самое интересное из любительских фильмов по компьютерным играм, трейлеров и прочих передач, не озвученных на русском языке. <br>
                  Мы стремимся делать нашу работу так, чтобы вы получали удовольствие от просмотра всей нашей продукции.
                </p>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © <?=date("Y")?> Все права защищены <?=Config::title();?>
            <span class="grey-text text-lighten-4 right">Сайт создан командой <a href="https://createpro.site/" target="_blank" class="grey-text text-lighten-4" style="text-decoration: underline;">CreatePro.Site</a></span>
            </div>
          </div>
        </footer>

    <div class="scrollTop " data-position="left" data-delay="50" data-tooltip="Проскролить наверх">
      <i class="fa fa-angle-up"></i>
    </div>
  </div>

  <?php if (!isset($_SESSION['id'])): ?>
    <div id="modalOfLogin" class="modal modal-footer">
      <div class="modal-content">
        <div>
          <div class="row" style="margin-bottom: 0">
            <div class="input-field col 12">
              <h4>ВХОД</h4>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              <input id="loginSignIN" type="text" class="validate">
              <label for="loginSignIN">Никнейм</label>
            </div>
            <div class="input-field col s12">
              <i class="material-icons prefix">lock_outline</i>
              <input id="passwordSignIn" type="password" class="validate">
              <label for="passwordSignIn">Пароль</label>
            </div>
            <div class="col s12" style="display: none;">
              <input type="checkbox" id="saveMeSignIn" checked="checked" />
              <label for="saveMeSignIn">Запомнить пароль</label>
            </div>
            <div class="col s12">
              <!-- <h5>Войти с помощью:</h5> -->
              <h5>
                <?
                  $vk_config = Config::VkApi();
                ?>
                <a href="https://oauth.vk.com/authorize?client_id=<?=$vk_config['id']?>&scope=email,offline&display=page&redirect_uri=<?=$vk_config['url']?>&response_type=code" title="Войти с ВК"><i style="float: left;" class="fa fa-vk socialLogIn socialLogIn-Vk" aria-hidden="true" target="_blank"></i></a>
                <!-- <div id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name;providers=vkontakte,google;hidden=;redirect_uri=http%3A%2F%2Fm95238ps.beget.tech%2Fhandler%2FsignWithWidjet;mobilebuttons=0;"></div> -->

                <button style="float: right;" id="do-signin-account" class="waves-effect waves-green btn-flat">Войти</button>
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?endif?>
  <div id="Preloader-wrapper" style="display: none;" class="valign-wrapper">
      <div class="frst">
        <div class="preloader-wrapper big active">
          <div class="spinner-layer spinner-white-only">
            <div class="circle-clipper left">
              <div class="circle"></div>
            </div><div class="gap-patch">
              <div class="circle"></div>
            </div><div class="circle-clipper right">
              <div class="circle"></div>
            </div>
          </div>
        </div>
    <div style="text-align:center;font-size:1.7em;color:#fff;position:absolute;top: 0;left: 0;width:100%;height:100%;" class="valign-wrapper">
        <div style="width:100%;" id="preloaderPercent">0%</div>
    </div>
      </div>
  </div>
<!--   <div id="Preloader-wall">
    <div class="left valign-wrapper">
        <div style="display: block;width: 100%;text-align: right; font-size: 1.2em;font-weight: 500;">Загр</div>
    </div>
    <div class="right valign-wrapper">
        <div style="display: block;width: 100%;text-align: left; font-size: 1.2em;font-weight: 500;">узка...</div>
    </div>
  </div> -->
  <div id="ajaxDiv"></div>

  <script type="text/javascript" src="/static/libs/jquery.js"></script>
  <script type="text/javascript" src="/static/libs/materialize.js"></script>
  <script type="text/javascript" src="/static/libs/jquery.form.js"></script>
  <script type="text/javascript" src="/static/libs/player.js"></script>
  <script type="text/javascript" src="/static/libs/chosen.jquery.min.js"></script>
  <!-- <script type="text/javascript" src="/static/libs/ulogin.js"></script> -->
  <script type="text/javascript" src="/static/js/pageLoading.js?v=2"></script>
  <script type="text/javascript" src="/static/js/ARating.js"></script>
  <!-- <script type="text/javascript" src="/static/js/scroll.js"></script> -->
  <script>
    $(document).ready(function(){
      $(".button-collapse").sideNav();
      Materialize.updateTextFields();
      $('.modal').modal();
      $('body,html').animate({scrollTop: 0}, 320);
      $('select').material_select();
      $('.materialboxed').materialbox();
      $("#targetSearch").click(function(){
        if ($("#inputOfSearchInMenu").is("focus")) {
          $("#srch").css("width", "");
          $("#resultsDesc").hide();
          $("#inputOfSearchInMenu").blur();
        }else {
          $("#srch").css("width", "auto");
          $("#inputOfSearchInMenu").focus();
        }
      });

      $("#inputOfSearchInMenu").focus(function(){
        $(this).attr("placeholder", "");
      }).blur(function(){
        $(this).attr("placeholder", "Поиск");
      });

      // var Preloaded = setTimeout(function() {
      //   $("#Preloader-wrapper").fadeOut();
      //   $("#wrapper").fadeIn();
      //   setTimeout (function () {
      //     $("#Preloader-wrapper").addClass("opacity");
      //   }, 1000);
      // }, 1500);

      $("#inputOfSearchInMenu").keyup(function() {
        var numChars = $(this).val().length;
        if (numChars >= 3) {
          var queryString = $(this).val();
          $.ajax({
              url: '/handler/search',
              method: 'POST',
              data: {queryString: queryString},
              beforeSend: function() {
                
              }}).done(function(data){
                if (data != "error") {
                  $("#resultsDesc").show();
                  $("#resultsDesc").html(data);
                }
          });
          previousNumChars = numChars;
        }else if (previousNumChars > numChars) {
          previousNumChars = 0;
          $("#resultsDesc").hide();
          $("#resultsDesc").html("");
        }
      });

      $("#MobileSearch").keyup(function() {
        var numChars = $(this).val().length;
        if (numChars >= 3) {
          var queryString = $(this).val();
          $.ajax({
              url: '/handler/search/mobile/1',
              method: 'POST',
              data: {queryString: queryString},
              beforeSend: function() {
                
              }}).done(function(data){
                if (data != "error") {
                  $("#MobileSearchResult").show();
                  $("#MobileSearchResult").html(data);
                }
          });
          previousNumChars = numChars;
        }else if (previousNumChars > numChars) {
          previousNumChars = 0;
          $("#MobileSearchResult").hide();
          $("#MobileSearchResult").html("");
        }
      });

      $("#do-signin-account").on("click", function(){
        var login = $("#loginSignIN").val(),
            password = $("#passwordSignIn").val(),
            saveme = $("#saveMeSignIn").prop("checked");
        if (login.length > 0 && password.length > 0) {
          $.ajax({
            url: '/handler/signIn',
            method: "POST",
            data: {
            "login": login,
            "password": password,
            "saveme": saveme
            },
            success: function (data) {
              $("#ajaxDiv").html(data);
            }
          });
        }else {
          toast("Заполните все поля");
        }
      });

      $(window).scroll(function () {
        if ($(this).scrollTop() > ($("#Menu").height()*2)) {
          $('.scrollTop').addClass("scrollTopActive");
        } else {
          $('.scrollTop').removeClass("scrollTopActive");
        }
      });

      $('.scrollTop').on("click", function() {
        $('html, body').animate({scrollTop: 0},400);
        return false;
      });
    });

    function OpenModal (MID) {
      $('#' + MID).modal('open');
    }
    $(function(){
      $(window).scroll(function() {
          var top = $(document).scrollTop();
          var heder_height = $("#headerLogo").height();   
          if (top < heder_height ) {
              $("#Menu").removeClass("navbar-fixed");
          } else {
              $("#Menu").addClass("navbar-fixed");
          }
      });
      PageLoading("off");
    });

     function randomAnime() {
        $.ajax({
          url: "/randomAnime",
          method: "POST",
          cache: false,
          data: {"true": "true"},
          success: function(e) {
            $("#randomAnime").html(e);
          }
        });
      }

    function toast (text) {
      Materialize.toast(text, 3000);
    }

    function loading (event) {
      if (event == "on") {
        $("main").addClass("disabled");
        $("#loading").addClass("active");
        $("#prg").show();
      }
      else if (event == "off") {
        $("main").removeClass("disabled");
        $("#loading").removeClass("active");
        $("#prg").hide();
      }
    }

    function PaginationSearch(title, href) {
      if (href != "#" && href != 'undefined' && href != '') {
            history.pushState(null, null, href);
            $.ajax({
                url: '/pagination',
                method: 'POST',
                data: {"href" : href},
                cache: false,
                beforeSend: function() {
                  loading("on");
                  // PageLoading("on");
                }}).done(function(data){
                  if (data != '404') {
                    $("#articleBlock").addClass("m8");
                    $("#adsBlock").addClass("m4");
                    $("#randomAnime").show();
                    $("#content").html(data);
                    document.title = title + " - Kansai Studio";
                    $('html, body').animate({scrollTop: 0},400);
                    randomAnime();
                    loading("off");
                    // PageLoading("off");
            }else {
              Pagination("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент.","/main");
              toast("Страница не найдена");
            }
            $('.button-collapse').sideNav('hide');
              });
      }
      $("input").val("");
      $("#resultsDesc").hide();
      $("#MobileSearchResult").hide();
      $("#MobileSearchResult").html("");
      $("#inputOfSearchInMenu").removeClass("activeSS");
      $("#inputOfSearchInMenu").blur();
      return false;
    }

    function Pagination(title, href) {
      if (href != "#" && href != 'undefined' && href != '') {
            history.pushState(null, null, href);
            $.ajax({
                url: '/pagination',
                method: 'POST',
                data: {"href" : href},
                cache: false,
                beforeSend: function() {
                  loading("on");
                  // PageLoading("on");
                }}).done(function(data){
                  if (data != '404') {
                    $("#articleBlock").addClass("m8");
                    $("#adsBlock").addClass("m4");
                    $("#randomAnime").show();
                    $("#content").html(data);
                    document.title = title + " - Kansai Studio";
                    $('html, body').animate({scrollTop: 0},400);
                    randomAnime();
                    loading("off");
                    // PageLoading("off");
            }else {
              Pagination("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент.","/main");
              toast("Страница не найдена");
            }
            $('.button-collapse').sideNav('hide');
              });
      }
      $("input").val("");
      $("#resultsDesc").hide();
      $("#MobileSearchResult").hide();
      $("#MobileSearchResult").html("");
      $("#inputOfSearchInMenu").removeClass("activeSS");
      $("#inputOfSearchInMenu").blur();
      return false;
    }

    function PaginationView(title, href) {
      if (href != "#" && href != 'undefined' && href != '') {
            history.pushState(null, null, href);
            $.ajax({
                url: '/pagination',
                method: 'POST',
                data: {"href" : href, "view": "1"},
                cache: false,
                beforeSend: function() {
                  loading("on");
                  // PageLoading("on");
                }}).done(function(data){
                  if (data != '404') {
                    $("#articleBlock").removeClass("m8");
                    $("#adsBlock").removeClass("m4");
                    $("#randomAnime").hide();
                    $("#content").html(data);
                    document.title = title + " - Kansai Studio";
                    window.scrollTo(0, 0);
                    randomAnime();
                    loading("off");
                    // PageLoading("off");
                    setTimeout(function() {
                      $(".caret").html('<i class="fa fa-caret-down" aria-hidden="true"></i>');
                    }, 1000);
            }else {
              Pagination("KANSAI. Смотреть аниме онлайн в хорошем качестве и скачать торрент.","/main");
              toast("Страница не найдена");
            }
            $('.button-collapse').sideNav('hide');
              });
      }
      $("input").val("");
      $("#resultsDesc").hide();
      $("#MobileSearchResult").hide();
      $("#MobileSearchResult").html("");
      $("#inputOfSearchInMenu").removeClass("activeSS");
      $("#inputOfSearchInMenu").blur();
      return false;
    }

    window.addEventListener("popstate", function(e) {
        Pagination("Kansai",location.pathname);
    }, false);

    <?if ( $Page != "#" && ($Page == 'index' || $Page == 'main') && !isset($_GET['page']) ) {?>
      Pagination("Главная", '/main');
    <?}?>
    <?if ( ($Page != "#" && $Page != 'index' && $Module != 'index' && $Page != 'main') || isset($_GET['page']) ) {?>
      Pagination("Kansai", '<?=$_SERVER['REQUEST_URI']?>');
    <?}?>
    // function LoaderOfAnime ( ID,number ) {
    //     var number = Number (number);
    //     $.ajax({
    //         url: '/handler/loadAnime',
    //         method: 'POST',
    //         data: {"startFrom" : number},
    //         beforeSend: function() {
    //           $( "#" + ID).hide();
    //           $("#" + ID + "-container > .preloader-wrapper" ).show();
    //         }}).done(function(data){
    //           if ( data == "error" ) {
    //             $( "#" + ID).remove();
    //             $("#" + ID + "-container" ).remove();
    //           }else {
                
    //             $("#AnimeContent").append(data);
    //             number += 10;
    //             number = String (number);
    //             $( "#" + ID).attr('data-number',number);
    //             $("#" + ID + "-container > .preloader-wrapper" ).hide();
    //             $( "#" + ID).show();
    //           }
    //         });
    // }

    function LoaderOfComments ( ID,number, item ) {
        var number = Number (number);
        $.ajax({
            url: '/handler/LoaderOfComments',
            method: 'POST',
            data: {"startFrom" : number, "anime_post": item},
            beforeSend: function() {
              $( "#" + ID).hide();
            }}).done(function(data){
              if ( data == "error" ) {
                $( "#" + ID).hide();
              }else {
                  $("#comments").append(data);
                number += 10;
                number = String (number);
                $( "#" + ID).attr('data-number',number);
                $( "#" + ID).show();
              }
            });
    }

  <?php if (User::Root(3)): ?>
    function DeleteComment (ID, comt) {
      var comt = Number (comt);
      $.ajax({
        url: "/admin/handle/DeleteComment/1",
        method: "POST",
        cache: false,
        data: {"comt": comt},
        success: function(data){
          if (data == "true"){
            $("#" + ID).remove();
            toast("Комментарий успешно удалён");
          }else {
            toast("Комментарий не удалось удалить");
            console.log(data);
          }
        }
      });
    }
  <?php endif ?>
  </script>
</body>
</html>