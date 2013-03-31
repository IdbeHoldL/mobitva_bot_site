<?php

/**
 * crosConfigCategory form base class.
 *
 * @method crosConfigCategory getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasecrosConfigCategoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'botconfig_id'       => new sfWidgetFormPropelChoice(array('model' => 'botconfig', 'add_empty' => false)),
      'config_category_id' => new sfWidgetFormPropelChoice(array('model' => 'configCategory', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'botconfig_id'       => new sfValidatorPropelChoice(array('model' => 'botconfig', 'column' => 'id')),
      'config_category_id' => new sfValidatorPropelChoice(array('model' => 'configCategory', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cros_config_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'crosConfigCategory';
  }


}
