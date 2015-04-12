<?php
$this->Html->addCrumb('Locais', '/admin/locais');
$this->Html->addCrumb('Editar Local \''.$this->request->data['Local']['titulo'].'\'', '');
?>
<div class="locais form">
<?php echo $this->Form->create('Local', array('enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Edição do Local'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('local');
              echo $this->Form->input('activo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Apagar'), array('action' => 'admin_delete', $this->Form->value('Local.id')), null, __('Tem a certeza que deseja apagar o registo # %s?', $this->Form->value('Local.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Locais'), array('action' => 'index')); ?></li>
	</ul>
</div>
