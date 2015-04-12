<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class Sessao extends AppModel {
    public $useTable = 'sessoes';
    public $primaryKey = "id";    
    public $displayField = 'titulo';
    
    public $belongsTo = array(
      'Ciclo' => array(
          'className' =>'Ciclo',
            'foreignKey' =>'id_ciclo'
      ),
      'Local' => array(
          'className' => 'Local',
          'foreignKey' => 'id_local'
      )
    );
    

    
    public function obterProgramacao($inicio=null, $fim=null) {
        $condicoes = array(
                        'Sessao.activo' => '1',
                        'Ciclo.activo' => '1'
                        /*
                        'Ciclo.data_fim >= NOW()'
                        'data >= "'.date("Y-m-d", $inicio).'"',
                        'data <= "'.date("Y-m-d", $fim).'"'
                         * 
                         */
                    );
        if($inicio!=null) $condicoes[] = 'Sessao.data >= "'.date("Y-m-d", $inicio).'"';
        else $condicoes[] = 'Sessao.data >= "'.date("Y-m-d", time()).'"';

        if($fim!=null) $condicoes[] = 'Sessao.data <= "'.date("Y-m-d", $fim).'"';
        
        //print_r($condicoes); exit();
        
        $sessoes = $this->find('all',
                array(
                    'conditions' => $condicoes,
                    'order' => array(
                        'Sessao.data ASC'
                    )
                ));
          return $sessoes;
   }
   
   
    public function obterProgramacaoAnterior() {
        $condicoes = array(
                        'Sessao.activo' => '1',
                        'Ciclo.activo' => '1',
                        
                        'Sessao.data < CURDATE()'
                    );
       //print_r($condicoes);
        $sessoes = $this->find('all',
                array(
                    'conditions' => $condicoes,
                    'order' => array(
                        'Sessao.data DESC'
                    ),
                    'limit' => 5
                ));
          return $sessoes;
    }
    
    
       
    public function filtraInicio($inicio =null) {
        if ($inicio == null) $inicio = mktime(0,0,0,date('n'),1, date('Y'));;
        return $inicio;
    }
    
    
    public function filtraFim($fim =null) {
        if ($fim == null) $fim = mktime(0,0,0,date('n'),date('t'), date('Y'));
       return $fim;
    }
    
    
    
    public function obterCalendario($inicio=null, $fim=null) {
        $calendarData = array();
        $mesesArray = Configure::read('NomeMeses');
        //if ($inicio == null) $inicio = mktime(0,0,0,date('n'),1, date('Y'));;
        //if ($fim == null) $fim = mktime(0,0,0,date('n'),date('t'), date('Y'));
        $inicio = $this->filtraInicio($inicio);
        $fim = $this->filtraFim($fim);
      
        
       
        $calendarData['calendarTitle'] = $mesesArray[date("n")-1]." ".date('Y');
        $calendarData['calendarDays'] = array("Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb");
        $calendarData['startTimestamp']=$inicio;
        $calendarData['endTimestamp']= $fim;
        $calendarData['weeksInMonth'] = ceil(date("t", $inicio)/7);
        $calendarData['daysInMonth'] = date("t", $inicio);
        $calendarData['firstDayWeekDay'] = date("N", $inicio);

        $calendarData['currentMonth']['month']=intval(date('n', $inicio));
        $calendarData['currentMonth']['year']=intval(date('Y', $inicio));
        
        $calendarData['previousMonth']['month'] = $calendarData['currentMonth']['month'] - 1;
        if ($calendarData['previousMonth']['month']<1) {
            $calendarData['previousMonth']['month'] = 12;
            $calendarData['previousMonth']['year'] = $calendarData['currentMonth']['year'] -1;
        }
        else $calendarData['previousMonth']['year'] = $calendarData['currentMonth']['year'];
        $calendarData['nextMonth']['month'] = $calendarData['currentMonth']['month'] + 1;
        if ($calendarData['nextMonth']['month']>12) {
            $calendarData['nextMonth']['month'] = 1;
            $calendarData['nextMonth']['year'] = $calendarData['currentMonth']['year']  +1;
            
        } else $calendarData['nextMonth']['year'] = $calendarData['currentMonth']['year'];
        
        
        $dados = array();
        $sessoes = $this->obterProgramacao($inicio, $fim);
        foreach($sessoes as $sessao) {
            //debug($sessao);
            $dados[$sessao['Sessao']['data']][] = $sessao;
        }
        $calendarData['data'] = $dados;
        
        //debug($calendarData);
        return $calendarData; 
   }
   
   
   
   public function deleteImage($id = null)  {
       $result = false;
       if ($id==null) return $result;
       $sessao = $this->findById($id);
       if (!empty($sessao['Sessao']['imagem'])) {
            $imagePath = $this->getImagePath($sessao['Sessao']['imagem']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
                $result = true;
            }
            $sessao['Sessao']['imagem'] = "";
            $this->save($sessao);
       
       }
       return $result;
   }
   
   public function getImagePath($imagemName) {
       return WWW_ROOT."img/sessoes/".$imagemName;
   }
           
   
   /**
    * Função executada antes de gravar
    * @param type $options
    * 
    * Testa se existe algum ficheiro enviado. se sim, define o novo nome, move para a localização, altera os dados do registo
    */
   public function beforeSave($options = array()) {
       
      
       
       if (isset($this->data['Sessao']['imagem']) && !empty($this->data['Sessao']['imagem']) && !empty($this->data['Sessao']['imagem']['name'])) {
           
           // todo: get the old image name and delete it
           // ---
           
           
           $termination = strtolower($this->data['Sessao']['imagem']['name']);
           $terminationArray = explode(".", $termination);
           $newFilename = uniqid().".".$terminationArray[1];
            
           
           // move into place
           $destination = $this->getImagePath($newFilename);
           //print_r($destination);
         
           
           
           // todo: usar  o imagemagick para fazer resize da imagem se necessário.
           // dimensão máxima: 270 pixels agora.
           if (move_uploaded_file($this->data['Sessao']['imagem']['tmp_name'], $destination)) {
                    $this->data['Sessao']['imagem'] = $newFilename;
               }
               else {
                    $this->data['Sessao']['imagem'] = ""; 
           }
           /*
           $fp = fopen($this->data['Sessao']['imagem']['tmp_name'], "r");
           if (!$fp) {
               $this->data['Sessao']['imagem'] = ""; 
               return;
           }
           $image = new Imagick($fp);
           if (!$image) {
                fclose($fp);
                $this->data['Sessao']['imagem'] = ""; 
                return;
           }
           $imageDimensions = $image->getImageGeometry();
           $finalWidth = 300;
           
           // too big -> resize
           if ($imageDimensions['width']>$finalWidth) {
               $aspectRatio = $imageDimensions['width']/$imageDimensions['height'];
           
                
                if (Imagick::resize($finalWidth, $finalWidth / $aspectRatio)){
                    $this->data['Sessao']['imagem'] = $newFilename;
                }
                else {
                    $this->data['Sessao']['imagem'] = ""; 
                }
           }
           else
           {
               // not big enough -> copy 
               if (move_uploaded_file($this->data['Sessao']['imagem']['tmp_name'], $destination)) {
                    $this->data['Sessao']['imagem'] = $newFilename;
               }
               else {
                    $this->data['Sessao']['imagem'] = ""; 
               }
           
           }
           
           
           fclose($fp);
           // change the record
           */
       }
       
       else unset($this->data['Sessao']['imagem']);
           //$this->data['Sessao']['imagem'] = "";
   }

   
    
    }