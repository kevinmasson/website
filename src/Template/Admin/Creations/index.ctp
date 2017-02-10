<?php
$this->assign('title', 'Gestion du portfolio');
?>
<?= $this->Element('page_header', ['mainTitle' => 'Gestion du portfolio', 'subtitle' => "Créations"]) ?>

<div class="creations row">
	<div class="col-md-3">
		<?= $this->Element('admin_portfolio_actions'); ?>
	</div>
	<div class="col-md-9">
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('slug') ?></th>
                <th><?= $this->Paginator->sort('public') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($creations as $creation): ?>
            <tr>
                <td><?= $this->Number->format($creation->id) ?></td>
		<td><?= $this->Html->link($creation->title, ['_name' => 'admin_creations_view', $creation->id]) ?></td>
                <td><?= h($creation->slug) ?></td>
		<td><?= $creation->public == 1 ? __('Oui') : __('Non'); ?></td>
                <td><?= h($creation->created) ?></td>
                <td><?= h($creation->modified) ?></td>
                <td class="actions">
                    
                    <?= $this->Html->link(__('Edit'), ['_name' => 'admin_creations_edit', $creation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['_name' => 'admin_creations_delete', $creation->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer la création {0}?', $creation->id)]) ?>
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
</div>
