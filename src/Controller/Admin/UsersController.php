<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

     public function index()
     {
        $this->set('users', $this->Users->find('all'));
    }

    public function view($id)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'add']);
            }
	    $this->Flash->error(__('Unable to add the user.'), [
	    	'key' => 'auth'
	    ]);
        }
        $this->set('user', $user);
    }
    
    public function login()
    {

	    if ($this->request->is('post')) {
		    $user = $this->Auth->identify();
		    if ($user) {
			    $this->Auth->setUser($user);
			    return $this->redirect($this->Auth->redirectUrl());
		    }
		    $this->Flash->error(__('Pseudonyme ou mot de passe incorrect, veuillez réessayer'), [
		    	'key' => 'auth'
		    ]);
	    }
    }

    public function logout()
    {
	    return $this->redirect($this->Auth->logout());
    }

}
