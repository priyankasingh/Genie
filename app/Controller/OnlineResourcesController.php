<?php
App::uses('AppController', 'Controller');
/**
 * Services Controller
 *
 * @property Service $Service
 */
class OnlineResourcesController extends AppController {
    
    function beforeFilter(){
	$this->Auth->allow(array('index', 'view'));
	parent::beforeFilter();
    }
    
    //public $helpers = array('Html', 'Form');

    public function index() {
        pr("test");
        $this->set('onlineResources', $this->OnlineResource->find('all'));
        pr($onlineResources);
    }
    
    /**
    * admin_index method
    *
    * @return void
    */
    public function admin_index() {
		$this->OnlineResource->recursive = 0;
		$this->set('onlineResources', $this->paginate());
    }
    
    /**
    * admin_view method
    *
    * @throws NotFoundException
    * @param string $id
    * @return void
    */
    public function admin_view($id = null) {
	if (!$this->OnlineResource->exists($id)) {
            throw new NotFoundException(__('Invalid Online Service'));
	}
	$options = array('conditions' => array('OnlineResource.' . $this->OnlineResource->primaryKey => $id));
	$this->set('onlineResources', $this->OnlineResource->find('first', $options));
    }
    
    
    /**
    * admin_add method
    *
    * @return void
    */
    public function admin_add() {
	//$this->OnlineResource->locale = array_keys( Configure::read('Site.languages') );
	
	if ($this->request->is('post')) {
            $this->OnlineResource->create();
            debug($this->request->data);
            if ($this->OnlineResource->save($this->request->data)) {
		$this->Session->setFlash(__('The online resource has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
		$this->Session->setFlash(__('The online resource could not be saved. Please, try again.'));
            }
            
            if(!empty($this->data))
            {
                //Check if image has been uploaded
                if(!empty($this->data['OnlineResource']['image']['name']))
                {
                    $img = $this->data['OnlineResource']['image']; //put the data into a var for easy use
                    $ext = substr(strtolower(strrchr($img['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif'); //set allowed extensions
                    
                    //only process if the extension is valid
                        if(in_array($ext, $arr_ext))
                        {
                            //do the actual uploading of the file. First arg is the tmp name, second arg is
                            //where we are putting it
                            move_uploaded_file($file['tmp_name'], WWW_ROOT . 'CakePHP/app/webroot/img/' . $img['name']);

                            //prepare the filename for database entry
                            $this->data['OnlineResource']['image_path'] = $img['name'];
                        }
                }
                
            }
	}
	$categories = $this->OnlineResource->Category->find('list');
        $this->set(compact('categories'));
    }
    
 /**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->OnlineResource->exists($id)) {
			throw new NotFoundException(__('Online resource does not exist'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    if( $this->OnlineResource->save( $this->request->data ) ){
				$this->Session->setFlash(__('The online resource has been saved'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
                } else {
                    $options = array('conditions' => array('OnlineResource.' . $this->OnlineResource->primaryKey => $id));
                    $this->request->data = $this->OnlineResource->find('first', $options);
                }
                
                $categories = $this->OnlineResource->Category->find('list');
		$this->set(compact('categories'));
                
        }
        
        
 /**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->OnlineResource->id = $id;
		if (!$this->OnlineResource->exists()) {
			throw new NotFoundException(__('Invalid online resource'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OnlineResource->delete()) {
			$this->Session->setFlash(__('Online resource deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Online resource was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
    
    
}