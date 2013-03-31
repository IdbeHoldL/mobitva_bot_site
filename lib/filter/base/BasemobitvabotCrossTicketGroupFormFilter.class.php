<?php

/**
 * mobitvabotCrossTicketGroup filter form base class.
 *
 * @package    mobitva
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasemobitvabotCrossTicketGroupFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'group_id'    => new sfWidgetFormPropelChoice(array('model' => 'mobitvabotTicketGroup', 'add_empty' => true)),
      'ticket_id'   => new sfWidgetFormPropelChoice(array('model' => 'mobitvabotTicket', 'add_empty' => true)),
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'group_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'mobitvabotTicketGroup', 'column' => 'id')),
      'ticket_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'mobitvabotTicket', 'column' => 'id')),
      'name'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('mobitvabot_cross_ticket_group_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'mobitvabotCrossTicketGroup';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'group_id'    => 'ForeignKey',
      'ticket_id'   => 'ForeignKey',
      'name'        => 'Text',
      'description' => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
