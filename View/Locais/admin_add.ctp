<?php
$this->Html->addCrumb('Locais', '/admin/locais');
$this->Html->addCrumb('Novo Local', '');
?>
<div class="locais form">
<?php echo $this->Form->create('Local'); ?>
	<fieldset>
		<legend><?php echo __('Adicionar Local'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('local');
		echo $this->Form->input('activo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Listar Locais'), array('action' => 'admin_index')); ?></li>
	</ul>
</div>

