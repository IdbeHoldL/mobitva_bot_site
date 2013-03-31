<?php

/**
 * licenseCharsPlaces filter form base class.
 *
 * @package    mobitva
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaselicenseCharsPlacesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'license_id'  => new sfWidgetFormPropelChoice(array('model' => 'license', 'add_empty' => true)),
      'chars_count' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_end'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'license_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'license', 'column' => 'id')),
      'chars_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date_end'    => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('license_chars_places_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'licenseCharsPlaces';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'license_id'  => 'ForeignKey',
      'chars_count' => 'Number',
      'date_end'    => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
