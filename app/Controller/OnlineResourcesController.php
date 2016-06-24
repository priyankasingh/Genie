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

    public function index($selected_parent_slug = null, $selected_category_slug = null, $selected_service_slug = null) {
        
        
        $this->set('onlineResources', $this->OnlineResource->find('all'));
        pr($selected_parent_slug);
        pr($selected_category_slug);
        pr($selected_service_slug);
        
        // Get network members
	// Has response?
        
        $this->loadModel('Response');
        $response_id = $this->Session->read( 'response' );
        $response = $response_id ? $this->Response->find('first',
                array(
                        'conditions' => array('Response.id' => $response_id ),
                        'contain' => array(
                                'NetworkMember'
                        ),
                )) : false;
        //pr($response);
       // pr($network_members);
	$this->set('network_members', $response);
        
        $this->loadModel('Service');
        //if($selected_service_slug){
            
		// VIEW INDIVIDUAL SERVICE
        //        $selected_service_id = $this->Service->getIdFromSlug($selected_service_slug);
        //        $this->setAction('view', $selected_parent_slug, $selected_category_slug, $selected_service_slug);
       // }

        $conditions = array();
        $joins = array();

        $selected_parent_id = null;
        $selected_category_id = null;
        
        
        if( $selected_parent_slug == 'favourites' ){
        // FAVOURITES
                // Logged in only
                if( !$this->Auth->user('id') ){
                        $this->Session->setFlash(__('Please log in to view favourites.'));
                        $this->redirect(array('controller'=>'users', 'action' => 'login'));
                }


                $this->loadModel('Favourite');
                $faves = $this->Favourite->find('all', array(
                        'conditions'=>array(
                                'Favourite.user_id' => $this->Auth->user('id'),
                                'Favourite.deleted' => null,
                        ),
                ));
                $faveIDs = array();
                foreach( $faves as $fave ) $faveIDs[] = $fave['Favourite']['service_id'];

                $conditions['Service.id'] = $faveIDs;

                // Set query and view vars
                $this->set('favourites', true);
        } else {
        // NORMAL CATEGORIES
                
                if($selected_parent_slug){
                        $selected_parent_id = $this->OnlineResource->Category->getIdFromSlug($selected_parent_slug);

                        pr($selected_parent_id);
                }
                if($selected_category_slug){
                        $selected_category_id = $this->OnlineResource->Category->getIdFromSlug($selected_category_slug);
                        pr($selected_category_id);

                }
        }
        
        //pr($sub_category_list);
        
        if($selected_parent_id || $selected_category_id){
                if($selected_parent_id){
                        $conditions['Category.parent_id'] = $selected_parent_id;
                        $sub_category_list = $this->OnlineResource->Category->getChildrenOfCategoryWithId($selected_parent_id);

                        $this->set( 'parent_category', $this->OnlineResource->Category->read(array('id','name','description'), $selected_parent_id) );
                }
                $joins = array(
                        array(
                                'table'=>'categories_online_resources',
                                'alias'=>'CategoriesOnlineResources',
                                'type'=>'inner',
                                'conditions'=>array(
                                        'OnlineResource.id = CategoriesOnlineResources.online_resource_id',
                                ),
                        ),
                        array(
                                'table'=>'categories',
                                'alias'=>'Category',
                                'type'=>'inner',
                                'conditions'=>array(
                                        'CategoriesOnlineResources.category_id = Category.id',
                                ),
                        ),
                );
                if($selected_category_id){
                        $conditions['Category.id'] = $selected_category_id;
                }
        }
        
        // Get list of sub categories
        $categories = $this->OnlineResource->Category->find('list');
        // pr($categories);

        $this->set('hasResponse', $this->Session->read( 'response' ));
        $this->set(compact('parents','categories','selected_parent_id','selected_category_id','sub_category_list','selected_parent_slug'));

        
    // KEYWORD SEARCH
        if( $search = $this->request->query('search') ){
                $searchBits = explode( ' ', $search );

                foreach( $searchBits as &$searchBit ){
                        $conditions['OR'][] = array( 'OnlineResource.name LIKE' => '%'.$searchBit.'%' );
                        $conditions['OR'][] = array( 'OnlineResource.description LIKE' => '%'.$searchBit.'%' );
                }
        }
        
        
        
        
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
           
            if ($this->OnlineResource->save($this->request->data)) {
                
                //Check if image has been uploaded
                if($this->request->data['OnlineResource']['image'])
                {
                    $img = $this->request->data['OnlineResource']['image']; //put the data into a var for easy use
                    $imgName = $img['name'];
                    
                    $ext = substr(strtolower(strrchr($img['name'], '.')), 1); //get the extension
                    $arr_ext = array('jpg', 'jpeg', 'gif', 'png'); //set allowed extensions
                    
                    //only process if the extension is valid
                     if(in_array($ext, $arr_ext))
                     {
                        //do the actual uploading of the file. First arg is the tmp name, second arg is
                        //where we are putting it

                        move_uploaded_file($img['tmp_name'], WWW_ROOT . 'uploads/images/' . $img['name']);

                           $this->Session->setFlash(__('The image has been saved'));
                            //prepare the filename for database entry
                           $this->request->data['OnlineResource']['image_path'] = $img['name'];
                           print_r($this->request->data['OnlineResource']['image_path']);
                           pr($this->request->data['OnlineResource']['image_path']);
                        //}
                        //else{
                            
                           // $this->Session->setFlash('There was a problem uploading file. Please try again.');
                       // }
                        
                     }
                }

		$this->Session->setFlash(__('The online resource has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                
		$this->Session->setFlash(__('The online resource could not be saved. Please, try again.'));
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