<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;

class MediasTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('medias');
        $this->primaryKey('id');

	$this->addBehavior('Timestamp');

	$this->addBehavior('Josegonzalez/Upload.Upload', [
	   'file' => [
	      'path' => 'webroot{DS}medias{DS}{year}{DS}{month}{DS}',
	      'fields' => [
		'dir' => 'file_dir'
	     ],
	     'nameCallback' => function(array $data, array $settings){
		$extension = pathinfo($data['name'], PATHINFO_EXTENSION);
		$name = Inflector::slug(time().'-'.mt_rand());
		debug($name);
		return $name . '.' . $extension;
	     },	
	     'keepFilesOnDelete' => false
	   ]
	]);

    }


    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

	$validator->notEmpty('description', __('Une description est requise.'));
	$validator->notEmpty('file', __('Un fichier est requis.'), 'create'); 

        return $validator;
    }

}
