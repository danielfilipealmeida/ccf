<?php
$this->Html->addCrumb('Utilizadores', '/admin/utilizadores');
$this->Html->addCrumb('Editar Utilizador \''.$this->request->data['Utilizador']['nome'].'\'', '');
?>
<div class="utilizadores form">
<?php echo $this->Form->create('Utilizador'); ?>
	<fieldset>
		<legend><?php echo __('Edição do Utilizador'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('login');
                echo $this->Form->input('senha', array("type"=>'password'));
                echo $this->Form->input('senha_repeat', array("type"=>'password', 'label' => 'Repetir a Senha'));
                echo $this->Form->input('nome');
                echo $this->Form->input('email');
                
                 
		echo $this->Form->input('activo', array('type'=>'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acções'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Apagar'), array('action' => 'admin_delete', $this->Form->value('Utilizador.id')), null, __('Tem a certeza que deseja apagar o registo # %s?', $this->Form->value('Utilizador.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Utilizadores'), array('action' => 'index')); ?></li>
	</ul>
</div>
