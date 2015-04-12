<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UtilizadoresController extends AppController {
    public $scaffold = 'admin';
    
    public $uses = array("Utilizador");
    
    function beforeFilter() {
        parent::beforeFilter();
    }
    
   
     public function admin_login() {
         
        if ($this->request->is('post')) {
            
            $user_id = 0;
            $username = $this->request->data['Utilizador']['login'];
            $password = $this->request->data['Utilizador']['senha'];
            
            if ($this->Auth->login()) {
                $result = $this->Utilizador->find('first', array(
                    'conditions' => array(
                        'login' => $username,
                        'senha' => $password,
                        "activo" => 1
                    ),
                    'recursive' => 0
                ));
                //debug($result);
                $this->Session->write('userData', $result);
               
                // log affiliate login
                $this->redirect(array('action'=>'admin_index'));
            } else {
               $this->Session->setFlash(__('Invalid username or password, try again'));
            }
             
        }
    }
    
    
    public function admin_logout() {
        $this->Session->write('userData',"");
        $this->Session->delete('userData');
        $this->redirect($this->Auth->logout());
    }
   
    
    /*
     * *********************************************************************
     * ADMIN ZONE METHODS
     * *********************************************************************
     */
    public function admin_index() {
        $this->Utilizador->recursive = 0;
        $this->set('utilizadores', $this->paginate());
    }


    
	public function admin_add() {
                //debug($this->request->data);exit();
		if ($this->request->is('post')) {
                        if ($this->request->data['Utilizador']['senha']!=$this->request->data['Utilizador']['senha_repeat']) {
                            $this->Session->setFlash(__('Os campos de senha têm valores diferentes. Tente novamente.'));
                        }
                        else {
                            $this->Utilizador->create();
                            if ($this->Utilizador->save($this->request->data)) {
                                    $this->Session->setFlash(__('O Utilizador foi gravado'));
                                    $this->redirect(array('action' => 'index'));
                            } else {
                                    $this->Session->setFlash(__('Não foi possivel gravar o Utilizador. Tente novamente.'));
                            }
                        }
		}
	}


        
	public function admin_edit($id = null) {
		if (!$this->Utilizador->exists($id)) {
			throw new NotFoundException(__('Utilizador inválido'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    if ($this->request->data['Utilizador']['senha']!=$this->request->data['Utilizador']['senha_repeat']) {
                            $this->Session->setFlash(__('Os campos de senha têm valores diferentes. Tente novamente.'));
                        }
                        else {
                            if ($this->Utilizador->save($this->request->data)) {
                                    $this->Session->setFlash(__('O Utilizador foi gravado'));
                                    $this->redirect(array('action' => 'index'));
                            } else {
                                    $this->Session->setFlash(__('Não foi possivel gravar o Utilizador. Tente novamente.'));
                            }
                        }
		} else {
			$options = array('conditions' => array('Utilizador.' . $this->Utilizador->primaryKey => $id));
			$this->request->data = $this->Utilizador->find('first', $options);
                        //debug($this->request->data);
		}
	}


        
	public function admin_delete($id = null) {
		$this->Utilizador->id = $id;
		if (!$this->Utilizador->exists()) {
			throw new NotFoundException(__('Utilizador Inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Utilizador->delete()) {
			$this->Session->setFlash(__('Utilizador apagado'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('O Utilizador não foi apagado'));
		$this->redirect(array('action' => 'index'));
	}
    
}