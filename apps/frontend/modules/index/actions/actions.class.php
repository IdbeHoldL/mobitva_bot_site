<?php

/**
 * index actions.
 *
 * @package    mobitvabot
 * @subpackage index
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class indexActions extends sfActions {

  public function executeIndex(sfWebRequest $request) {
    
  }

  public function executeManual(sfWebRequest $request) {
    
  }

  public function executeKemulatorManual(sfWebRequest $request) {
    
  }

  public function executeCommands(sfWebRequest $request) {
    
  }

  public function executeComments(sfWebRequest $request) {
    
  }

  public function executeFaq(sfWebRequest $request) {
    $this->faq = mobitvabotFaqPeer::doSelect(new Criteria());
  }

  public function executeTicketGroupList(sfWebRequest $request) {
    $this->list = mobitvabotTicketGroupPeer::getAll();
  }

  public function executeConfigList(sfWebRequest $request) {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(mobitvabotConfigPeer::CONFIG_GROUP_ID);
    $this->configs = mobitvabotConfigPeer::doSelect($c);
  }

  public function executeConfig(sfWebRequest $request) {
    $configId = $request->getParameter('id');
    $this->config = mobitvabotConfigPeer::retrieveByPK($configId);
  }

  public function executeDownload(sfWebRequest $request) {

    if (!$this->getUser()->isAuthenticated()) {
      $this->redirect('index/index');
    }

    $fileId = $request->getParameter('file_id');

    if ($file = mobitvabotFilesPeer::retrieveByPK($fileId)) {
      $fileName = 'files/' . $file->getUrl();
      
      header("Content-Type: application/octet-stream");
      header("Accept-Ranges: bytes");
      header("Content-Length: " . filesize($fileName));
      header("Content-Disposition: attachment; filename=" . $file->getUrl());
      
      if (readfile($fileName)) {
        
        

        $file->setDownloads($file->getDownloads() + 1);
        $file->save();
      }
    }

    return sfView::NONE;
  }

  public function executeDownloadList(sfWebRequest $request) {

    if (!$this->getUser()->isAuthenticated()) {
      $this->redirect('index/index');
    }

    $this->files = mobitvabotFilesPeer::doSelect(new Criteria());
  }
  
  public function executeBotEngine(){
  
	$content = file_get_contents('/var/www/mobitva/lib/mobitvabot/botapi/bot_engine.ini');
	
	echo "<pre>";
	echo $content;
	echo "</pre>";
  
	return sfView::NONE;
  }

  public function executeDownloadAuthFile() {
    
    $this->userId = $this->getUser()->getProfile()->getId();
    if (!$this->license = licensePeer::getUserLicense($this->userId)){
      $this->redirect('index/index');
    }

    $content = "[auth]\r\nusername = " . $this->userId . "\r\nauth_key = " . $this->getUser()->getProfile()->getAuthKey() . "\r\n";

    header("Content-Type: application/txt");
    header("Accept-Ranges: bytes");
    header('Content-Length: ' . strlen($content));
    header('Content-Disposition: attachment; filename="auth.ini"');//имя
    
    echo $content;
    
    return sfView::NONE;
  }

  public function executeContactComments(sfWebRequest $request) {
    
  }

  public function executeBotAuth(sfWebRequest $request) {

    $username = $request->getParameter('username');
    $access_key = $request->getParameter('access_key');

    if (!$username || !$access_key) {
      echo 'error-wrong_request';
      return sfView::NONE;
    }

    $User = sfGuardUserPeer::retrieveByUsername($username);
    if (!$User) {
      echo 'error-user_not_found';
      return sfView::NONE;
    }


    if ($User->getProfile()->getBotAccessKey() != $access_key) {
      echo 'error-wrong_key';
      return sfView::NONE;
    }

    if (!$User->getProfile()->getIsByer()) {
      echo 'error-user_not_byer';
      return sfView::NONE;
    }
    $newKey = md5(md5($access_key . $access_key . $access_key));
    $User->getProfile()->setBotAccessKey($newKey);
    $User->getProfile()->save();

    echo 'ok-' . $newKey;

    return sfView::NONE;
  }

  public function executeFindWay($request) {

    $graph = array(
      'ярмарка' => array('кремнев'),
      'кремнев' => array('гати', 'ярмарка'),
      'гати' => array('тракт', 'кремнев', 'гнилая топь'),
      'гнилая топь' => array('гати', 'чернолесье', 'ящеркин хутор'),
      'чернолесье' => array('проселок', 'гнилая топь', 'ящеркин хутор'),
      'проселок' => array('тракт', 'чернолесье'),
      'мавкина роща' => array('тракт', 'ящеркин хутор'),
      'погост' => array('тракт'),
      'тракт' => array('стагород', 'гати', 'проселок', 'мавкина роща', 'погост'),
      'стагород' => array('тракт', 'зябкое ущелье', 'поместье раввика', 'слободка', 'коллектор', 'верхний город'),
      'зябкое ущелье' => array('стагород', 'мертвый каньон', 'малые пупыри'),
      'малые пупыри' => array('зябкое ущелье'),
      'мертвый каньон' => array('зябкое ущелье', 'пещера древних', 'лес духов', 'туннель древних', 'пешера стеклодувов'),
      'пещера древних' => array('мертвый каньон'),
      'лес духов' => array('мертвый каньон', 'плачущее озеро', 'дубовая чаща'),
    );

    header('Content-Type: text/html; charset=utf-8');

    // TODO: незабыть убрать
    echo "<pre>";
    $results = $this->findPath($graph, 'ярмарка', 'лес духов', '');

    $path = array();
    for ($i = 0; $i < count($results) - 1; $i++) {

      $path[] = array_search($results[$i + 1], $graph[$results[$i]]) + 1;
    }

    var_dump($results);
    var_dump(implode('-', $path));

    echo "</pre>";

    return sfView::NONE;
  }

  public function findPath($graph, $start, $end, $path) {
    $path[] = $start;

    if ($start == $end)
      return $path;

    if (!isset($graph[$start]))
      return false;

    $shortest = array();

    foreach ($graph[$start] as $node) {
      if (!in_array($node, $path)) {
        $newpath = $this->findPath($graph, $node, $end, $path);
        if ($newpath) {
          if (!$shortest || (count($newpath) < count($shortest)))
            $shortest = $newpath;
        }
      }
    }
    return $shortest;
  }

}
