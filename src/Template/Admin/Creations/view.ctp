<?php
$this->assign('title', 'Gestion du portfolio');
?>
<div class="container">
	<?= $this->Element('page_header', ['mainTitle' => $creation->title]) ?>	
	<div class="row">
		<div class="col-md-3">
			<?= $this->Element('admin_portfolio_actions', ['noclose' => '']); ?>
			<?= $this->Html->link(__('Modifier'), ['_name' => 'admin_creations_edit', $creation->id], ['btn' => 'primary']) ?> 
			<?= $this->Form->postLink(__('Supprimer'), ['_name' => 'admin_creations_delete', $creation->id], ['confirm' => __('Êtes vous sûr de vouloir supprimer la création {0}?', $creation->id), 'btn' => 'danger'] ) ?> 
			</div>
		</div>
		<div class="col-md-9 ">
			<div class="row">
			<div class="col-md-6">
				<p><?= $this->Html->cimage($creation, 'thumbnail', ['alt' => 'Miniature', 'class' => "img-fluid"]); ?></p>
			</div>
			<div class="col-md-6">
				<table class="vertical-table">
					<tr>
				            <th scope="row"><?= __('Title') ?></th>
				            <td><?= h($creation->title) ?></td>
				        </tr>
				        <tr>
				            <th scope="row"><?= __('Slug') ?></th>
				            <td><?= h($creation->slug) ?></td>
				        </tr>
				        <tr>
				            <th scope="row"><?= __('Public') ?></th>
				            <td><?= $creation->public == 1 ? __('Oui') : __('Non'); ?></td>
				        </tr>
				        <tr>
				            <th scope="row"><?= __('Id') ?></th>
				            <td><?= $this->Number->format($creation->id) ?></td>
				        </tr>
				        <tr>
				            <th scope="row"><?= __('Created') ?></th>
				            <td><?= h($creation->created) ?></td>
				        </tr>
				        <tr>
				            <th scope="row"><?= __('Modified') ?></th>
				            <td><?= h($creation->modified) ?></td>
					</tr>
			    </table>
			</div>
			</div>
			<div id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="card">
			    <div class="card-header" role="tab" id="headingOne">
			      <h5 class="mb-0">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				<?= __('Contenu'); ?></a>
			      </h5>
			    </div>
			    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
				    <div class="card-block"><?= $creation->body; ?>
				      </div>
			    </div>
			  </div>	
			</div>
		</div>
	</div>
</div>
<div class="container mt20">
<hr>
<h2><?= __('Type(s) lié(s)') ?></h2>
<?php if (!empty($creation->types)): ?>
<table class="table table-hover">
	<tr>
		<th scope="col"><?= __('Id') ?></th>
		<th scope="col"><?= __('Nom') ?></th>
	</tr>
	<?php foreach ($creation->types as $types): ?>
	<tr>
		<td><?= h($types->id) ?></td>
		<td><?= $this->Html->link($types->name, ['controller' => 'Types', '_name' => 'admin_types_view', $types->id]) ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>
</div>
