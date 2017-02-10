<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\Time;

/**
 * Creations Controller
 *
 * @property \App\Model\Table\CreationsTable $Creations
 */
class CreationsController extends AppController
{


	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$creations = $this->paginate($this->Creations);

		$this->set(compact('creations'));
	}
	

	/**
	 * View method
	 *
	 * @param string|null $id Creation id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$creation = $this->Creations->get($id, [
			'contain' => ['Types']
		]);

		$this->set('creation', $creation);
		$this->set('_serialize', ['creation']);
	}


	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$creation = $this->Creations->newEntity();
		if ($this->request->is('post')) {
			$creation = $this->Creations->patchEntity($creation, $this->request->data);
			$t = Time::createFromFormat(
				'Y m',
				$this->request->data['created']['year'] . ' ' . 
				$this->request->data['created']['month'],	
				'Europe/Paris'
			);
			$creation->created = $t;

			if ($this->Creations->save($creation)) {
				$this->Flash->success(__('La création a été ajoutée.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('La création n\'a pas pu être ajoutée, veuillez réessayer.'));
			}
		}
		$types = $this->Creations->Types->find('list', ['limit' => 200]);
		$this->set(compact('creation', 'types'));
		$this->set('_serialize', ['creation']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Creation id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$creation = $this->Creations->get($id, [
			'contain' => ['Types']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$creation = $this->Creations->patchEntity($creation, $this->request->data);
			$t = Time::createFromFormat(
				'Y m',
				$this->request->data['created']['year'] . ' ' . 
				$this->request->data['created']['month'],	
				'Europe/Paris'
			);
			$creation->created = $t;
		   if(array_key_exists('public', $this->request->data)){
		      $creation->public = 1;
		   }else{
		      $creation->public = 0;
		   }
			if ($this->Creations->save($creation)) {
				$this->Flash->success(__('La création a été modifiée.'));

			} else {
				$this->Flash->error(__('La création n\'a pas pu être modifiée, veuillez réessayer.'));
			}
		}
		$types = $this->Creations->Types->find('list', ['limit' => 200]);
		$this->set(compact('creation', 'types'));
		$this->set('_serialize', ['creation']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Creation id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$creation = $this->Creations->get($id);
		if ($this->Creations->delete($creation)) {
			$this->Flash->success(__('La création a été supprimée.'));
		} else {
			$this->Flash->error(__('La création n\'a pas pu être supprimée. Veuillez réessayer.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
