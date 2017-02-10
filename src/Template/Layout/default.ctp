<?php

use Cake\Routing\Router;

$siteTitle = 'Kevin Masson';
$currentUrl = Router::normalize($this->request->here);
$this->append('meta');
echo $this->Html->meta(
	'author',
	'Kevin Masson'
);
if($this->fetch('noindex') || $this->request->param('prefix') === 'admin')
	echo $this->Html->meta(
		'robots',
		'none'
	);
else
	echo $this->Html->meta(
		'robots',
		'all'
	);
$this->end();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?= $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $siteTitle ?> - <?= $this->fetch('title') ?></title>

    <?= $this->Html->meta('icon', 'favicon.png') ?>
    <?= $this->Html->css('bootstrap-reboot.min.css') ?>
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('bootstrap-grid.min.css') ?>
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?> <?= $this->Html->script('tinymce/tinymce.min.js') ?> 
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>
<?php
if (isset($userDetails) && !is_null($userDetails) && $userDetails['role'] === 'admin')
   echo $this->Element('admin_nav');
?>
	<nav class="navbar navbar-full navbar-dark bg-inverse">
	<button class="navbar-toggler hidden-lg-up" 
		type="button" data-toggle="collapse" 
		data-target="#regularNavResponsive" 
		aria-controls="regularNavResponsive" aria-expanded="false" 
		aria-label="Toggle navigation">
	</button>
	<div class="collapse navbar-toggleable-md" id="regularNavResponsive">

	<a class="navbar-brand" href="<?= Router::url(['_name' => 'home']) ?>"><?= $siteTitle ?></a>
		<ul class="nav navbar-nav">
		<li class="nav-item <?= $currentUrl === '/' ? 'active' : ''; ?>">
			<a class="nav-link" href="<?= Router::url(['_name' => 'home']) ?>">Accueil<span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item <?= substr($currentUrl, 0, strlen('/portfolio')) === '/portfolio' ? 'active' : ''; ?>">		
				<a class="nav-link" href="<?= Router::url(['_name' => 'portfolio']); ?>">Portfolio</a>
			</li>
			<li class="nav-item <?= $currentUrl === '/contact' ? 'active' : ''; ?>">		
				<a class="nav-link" href="<?= Router::url(['_name' => 'contact']); ?>">Contact</a>
			</li>
		</ul>
	</div>
	</nav>
    <div class="container" style='margin-top:40px;padding-bottom:120px;'>
      <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
    </div>
    <footer>
	<nav class="navbar navbar-fixed-bottom navbar-light navbar-full bg-faded">
		<span class="navbar-text float-xs-left">
			2016 &#169; Tous droits reservés
		</span>
		<span class="navbar-text float-xs-right">
			<a href="https://www.facebook.com/kmassonstudio/">facebook</a>, 
			<a href="https://github.com/kevinmasson/">github</a>, 
			<a href="https://fr.linkedin.com/in/kevin-masson-968a35113">linkedin</a>, 
			<a href="https://twitter.com/mindlessocto">twitter</a>, 
			<a href="https://500px.com/km-studio">flickr</a> <span class="text-muted"> - 
			<a class="text-muted" href="https://github.com/kevinmasson/website">v0.1</a></span>
		</span>
	</nav>
    </footer>
</body>
</html>
