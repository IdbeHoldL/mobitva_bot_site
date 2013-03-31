<?php

/**
 * mobitvabotTransaction form base class.
 *
 * @method mobitvabotTransaction getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasemobitvabotTransactionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'user_id'      => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'price'        => new sfWidgetFormInputText(),
      'md5hash'      => new sfWidgetFormInputText(),
      'details'      => new sfWidgetFormTextarea(),
      'is_confirmed' => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'      => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'price'        => new sfValidatorString(array('max_length' => 50)),
      'md5hash'      => new sfValidatorString(array('max_length' => 255)),
      'details'      => new sfValidatorString(),
      'is_confirmed' => new sfValidatorBoolean(),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobitvabot_transaction[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'mobitvabotTransaction';
  }


}
