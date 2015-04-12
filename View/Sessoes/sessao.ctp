<?php
$this->Html->addCrumb('Programação','/sessoes/programacao/');
$this->Html->addCrumb($titulo,'');
//debug($sessoes);
//debug($sessao);
?>



    
<div class='col-md-12' id='title'>
    <h2><?php echo($titulo);?> <small> | <?=$sessao['Sessao']['data'];?>, <?=$sessao['Local']['local'];?>, <?=$sessao['Sessao']['hora'];?></small></h2>
    
</div>

<main>
   <div class='col-md-9' id='mainCol'>
   
    <div class="row">
        <div class='col-md-4'>
            <?php if(!empty($sessao['Sessao']['imagem'])) echo $this->Html->image("sessoes/".$sessao['Sessao']['imagem'], array('class' => 'img-responsive'));?>
        </div>
        <div class='col-md-8'>
            <?php if(!empty($sessao['Sessao']['realizacao'])) {?><p><strong>Realização: </strong><?=$sessao['Sessao']['realizacao'];?></p><?php } ?>
            <?php if(!empty($sessao['Sessao']['producao'])) {?><p><strong>Produção: </strong><?=$sessao['Sessao']['producao'];?></p><?php } ?>
            <?php if(!empty($sessao['Sessao']['origem'])) {?><p><strong>Origem: </strong><?=$sessao['Sessao']['origem'];?></p><?php } ?>
            <?php if(!empty($sessao['Sessao']['elenco'])) {?><p><strong>Elenco: </strong><?=$sessao['Sessao']['elenco'];?></p><?php } ?>
            <?php if(!empty($sessao['Sessao']['duracao'])) {?><p><strong>Duração: </strong><?=$sessao['Sessao']['duracao'];?> minutos</p><?php } ?>
            <?php if(!empty($sessao['Sessao']['ano'])) {?><p><strong>Ano: </strong><?=$sessao['Sessao']['ano'];?></p><?php } ?>
         
             
            <p><?php echo nl2br($sessao['Sessao']['info']);?></p>
        </div>
        
    </div>

</div> 
</main>


<div class='col-md-3' id='rightCol'>
              <?php echo $this->element('rightCol'); ?>  
        <div class="fb-share-button" data-href="<?php echo Router::url( $this->here, true ); ?>" data-layout="button_count" data-title='<?php echo($titulo);?> - Cineclube de Faro'></div>
</div>