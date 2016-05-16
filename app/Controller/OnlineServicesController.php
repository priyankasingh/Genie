<?php
App::uses('AppController', 'Controller');
/**
 * Services Controller
 *
 * @property Service $Service
 */
class OnlineServicesController extends AppController {
    
    function beforeFilter(){
	$this->Auth->allow(array('index', 'view'));
	parent::beforeFilter();
}
    
    //public $helpers = array('Html', 'Form');

    public function index() {
        $this->set('online_services', $this->OnlineService->find('all'));
    }
    
    /**
    * admin_index method
    *
    * @return void
    */
    public function admin_index() {
		$this->OnlineService->recursive = 0;
		$this->set('online_services', $this->paginate());
    }
    
    /**
    * admin_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function admin_view($id = null) {
	if (!$this->OnlineService->exists($id)) {
            throw new NotFoundException(__('Invalid Online Service'));
	}
	
	$this->set('online_service', $this->OnlineService->find('first', $options));
    }
    
    
    /**
    * admin_add method
    *
    * @return void
    */
    public function admin_add() {
	//$this->OnlineService->locale = array_keys( Configure::read('Site.languages') );
	
	if ($this->request->is('post')) {
            $this->OnlineService->create();
            if ($this->OnlineService->saveAssociated($this->request->data)) {
		$this->Session->setFlash(__('The online service has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
		$this->Session->setFlash(__('The online service could not be saved. Please, try again.'));
            }
	}
	$categories = $this->OnlineService->Category->find('list');
            $this->set(compact('categories'));
	}
    
    
    
    
}