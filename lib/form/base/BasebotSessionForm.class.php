<?php

/**
 * botSession form base class.
 *
 * @method botSession getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasebotSessionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'user_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'access_key'   => new sfWidgetFormInputText(),
      'connect_ip'   => new sfWidgetFormInputText(),
      'hardware_key' => new sfWidgetFormInputText(),
      'is_closed'    => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'      => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'access_key'   => new sfValidatorString(array('max_length' => 255)),
      'connect_ip'   => new sfValidatorString(array('max_length' => 255)),
      'hardware_key' => new sfValidatorString(array('max_length' => 255)),
      'is_closed'    => new sfValidatorBoolean(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('bot_session[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'botSession';
  }


}
