<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Mailer\Email;
use App\Form\ContactForm;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

	/**
	 * Displays a view
	 *
	 * @return void|\Cake\Network\Response
	 * @throws \Cake\Network\Exception\ForbiddenException When a directory traversal attempt.
	 * @throws \Cake\Network\Exception\NotFoundException When the view file could not
	 *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
	 */
	public function display()
	{
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		$this->set(compact('page', 'subpage'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingTemplateException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function contact(){
		$contact = new ContactForm();
		if ($this->request->is('post')) {
			if ($contact->execute($this->request->data)) {
				$this->Flash->success(__('Votre mail a bien été envoyé, je vous répondrais dans les plus bref délais.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('Une erreur est survenue lors de l\'envoi. Veuillez réessayer ou envoyez directement un mail à {0}.', Configure::read('contactFormReceive')));
			}
		}
		$this->set('contact', $contact);
	}

	public function index(){

		$this->loadModel('Creations');
		$creations = $this->Creations->find('all', [
			'conditions' => ['Creations.public =' => 1],
			'contain' => ['Types'],
			'order' => ['Creations.created' => 'desc'],
			'limit' => 3
		])->all();

		$this->set(compact('creations'));
	}
}
