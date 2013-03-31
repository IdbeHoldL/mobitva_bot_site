<?php

/**
 * configs actions.
 *
 * @package    mobitva
 * @subpackage configs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class configsActions extends sfActions {

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {

    if ($this->getUser()->isAnonymous()) {
      $this->redirect('index/index');
    }

    $this->userId = $this->getUser()->getProfile()->getId();
    $this->configCategoriesForButton = configCategoryPeer::doSelect(new Criteria());

    $this->userConfigs = botconfigPeer::getUserConfigs($this->userId);
    $this->userAddedConfig = botconfigPeer::getUserAddedConfigs($this->userId);

//    var_dump($this->userAddedConfig);
  }

  public function executeConfigForm($request) {

    if ($this->getUser()->isAnonymous()) {
      $this->redirect('index/index');
    }

    $this->getUser()->setCulture('ru');
    $this->userId = $this->getUser()->getProfile()->getId();
    $this->userConfigs = botconfigPeer::getUserConfigs($this->userId);

    $this->setLayout('without_left_column');

    if ($this->configId = $request->getParameter('id')) {
      if ($this->botconfig = botconfigPeer::retrieveByPK($this->configId)) {
        $this->configForm = new botconfigForm($this->botconfig);
      } else {
        $this->redirect404();
      }
    } else {
      $this->configForm = new botconfigForm();
    }

    if ($request->isMethod(sfRequest::POST)) {

      $formFields = $request->getParameter('botconfig');
      $this->configForm->bind($formFields);

      if ($this->configForm->isValid()) {

        if ($this->configForm->isNew()) {
          $botConfig = new botconfig();
          $botConfig->setUserId($this->userId);

          $configForm = new botconfigForm($botConfig);
          $configForm->bind($formFields);
          $configForm->save();
          $botconfig = $configForm->getObject();
        }else{
          $this->configForm->save();
          $botconfig = $this->configForm->getObject();
        }
        
        
        // связи конфигов
        if ($relations = $request->getParameter('relations')) {
          $this->setRelation($botconfig->getId(), $relations);
        }

        $this->message = 'Изменения сохранены';
      }
    }
  }

  public function executeConfigShop() {

//    $this->shopConfigs = botconfigPeer::getShopConfigs($this->userId);
  }

  public function setRelation($parentId, $relations) {

    foreach ($relations as $key => $relation) {
      $hasRelation = botconfigRelationsPeer::checkRelation($parentId, $key);
      if ($relation == 'true' && !$hasRelation) {
        // задаем связи для конфига  
        $botconfigRelations = new botconfigRelations();
        $botconfigRelations->setParentBotconfigId($parentId);
        $botconfigRelations->setBotconfigId($key);
        $botconfigRelations->save();
      } elseif ($relation == 'false' && $hasRelation) {
        // удаляем ненужные связи  
        $botconfigRelations = botconfigRelationsPeer::getByParentIdAndConfigId($parentId, $key);        
        $botconfigRelations->delete();
      }
    }
  }

}
