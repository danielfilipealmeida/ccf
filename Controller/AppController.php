<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $helpers = array('Html');
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'utilizadores', 
                'action' => 'admin_index', 
            ),
            'logoutRedirect' => array(
                'controller' => 'utilizadores', 
                'action' => 'logout'
            ),
            'logoutAction' => array(
                'controller' => 'utilizadores',
                'action' => 'logout'
            ),
            'loginAction' => array(
                'controller' => 'utilizadores', 
                'action' => 'login'
            ),
             'authError' => 'Não tem permissões!'
        )
        
    );
    
    //public $uses = array("Sessao");
    
    /*
     public $components = array(
        'Websites',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'pages', 'action' => 'display', 'home'),
            'logoutRedirect' => array('controller' => 'pages', 'action' => 'display', 'home')
        )
    );
    */
    
    
    function beforeFilter() {
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            $this->layout = 'admin';
        } 
         $this->Auth->authenticate = array(
             'NoHash',
             AuthComponent::ALL => array(
                 'userModel' => 'Utilizador',
                 'loginAction' => array(
                     'controller' => 'utilizadores',
                     'action' => 'login',
                 ),
                 'logoutAction' => array(
                     'controller' => 'utilizadores',
                     'action' => 'logout'
                 ),
                 'scope' => array("Utilizador.activo" => 1),
                 'fields' => array(
                     'username' => 'login',
                     'password' => 'senha'
                 )
             ),
             'Form'
            
         );
        $this->Auth->allow('admin-index');
        $this->Auth->allow('index', 'view', 'contacts', 'sobre');
        
       
        $calendarData = null;
        
        //print_r($this->Session->read('calendarData'));//exit();
        //$this->Session->delete('calendarData');
        $calData = $this->Session->read('calendarData');
        if (isset($calData) && !empty($calData)) {
            if (isset($this->Sessao)) 
            {
                $calendarData = $this->Sessao->obterCalendario(null, null);
                $this->Session->write('calendarData', $calendarData);
                //exit();
                
            }    
        }
        else 
        {
            //echo("2");
            $calendarData = $this->Session->read('calendarData');
        }
        
        $this->set('calendarData', $calendarData);
        
    }
    
    /*
    public function getMenu() {
        $menuData = Configure::read("Menu");
        $menu = array();
        foreach($menuData as $item) {
            $itemHtml="";
            if (isset($item['controller'])) {
                $optionsArray = array('controller' => $item['controller'], 'action' => $item['action']);
                if(isset($item['extra'])) $optionsArray[] = $item['extra'];
                $itemHtml = $Html->link($item['title'], $optionsArray);
            }
            if (isset($item['url'])) {
                $itemHtml = $this->Html->link($item['title'], $item['url']);   
            }
            $menu[] = $itemHtml;
        }
        debug($menu);
        $this->set('menuArray', $menu);
    }
    */
}
