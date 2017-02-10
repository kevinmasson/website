<?php
$this->assign('title', __('Gestion du portfolio'));
?>

<div class="container">
	<?= $this->Element('page_header', ['mainTitle' => __('Modifier un type')]) ?>	
	<div class="row">
		<div class="col-md-3">
			<?= $this->Element('admin_portfolio_actions', ['noclose' => '']); ?>
			<?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $type->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer le type {0}?', $type->id), 'btn' => 'danger'] ) ?> 
			</div>
		</div>
		<div class="col-md-9">
		    <?= $this->Form->create($type) ?>
			<?php
		        echo $this->Form->input('name', ['label' => 'Nom']);
		    
/bin/bash: :tabe: command not found
        		?>
		    <?= $this->Form->button(__('Modifier')) ?>
		    <?= $this->Form->end() ?>
		</div>
	</div>
</div>
