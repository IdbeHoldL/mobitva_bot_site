<div class="h-container">
    <h2>Список конфигов</h2>
</div>
<br />

<?php if (count($configs)): ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 70px;">Категория</th>
                <th>Автор</th>
                <th>Название</th>
                <th style="width: 70px;"></th>
                <th style="width: 70px;"></th>
            </tr>
        </thead>
        <?php $i = 0;?>
        <?php foreach ($configs as $config): ?>
            <tr>
                <td><?php echo $config->getmobitvabotConfigGroup()->getName()?></td>
                <td><?php echo $config->getCreatorName()?></td>
                <td><?php echo $config->getDescription()?></td>
                <td>
                    <a class="btn" href="<?php echo url_for2('config', $params = array('id' => $config->getId()))?>">
                       Смотреть 
                    </a>
                    
                    
                </td>
                <td>
                    <div id="<?php echo 'config'.md5($config->getId())?>"></div>
                    <script type="text/javascript">
                        VK.Widgets.Like("<?php echo 'config'.md5($config->getId())?>", {type: "vertical", height: 18});
                    </script>
                </td>
                
            </tr>
        <?php endforeach; ?>
            
    </table>
<?php else:?>
<div class="alert alert-danger"> Тут пока нет ни одного конфига</div>
<?php endif; ?>
