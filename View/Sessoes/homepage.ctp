<?php
//$this->Html->addCrumb($titulo,'');
//debug($sessoes);
?>


<div class='col-md-9'>  
    <?php foreach($sessoes as $sessao) { ?>
    <div class="row">
        <div class='col-md-5' id='mainCol'>
            <p>&nbsp;</p>
            <?php if(!empty($sessao['Sessao']['imagem'])) echo $this->Html->image("sessoes/".$sessao['Sessao']['imagem'], array('class' => 'img-responsive'));?>
        </div>
        <div class='col-md-7' id='mainCol'>
            <?php if(isset($sessao['Sessao']['data']) and !empty($sessao['Sessao']['data'])) {?><p><?=$sessao['Sessao']['data'];?></p><?php } ?>
            <?php if(isset($sessao['Sessao']['titulo']) and !empty($sessao['Sessao']['titulo'])) {?><h3><?=$sessao['Sessao']['titulo'];?></h3><br /><?php } ?>
            <h4>Ciclo '<?php echo $this->Html->link($sessao['Ciclo']['titulo'], array(
                "controller"=>'ciclos',
                "action"=>'view',
                $sessao['Ciclo']['id']
            ))?>'</h4>
            <?php if(isset($sessao['Sessao']['realizacao']) and !empty($sessao['Sessao']['realizacao'])) {?><p><strong>Realização: </strong><?=$sessao['Sessao']['realizacao'];?></p><?php } ?>
            <?php if(isset($sessao['Sessao']['elenco']) and !empty($sessao['Sessao']['elenco'])) {?><p><strong>Elenco: </strong><?=$sessao['Sessao']['elenco'];?></p><?php } ?>
            <?php if(isset($sessao['Sessao']['duracao']) and !empty($sessao['Sessao']['duracao'])) {?><p><strong>Duração: </strong><?=$sessao['Sessao']['duracao'];?> minutos</p><?php } ?>
        </div>
    </div>
    <?php } ?>
    
</div>
<div class='col-md-3'>
    <?php echo $this->element('calendar'); ?>
</div>
