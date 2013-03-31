<?php

/**
 * botconfigRelations filter form base class.
 *
 * @package    mobitva
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasebotconfigRelationsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'botconfig_id'        => new sfWidgetFormPropelChoice(array('model' => 'botconfig', 'add_empty' => true)),
      'parent_botconfig_id' => new sfWidgetFormPropelChoice(array('model' => 'botconfig', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'botconfig_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'botconfig', 'column' => 'id')),
      'parent_botconfig_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'botconfig', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('botconfig_relations_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'botconfigRelations';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'botconfig_id'        => 'ForeignKey',
      'parent_botconfig_id' => 'ForeignKey',
    );
  }
}
