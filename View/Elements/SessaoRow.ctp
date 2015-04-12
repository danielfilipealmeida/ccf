   <div class="row">
        <div class='col-md-4' id='mainCol'>
            <?php if(!empty($sessao['Sessao']['imagem'])) echo $this->Html->image("sessoes/".$sessao['Sessao']['imagem'], array('class' => 'img-responsive'));?>
        </div>
        <div class='col-md-8 filmeInfo' id='mainCol'>
            <?php if(!empty($sessao['Sessao']['realizacao'])) {?><p><strong>Realização: </strong><?=$sessao['Sessao']['realizacao'];?></p><?php } ?>
            <?php if(!empty($sessao['Sessao']['origem'])) {?><p><strong>Origem: </strong><?=$sessao['Sessao']['origem'];?></p><?php } ?>
            <?php if(!empty($sessao['Sessao']['duracao'])) {?><p><strong>Duração: </strong><?=$sessao['Sessao']['duracao'];?> minutos</p><?php } ?>
             
            <?php if(!empty($sessao['Sessao']['sinopse'])) {?><p><?php echo $this->Text->truncate($sessao['Sessao']['sinopse'], 250);?></p><?php } ?>
            <p><?php echo $this->Html->link("Mais Informações", array('action'=>'sessao', $sessao['Sessao']['id']), array('class'=>'btn btn-default'));?></p>
        </div>
    </div>  

