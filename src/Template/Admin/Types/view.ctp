<?php
$this->assign('title', __('Gestion du portfolio'));
?>

<div class="container">
	<?= $this->Element('page_header', ['mainTitle' => $type->name]) ?>	
	<div class="row">
		<div class="col-md-3">
			<?= $this->Element('admin_portfolio_actions', ['noclose' => '']); ?>
			<?= $this->Html->link(__('Modifier'), ['_name' => 'admin_types_edit', $type->id], ['btn' => 'primary']) ?> 
			<?= $this->Form->postLink(__('Supprimer'), ['_name' => 'admin_types_delete', $type->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer le type {0}?', $type->id), 'btn' => 'danger'] ) ?> 
			</div>
		</div>
		<div class="col-md-9">
		    <table class="vertical-table">
			<tr>
			    <th scope="row"><?= __('Name') ?></th>
			    <td><?= h($type->name) ?></td>
			</tr>
			<tr>
			    <th scope="row"><?= __('Slug') ?></th>
			    <td><?= h($type->slug) ?></td>
			</tr>
			<tr>
			    <th scope="row"><?= __('Id') ?></th>
			    <td><?= $this->Number->format($type->id) ?></td>
			</tr>
		    </table>
		</div>
	</div>
</div>

<div class="mt20 container">
	<h2><?= __('Création(s) liée(s)') ?></h2>
	<?php if (!empty($type->creations)): ?>
	<table class="table table-hover">
	    <tr>
		<th scope="col"><?= __('Id') ?></th>
		<th scope="col"><?= __('Titre') ?></th>
	    </tr>
	    <?php foreach ($type->creations as $creations): ?>
	    <tr>
		<td><?= h($creations->id) ?></td>
		<td><?= $this->Html->link($creations->title, ['_name' => 'admin_creations_view', $creations->id]) ?></td>
	    </tr>
	    <?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>
