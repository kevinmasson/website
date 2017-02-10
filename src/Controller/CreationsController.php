<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Creations Controller
 *
 * @property \App\Model\Table\CreationsTable $Creations
 */
class CreationsController extends AppController
{



	public function index()
	{
		$this->loadModel('Types');
		$creations = $this->Creations->find('all', [
		   	'conditions' => ['Creations.public =' => 1],
			'contain' => ['Types'],
			'order' => ['Creations.created' => 'desc']
		])->all();

		$types = $this->Types->find('all');

		$this->set(compact('creations'));
		$this->set(compact('types'));


	}


	public function view($slug = null){
		$creation = $this->Creations->find('all', [
			'conditions' => ['Creations.slug =' => $slug],
			'contain' => ['Types']
		])->first();


		if(is_null($creation)) throw new RecordNotFoundException(__("Création non trouvée"));

		$this->set('creation', $creation);



	}

}
