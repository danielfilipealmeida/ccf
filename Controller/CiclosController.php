<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CiclosController extends AppController {
    //public $scaffold = 'admin';
    
    public $uses = array("Ciclo");
    
    
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
    
     
     
   
    public function index() {
        // lista todos os ciclos em ordem descentente de tempo
        
        
    }
    
    
   
    
   
    public function view($id=null) {
        $titulo = "Ciclo inválido";
        
        if ($id == null) {
            $ciclo = $this->Ciclo->obterProximoCiclo();
        } 
        else {
            $ciclo = $this->Ciclo->findById($id);
        }
        //debug($ciclo);
         if (!empty($ciclo)) {
             $this->set('titulo', $ciclo['Ciclo']['titulo']);
             $this->set('data', $ciclo);
         }
    }
    
    public function homepage() {
        // mostra o actual ou próximo ciclo
    }

    
    
    /*
     * *********************************************************************
     * ADMIN ZONE METHODS
     * *********************************************************************
     */
    public function admin_index() {
        $this->Ciclo->recursive = 0;
        $this->set('ciclos', $this->paginate());
    }


    
	public function admin_add() {
            $this->helpers = array('TinyMCE.TinyMCE');
		if ($this->request->is('post')) {
			$this->Ciclo->create();
			if ($this->Ciclo->save($this->request->data)) {
				$this->Session->setFlash(__('O Ciclo foi gravado'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Não foi possivel gravar o Ciclo. Tente novamente.'));
			}
		}
	}


        
	public function admin_edit($id = null) {
		if (!$this->Ciclo->exists($id)) {
			throw new NotFoundException(__('Ciclo inválido'));
		}
                
                $this->helpers = array('TinyMCE.TinyMCE');
                
                
		if ($this->request->is('post') || $this->request->is('put')) {
                    if ($this->Ciclo->save($this->request->data)) {
			$this->Session->setFlash(__('O Ciclo foi gravado'));
			$this->redirect(array('action' => 'index'));
                    } else {
			$this->Session->setFlash(__('Não foi possivel gravar o Ciclo. Tente novamente.'));
                    }
		} else {
			$options = array('conditions' => array('Ciclo.' . $this->Ciclo->primaryKey => $id));
			$this->request->data = $this->Ciclo->find('first', $options);
		}
	}


        
	public function admin_delete($id = null) {
		$this->Ciclo->id = $id;
		if (!$this->Ciclo->exists()) {
			throw new NotFoundException(__('Ciclo Inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ciclo->delete()) {
			$this->Session->setFlash(__('Ciclo apagado'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('O Ciclo não foi apagado'));
		$this->redirect(array('action' => 'index'));
	}
}