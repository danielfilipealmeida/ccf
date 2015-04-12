<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PesquisasController extends AppController {
    public $scaffold = 'admin';
    
    public $uses = array("Pesquisa");
    
    function beforeFilter() {
        parent::beforeFilter();
         $this->Auth->allow('index', 'homepage');
       
     }
    
     
     
   
    public function index() {
        // lista todos os ciclos em ordem descentente de tempo
        //$filmes = $this->Pesquisa->find('all');
        //debug($filmes);\
        $this->Pesquisa->useDbConfig = 'biblioteca';
        debug($this->Pesquisa->query("show tables"));
    }
    
   
}