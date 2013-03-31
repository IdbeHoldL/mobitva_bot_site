<div class="h-container">
  <h2>Лицензия</h2>
</div>
<br />
<table class="table table-bordered">
  <thead>
    <tr>
      <td>№ лицензии</td>
      <td>Состояние</td>
      <td>Дата окончания</td>
      <td>Макс. копий запущенных одновременно:</td>
    <tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $license->getId(); ?></td>
      <td><?php echo (strtotime($license->getDateEnd()) > time()) ? '<span class="green">активна<span>' : '<span class="red">просрочена, необходимо продлить<span>'; ?></td>
      <td><?php echo $license->getDateEnd(); ?></td>
      <td>
        <?php echo licenseCharsPlacesPeer::getCountCharsByLicenseId($license->getId()); ?>
      </td>
    <tr>
  </tbody>
</table>

<a href="<?php echo url_for("@add_chars") ?>" class="btn user-menu-button" style="width: 250px; float: right">Увеличить макс. количество копий</a>
<a href="<?php echo url_for("@add_days") ?>" class="btn user-menu-button" style="width: 250px; float: right">Продлить лицензию</a>
<div class="separator-r" style="padding: 5px;"></div>
<div class="separator-l" style="padding: 5px;"></div>


<div class="alert alert-info">
  Полезно знать:
  <ul>

    <li>
      <i><b>Продление лицензии</b></i>, на несколько месяцев вперед, более выгодно.
    </li>
    <li>
      <i><b>Продлевая лицензию</b></i>, до окончания ее срока действия, 
      Вы получаете <b><?php echo sfConfig::get('app_bot_pre_end_discount'); ?>% скидку</b>
    </li>
    <li>
      <i><b>Продлевая лицензию</b></i>, Вы отодвигаете дату ее окончания на заданный промежуток времени, 
      независимо от того, на сколько она уже была просрочена.
    </li>
    <li>
      <i><b>Макс. копий запущенных одновременно</b></i> - расширение лицензии, позволяет запускать 
      одновременно несколько копий бота и качать сразу несколько персонажей. (изначально разрешено 
      запускать одновременно только одну копию программы)
    </li>
  </ul>
</div>



