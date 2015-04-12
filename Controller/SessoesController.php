<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class SessoesController extends AppController {
    //public $scaffold = 'admin';
    
    public $uses = array("Sessao", "Ciclo", "Local");
    
    public $helper = array("Text", "TinyMCE.TinyMCE", "FormElements");

    public $paginate = array(
        'limit' => 25, 
        'order' => array(
            'Sessao.id' => 'desc' 
        )
    );
        
        
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'view','programacao', 'homepage', 'sessao', 'alteraMesCalendario');
       
     }
    
    public function index() {

    }
    
    
    public function homepage() {
        $this->layout = "homepage";
        $sessoes = $this->Sessao->obterProgramacao(null, null);
        $this->set('sessoes', $sessoes);
        
        /*
        $calendarData = $this->Sessao->obterCalendario(null, null);
        $this->set('calendarData', $calendarData);
         * 
         */
    }
    
    
     /* obtem todos os filmes entre 2 datas
     * recebe as datas em timestamp
     */
    public function programacao($inicio=null, $fim=null) {
        $calendarData = $this->Sessao->obterCalendario(null, null);
        $this->set('calendarData', $calendarData);
        
        $mesesArray = Configure::read('NomeMeses');
       
        //$inicio = $this->Sessao->filtraInicio($inicio);
        $sessoes = $this->Sessao->obterProgramacao();
        $sessoesAnteriores = $this->Sessao->obterProgramacaoAnterior();
        $titulo = "Programação";
        $this->set('titulo', $titulo);
        $this->set('sessoes', $sessoes);
        $this->set('sessoesAnteriores', $sessoesAnteriores);
           
    }
    
    public function sessao($id) {
        if (!$this->Sessao->exists($id)) {
            throw new NotFoundException(__('Sessão inexistente!'));
	}
        $options = array('conditions' => array('Sessao.' . $this->Sessao->primaryKey => $id));
        $sessao = $this->Sessao->find('first', $options);
        $this->set('sessao', $sessao);   
        $titulo = $sessao['Sessao']['titulo'];
        $this->set('titulo', $titulo);
        $this->set('title_for_layout',  $titulo);
    }
    
    function alteraMesCalendario($month, $year) {
        $startTimestamp = mktime(0,0,0,$month, 1, $year);
        $daysInMonth = date('t', $startTimestamp);
        $endTimestamp = mktime(0,0,0, $month, $daysInMonth, $year);
        $this->Session->delete('calendarData');
        $calendarData = $this->Sessao->obterCalendario($startTimestamp, $endTimestamp);
        $this->Session->write('calendarData', $calendarData);
        
        //print_r($this->Session->read('calendarData'));exit();
        
        // reload previous page. 
        // todo: convert this to ajax
        $this->redirect($this->referer());
        
    }

    
    /*
     * *********************************************************************
     * ADMIN ZONE METHODS
     * *********************************************************************
     */
    public function admin_index() {
        $this->Sessao->recursive = 0;
        $this->set('sessoes', $this->paginate());
    }


    
	public function admin_add() {
            $this->helpers = array('TinyMCE.TinyMCE');
		if ($this->request->is('post')) {
			$this->Sessao->create();
			if ($this->Sessao->save($this->request->data)) {
				$this->Session->setFlash(__('A Sessão foi gravada'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Não foi possivel gravar a Sessão. Tente novamente.'));
			}
		} else {
                    $ciclos = $this->Ciclo->find('list');
                    $this->set('ciclos', $ciclos, array('conditions' => array('activo' => 1)));
                    $locais = $this->Local->find('list', array('conditions' => array('activo' => 1)));
                    $this->set('locais', $locais);
                }
	}


        
	public function admin_edit($id = null) {
            $this->helpers = array('TinyMCE.TinyMCE');
            
		if (!$this->Sessao->exists($id)) {
			throw new NotFoundException(__('Sessão inválida'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   
                      
                        if ($this->Sessao->save($this->request->data)) {
				$this->Session->setFlash(__('A Sessão foi gravada'));
				$this->redirect(array('action' => 'admin_edit', $id));
			} else {
				$this->Session->setFlash(__('Não foi possivel gravar a Sessão. Tente novamente.'));
			}
		} else {
			$options = array('conditions' => array('Sessao.' . $this->Sessao->primaryKey => $id));
			$this->request->data = $this->Sessao->find('first', $options);
                        //debug($this->request->data);
                        
                        $ciclos = $this->Ciclo->find('list', array('conditions' => array('activo' => 1)));
                        $this->set('ciclos', $ciclos);
                        //debug($ciclos);
                        
                        $locais = $this->Local->find('list', array('conditions' => array('activo' => 1)));
                        $this->set('locais', $locais);
		
                        
                        $previousRecord = $this->Sessao->find('first',array(
                            'conditions' => array(
                                'Sessao.id < '.$id
                            ),
                            'order' => array ('Sessao.Id desc')
                        ));
                        $this->set('previousRecord', $previousRecord);
                        
                        $nextRecord = $this->Sessao->find('first',array(
                            'conditions' => array(
                                'Sessao.id > '.$id
                            ),
                            'order' => array ('Sessao.Id asc')
                        ));
                        $this->set('nextRecord', $nextRecord);
                        
                        //debug($previousRecord);exit();
                        
                }
	}


        
	public function admin_delete($id = null) {
		$this->Sessao->id = $id;
		if (!$this->Sessao->exists()) {
			throw new NotFoundException(__('Sessão Inválida'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sessao->delete()) {
			$this->Session->setFlash(__('Sessão apagada'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('A Sessão não foi apagada'));
		$this->redirect(array('action' => 'index'));
	}
    
        
        public function admin_apagarImagem($id = null) {
            if ($this->Sessao->deleteImage($id)) $this->Session->setFlash(__('A Imagem foi apagada'));
            else $this->Session->setFlash(__('A Imagem não foi apagada'));
            $this->redirect(array('action' => 'admin_edit', $id));
        }
}