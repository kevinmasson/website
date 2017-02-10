<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Inflector;

class CreationsTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('creations');
        $this->displayField('title');
        $this->primaryKey('id');

	$this->addBehavior('Timestamp');

	$this->addBehavior('Josegonzalez/Upload.Upload', [
	   'thumbnail' => [
	      'path' => 'webroot{DS}img{DS}portfolio{DS}thumbnails{DS}',
	      'fields' => [
		'dir' => 'thumbnail_dir'
	      ]
	   ] 
	]);

        $this->belongsToMany('Types', [
            'foreignKey' => 'creation_id',
            'targetForeignKey' => 'type_id',
            'joinTable' => 'creations_types'
        ]);
    }

    public function beforeSave($event, $entity, $options){
	    $entity->slug = Inflector::slug($entity->title);

	    return true;
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
	    ->allowEmpty('id', 'create')
	    ->allowEmpty('public', 'create');

        $validator
            ->notEmpty('title', __('Veuillez saisir un titre.'))
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => __('Le titre doit être unique')]);

	$validator->notEmpty('thumbnail', __('Une miniature est requise.'), 'create'); 

        $validator
            ->notEmpty('body');

        return $validator;
    }


    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['slug']));
        $rules->add($rules->isUnique(['title']));

        return $rules;
    }
}
