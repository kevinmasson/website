<?php
$this->assign('title', __('Gestion du portfolio'));
?>
<?= $this->Element('page_header', ['mainTitle' => __('Modifier la création')]) ?>
<?= $this->Element('admin_portfolio_actions') ?>
<div class="btn-group">
<?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $creation->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer la création {0}?', $creation->id), 'btn' => 'danger'] ) ?>
</div>
<?= $this->Form->create($creation, ['type' => 'file']) ?>
<?php
    echo $this->Form->input('title', ['label' => 'Titre']);
    ?><div class="form-group"><?php
    echo $this->Form->label('public', __('Public'));
    echo $this->Form->checkbox('public', ['hiddenField' => false, 'required' => false]);
    ?></div><div class="form-group"><?php
    echo $this->Form->label('created', __('Date'));
    echo $this->Form->datetime('created', [
        'default' => 'time',
        'year' => [
           'data-type' => 'year',
        ],
        'month' => [
           'class' => 'month-class',
           'data-type' => 'month',
        ],
        'day' => false, 'minute' => false, 'hour' => false
        ]);

    ?></div><?php
    echo $this->Form->input('thumbnail', ['label' => 'Miniature', 'type' => 'file']);
    echo $this->Form->input('body', ['label' => 'Contenu', 'class' => 'wisiwyg', 'required' => false]);
    echo $this->Form->input('types._ids', ['options' => $types]);
?>
<?= $this->Form->button(__('Valider')) ?>
<?= $this->Form->end() ?>
</div>
<?= $this->Element('tinymce') ?>
