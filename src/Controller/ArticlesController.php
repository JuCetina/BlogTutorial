<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

class ArticlesController extends AppController{
	public function initialize(){
		parent::initialize();
		$this->loadComponent('Flash');
	}

	public function index(){
		$this->set('articles', $this->Articles->find('all')); //Trae todos los articulos y los pasa a la vista index.ctp
	}

	public function view($id){
		$article = $this->Articles->get($id); //Trae un articulo y lo guarda en $article
		$this->set(compact('article')); //Pasa los datos a la vista view.ctp
	}	 

	public function add(){
		$article = $this->Articles->newEntity();
		if ($this->request->is('post')) { //Si la peticion es POST
			$article = $this->Articles->patchEntity($article, $this->request->data);
			$article->user_id = $this->Auth->user('id'); //Obtiene el id del usuario logueado
			$newData = ['user_id' => $this->Auth->user('id')]; //Guarda el id del usuario logueado en $newData
        	$article = $this->Articles->patchEntity($article, $newData);
			if($this->Articles->save($article)){ //Si se guarda en la base de datos (si cumple con todas la validaciones)
				$this->Flash->success(__('Your article has been saved.')); //Mensaje de éxito al usuario
				return $this->redirect(['action' => 'index']);	//Redirecciona al index		
			}
			$this->Flash->error(__('Unable to add your article.')); //Mensaje de fracaso de la acción al usuario
		}
		$this->set('article', $article);

		$categories = $this->Articles->Categories->find('treeList'); //Obtiene el arbol de categorías
        $this->set(compact('categories')); //Pasa los datos a la vista
	}

	public function edit($id = null){
    	$article = $this->Articles->get($id); //Obtiene el artículo por id y lo guarda en $article 
    	if ($this->request->is(['post', 'put'])){ //Si la petición es POST o PUT 
    	    $this->Articles->patchEntity($article, $this->request->data);
    	    if ($this->Articles->save($article)) { //Si pasa todas las validaciones
    	        $this->Flash->success(__('Your article has been updated.'));
    	        return $this->redirect(['action' => 'index']); //Redirecciona al index
    	    }
    	    $this->Flash->error(__('Unable to update your article.'));
    	}
    	$this->set('article', $article);
	}

	public function delete($id){
	    $this->request->allowMethod(['post', 'delete']);
	
	    $article = $this->Articles->get($id); //Obtiene el articulo por id
	    if ($this->Articles->delete($article)){ //Si lo encuentra y lo borra
	        $this->Flash->success(__('The article with id: {0} has been deleted.', h($id))); //Mensaje de confirmación de eliminado al usuario 
	        return $this->redirect(['action' => 'index']); //Redirecciona al index
    	}
	}

	public function isAuthorized($user)
	{
	    // Todos los uauarios registrados puede crear artículos
	    if ($this->request->action === 'add') {
	        return true;
	    }
	
	    // Solo el creador de un artículo puede editarlo y borrarlo
	    if (in_array($this->request->action, ['edit', 'delete'])) {
	        $articleId = (int)$this->request->params['pass'][0];
	        if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
	            return true;
	        }
	    }
	
	    return parent::isAuthorized($user);
	}
}