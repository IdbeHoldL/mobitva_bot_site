<?php

/**
 * mobitvabotCrossTicketGroup form base class.
 *
 * @method mobitvabotCrossTicketGroup getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasemobitvabotCrossTicketGroupForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'group_id'    => new sfWidgetFormPropelChoice(array('model' => 'mobitvabotTicketGroup', 'add_empty' => false)),
      'ticket_id'   => new sfWidgetFormPropelChoice(array('model' => 'mobitvabotTicket', 'add_empty' => false)),
      'name'        => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'group_id'    => new sfValidatorPropelChoice(array('model' => 'mobitvabotTicketGroup', 'column' => 'id')),
      'ticket_id'   => new sfValidatorPropelChoice(array('model' => 'mobitvabotTicket', 'column' => 'id')),
      'name'        => new sfValidatorString(array('max_length' => 50)),
      'description' => new sfValidatorString(array('max_length' => 255)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobitvabot_cross_ticket_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'mobitvabotCrossTicketGroup';
  }


}
