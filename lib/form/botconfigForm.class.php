<?php

/**
 * botconfig form.
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
class botconfigForm extends BasebotconfigForm {
  
  public $labelsTexts = array(
    'description' => array(
      'label' => 'Описание конфига',
      'tooltip' => 'Старайтесь делать подробное описание, если собираетесь продавать свой конфиг.
        Укажите примеры использования. Описание должно быть максимально подробным,
        чтобы другой пользователь легко смог разобраться'
    ),
    'name' => array('label' => 'Имя','tooltip' => '',),
    'body' => array('label' => 'Текст конфига','tooltip' => 'Опишите последовательность действий бота',),
    
  );

  public function addTooltip($tooltipText, $tooltipPlacement = 'top', $linkText = '(?)') {
    if ($tooltipText == ''){
      return '';
    }
    $tooltip = '<a href="#" 
      class="tooltip-link" 
      data-placement="%tooltipPlacement%" 
      data-original-title="%tooltipText%">%linkText%</a>';

    $tooltip = str_replace('%tooltipText%', $tooltipText, $tooltip);
    $tooltip = str_replace('%tooltipPlacement%', $tooltipPlacement, $tooltip);
    $tooltip = str_replace('%linkText%', $linkText, $tooltip);
    
    return $tooltip;
    
  }
  
  public function addTooltips(){
    foreach ($this->labelsTexts as $fieldName => $label){
      $this->widgetSchema->setLabel($fieldName, $label['label'] . ' ' . $this->addTooltip($label['tooltip']));
    }
  }

  public function configure() {

    $this->setWidgets(array(
      'id' => new sfWidgetFormInputHidden(),
      'user_id' => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'name' => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(array(),array('rows'=>10,'cols'=>100)),
      'body' => new sfWidgetFormTextarea(array(),array('rows'=>50,'cols'=>100)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id' => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'name' => new sfValidatorString(array('max_length' => 255)),
      'description' => new sfValidatorString(),
      'body' => new sfValidatorString(),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('botconfig[%s]');

//    $this->widgetSchema->setLabel('is_protected', 'Защишен ' . $this->addTooltip('asdasdasdasd'));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->addTooltips();

    parent::configure();

    $this->wantedFields = array(
      'name',
      'description',
      'body',
    );

    foreach ($this as $fieldName => $widget) {
      if (!in_array($fieldName, $this->wantedFields)) {
        unset($this->widgetSchema[$fieldName]);
        unset($this->validatorSchema[$fieldName]);
      }
    }
  }

}
