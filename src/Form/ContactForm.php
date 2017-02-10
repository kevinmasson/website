<?php
// in src/Form/ContactForm.php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class ContactForm extends Form
{

	protected function _buildSchema(Schema $schema)
	{
		return $schema->addField('name', 'string')
			->addField('subject', 'string')
			->addField('email', ['type' => 'string'])
			->addField('body', ['type' => 'text']);
	}

	protected function _buildValidator(Validator $validator)
	{
		$validator->add('email', 'format', [
			'rule' => 'email',
			'message' => __('Une addresse email valide est requise') 
		]);

		$validator->notEmpty('subject', __('Un sujet est requis (entre 10 et 70 caractères)'));
		$validator->add('subject', 'minLength', [
			'rule' => ['minLength', 10],
			'message' => __('Votre sujet est trop court (entre 10 et 70 caractères)')
		]);
		$validator->add('subject', 'maxLength', [
			'rule' => ['maxLength', 70],
			'message' => __('Votre sujet est trop long (entre 10 et 70 caractères)')
		]);

		$validator->notEmpty('body', __('Un message est requis (entre 100 et 700 caractères)'));
		$validator->add('body', 'minLength', [
			'rule' => ['minLength', 100],
			'message' => __('Votre message est trop court (entre 100 et 700 caractères)')
		]);
		$validator->add('body', 'maxLength', [
			'rule' => ['maxLength', 700],
			'message' => __('Votre message est trop long (entre 100 et 700 caractères)')
		]);

		$validator->notEmpty('name', __('Un nom est requis (entre 6 et 70 caractères)'));
		$validator->add('name', 'minLength', [
			'rule' => ['minLength', 6],
			'message' => __('Votre nom est trop court (entre 6 et 70 caractères)')
		]);
		$validator->add('name', 'maxLength', [
			'rule' => ['maxLength', 70],
			'message' => __('Votre nom est trop long (entre 6 et 70 caractères)')
		]);


		return $validator;
	}

	protected function _execute(array $data)
	{

		$message = "
Sujet : " . $data['subject'] . "\n
Nom : " . $data['name'] . "\n
Mail : " . $data['email'] . "\n

_______________________________
" . $data['body'] . "
______________________________
";
		$email = new Email('default');
		$email->from([Configure::read('contactFormSender') => $data['name']])
			->to(Configure::read('contactFormReceive'))
			->subject('KM.COM CF: ' . $data['subject'])
			->send($message);

		return true;
	}
}
