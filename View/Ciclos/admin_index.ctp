<?php
$this->Html->addCrumb('Ciclos', '/admin/ciclos');
?>
<div class="ciclos index">
	<h2><?php echo __('Ciclos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('titulo'); ?></th>
                        <th><?php echo $this->Paginator->sort('data_inicio'); ?></th>
                        <th><?php echo $this->Paginator->sort('data_fim'); ?></th>
                         <th><?php echo $this->Paginator->sort('activo'); ?></th>
			<th class="actions"></th>
	</tr>
	<?php foreach ($ciclos as $ciclo): ?>
	<tr>
		<td><?php echo h($ciclo['Ciclo']['id']); ?>&nbsp;</td>
		<td><?php echo h($ciclo['Ciclo']['titulo']); ?>&nbsp;</td>
                <td><?php echo h($ciclo['Ciclo']['data_inicio']); ?>&nbsp;</td>
                <td><?php echo h($ciclo['Ciclo']['data_fim']); ?>&nbsp;</td>
                <td><?php echo $this->FormElements->drawCheckboxIcon($ciclo['Ciclo']['activo']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $ciclo['Ciclo']['id'])); ?>
			<?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $ciclo['Ciclo']['id']), null, __('Tem a certeza que deseja apagar o registo # %s?', $ciclo['Ciclo']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Novo Cíclo'), array('action' => 'add')); ?></li>
	</ul>
</div>
