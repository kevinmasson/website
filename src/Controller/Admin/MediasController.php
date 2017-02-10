<?php


namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Form\UploadForm;

class MediasController extends AppController
{
   public function index()
   {
      $mediaForm = $this->Medias->newEntity();
      if ($this->request->is('post')) {
	 $newMedia = $this->Medias->patchEntity($mediaForm, $this->request->data);
	 if ($this->Medias->save($newMedia)) {
	    $this->Flash->success(__('Le fichier a bien été ajouté.'));
	    return $this->redirect(['action' => 'index']);
	 } else {
	    $this->Flash->error(__('Le fichier  n\'a pas pu être ajouté, veuillez réessayer.'));
	 }

      }
      $mediaForm = $this->Medias->newEntity();
      $this->set(compact('mediaForm'));
      $medias = $this->paginate($this->Medias->find('all', [
			'order' => ['Medias.created' => 'desc'],
		]));

      $this->set(compact('medias'));
   }
}

?>
