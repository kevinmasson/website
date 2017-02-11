<?php

use Cake\Routing\Router;
$this->assign('title', "freelance basé à Strasbourg");
$this->append('meta');
echo $this->Html->meta(
	'description',
	__('Motion et web designer freelance basé sur Strasbourg, je réalise des projets à distance et sur place.')
);
echo $this->Html->meta(
	'keywords',
	__('motion design, web design, freelance, strasbourg')
);
$this->end();


?>

<div class="clear"></div>
<h1 class="sr-only">Freelance basé à Strasbourg</h1>
<h2>Créateur indépendant</h2>
<hr>
<p class="text-justify">Je me présente, Kevin Masson, étudiant en 3ème année de licence informatique et motion designer freelance. Étant passioné par tout ce qui touche l'art numérique et la programmation, je propose principalement mes services de motion design, mais aussi de graphisme et de web design. Je pratique aussi beaucoup la photographie, ce qui me permet de sortir un peu mon nez dehors (et oui, je ne suis pas en info pour rien) et d'avoir un meilleur oeil critique sur ce que je fait ! Toutes ces compétences  me permettent d'intervenir sur divers projets. Vous retrouverez dans mon portfolio quelques uns d'entre eux.</p>

<p style="text-align:center;"><a href="<?= Router::url(['_name' => 'contact']); ?>" class="btn btn-outline-success btn-lg"><?= __('Me contacter') ?></a></p>
<h2 class="sr-only"><?= __("Mes dernières créations");?></h2>
<hr>
<?php
echo $this->element("grid_creations", [
	"creations" => $creations
     ]);

?>
<p class="text-center"><a href="<?= Router::url(['_name' => 'portfolio']); ?>" class="btn btn-outline-info "><?= __('Plus de créations') ?></a></p>
<div class="alert alert-info" role="alert">
  <strong>En construction !</strong> Le site web est en cours de construction, celui sur lequel vous êtes actuellement n'est qu'une première version. Ne vous inquiétez donc pas, le thème bootstrap ne va pas rester là très longtemps !
</div>
