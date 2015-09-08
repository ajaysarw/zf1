<?php
    
class AuthController extends Zend_Controller_Action
{
    // this method 
    public function loginAction()
    {
        $loginForm = new Form_Auth_Login();
 
        if ($loginForm->isValid($_POST)) {           
            
            # Better to use more secure hash method, using md5 just to explain and simplicity
            $authAdapter = new Zend_Auth_Adapter_DbTable(
                Zend_Db_Table::getDefaultAdapter(),
                'users',
                'username',
                'password',
                'MD5(?)'
            );

            # alternaitive to above 
            // $authAdapter->setTableName('users')  
            //             ->setIdentityColumn('username')  
            //             ->setCredentialColumn('password')  
            //             ->setCredentialTreatment('MD5(?)'); 
            
            // putting the form values to adapter,  so in future it can be verify 
            $authAdapter->setIdentity( $loginForm->getValue('username') );            
            $authAdapter->setCredential( $loginForm->getValue('password') );
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($authAdapter);            
 
            if ($result->isValid()) {
                $this->_helper->FlashMessenger('Login successful');
                // setting the message, so in view it can be display
                $this->view->message = $this->_helper->flashMessenger->getMessages();
                
                if ( $loginForm->getValue('username') == 'admin' ) {
                    $this->_helper->FlashMessenger('Welcome Admin');                    
                    $this->view->message = $this->_helper->flashMessenger->getMessages();
                    $this->_redirect('user/index');   
                    //$this->_redirect('http://google.com');
                }
                return;                
            } else {
                echo "failed";
            } 
        } 
        $this->view->loginForm = $loginForm;
    }

    public function indexAction()
    {
        // Disable the main layout renderer
            //$this->_helper->layout->disableLayout();
        // Do not even attempt to render a view
            //$this->_helper->viewRenderer->setNoRender(true);
        $this->_redirect('Auth/login');        
    }
}