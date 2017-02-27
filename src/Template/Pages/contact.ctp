<?php
$this->assign('title', "Formulaire de contact");
$this->append('meta');
echo $this->Html->meta(
	'description',
	__('Contacter moi via ce formulaire pour une demande de devis ou autre.')
);
$this->end();


echo $this->Element('page_header', ['mainTitle' => __('Contact')]);

echo $this->Form->create($contact);
echo $this->Form->input('name',[
	'label' => __('Prénom et nom'),
	'required' => true
]);
echo $this->Form->input('subject', [
	'label' => __('Sujet'),
	'required' => true
]);
echo $this->Form->input('email', [
	'label' => __('Email'),
	'required' => true
]);
echo $this->Form->input('body', [
	'label' => __('Message (entre 100 et 700 caractères)'),
	'required' => true
]);
echo $this->Form->button(__('Envoyer'), [
    'class' => 'mt3'
]);
echo $this->Form->end();

?>
