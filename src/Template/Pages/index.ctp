<?php

use Cake\Routing\Router;
$this->assign('title', "Motion Designer freelance");
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

$this->append('topContent');

?>
<div class="welcome-info my5 wrap">
    <?= $this->Html->image("km_pic_home.png", [
        "alt" => __("C'est moi de dos !"),
        "class" => "img-fluid mxa d-block"
    ]); ?>
<h1 class="text-center mt2 mb2">Bienvenue sur mon portail de l'internet<small class="d-block mt1">Attendez, restez !</small></h1>
    <p class="text-center pb5">Motion designer freelance basé à Strasbourg. Mais aussi passioné de photographie et étudiant en informatique. Essaye de rendre le monde meilleur en contribuant à <?= $this->Html->link("duik", "https://rainboxprod.coop/fr/outils/duik/", ['alt' =>  "Page du projet"]); ?>.</p>
</div>
<?php
$this->end();

?>
<h2 class="sr-only"><?= __("Mes dernières créations");?></h2>
<?php
echo $this->element("grid_creations", [
	"creations" => $creations
     ]);

?>
<p class="text-right">
	<a href="<?= Router::url(['_name' => 'portfolio']); ?>">
		<?= __('Je veux tout voir !') ?>
	</a>
</p>

<h2 id="about">À Propos</h2>
<hr>
<p class="text-justify">Je me présente, Kevin Masson, étudiant en 3ème année de licence informatique et motion designer freelance. Étant passioné par tout ce qui touche l'art numérique et la programmation, je propose principalement mes services de motion design, mais aussi de graphisme et de web design. Je pratique aussi beaucoup la photographie, ce qui me permet de sortir un peu mon nez dehors (et oui, je ne suis pas en info pour rien) et d'avoir un meilleur oeil critique sur ce que je fait ! Toutes ces compétences  me permettent d'intervenir sur divers projets. Vous retrouverez dans mon portfolio quelques uns d'entre eux.</p>

<p class="text-right">
	<a href="<?= Router::url(['_name' => 'contact']); ?>">
		<?= __('Me contacter') ?>
	</a>
</p>
