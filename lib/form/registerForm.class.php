<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class registerForm extends baseForm
{
  public function configure()
  {
      
    $this->setWidgets(array(
      'username' => new sfWidgetFormInputText(),
      'userpass'  => new sfWidgetFormInputPassword(),
      'confirm_userpass'  => new sfWidgetFormInputPassword(),
      'captcha' => new sfWidgetCaptchaGD(),
    ));

    $this->setValidators(array(
      'username' => new sfValidatorEmail(array('min_length' => 6, 'max_length' => 50, 'required' => true)),
      'userpass'  => new sfValidatorString(array('min_length' => 6, 'max_length' => 50, 'required' => true)),
      'confirm_userpass'  => new sfValidatorString(array('min_length' => 6, 'max_length' => 50, 'required' => true)),
      'captcha' => new sfCaptchaGDValidator(array('length' => 4)),
    ));
    
    $this->widgetSchema->setNameFormat('register[%s]');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    parent::setup();
    
  }
  
  
  
}

?>