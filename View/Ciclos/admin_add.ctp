<?php
$this->Html->addCrumb('Ciclos', '/admin/ciclos');
$this->Html->addCrumb('Novo Ciclo', '');
?>
<div class="ciclos form">
<?php echo $this->Form->create('Ciclo'); ?>
	<fieldset>
		<legend><?php echo __('Adicionar Ciclo'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('titulo');
                echo $this->Form->input('info');
                echo $this->Form->input('data_inicio');
                echo $this->Form->input('data_fim');
                echo $this->Form->input('imagem');
		echo $this->Form->input('activo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Listar Ciclos'), array('action' => 'admin_index')); ?></li>
	</ul>
</div>

<?php
$this->TinyMCE->editor(array('theme' => 'advanced', 'mode' => 'textareas'));          
?>