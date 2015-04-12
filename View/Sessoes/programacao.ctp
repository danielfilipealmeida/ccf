<?php
$this->Html->addCrumb($titulo,'');
//debug($sessoes);
?>

<div class='col-md-9' id='mainCol'>
    <h2><?=$titulo;?></h2>
    <?php if (!empty($sessoes) ) { ?>
    <h3>Próximas Sessões</h3>
    <?php foreach($sessoes as $sessao) { ?>
    <?php //debug($sessao); ?>
    <div class='row'>
        <div class='col-md-12' id='mainCol'>
            <h3><a href='/sessoes/sessao/<?=$sessao['Sessao']['id']?>'><?=$sessao['Sessao']['titulo'];?></a> <small> | <?=$sessao['Sessao']['data'];?>, <?=$sessao['Local']['local'];?>, <?=$sessao['Sessao']['hora'];?></small></h3>
            <h4>Ciclo '<a href='/ciclos/view/<?=$sessao['Ciclo']['id']?>'><?=$sessao['Ciclo']['titulo']?></a>'</h4>
            
        </div>
    </div>
    
    
    <?php echo $this->element('SessaoRow', array('sessao' => $sessao)); ?>
    
    <?php } // end foreach?>
    <?php } // end if !empty?>
    
    
    <h3>Sessões Anteriores</h3>
    <?php foreach($sessoesAnteriores as $sessao) { ?>
    <?php //debug($sessao); ?>
    <div class='row'>
        <div class='col-md-12' id='mainCol'>
            <h3><a href='/sessoes/sessao/<?=$sessao['Sessao']['id']?>'><?=$sessao['Sessao']['titulo'];?></a> <small> | <?=$sessao['Sessao']['data'];?>, <?=$sessao['Local']['local'];?>, <?=$sessao['Sessao']['hora'];?></small></h3>
            <h4>Ciclo '<a href='/ciclos/view/<?=$sessao['Ciclo']['id']?>'><?=$sessao['Ciclo']['titulo']?></a>'</h4>
            
        </div>
    </div>
    
    <?php echo $this->element('SessaoRow', array('sessao' => $sessao)); ?>
    <?php } // end foreach?>
    
    
</div>
<div class='col-md-3' id='rightCol'>
              <?php echo $this->element('rightCol'); ?>  
</div>