<?php
$this->Html->addCrumb('Utilizadores', '/admin/utilizadores');
?>
<div class="utilizadores index">
	<h2><?php echo __('Utilizadores'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('login'); ?></th>
                        <th><?php echo $this->Paginator->sort('nome'); ?></th>
                        <th><?php echo $this->Paginator->sort('email'); ?></th>
                         <th><?php echo $this->Paginator->sort('activo'); ?></th>
			<th class="actions"></th>
	</tr>
	<?php foreach ($utilizadores as $utilizador): ?>
	<tr>
		<td><?php echo h($utilizador['Utilizador']['id']); ?>&nbsp;</td>
		<td><?php echo h($utilizador['Utilizador']['login']); ?>&nbsp;</td>
		<td><?php echo h($utilizador['Utilizador']['nome']); ?>&nbsp;</td>
		<td><?php echo h($utilizador['Utilizador']['email']); ?>&nbsp;</td>
		
                <td><?php echo $this->FormElements->drawCheckboxIcon($utilizador['Utilizador']['activo']); ?>&nbsp;</td>
                
		<td class="actions">
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $utilizador['Utilizador']['id'])); ?>
			<?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $utilizador['Utilizador']['id']), null, __('Tem a certeza que deseja apagar o registo # %s?', $utilizador['Utilizador']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, apresentando {:current} registos de um total de {:count}, iniciando no registo {:start}, terminando em {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Próximo') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Novo Utilizador'), array('action' => 'add')); ?></li>
	</ul>
</div>
