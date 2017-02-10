<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class UploadForm extends Form
{

   protected function _buildSchema(Schema $schema)
   {
      return $schema->
	 addField('media', ['type' => 'file', 'label' => __('Média')])
	 ->addField('name', ['type' => 'string', 'label' => __('Nom du média')]);
   }

   protected function _buildValidator(Validator $validator)
   {
      return $validator->notEmpty('media', __('Un fichier doit être fournis'));
   }

   protected function _execute(array $data, array $options = [])
   {
  	return true; 
   }
}
?>
