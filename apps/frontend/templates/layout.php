<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>

    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <link rel="shortcut icon" href="/images/icon.png"/>
    
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?84"></script>
    <script type="text/javascript">
      VK.init({apiId: 3119759, onlyWidgets: true});
    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  </head>
  <body>
    <div class="container">

      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="<?php echo url_for('@homepage') ?>">
              KEmulator Mobitva bot
            </a>
            <ul class="nav">
              <li class="active">
                <a href="<?php echo url_for('@homepage') ?>">Главная</a>
              </li>
<!--              <li><a href="<?php echo url_for('@configs') ?>">Конфиги</a></li>-->

<!--              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Помощь<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo url_for('@kemulatorManual') ?>">Настройка Кемулятора</a></li>
                  <li><a href="<?php echo url_for('@manual') ?>">Настройка бота</a></li>
                  <li><a href="<?php echo url_for('@commands') ?>">Описание команд</a></li>
                                                      <li><a href="#">Оплата, условия</a></li>
                  <li class="divider"></li>
                  <li>
                    <a href="<?php echo url_for('@faq') ?>">FAQ</a>
                  </li>
                </ul>
              </li>-->

              <li><a href="<?php echo url_for('@contactComments') ?>">Обсуждение</a></li>
              <?php if (!$sf_user->isAnonymous()): ?>
                <li><a href="<?php echo url_for('@sf_guard_signout') ?>">Выход</a></li>
              <?php else: ?>
                <li><a href="<?php echo url_for('@sf_guard_signin') ?>">Вход</a></li>
                <li><a href="<?php echo url_for('@register') ?>">Регистрация</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="span3">

          <div class="user-corner">

            <div class="h-container" style="padding-left: 0px;">
              <center><h3>Личный Кабинет</h3></center>
            </div>
            <div class="separator-r" style="padding: 5px;"></div>
            <?php if ($sf_user->isAnonymous()): ?>

              Авторизируйтесь, чтобы получить доспуп ко всем фунциям сайта.
              <div style="clear: right; padding: 5px;"></div>
            <?php endif; ?>

            <?php if (!$sf_user->isAnonymous()): ?>
              <div class="username">
                <?php echo $sf_user->getGuardUser()->getUserName(); ?>
                <br />
                <?php $ballance = $sf_user->getGuardUser()->getProfile()->getBalance(); ?>
                баланс : <?php echo empty($ballance) ? '0' : $ballance; ?> руб.
              </div>
              <div class="btn-group right">
                <a href="<?php echo url_for('@sf_guard_signout') ?>" class="btn btn-primary">Выйти</a>
              </div>
              <?php $license = licensePeer::getUserLicense($sf_user->getGuardUser()->getId()); ?>

              <div class="separator-r" style="padding: 5px;"></div>
              <?php if (!$license): ?>

                <div class="alert alert-danger">
                  Внимание! У Вас еще нет лицензии на использование бота.
                </div>
              <?php else: ?>
                <?php if (strtotime($license->getDateEnd()) < time()): ?>
                  <div class="alert alert-danger">
                    Внимание! Текущая лицензия нуждается в продлении.
                  </div>
                <?php endif; ?>

                <table class="table table-striped table-bordered">
                  <tbody>
                    <tr>
                      <td>№ Лицензии</td>
                      <td><?php echo $license->getId(); ?></td>
                    </tr>
                    <tr>
                      <td>Состояние</td>
                      <td>
                        <?php echo (strtotime($license->getDateEnd()) > time()) ? 'активна' : 'необходимо продлить'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Дата окончания</td>
                      <td><?php echo $license->getDateEnd(); ?></td>
                    </tr>
                    <tr>
                      <td>Количество копий</td>
                      <td><?php echo licenseCharsPlacesPeer::getCountCharsByLicenseId($license->getId()); ?></td>
                    </tr>
                  </tbody>
                </table>

                <a href="<?php echo url_for('@downloadList') ?>" class="btn user-menu-button">Скачать бота</a>
                <a href="#" class="btn user-menu-button">Управление счетом</a>
                <a href="<?php echo url_for('@my_configs') ?>" class="btn user-menu-button">Управление конфигами</a>

              <?php endif; ?>

              <?php if ($license): ?>
                <a href="<?php echo url_for('@license') ?>" class="btn user-menu-button">
                  Управление лицензией
                </a>
              <?php else: ?>
                <a href="<?php echo url_for('@add_days') ?>" class="btn user-menu-button">
                  Купить лицензию
                </a>
              <?php endif; ?>

            <?php else: ?>
              <div class="btn-group right">
                <a href="<?php echo url_for('@sf_guard_signin') ?>" class="btn btn-primary">Вход</a>
                <a href="<?php echo url_for('@register') ?>" class="btn btn-inverse">Регистрация</a>
              </div>
            <?php endif; ?>
            <div class="separator-r" style="padding: 5px;"></div>
          </div>
        </div>
        <div class="span9">
          <div class="content">
            <?php echo $sf_content ?>
          </div>
        </div>
      </div>
      <div class="navbar">
        <div class="navbar-inner">
          <div class="container" style="padding: 10px;">
            <center>
            <?php
            $quotesArray = array(
              '«Мы распяты на циферблате часов.» <a target="_blank" href="http://ru.wikipedia.org/wiki/%D0%9B%D0%B5%D1%86,_%D0%A1%D1%82%D0%B0%D0%BD%D0%B8%D1%81%D0%BB%D0%B0%D0%B2_%D0%95%D0%B6%D0%B8">Ежи Лец С.</a>',
              '«Хорошее употребление времени делает время еще более драгоценным.» <a target="_blank" href="http://ru.wikipedia.org/wiki/%D0%A0%D1%83%D1%81%D1%81%D0%BE,_%D0%96%D0%B0%D0%BD-%D0%96%D0%B0%D0%BA">Руссо Ж.</a>',
              '«Счастливые часов не наблюдают» <a target="_blank" href="http://ru.wikipedia.org/wiki/%D0%93%D1%80%D0%B8%D0%B1%D0%BE%D0%B5%D0%B4%D0%BE%D0%B2,_%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B5%D0%B2%D0%B8%D1%87">Грибоедов А.</a>',
              '«Ничем не может человек распорядиться в большей степени, чем временем.» <a target="_blank" href="http://ru.wikipedia.org/wiki/%D0%A4%D0%B5%D0%B9%D0%B5%D1%80%D0%B1%D0%B0%D1%85,_%D0%9B%D1%8E%D0%B4%D0%B2%D0%B8%D0%B3_%D0%90%D0%BD%D0%B4%D1%80%D0%B5%D0%B0%D1%81">Фейербах Л.</a>',
              '«Когда у человека много свободного времени, он немногого достигнет.» <a target="_blank" href="http://ru.wikipedia.org/wiki/%D0%A1%D1%8E%D0%BD%D1%8C%D1%86%D0%B7%D1%8B">Сюньцзы</a>',
              '«Час ребенка длиннее, чем день старика.» <a target="_blank" href="http://ru.wikipedia.org/wiki/%D0%A8%D0%BE%D0%BF%D0%B5%D0%BD%D0%B3%D0%B0%D1%83%D1%8D%D1%80_%D0%90.">Шопенгауэр А.</a>',
            );
            echo $quotesArray[rand(0, count($quotesArray) - 1)];
            ?>
          </center>
          </div>
        </div>
      </div>
    </div>

    <?php
    if (false) {
      for ($i = 0; $i <= 19; $i++) {
        $sa = array();
        $sa[] = substr(md5(microtime()), 1, 1);
        $sa[] = substr(md5(microtime()), 1, 1);
        $sa[] = substr(md5(microtime()), 1, 1);
        $sa[] = substr(md5(microtime()), 1, 1);
        $sa[] = substr(md5(microtime()), 1, 1);
        $sa[] = substr(md5(microtime()), 1, 1);
        $sa[] = substr(md5(microtime()), 1, 1);
        echo implode('', $sa) . '<br />';
      }
    }
    ?>
  </body>
</html>
