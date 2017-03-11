<?php
$this->assign('title', __('Gestion du portfolio'));
?>
<?= $this->Element('page_header', ['mainTitle' => 'Gestion du portfolio', 'subtitle' => "Types"]) ?>

<?= $this->Element('admin_portfolio_actions'); ?>
<div class="types my3">
	    <table>
	        <thead>
	            <tr>
	                <th><?= $this->Paginator->sort('id') ?></th>
	                <th><?= $this->Paginator->sort('name') ?></th>
	                <th><?= $this->Paginator->sort('slug') ?></th>
	                <th><?= __('Actions') ?></th>
	            </tr>
	        </thead>
	        <tbody>
	            <?php foreach ($types as $type): ?>
	            <tr>
	                <td><?= $this->Number->format($type->id) ?></td>
	                <td><?= $this->Html->link($type->name, ['action' => 'view', $type->id]) ?></td>
	                <td><?= h($type->slug) ?></td>
	                <td class="actions">
	                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $type->id]) ?>
	                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $type->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer le type {0}?', $type->id)]) ?>
	                </td>
	            </tr>
	            <?php endforeach; ?>
	        </tbody>
	    </table>

		<nav aria-label="Page navigation">
		  <ul class="pagination">
		    <?= $this->Paginator->prev('< ' . __('previous')) ?>
	            <?= $this->Paginator->numbers() ?>
	            <?= $this->Paginator->next(__('next') . ' >') ?>
		  </ul>
	</nav>
</div>
