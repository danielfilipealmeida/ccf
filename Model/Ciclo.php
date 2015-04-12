<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class Ciclo extends AppModel {
    public $useTable = 'ciclos';
    public $primaryKey = "id";    
    public $displayField = 'titulo';
    
    public $hasMany = array(
        'Sessao' => array(
            'className' => 'Sessao',
            'foreignKey' => 'id_ciclo',
            'conditions' => array('Sessao.activo' => '1'),
            'order' => 'Sessao.data ASC'
        )
    );
    
    public function obterProximoCiclo() {
        $ciclo = $this->find('first', array(
            'conditions' => array(
                'data_fim >NOW()'
            ),
            'order' => array(
                'data_fim' => 'DESC'
            )
        ));
        
       
        return $ciclo;
    }
}