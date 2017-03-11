
<?php

use Cake\Routing\Router;

$this->assign('title', __($creation->title));

$tags = "";

if (!empty($creation->types)):
    ?> <p> <?php
    $first = True;
foreach ($creation->types as $type):
    if(!$first) $tags .= ", ";
        $first = False;
		$tags .=
		'<a href="' .
		Router::url(['_name' => 'portfolio_type', $type->slug]) .
		'">' .
		__(h($type->name)) .
        '</a>';

endforeach;
    ?> </p> <?php
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
	<p>
		<?= h($creation->created->i18nFormat('MMMM y', null, 'fr-FR')) ?> - <?= $tags ?>
	</p>
	<div class="creation-content">
		<?= $creation->body ?>
	</div>
</div>
