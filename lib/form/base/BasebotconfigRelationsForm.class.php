<?php

/**
 * botconfigRelations form base class.
 *
 * @method botconfigRelations getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasebotconfigRelationsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'botconfig_id'        => new sfWidgetFormPropelChoice(array('model' => 'botconfig', 'add_empty' => false)),
      'parent_botconfig_id' => new sfWidgetFormPropelChoice(array('model' => 'botconfig', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'botconfig_id'        => new sfValidatorPropelChoice(array('model' => 'botconfig', 'column' => 'id')),
      'parent_botconfig_id' => new sfValidatorPropelChoice(array('model' => 'botconfig', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('botconfig_relations[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'botconfigRelations';
  }


}
