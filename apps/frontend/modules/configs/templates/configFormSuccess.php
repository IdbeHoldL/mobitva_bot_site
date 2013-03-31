<?php use_helper('I18N'); ?>
<?php if (isset($message) && $message != ''): ?>
  <div class="alert alert-info">
    <?php echo $message; ?>
  </div>
<?php endif; ?>
<form method="POST" action="">
  <div style="float:right; padding: 5px; margin-bottom: 5px; border: solid 1px; width: 35%; margin-right: 3%;">
    <h5>Прикрепить конфиги:</h5>
    <div style="max-height: 200px; overflow: scroll; overflow-x: hidden;">
      <?php foreach ($userConfigs as $userConfig): ?>
        <?php $has_relation = false; ?>
        <?php if (!$configForm->isNew() && botconfigRelationsPeer::checkRelation($botconfig->getId(), $userConfig->getId())): ?>
          <?php $has_relation = true; ?>
        <?php endif; ?>

        <?php if (!isset($botconfig) || $botconfig->getId() != $userConfig->getId()): ?>
          <div class="relation relation_<?php echo ($has_relation) ? 'true' : 'false'; ?>">         
            <input type="hidden" name="relations[<?php echo $userConfig->getId(); ?>]" value="<?php echo ($has_relation) ? 'true' : 'false'; ?>" />
            <div class="tooltip-config" style="margin-left: 10px;" data-placement="left" data-original-title="<?php echo $userConfig->getDescription(); ?>">
              <?php echo $userConfig->getName(); ?>
            </div>
          </div>
        <?php endif; ?>

      <?php endforeach; ?>
    </div>
  </div>


  <?php $configForm->renderHiddenFields(); ?>

  <table class="table table-striped table-bordered" style="width: 60%; min-width: 650px;">
    <thead>
      <tr>
        <td colspan="4">
          <h3>
            <?php if (!$configForm->isNew()): ?>
              Редактирование конфига <?php echo $configId; ?>
            <?php else: ?>
              Создание конфига
            <?php endif; ?>
          </h3>
        </td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($configForm as $field): ?>
        <tr>
          <td colspan="4">
            <?php echo $field->getWidget()->getOption('label'); ?>
            <?php if ($field->getError()): ?>
              <div class="alert alert-danger" style="float: right;">
                <?php echo __($field->getError()->getMessageFormat(), $field->getError()->getArguments()); ?>
              </div>
            <?php endif; ?>
            <div style="margin-bottom: 7px; padding: 0;" class="separator-l separator-r"></div>
            <?php echo $field->render(); ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <input type="submit" value="Сохранить"/>
</form>
<script type="text/javascript">
  $('.tooltip-link').tooltip();
  $('.tooltip-config').tooltip();
  $('.tooltip-link').click(function(){
    return false;
  });
  
  $('.relation').click(function(){
    
    console.log('click');
    
    var current_value = $(this).find('input').first().val();
    var value = (current_value == 'true') ? 'false' : 'true';
    $(this).find('input').first().val(value);
    $(this).removeClass('relation_' + current_value);
    $(this).addClass('relation_' + value);
  });
</script>
