<?php

/**
 * licenseCharsPlaces form base class.
 *
 * @method licenseCharsPlaces getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BaselicenseCharsPlacesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'license_id'  => new sfWidgetFormPropelChoice(array('model' => 'license', 'add_empty' => false)),
      'chars_count' => new sfWidgetFormInputText(),
      'date_end'    => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'license_id'  => new sfValidatorPropelChoice(array('model' => 'license', 'column' => 'id')),
      'chars_count' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'date_end'    => new sfValidatorString(array('max_length' => 255)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('license_chars_places[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'licenseCharsPlaces';
  }


}
