<?php
$this->assign('title', __('Gestion du portfolio'));
?>
<div class="container">
	<?= $this->Element('page_header', ['mainTitle' => __('Ajouter un type')]) ?>	
	<div class="row">
		<div class="col-md-3">
			<?= $this->Element('admin_portfolio_actions'); ?>
		</div>
		<div class="col-md-9">
    			<?= $this->Form->create($type) ?>
		        <?php
				echo $this->Form->input('name', ['label' => 'Nom']);
            			echo $this->Form->input('creations._ids', ['options' => $creations]);
		        ?>
			<?= $this->Form->button(__('Ajouter')) ?>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>	
