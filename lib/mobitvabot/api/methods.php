<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of apiMethods
 *
 * @author q
 */
class methods {

  public static function getPlaces($params) {

    return array('ololo' => true);
  }

  public static function getAlbums($params) {

    $albums = albumPeer::getAlbumsWithPhotos($params);

//        var_dump($albums);
    return array('albums' => $albums);
  }

  public static function parseAlbum($params) {

    $provider = providerPeer::retrieveByPK($params['provider_id']);

    // TODO: незабыть убрать
//    echo "<pre>";
//    var_dump($params);
//    echo "</pre>";
    
    
    if (($params['is_photo_links']) == 'false') {
    
    
//    var_dump('HERE!');

//      http://parser.mobitva-bot.ru/frontend.php/api/index?method_name=parsePage&params[key]=inight1&params[urls][0]=111&params[urls][1]=http://nsk.gdechego.ru/meropriyatiya/klubnie/dva_gusya_22_goda_fgo_pravda_1811/


    $urlsParamsString = '';
    foreach ($params['urls'] as $key => $url) {
      $urlsParamsString .= '&params[urls][' . $key . ']=' . $url;
    }

    $apiUrl =
      'http://parser.mobitva-bot.ru/frontend.php/api/index?method_name=parsePage' .
      '&params[key]=' . $provider->getParserTaskKey() .
      $urlsParamsString . '';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
//    curl_setopt($ch, CURLOPT_MUTE, true);
    ob_start();
    $urlHtml = curl_exec($ch);
    $urlHtml = ob_get_clean();
    
//    var_dump($urlHtml);
    $response = json_decode($urlHtml, true);
    
    
    }else{
      $response['response']['elements'] = $params['urls'];
    }
    
//    var_dump($response['response']['elements']);
    
    if (!count($response['response']['elements'])){
      return false;
    }
    
    $album = new album();
    $album->setUserId(1);
    $album->setName('Новый альбом');
    $album->setProviderId($params['provider_id']);
    $album->setPlaceId(1);
    $album->setDate(date('Y-m-d'));
    $album->setTags('');
    $album->save();
    
    
//    // TODO: незабыть убрать
//    echo "<pre>";
//    var_dump($apiUrl);
//    var_dump($response);
//    echo "</pre>";
    
    $isPrimary = true;
    foreach ($response['response']['elements'] as $element) {
      
      $urlPreview = (($params['image_preview_prefix'] != '') ? $params['image_preview_prefix'] : $provider->getImagePreviewPrefix() . $element);
      $urlOriginal = (($params['image_original_prefix'] != '') ? $params['image_original_prefix'] : $provider->getImageOriginalPrefix() . $element);
      
      if ( ($expr = $provider->getImagePreviewPregReplaceExpr()) != ''){
        $urlPreview = preg_replace($expr,$provider->getImagePreviewReplacement(),$urlPreview);
      }
      
      if ( ($expr = $provider->getImageOriginalPregReplaceExpr()) != ''){
        $urlOriginal = preg_replace($expr,$provider->getImageOriginalReplacement(),$urlOriginal);
      }
      
      $photoObject = new photo();
      $photoObject->setAlbumId($album->getId());
      $photoObject->setIsPrimary($isPrimary);
      $photoObject->setUrlPreview($urlPreview);
      $photoObject->setUrlOriginal($urlOriginal);
      $photoObject->save();
      $isPrimary = false;
    }
    
  }

}

?>
