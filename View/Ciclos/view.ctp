<?php
$this->Html->addCrumb('Programação','/sessoes/programacao/');
$this->Html->addCrumb($titulo,'');
?>

<div class='col-md-12' id='title'>
    <h2>Ciclo '<?php echo($titulo);?>'</h2>
    
</div>

<div class='col-md-9' id='mainCol'>
    
    <div>
        <?php echo($data['Ciclo']['info']);?>
    </div>
    
    <?php foreach($data['Sessao'] as $sessao) { ?>
    <div class='row'>
        <div class='col-md-12' id='mainCol'>
            <h3><a href='/sessoes/sessao/<?=$sessao['id']?>'><?=$sessao['titulo'];?></a> <small> | <?=$sessao['data'];?></small></h3>
            <h4>Ciclo '<a href='/ciclos/view/<?=$data['Ciclo']['id']?>'><?=$data['Ciclo']['titulo']?></a>'</h4>
            
        </div>
    </div>
    
    <div class="row">
        <div class='col-md-4' id='mainCol'>
            <?php if(!empty($sessao['imagem'])) echo $this->Html->image("sessoes/".$sessao['imagem'], array('class' => 'img-responsive'));?>
        </div>
        <div class='col-md-8' id='mainCol'>
           <?php if(!empty($sessao['realizacao'])) {?><p><strong>Realização: </strong><?=$sessao['realizacao'];?></p><?php } ?>
            <?php if(!empty($sessao['origem'])) {?><p><strong>Origem: </strong><?=$sessao['origem'];?></p><?php } ?>
            <?php if(!empty($sessao['duracao'])) {?><p><strong>Duração: </strong><?=$sessao['duracao'];?> minutos</p><?php } ?>
             
            <?php if(!empty($sessao['sinopse'])) {?><p><?php echo $this->Text->truncate($sessao['sinopse'], 250);?></p><?php } ?>
            <p><?php echo $this->Html->link("Mais Informações", array('controller' => 'sessoes', 'action'=>'sessao', $sessao['id']), array('class'=>'btn btn-default'));?></p>
        </div>
        
    </div>
    <?php } ?>
    
</div>
<div class='col-md-3' id='rightCol'>
              <?php echo $this->element('rightCol'); ?>  
</div>