<?php
$this->Html->addCrumb('Sessões', '/admin/sessoes');
$this->Html->addCrumb('Editar Sessao \''.$this->request->data['Sessao']['titulo'].'\'', '');

//debug($previousRecord);
?>
<div class="sessoes form">
<?php echo $this->Form->create('Sessao', array('enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Edição da Sessão'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('titulo');
                echo $this->Form->input('realizacao');
                echo $this->Form->input('producao');
                echo $this->Form->input('ano', array("type" => 'number'));
                echo $this->Form->input('duracao');
                echo $this->Form->input('elenco');
                echo $this->Form->input('origem');
                echo $this->Form->input('sinopse', array('type' => 'text'));
                echo $this->Form->input('info', array('type' => 'textarea'));
                echo $this->Form->input('imagem', array('type' => 'file'));
                echo $this->Form->input('data', array('label'=>'Data'));
                echo $this->Form->input('hora', array('type' => 'text'));
                echo $this->Form->input('id_local', array("type"=>"select", "options" =>$locais, "label" => 'Local') );
                echo $this->Form->input('id_ciclo', array("type"=>"select", "options" =>$ciclos, "label" => 'Ciclo') );
		echo $this->Form->input('activo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Apagar'), array('action' => 'admin_delete', $this->Form->value('Sessao.id')), null, __('Tem a certeza que deseja apagar o registo # %s?', $this->Form->value('Sessao.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Nova Sessão'), array('action' => 'admin_add')); ?></li>
		<li><?php echo $this->Html->link(__('Listar Sessões'), array('action' => 'index')); ?></li>
            <li><?php if (isset($previousRecord['Sessao']['id']))  echo $this->Html->link(__('< Anterior'), array('action' => 'edit', $previousRecord['Sessao']['id'])); ?></li>
            <li><?php if (isset($nextRecord['Sessao']['id'])) echo $this->Html->link(__('Seguinte >'), array('action' => 'edit', $nextRecord['Sessao']['id'])); ?></li>
	
        </ul>
        
        <br />
        <h3>Imagem</h3>
        
        <?php 
        $imagem = $this->request->data['Sessao']['imagem'];
        if(!empty($imagem)) { 
            echo $this->Html->image("sessoes/".$imagem, array('class' => 'img-responsive'));
            echo("<br />");
            echo $this->Html->link(__('Apagar Imagem'), array('action' => 'admin_apagarImagem', $this->request->data['Sessao']['id']));
        } 
        else 
        {
            echo("Nenhuma imagem definida.");
        }
        ?>
</div>

<?php
//debug($this->request->data);
$this->TinyMCE->editor(array(
    'theme' => 'advanced', 
    'mode' => 'textareas',
    'plugins' => 'media',
    'extended_valid_elements' => "span[!class], iframe[src|width|height|name|align], embed[width|height|name|flashvars|src|bgcolor|align|play|loop|quality|allowscriptaccess|type|pluginspage]",
    'theme_advanced_buttons1' => "code", 
    'media_strict' => false 
    ));          
?>