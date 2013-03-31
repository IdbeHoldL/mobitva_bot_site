<?php

/**
 * licenseChar filter form base class.
 *
 * @package    mobitva
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaselicenseCharFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'license_id' => new sfWidgetFormPropelChoice(array('model' => 'license', 'add_empty' => true)),
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hash'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'license_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'license', 'column' => 'id')),
      'name'       => new sfValidatorPass(array('required' => false)),
      'hash'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('license_char_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'licenseChar';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'license_id' => 'ForeignKey',
      'name'       => 'Text',
      'hash'       => 'Text',
    );
  }
}
