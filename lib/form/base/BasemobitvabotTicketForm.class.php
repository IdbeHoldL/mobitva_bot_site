<?php

/**
 * mobitvabotTicket form base class.
 *
 * @method mobitvabotTicket getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasemobitvabotTicketForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'user_id'         => new sfWidgetFormPropelChoice(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'ticket_group_id' => new sfWidgetFormPropelChoice(array('model' => 'mobitvabotTicketGroup', 'add_empty' => false)),
      'is_new'          => new sfWidgetFormInputCheckbox(),
      'is_public'       => new sfWidgetFormInputCheckbox(),
      'is_closed'       => new sfWidgetFormInputCheckbox(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'user_id'         => new sfValidatorPropelChoice(array('model' => 'sfGuardUser', 'column' => 'id')),
      'ticket_group_id' => new sfValidatorPropelChoice(array('model' => 'mobitvabotTicketGroup', 'column' => 'id')),
      'is_new'          => new sfValidatorBoolean(),
      'is_public'       => new sfValidatorBoolean(),
      'is_closed'       => new sfValidatorBoolean(),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorString(array('max_length' => 255)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobitvabot_ticket[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'mobitvabotTicket';
  }


}
