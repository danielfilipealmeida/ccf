<?php
$this->Html->addCrumb('Sessões', '/admin/sessoes');
$this->Html->addCrumb('Nova Sessao', '');
?>
<div class="sessoes form">
<?php echo $this->Form->create('Sessao'); ?>
	<fieldset>
		<legend><?php echo __('Adicionar Sessão'); ?></legend>
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
                //echo $this->Form->input('imagem', array('type' => 'file'));
                echo $this->Form->input('data', array('label'=>'Data'));
                echo $this->Form->input('hora', array('type' => 'text', 'value' => '21:30'));
                echo $this->Form->input('id_local', array("type"=>"select", "options" =>$locais, "label" => 'Local') );
                echo $this->Form->input('id_ciclo', array("type"=>"select", "options" =>$ciclos, "label" => 'Ciclo') );
		echo $this->Form->input('activo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Listar Sessões'), array('action' => 'admin_index')); ?></li>
	</ul>
</div>

<?php
$this->TinyMCE->editor(array(
    'theme' => 'advanced', 
    'mode' => 'textareas',
    'plugins' => 'media',
    'extended_valid_elements' => "span[!class], iframe[src|width|height|name|align], embed[width|height|name|flashvars|src|bgcolor|align|play|loop|quality|allowscriptaccess|type|pluginspage]",
    'theme_advanced_buttons1' => "code", 
    'media_strict' => false 
    ));        
?>