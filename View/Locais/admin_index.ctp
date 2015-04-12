<?php
$this->Html->addCrumb('Locais', '/admin/locais');
?>
<div class="locais index">
	<h2><?php echo __('Locais'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('local'); ?></th>
                        <th><?php echo $this->Paginator->sort('activo'); ?></th>
			<th class="actions"></th>
	</tr>
	<?php foreach ($locais as $local): ?>
	<tr>
		<td><?php echo h($local['Local']['id']); ?>&nbsp;</td>
		<td><?php echo h($local['Local']['local']); ?>&nbsp;</td>
                <td><?php echo $this->FormElements->drawCheckboxIcon($local['Local']['activo']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $local['Local']['id'])); ?>
			<?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $local['Local']['id']), null, __('Tem a certeza que deseja apagar o registo # %s?', $local['Local']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Novo Local'), array('action' => 'add')); ?></li>
	</ul>
</div>
