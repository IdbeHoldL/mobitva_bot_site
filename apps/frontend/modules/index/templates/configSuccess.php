<?php if (count($config)):?>

<div class="h-container">
    <h2><?php echo $config->getName()?></h2>
</div>
<div class="autor_name right">
<b>Автор:</b> <?php echo $config->getCreatorName()?>
</div>
<div class="separator-r"></div>
<!--<p>Представляем Вашему вниманию Бота для Мобиты.</p>-->
<div class="h-container">
    <h3>Описание</h3>
</div>
<br />
<p>
    <?php echo  $config->getDescription() ?>
</p>

<pre>
<?php echo  $config->getConfigText() ?>
</pre>
<p>
    Не забудьте поставить лайк, если вам понравился этот конфиг.
</p>

<div id="<?php echo 'config'.md5($config->getId())?>"></div>
<script type="text/javascript">
    VK.Widgets.Like("<?php echo 'config'.md5($config->getId())?>", {type: "vertical", height: 18});
</script>

<?php endif; ?>
