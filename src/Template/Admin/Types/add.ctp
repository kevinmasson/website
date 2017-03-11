<?php
$this->assign('title', __('Gestion du portfolio'));
?>
<?= $this->Element('page_header', ['mainTitle' => __('Ajouter un type')]) ?>
<?= $this->Element('admin_portfolio_actions'); ?>
<?= $this->Form->create($type) ?>
<?php
echo $this->Form->input('name', ['label' => 'Nom']);
        echo $this->Form->input('creations._ids', ['options' => $creations]);
?>
<?= $this->Form->button(__('Ajouter')) ?>
<?= $this->Form->end() ?>
