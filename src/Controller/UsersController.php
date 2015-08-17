<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
         $this->Auth->allow(['add', 'logout']); //Permite a los usuarios registrarse y salir no se pone login porque genera problemas con el componente
    }

    public function login()
	{
	    if ($this->request->is('post')) { //Si la petición es POST
	        $user = $this->Auth->identify(); //Identifica el usuario y lo guarda en $user
	        if ($user) { //Si trae un usuario (si el usuario existe)
	            $this->Auth->setUser($user); 
	            return $this->redirect($this->Auth->redirectUrl()); //Redirecciona al index de artículos (página configurada en AppController.php)
	        }
	        $this->Flash->error(__('Invalid username or password, try again'));
	    }
	}
	
	public function logout()
	{
	    return $this->redirect($this->Auth->logout()); //Redirecciona a la página de setup de cakephp (página configurada en AppController.php)
	}

    public function index()
    {
        $this->set('users', $this->Users->find('all')); //Trae todos los articulos y los pasa a la vista
    }

    public function view($id)
    {
        $user = $this->Users->get($id); //Obtiene un usuario por id
        $this->set(compact('user')); //Lo pasa a la vista
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) { //Si la petición es POST
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) { //Si pasa todas las validaciones
                $this->Flash->success(__('The user has been saved.')); //Mensaje de éxito al usuario
                return $this->redirect(['action' => 'add']); //Redirecciona al formulario para crear usuarios
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
}