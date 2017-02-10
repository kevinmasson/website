<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Types Controller
 *
 * @property \App\Model\Table\TypesTable $Types
 */
class TypesController extends AppController
{

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$types = $this->paginate($this->Types);

		$this->set(compact('types'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Type id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$type = $this->Types->get($id, [
			'contain' => ['Creations']
		]);

		$this->set('type', $type);
		$this->set('_serialize', ['type']);
	}

	public function frontView($slug = null){
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
			->contain(['Types'])
			->order(['Creations.created' => 'desc'])
			->all();

		//debug($creations);



		$this->set('typeName', $typeName);
		$this->set('creations', $creations);

	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$type = $this->Types->newEntity();
		if ($this->request->is('post')) {
			$type = $this->Types->patchEntity($type, $this->request->data);
			if ($this->Types->save($type)) {
				$this->Flash->success(__('Le type a été créé.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('Le type n\' a pas pu être créé, veuillez réessayer.'));
			}
		}
		$creations = $this->Types->Creations->find('list', ['limit' => 200]);
		$this->set(compact('type', 'creations'));
		$this->set('_serialize', ['type']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Type id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$type = $this->Types->get($id, [
			'contain' => ['Creations']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$type = $this->Types->patchEntity($type, $this->request->data);
			if ($this->Types->save($type)) {
				$this->Flash->success(__('Le type a été modifié.'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('Le type n\' a pas pu être modifié, veuillez réessayer.'));
			}
		}
		$creations = $this->Types->Creations->find('list', ['limit' => 200]);
		$this->set(compact('type', 'creations'));
		$this->set('_serialize', ['type']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Type id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$type = $this->Types->get($id);
		if ($this->Types->delete($type)) {
			$this->Flash->success(__('Le type a été supprimé.'));
		} else {
			$this->Flash->error(__('Le type n\' a pas pu être supprimé, veuillez réessayer.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
