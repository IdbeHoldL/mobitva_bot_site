<?php

/**
 * api actions.
 *
 * @package    inight
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        /**
         * 
         * data = array();
         * 
         * data[0] = api_method_name
         * data[1] = array( param1 = value1,
         *                  parem2 = value2)
         * 
         * 
         * 
         */
//        $request->getParameter('data');
//        $request->getParameter('');
        
        $method_name = $request->getParameter('method_name');
        $params = $request->getParameter('params');
        
//        echo '<pre>';
//        var_dump($method_name);
//        var_dump($params);
//        echo '</pre>';
        
//        $a1 = array('ololo' => 'trololo');
//        $a1 = array('city_id' => array('trololo'));
//        $a1 = array();
        echo api::run($method_name, $params);

        return sfView::NONE;
    }

}
