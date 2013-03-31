<?php if (count($files)): ?>



  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <td style="width: 150px;">Файл</td>
        <td>Описание</td>
        <td>Счетчик</td>
        <td>Ссылка</td>
      </tr>
    </thead>

    <?php foreach ($files as $file): ?>
      <tr>
        <td><b><?php echo $file->getName() ?></b></td>
        <td><?php echo $file->getDescription() ?></td>
        <td><?php echo $file->getDownloads() ?></td>
        <td>
          <a href="<?php echo url_for('@download?file_id=' . $file->getId()) ?>" class="btn">Скачать</a>
        </td>

      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <div class="alert alert-danger"> Тут пока нет ни одного файла</div>
<?php endif; ?>
<a href="<?php echo url_for('@downloadAuthFile') ?>" class="btn" style="float:right">
  Скачать ключ-файл
</a>
  <div class="separator-r"></div>
<br />
<div class="alert alert-info">
  Не забудьте Скачать и скопировать ключ-файл в папку с ботом!
</div>