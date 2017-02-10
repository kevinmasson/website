<?= $this->Element('page_header', ['mainTitle' => 'Administration', 'subtitle' => 'accès au panel']); ?>
<?= $this->Flash->render('auth') ?>
<?php
$this->Form->templates($form_templates['textual']);
//debug($this->Form->templates());
?>
<?= $this->Form->create() ?>
<?= $this->Form->input('username', [
	'label' => [
		'text' => 'Pseudonyme'
	],
	'autofocus'
]) ?>
	<?= $this->Form->input('password', [
		'label' => [
			'text' => 'Mot de passe'
		]
	]) ?>
<?= $this->Form->button(__('Connexion')); ?>
<?= $this->Form->end() ?>
