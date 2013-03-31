<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>

    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>

    <link rel="shortcut icon" href="/images/icon.png"/>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  </head>
  <body>
    <div class="container">

      <div class="navbar">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand" href="<?php echo url_for('@homepage') ?>" onclick="return confirm('Вы уверены, что хотите покинуть страницу?');">
             KEmulator Mobitva bot
          </a>
          <ul class="nav">
            <li>
              <a href="#">Сохранить</a>
            </li>
            <li>
              <a href="#">Помошник</a>
            </li>
            <li>
              <a href="#">Команды</a>
            </li>
            <li>
              <a href="#">Справка</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="span12">
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
</body>
</html>
