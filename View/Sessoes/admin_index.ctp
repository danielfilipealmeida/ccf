<?php
$this->Html->addCrumb('Sessões', '/admin/sessoes');
?>
<div class="sessoes index">
	<h2><?php echo __('Sessões'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('titulo'); ?></th>
                        <th><?php echo $this->Paginator->sort('realizacao'); ?></th>
                        <th><?php echo $this->Paginator->sort('ano'); ?></th>
                        <th><?php echo $this->Paginator->sort('origem'); ?></th>
                        <th><?php echo $this->Paginator->sort('data'); ?></th>
                         <th><?php echo $this->Paginator->sort('activo'); ?></th>
			<th class="actions"></th>
	</tr>
	<?php foreach ($sessoes as $sessao): ?>
	<tr>
		<td><?php echo h($sessao['Sessao']['id']); ?>&nbsp;</td>
		<td><?php echo h($sessao['Sessao']['titulo']); ?>&nbsp;</td>
                <td><?php echo h($sessao['Sessao']['realizacao']); ?>&nbsp;</td>
                <td><?php echo h($sessao['Sessao']['ano']); ?>&nbsp;</td>
                <td><?php echo h($sessao['Sessao']['origem']); ?>&nbsp;</td>
                <td><?php echo h($sessao['Sessao']['data']); ?>&nbsp;</td>
                <td><?php echo $this->FormElements->drawCheckboxIcon($sessao['Sessao']['activo']); ?>&nbsp;</td>
                
		<td class="actions">
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $sessao['Sessao']['id'])); ?>
			<?php echo $this->Form->postLink(__('Apagar'), array('action' => 'delete', $sessao['Sessao']['id']), null, __('Tem a certeza que deseja apagar o registo # %s?', $sessao['Sessao']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Nova Sessão'), array('action' => 'add')); ?></li>
	</ul>
</div>
