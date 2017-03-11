<?php
$this->assign('title', __('Gestion du portfolio'));
?>

<?= $this->Element('page_header', ['mainTitle' => $type->name]) ?>
<?= $this->Element('admin_portfolio_actions'); ?>
<div class="btn-group">
<?= $this->Html->link(__('Modifier'), ['_name' => 'admin_types_edit', $type->id], ['btn' => 'primary']) ?>
<?= $this->Form->postLink(__('Supprimer'), ['_name' => 'admin_types_delete', $type->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer le type {0}?', $type->id), 'btn' => 'danger'] ) ?>
</div>
<div class="my3">
    <table>
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
<h2><?= __('Création(s) liée(s)') ?></h2>
<?php if (!empty($type->creations)): ?>
<table>
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
