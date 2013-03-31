<?php

/**
 * mobitvabotConfig form base class.
 *
 * @method mobitvabotConfig getObject() Returns the current form's model object
 *
 * @package    mobitva
 * @subpackage form
 * @author     Your name here
 */
abstract class BasemobitvabotConfigForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'creator_name'    => new sfWidgetFormInputText(),
      'name'            => new sfWidgetFormInputText(),
      'description'     => new sfWidgetFormTextarea(),
      'config_text'     => new sfWidgetFormTextarea(),
      'config_group_id' => new sfWidgetFormPropelChoice(array('model' => 'mobitvabotConfigGroup', 'add_empty' => false)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'creator_name'    => new sfValidatorString(array('max_length' => 255)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'description'     => new sfValidatorString(),
      'config_text'     => new sfValidatorString(),
      'config_group_id' => new sfValidatorPropelChoice(array('model' => 'mobitvabotConfigGroup', 'column' => 'id')),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobitvabot_config[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'mobitvabotConfig';
  }


}
