<?php

class AlbumController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        //var_dump ( extension_loaded('pdo') ); exit;
    }

    public function indexAction()
    {
        // action body
        $albums = new Application_Model_DbTable_Albums();
		$this->view->albums = $albums->fetchAll();

    }

    public function addAction()
    {
        $form = new Application_Form_Album();
        $form->submit->setLabel('Add');
        
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();            
            // form validation
            if ($form->isValid($formData)) {
                // collecting the data from user intput
                $dataArray = array(
                    'artist' => $form->getValue('artist'),
                    'title' => $form->getValue('title'),
                    'price'  => $form->getValue('price'),
                );
                //commented after passing 
                //$artist = $form->getValue('artist');
                //$title = $form->getValue('title');                    
                //$albums = new Model_Albums();                
                // some db related stuff
                $albums = new Application_Model_DbTable_Albums();                
                $albums->addAlbum($dataArray);                
                // after success redirect to index action
                $this->_helper->redirector('index');
            } else {
                // if any validation erros, 
                // populate the form with previouis data
                $form->populate($formData);
            }
        }
    }

    public function deleteAction()
    {
        $this->view->autoRender = false;
        
        $id = $this->getParam('id');
        
        if (!$id) {
            $id = $this->getRequest()->getPost('id');    
        }

        $dbObject = new Application_Model_DbTable_Albums;
        $deleteResult = $dbObject->deleteAlbum($id);
        
        // render the index page after deleting the data.
        $this->_helper->redirector('index');
    }
}
