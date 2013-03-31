<?php

/**
 * botconfig form base class.
 *
 * @method botconfig getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasebotconfigForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'name'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormTextarea(),
      'body'        => new sfWidgetFormTextarea(),
      'price'       => new sfWidgetFormInputText(),
      'price_koef'  => new sfWidgetFormInputText(),
      'is_approved' => new sfWidgetFormInputCheckbox(),
      'is_global'   => new sfWidgetFormInputCheckbox(),
      'is_editable' => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'description' => new sfValidatorString(),
      'body'        => new sfValidatorString(),
      'price'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'price_koef'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'is_approved' => new sfValidatorBoolean(array('required' => false)),
      'is_global'   => new sfValidatorBoolean(array('required' => false)),
      'is_editable' => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('botconfig[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'botconfig';
  }


}
