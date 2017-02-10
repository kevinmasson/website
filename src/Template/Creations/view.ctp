
<?php

use Cake\Routing\Router;

$this->assign('title', __($creation->title));

$tags = "";

if (!empty($creation->types)):
	foreach ($creation->types as $type):
		$tags .= 
		'<a class="btn btn-outline-secondary btn-sm" href="' .
		Router::url(['_name' => 'portfolio_type', $type->slug]) .  
		'">' .
		__(h($type->name)) .
		'</a>';
endforeach;
endif;
/*
<?php foreach ($creation->types as $types): ?>
		<td><?= h($types->name) ?></td>
		    <?= $this->Html->link(__('View'), ['controller' => 'Types', 'action' => 'view', $types->id]) ?>
	    <?php endforeach; ?>
	<?php endif; ?>
 */

?>

<div class="creation">   

<?= $this->Element('page_header', ['mainTitle' => __($creation->title)]) ?>	
<div class="row" style='margin-top:20px;'>
	<div class="col-md-2">
		<?= $tags ?>
	</div>
	<div class="creation-content col-md-8"> 
		<?= $creation->body ?>
	</div>
	<div class="col-md-2 text-muted text-capitalize">
	    <p class="text-xs-right"><?= h($creation->created->i18nFormat('MMMM y', null, 'fr-FR')) ?></p>
	</div>
</div>
</div>
