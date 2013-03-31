<?php

/**
 * balanceOperation filter form base class.
 *
 * @package    mobitva
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasebalanceOperationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_id'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'user_id'        => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'sum'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'operation_data' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'additional'     => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'type_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'user_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'sum'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'operation_data' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'additional'     => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('balance_operation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'balanceOperation';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'type_id'        => 'Number',
      'user_id'        => 'ForeignKey',
      'sum'            => 'Number',
      'operation_data' => 'Number',
      'additional'     => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
