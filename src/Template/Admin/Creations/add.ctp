<?php
$this->assign('title', __('Gestion du portfolio'));
?>
<?= $this->Element('page_header', ['mainTitle' => __('Ajouter une création')]) ?>
<?= $this->Element('admin_portfolio_actions'); ?>
<?= $this->Form->create($creation, ["type" => "file"]) ?>
    <?php
echo $this->Form->input('title', ['label' => 'Titre']);
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
echo $this->Form->input('thumbnail', ['label' => 'Miniature', 'type' => 'file']);
echo $this->Form->input('body', ['label' => 'Contenu', 'class' => 'wisiwyg', 'required' => false]);
    echo $this->Form->input('types._ids', ['options' => $types]);
?>
<?= $this->Form->button(__('Ajouter')) ?>
<?= $this->Form->end() ?>
<?= $this->Element('tinymce') ?>
