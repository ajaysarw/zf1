<?php
    
class UserController extends Zend_Controller_Action
{
    private $db;

    private $systemUsers;

    public function init()
    {
        $this->db =  Zend_Registry::get('dbNorthwind');
         
        $messages = $this->_helper->flashMessenger->getMessages();
        if(!empty($messages)){
            $this->_helper->layout->getView()->message = $messages[0];
        }

        $this->systemUsers = array('admin','qa','guest');

    }

    public function addAction()
    {
        $userForm = new Form_Auth_Add();
 
        if ($userForm->isValid($_POST)) {            
            $data = array(
                'username' => $userForm->getValue('username'),
                'password' => md5($userForm->getValue('password')),                
            );

            try {
                $this->db->insert('users', $data);
                $this->_helper->FlashMessenger('Add user successful');                
                $this->_redirect('user/index');                
                return;                
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger("DB-error");    
            } catch (Exception $e) {
                $this->_helper->flashMessenger("Pata naheen kya hua");    
            }
 
             
        } 
        $this->view->userForm = $userForm;
    }

    public function editAction()
    {
        //$this->_helper->viewRenderer->setNoRender(true);
        $referer = $this->getRequest()->getHeader('Referer');
        $id = $this->getParam('id');
        $userForm = new Form_Auth_Add();

        try{            
            #using named parameters
            /*
            $sql = 'SELECT * FROM users WHERE id = :id';
            $stmt = new Zend_Db_Statement_Pdo($this->db, $sql);
            $stmt->execute(array(':id' => $this->getParam('id')));
            */

            #using positional parameters
            $sql =  'SELECT * FROM users WHERE id = ?';
            $stmt = new Zend_Db_Statement_Pdo($this->db, $sql);
            $stmt->execute(array($id));
            $userData = $stmt->fetchAll();

            if ($this->getRequest()->isPost()) {
                print_r($usersData); exit;
                // clearing previous values 
                $usersData = array();
                $userData  = $this->getRequest()->getPost();
                if ($userForm->isValid($userData)) {
                   $this->db->update($userData, 'id = '. (int)$id);
                   $this->_redirect($referer);
                }                 
            }
            $userForm->populate($userData);      
            
            print_r($userData[0] ); //exit;
            //$this->view->users = $usersData; // oneliner // $this->view->users = $this->db->fetchAll($sql);                       
            $this->view->userForm = $userForm; // oneliner // $this->view->users = $this->db->fetchAll($sql);



        } catch (Exception $e) {
            $this->_helper->flashMessenger('An error_log');
        }
        
    }

    public function indexAction()
    {
        
        //$sql = "select * from users where username = ? and id = ?";
        //$this->view->users = $this->db->fetchAll($sql, array('admin','15'));
        #using select object    
        //$select = new Zend_Db_Select($this->db); 
        //$this->db->setFetchMode(Zend_Db::FETCH_OBJ);

        # Possible modes
        // Zend_Db::FETCH_ASSOC(*), Zend_Db::FETCH_ASSOC, Zend_Db::FETCH_BOTH, Zend_Db::FETCH_OBJ, Zend_Db::FETCH_COLUMN        
        /*
        $this->db->setFetchMode(Zend_Db::FETCH_ASSOC);
        $sql = "select * from users";
        $usersData = $this->db->fetchAll($sql);
        */

        try{            
            /*
            # using Zend_Db_statment
            $sql = 'SELECT * FROM users';
            $stmt = new Zend_Db_Statement_Pdo($this->db, $sql);            
            $stmt->execute();
            $usersData = $stmt->fetchAll();
            */

            /*
            # using Zend_db
            $this->db->setFetchMode(Zend_Db::FETCH_ASSOC);
            $sql = "select * from users";
            $usersData = $this->db->fetchAll($sql);
            */
            
            # using Zend_db_select
            $usersData =  $this->db
                          ->select()
                          ->from('Suppliers')
                          ->query()
                          ->fetchAll();

            $this->view->users = $usersData; // oneliner // $this->view->users = $this->db->fetchAll($sql);
        } catch (Exception $e) {
            $this->_helper->flashMessenger($e->getMessage());
        }
        
        //echo "<pre/>";print_r($usersData); //exit;


        


    }

    public function deleteAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        //$url = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        //$id = $this->getParam('id');
        
        # Care: We can't move further this point with invalid user
        $userData = $this->checkValidUser();

        $referer = $this->getRequest()->getHeader('Referer');
        // now we can proceed safely 
        if (in_array(strtolower($userData['username']), $this->systemUsers )) {
            $this->_helper->flashMessenger("this user can't be deleted");
        } else {
            try {
                $delStatus = $this->db->delete('users', 'id = ' . (int) $userData['id']);
            } catch (Zend_Db_Exception $e) {
                $this->_helper->flashMessenger("Pata naheen kya hua");    
            }
            
            if($delStatus){
                $this->_helper->flashMessenger("user successfully deleted");    
            }            
        }

        $this->_redirect($referer);        
    }

    private function checkValidUser()
    {
        $id = $this->getParam('id');
        $referer = $this->getRequest()->getHeader('Referer');
        if (empty($id)) {            
            $this->_helper->flashMessenger("Missing id parameter");
            $this->_redirect($referer);
        }

        $username = $this->db->fetchCol("select username from users where id = ?",  $id);        
        if (empty($username)) {            
            $this->_helper->flashMessenger("This id does not exist");
            $this->_redirect($referer);
        }

        # now user is valid user
        $userData = array(
            'id' => $id,
            'username' => $username[0],
            );
        return $userData;
    }
}
