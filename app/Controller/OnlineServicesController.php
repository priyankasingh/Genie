<?php
App::uses('AppController', 'Controller');
/**
 * Services Controller
 *
 * @property Service $Service
 */
class OnlineServicesController extends AppController {
    
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
	
	$this->set('online_service', $this->Category->find('first', $options));
    }
    
    
    
}