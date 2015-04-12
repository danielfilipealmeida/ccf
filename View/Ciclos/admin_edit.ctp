<?php
$this->Html->addCrumb('Ciclos', '/admin/ciclos');
$this->Html->addCrumb('Editar Ciclo \''.$this->request->data['Ciclo']['titulo'].'\'', '');
?>
<div class="ciclos form">
<?php echo $this->Form->create('Ciclo', array('enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Edição do Ciclo'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('titulo');
                echo $this->Form->input('info');
                echo $this->Form->input('data_inicio');
                echo $this->Form->input('data_fim');
                //echo $this->Form->input('imagem', array('type'=>'file'));
		echo $this->Form->input('activo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Apagar'), array('action' => 'admin_delete', $this->Form->value('Ciclo.id')), null, __('Tem a certeza que deseja apagar o registo # %s?', $this->Form->value('Ciclo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Ciclos'), array('action' => 'index')); ?></li>
	</ul>
</div>

<?php
$this->TinyMCE->editor(array('theme' => 'advanced', 'mode' => 'textareas'));          
?>