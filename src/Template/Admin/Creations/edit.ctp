<?php
$this->assign('title', __('Gestion du portfolio'));
?>
<div class="container">
	<?= $this->Element('page_header', ['mainTitle' => __('Modifier la création')]) ?>	
	<div class="row">
		<div class="col-md-3">
			<?= $this->Element('admin_portfolio_actions', ['noclose' => '']); ?>
			<?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $creation->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer la création {0}?', $creation->id), 'btn' => 'danger'] ) ?> 
				</div>
		</div>
		<div class="col-md-9 ">
    <?= $this->Form->create($creation, ['type' => 'file']) ?>
        <?php
	echo $this->Form->input('title', ['label' => 'Titre']);
	echo $this->Form->label('public', __('Public'));
	echo $this->Form->checkbox('public', ['hiddenField' => false, 'required' => false]);
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
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->Element('tinymce') ?>	
