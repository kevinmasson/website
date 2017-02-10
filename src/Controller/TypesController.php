<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Types Controller
 *
 * @property \App\Model\Table\TypesTable $Types
 */
class TypesController extends AppController
{


	public function view($slug = null){
		$this->loadModel('Creations');

		$typeName = $this->Types->find('all', [
			'conditions' => ['Types.slug' => $slug]
		])->first();

		if(is_null($typeName)) throw new RecordNotFoundException(__("Type innexistant"));

		$typeName = $typeName->name;


		$creations = $this->Creations->find('all')
			->matching('Types', function($q) use ($slug) {
				return $q->where(['Types.slug' => $slug]);
			})
			->where(['Creations.public =' => 1])
			->contain(['Types'])
			->order(['Creations.created' => 'desc'])
			->all();

		//debug($creations);



		$this->set('typeName', $typeName);
		$this->set('creations', $creations);

	}

}
