<?php

/**
 * licenseChar form base class.
 *
 * @method licenseChar getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BaselicenseCharForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'license_id' => new sfWidgetFormPropelChoice(array('model' => 'license', 'add_empty' => false)),
      'name'       => new sfWidgetFormInputText(),
      'hash'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'license_id' => new sfValidatorPropelChoice(array('model' => 'license', 'column' => 'id')),
      'name'       => new sfValidatorString(array('max_length' => 255)),
      'hash'       => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('license_char[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'licenseChar';
  }


}
