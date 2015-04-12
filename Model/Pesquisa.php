<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Pesquisa extends AppModel {
     public $useDBConfig = 'biblioteca';
    public $useTable = 'FILMES';
    public $primaryKey = "Nº FILME";    
    public $displayField = 'TÍTULO FILME';
    
}