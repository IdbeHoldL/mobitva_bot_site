<div class="h-container">
  <h2>Управление конфигами</h2>
</div>
<br />
<div class="h-container">
  <h3>Мои конфиги</h3>
</div>
<br />

<?php if (!count($userConfigs)): ?>
<a target="_blank" href="<?php echo url_for2('config_new'); ?>" class="btn">Создать</a>
  <br />
  <br />
  <div class="alert alert-info">У Вас нет своих конфигов</div>
  
<?php else: ?>
  <div class="config_tags_filter">
    <a href="#" id="my_config_all" class="btn btn-mini btn-primary">Все</a>
    <?php foreach ($configCategoriesForButton as $configCategory): ?>
      <?php if ($configCategoriesForButton[0] == $configCategory)
        continue ?>
      <a href="#" class="btn btn-mini my_config_category_filter" config_category_id="<?php echo $configCategory->getId() ?>">
        <?php echo $configCategory->getName() ?>
      </a>
    <?php endforeach; ?>
    <a href="#" id="my_config_empty_category" class="btn btn-mini">Без тегов</a>
  </div>
  <div class="separator-l" style="padding: 5px;"></div>
  <table class="table table-bordered table-striped my_configs_table">
    <thead>
    <td>id конфига</td>
    <td>Название</td>
    <td>Описание</td>
    <td>Количество продаж / установок</td>
    <td>
      Действия
      <br />
      <div class="separator-l"></div>
      <a target="_blank" href="<?php echo url_for2('config_new'); ?>" class="btn">Создать</a>
    </td>
  </thead>
  <tbody>
    <?php /* @var $config botconfig */ ?>
    <?php foreach ($userConfigs as $config): ?>
      <?php $configCategories = $config->getcrosConfigCategorysJoinconfigCategory(); ?>
      <?php $categoryIds = array(); ?>
      <?php foreach ($configCategories as $configCategory): ?>
        <?php $categoryIds[] = $configCategory->getId(); ?>
      <?php endforeach; ?>
      <tr config_categories="<?php echo implode('-', $categoryIds); ?>">
        <td>
          <?php echo $config->getId(); ?>
        </td>
        <td><?php echo $config->getName(); ?></td>
        <td><?php echo $config->getDescription(); ?></td>
        <td>
          <?php echo count($config->getcrosUserConfigs()); ?>
        </td>
        <td>
          <a target="_blank" href="<?php echo url_for2('config_edit', array('id' => $config->getId())); ?>" class="btn btn-mini">редактировать</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>  
<?php endif; ?>

<div class="h-container">
  <h3>Добавленные/купленные конфиги</h3>
</div>
<br />

<?php if (!count($userAddedConfig)): ?>
  <div class="alert alert-info">У Вас нет добавленных или купленных конфигов</div>
<?php else: ?>
  <div class="config_tags_filter">
    <a href="#" id="config_all" class="btn btn-mini btn-primary">Все</a>
    <?php foreach ($configCategoriesForButton as $configCategory): ?>
      <?php if ($configCategoriesForButton[0] == $configCategory)
        continue ?>
      <a href="#" class="btn btn-mini config_category_filter" config_category_id="<?php echo $configCategory->getId() ?>">
        <?php echo $configCategory->getName(); ?>
      </a>
    <?php endforeach; ?>
    <a href="#" id="config_empty_category" class="btn btn-mini">Без тегов</a>
  </div>
  <div class="separator-l" style="padding: 5px;"></div>
  <table class="table table-bordered table-striped configs_table">
    <thead>
    <td>id конфига</td>
    <td>Автор</td>
    <td>Название</td>
    <td>Описание</td>
    <td>Цена<a href="#" class="tooltip-link" data-original-title="Цена лицензии на использования Вашего конфига в течении месяца">&nbsp(?)</a></td>
    <td>Дата окончания лицензии:</td>
    <td>Действия</td>
  </thead>
  <tbody>
    <?php /* @var $config botconfig */ ?>
    <?php foreach ($userAddedConfig as $config): ?>
      <?php $configCategories = $config->getcrosConfigCategorysJoinconfigCategory(); ?>
      <?php $categoryIds = array(); ?>
      <?php foreach ($configCategories as $configCategory): ?>
        <?php $categoryIds[] = $configCategory->getId(); ?>
      <?php endforeach; ?>
      <tr config_categories="<?php echo implode('-', $categoryIds); ?>">
        <td>
          <?php echo $config->getId(); ?>
        </td>
        <td><?php echo $config->getConfigStatus()->getName(); ?></td>
        <td><?php echo $config->getName(); ?></td>
        <td><?php echo $config->getDescription(); ?></td>
        <td><?php echo $config->getPrice(); ?>руб. в месяц</td>
        <td nowrap>
          <?php $crosUserConfigs = $config->getcrosUserConfigsJoinsfGuardUser(); ?>
          <?php $dateEnd = $crosUserConfigs[0]->getDateEnd(); ?>
          <?php if ($dateEnd == ''): ?>
            <div class="nobr">Не задана</div>
          <?php elseif ($dateEnd < date('Y-m-d')): ?>
            <div class="nobr"><b>Просрочена </b></div>
          <?php else: ?>
            <div class="nobr"><?php echo $dateEnd ?></div>
          <?php endif; ?>
        </td>
        <td></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>  
<?php endif; ?>


<script type="text/javascript">

  $(function(){
    $('.tooltip-link').tooltip();
    $('.tooltip-link').click(function(){return false});
      
    $('#my_config_all').click(function(){
      $('.my_config_category_filter').removeClass('btn-primary');
      $('#my_config_empty_category').removeClass('btn-primary');
      $('#my_config_all').addClass('btn-primary');
      $('.my_configs_table tbody tr').show();
      return false;
    });
    
    $('#my_config_empty_category').click(function(){
      $('.my_config_category_filter').removeClass('btn-primary');
      $('#my_config_empty_category').addClass('btn-primary');
      $('.my_configs_table tbody tr').hide();
      $('.my_configs_table tbody tr').each(function(){
        if ( $(this).attr('config_categories') == ''){
          $(this).show();
        }
      });
      return false;
    });
      
    $('.my_config_category_filter').click(function(){
      $('#my_config_all').removeClass('btn-primary');
      $('#my_config_empty_category').removeClass('btn-primary');
      $('.my_config_category_filter').removeClass('btn-primary');
      
      
      $('.my_configs_table tbody tr').hide();
      var that = $(this);
      $(this).addClass('btn-primary')
      $('.my_configs_table tbody tr').each(function(){
        
        if ( $(this).attr('config_categories') != ''){
          var categories_ids = $(this).attr('config_categories').split('-');
          for (i = 0; i<categories_ids.length; i++){

            if (categories_ids[i] == that.attr('config_category_id')){

              $(this).show();
            }
          }
        }

      });
      return false;
    });
      
  });

</script>

<script type="text/javascript">

  $(function(){
      
    $('#config_all').click(function(){
      $('.config_category_filter').removeClass('btn-primary');
      $('#config_empty_category').removeClass('btn-primary');
      $('#config_all').addClass('btn-primary');
      $('.configs_table tbody tr').show();
      return false;
    });
    
    $('#config_empty_category').click(function(){
      $('.config_category_filter').removeClass('btn-primary');
      $('#config_empty_category').addClass('btn-primary');
      $('.configs_table tbody tr').hide();
      $('.configs_table tbody tr').each(function(){
        if ( $(this).attr('config_categories') == ''){
          $(this).show();
        }
      });
      return false;
    });
      
    $('.config_category_filter').click(function(){
      $('#config_all').removeClass('btn-primary');
      $('#config_empty_category').removeClass('btn-primary');
      $('.config_category_filter').removeClass('btn-primary');
      
      
      $('.configs_table tbody tr').hide();
      var that = $(this);
      $(this).addClass('btn-primary')
      $('.configs_table tbody tr').each(function(){
        
        if ( $(this).attr('config_categories') != ''){
          var categories_ids = $(this).attr('config_categories').split('-');
          for (i = 0; i<categories_ids.length; i++){

            if (categories_ids[i] == that.attr('config_category_id')){

              $(this).show();
            }
          }
        }

      });
      return false;
    });
      
  });

</script>






