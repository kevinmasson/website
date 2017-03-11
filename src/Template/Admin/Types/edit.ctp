<?php
$this->assign('title', __('Gestion du portfolio'));
?>

<?= $this->Element('page_header', ['mainTitle' => __('Modifier un type')]) ?>
<?= $this->Element('admin_portfolio_actions')?>
<div class="btn'group">
<?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $type->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer le type {0}?', $type->id), 'btn' => 'danger'] ) ?>
</div>
<?= $this->Form->create($type) ?>
<?php
echo $this->Form->input('name', ['label' => 'Nom']);

?>
<?= $this->Form->button(__('Modifier')) ?>
<?= $this->Form->end() ?>
