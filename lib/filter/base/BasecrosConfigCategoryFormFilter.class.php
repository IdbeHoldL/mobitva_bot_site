<?php

/**
 * crosConfigCategory filter form base class.
 *
 * @package    mobitva
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasecrosConfigCategoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'botconfig_id'       => new sfWidgetFormPropelChoice(array('model' => 'botconfig', 'add_empty' => true)),
      'config_category_id' => new sfWidgetFormPropelChoice(array('model' => 'configCategory', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'botconfig_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'botconfig', 'column' => 'id')),
      'config_category_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'configCategory', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cros_config_category_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'crosConfigCategory';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'botconfig_id'       => 'ForeignKey',
      'config_category_id' => 'ForeignKey',
    );
  }
}
