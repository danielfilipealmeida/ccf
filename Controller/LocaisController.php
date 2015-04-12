<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP LocaisController
 * @author daniel
 */
class LocaisController extends AppController {
    public $uses = array("Local");
    
    
    public $paginate = array(
        'limit' => 25, 
        'order' => array(
            'Ciclo.id' => 'desc' 
        )
    );
    
    function beforeFilter() {
        parent::beforeFilter();
         $this->Auth->allow('index', 'homepage');
       
     }
    
   
  /*
     * *********************************************************************
     * ADMIN ZONE METHODS
     * *********************************************************************
     */
    public function admin_index() {
        $this->Local->recursive = 0;
        $this->set('locais', $this->paginate());
    }


    
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Local->create();
		if ($this->Local->save($this->request->data)) {
                    $this->Session->setFlash(__('O Local foi gravado'));
                    $this->redirect(array('action' => 'index'));
		} else {
                    $this->Session->setFlash(__('Não foi possivel gravar o Local. Tente novamente.'));
		}
	}
    }


        
    public function admin_edit($id = null) {
        if (!$this->Local->exists($id)) {
            throw new NotFoundException(__('Local inválido'));
	}
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Local->save($this->request->data)) {
		$this->Session->setFlash(__('O Local foi gravado'));
		$this->redirect(array('action' => 'index'));
            } else {
		$this->Session->setFlash(__('Não foi possivel gravar o Local. Tente novamente.'));
            }
        } else {
            $options = array('conditions' => array('Local.' . $this->Local->primaryKey => $id));
            $this->request->data = $this->Local->find('first', $options);
	}
    }

       
        
	public function admin_delete($id = null) {
		$this->Local->id = $id;
		if (!$this->Local->exists()) {
			throw new NotFoundException(__('Local Inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Local->delete()) {
			$this->Session->setFlash(__('Local apagado'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('O Local não foi apagado'));
		$this->redirect(array('action' => 'index'));
	}
         
     
}
