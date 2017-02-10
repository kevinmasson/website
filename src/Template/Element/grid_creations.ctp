<?php

use Cake\Routing\Router;

?>



<?php

if( !$creations->isEmpty()):
$i = 0;
foreach ($creations as $creation):
	
	if($i % 3 == 0){
?>
	<div class='card-deck'>
<?php
	}
?>
	<div class="card">
		<a href="<?= Router::url(['_name' => 'portfolio_item', $creation->slug])?>">
			<?= $this->Html->cimage($creation, 'thumbnail', ['alt' => $creation->title, 'class' => 'img-fluid']); ?>
		</a>
  		<div class="card-block">
			<h3 class="sr-only card-title"><a href="<?=			
		Router::url(['_name' => 'portfolio_item', $creation->slug])
		?>"><?= $creation->title ?></a></h3>
			<h6 class="card-subtitle text-muted">
			<?php $start = 0;
				$count = count($creation->types);
				foreach ($creation->types as $type):
					echo $type->name;
					$start++;
					if($count > 1 && $start < $count) echo ", ";
				endforeach;
			?>
			</h6>
  		</div>
	</div>
<?php
	$i += 1;
	if($i % 3 == 0){
?>
	</div>
<?php
	}
endforeach;

if($i % 3 != 0):

	for ($j = 0; $j <= 2 - ($i%3); $j++) { ?>
		<div class="card" style="opacity:0;"></div>
<?php
	}
?>
</div>
<?php
endif;

else:
?>
<p>Il n'y a rien ici !</p>
<?php
endif;
?>
