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

        // Get network members
	// Has response?
        
        $this->loadModel('Response');
        $response_id = $this->Session->read( 'response' );
        //pr($response_id);
        $response = $response_id ? $this->Response->find('first',
                array(
                        'conditions' => array('Response.id' => $response_id ),
                        'contain' => array(
                                'NetworkMember', 'ResponseStatement'
                        ),
                )) : false;
        //pr($response);
   
        //Get statement id for the online resource user picked
        $response_statement_id = $response['ResponseStatement']['11']['id'];
        //pr($response_statement_id);
      
        
        
        // Get all the category user picked for the statement
        $this->loadModel('Category');
        $query = array();
        $query = $this->Category->ResponseStatement->find('all',
                ['conditions' => ['ResponseStatement.id' => $response_statement_id]]);
        

        //pr($query['0']['Category']);
       
        $cats = array();
	$catIDs = array();
        
        foreach( $query['0']['Category'] as $category)
        {
            if( !in_array( $category['id'], $catIDs ) ){ // No duplicates
		$cats[]['Category'] = $category;
		$catIDs[] = $category['id'];
            }
        }
        //pr($cats);
        //pr($catIDs);
        
        $query2 = array();
        
        foreach($catIDs as $catId)
        {
            // Set the category variable
            
            $query2 = $this->OnlineResource->Category->find('all',
                ['conditions' => ['Category.id' => $catId]]);
            
            //pr($query2[0]['Category']['name']);
            $this->set('cat', $query2[0]['Category']['name']);
        }
        
        // Find all the online resources for each category and set it to onlineResource variable for view to access it
        foreach($catIDs as $catId)
        {
            // Search for all the online resources from the categories user has chosen
            //$this->set('onlineResource', $this->OnlineResource->find('all'));
            $this->set('onlineResource', $this->OnlineResource->Category->find('all',
                ['conditions' => ['Category.id' => $catId]]));
        }
          
        //Add category desription]
        $selected_parent_id = null;

        if($selected_parent_slug){
            
            //$this->loadModel('Service');
            $selected_parent_id = $this->OnlineResource->Category->getIdFromSlug($selected_parent_slug);
			
          
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
            
            
            
            //Add Sub category filter
            
            $selected_category_id = null;
            
            if($selected_category_slug){
		$selected_category_id = $this->OnlineResource->Category->getIdFromSlug($selected_category_slug);
                    
            }
            
            if($selected_category_slug){
		$selected_category_id = $this->OnlineResource->Category->getIdFromSlug($selected_category_slug);
            }
            
            if($selected_category_id){
		$conditions['Category.id'] = $selected_category_id;
            }
            
            $sub_category_list = $this->OnlineResource->Category->getChildrenOfCategoryWithId($selected_parent_id);
                
            //Get list of categories
            $categories = $this->OnlineResource->Category->find('list');
            $this->set(compact('categories','selected_parent_id','service','selected_parent_slug','sub_category_list','selected_category_id'));
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
	
        if($this->request->is('post'))
        {
            $this->OnlineResource->create();
            if(!empty($this->data))
            {
                if(!empty($this->data['OnlineResource']['image']['name']))
                {
                    $file = $this->data['OnlineResource']['image'];
                    $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                    $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions

                    $imageName =$file['name'];
                    
                    if(in_array($ext, $arr_ext))
                    {
                         
  			//create full filename with timestamp
                        $imageName = date('His') . $imageName;
                            
                        if(move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads/images/' . DS . $imageName))
                        {
                            //prepare the filename for database entry
                            $this->request->data['OnlineResource']['image_path'] = $imageName;
                            pr($imageName);
                            if($this->OnlineResource->save($this->request->data)) 
                            {
                                $this->Session->setFlash(__('The online resource with image has been saved'), 'default',array('class'=>'success'));
                                $this->redirect(array('action'=>'index'));
                            }
                            else
                            {
                                $this->Session->setFlash(__('The online resource and image could not be saved. Please, try again.'));
                            }
                        }
                    }
                    else
                    {
                        $this->Session->setFlash(__('You can only upload an image, no other file type.'));
                    }
                }
                elseif(empty($this->data['OnlineResource']['image']['name']))
                {
                    if($this->OnlineResource->save($this->request->data)) 
                    {
                        $this->Session->setFlash(__('The online resource has been saved.'), 'default',array('class'=>'success'));
                        $this->redirect(array('action'=>'index'));
                    }
                }
                else
                {
                    $this->Session->setFlash(__('The online resource could not be saved. Please, try again.'));
                }
            }
        }
        $categories = $this->OnlineResource->Category->find('list');
        $this->set(compact('categories'));
        
        
        /*//$this->OnlineResource->locale = array_keys( Configure::read('Site.languages') );
	
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
        $this->set(compact('categories')); */
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