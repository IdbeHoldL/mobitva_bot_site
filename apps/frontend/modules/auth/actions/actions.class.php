<?php

/**
 * auth actions.
 *
 * @package    mobitvabot
 * @subpackage auth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeSignup(sfWebRequest $request){
        
      
      if ($this->getUser()->isAuthenticated()){
          $this->redirect('index/index');
      }
      
        $this->registerForm = new registerForm();
        
        $this->message = '';
        
        if ($request->isMethod(sfRequest::POST)){
//            $registrationFields = $request->getPostParameters();
            $registrationFields = $request->getParameter('register');
//            var_dump($registrationFields);
            $this->registerForm->bind($registrationFields);
            
            if ($this->registerForm->isValid())
            {
//                var_dump('valid');
                
                if ($registrationFields['userpass'] !== $registrationFields['confirm_userpass'])
                {
                    $this->message = "Введенные пароли не совпадают";
                    return sfView::SUCCESS; 
                }
                
                $email = $registrationFields['username'];
                $c = new Criteria();
                $c->add(sfGuardUserPeer::USERNAME, $email);
                $userProfile = sfGuardUserPeer::doSelectOne($c);
                
                if (isset($userProfile))
                {
                    $this->message = "Пользователь с таким имейлом уже существует";
                    return sfView::SUCCESS; 
                }else{
                    
                    $user = new sfGuardUser();
                    $user->setUsername($registrationFields['username']);
                    $user->setPassword($registrationFields['userpass']);                    
                    
                    $userProfile = new sfGuardUserProfile();
                    $userProfile->setsfGuardUser($user);
                    $userProfile->setAuthKey(sha1(microtime()));
                    $userProfile->save();
                    
                    if (date('Y-m-d') <= "2013-04-30"){
                      
                      $license = new license();
                      $license->setUserId($user->getId());
                      $license->setDateEnd('2013-04-30');
                      $license->save();
                      
                      $licenseCharsPlaces = new licenseCharsPlaces();
                      $licenseCharsPlaces->setLicenseId($license->getId());
                      $licenseCharsPlaces->setCharsCount(3);
                      $licenseCharsPlaces->setDateEnd("2013-04-30");
                      $licenseCharsPlaces->save();
                        
                      balanceOperationPeer::addAction($user->getId(), balanceOperationPeer::ADMIN_BONUS , 125.46, "125.46", "бонус от администрации (+125.46)");
                      balanceOperationPeer::addAction($user->getId(), balanceOperationPeer::BYE_LICENCE , 40.5, "40.5", "автопоупка лицензии (-40.5)");
                      balanceOperationPeer::addAction($user->getId(), balanceOperationPeer::ADD_CHARS , 84.96, "84.96", "добавление количества копий для запуска (-84.96)");
                      
                    }
                    
                    $this->registerForm->bind(array());
                    $this->message = 'Регистрация прошла успешно';
                    
                    if (date('Y-m-d') <= "2013-05-30"){
                      $this->message = 'Регистрация прошла успешно. Вы получили бонусную лицензию.';
                    }
                    
                    $this->getUser()->signin($user);
                    $this->redirect('index/index');
                    
                            
                }
                
                
                
                
            }else{
                
                
                
//                $error = new sfValidatorError();
//                $error->getMessage()
//                var_dump('not_valid');
                foreach( $this->registerForm->getErrorSchema()->getErrors() as $key => $error){
                    
                    if ($key == 'captcha'){
                        $this->message = 'Неправильно введен проверочный код';
                    }
                    
                    if ($key == 'userpass'){
                        $this->message = 'введите пароль от 6 до 50 символов';
                    }
                    
                    if ($key == 'username'){
                        $this->message = 'укажите e-mail вида user@exapmle.com, <br />
                            6-50 символов';
                    }
                    
//                    
//                    $this->message = $key.': '.$error->getMessage();
//                    break;
                }
            }
            
            
            
            
        }
        
        return sfView::SUCCESS;
    }
}
