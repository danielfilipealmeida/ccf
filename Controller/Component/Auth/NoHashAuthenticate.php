<?php

/**
 * Description of NoHash
 *
 * @author daniel
 */

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class NoHashAuthenticate extends BaseAuthenticate {
    
    public function authenticate(CakeRequest $request, CakeResponse $response) {

        
        // load affiliate Model
        $this->Utilizador = ClassRegistry::init('Utilizador');
       
        $result = $this->Utilizador->find('first', array(
            'conditions' => array(
                'login' => $request['data']['Utilizador']['login'],
                'senha' => $request['data']['Utilizador']['senha'],
                "activo" => 1
            ),
            'recursive' => 0
        ));
        //debug($result);
       
        if (!empty($result)) return $result; else return false;
    }
}

?>
