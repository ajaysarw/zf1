<?php
    
    class Form_Auth_Add extends Zend_Form
    {
        public function init()
        {
            $this->setMethod('post');
     
            $this->addElement('text', 'username', 
                array(
                    'label' => 'Username:', 'required' => true, 'filters'=> array('StringTrim','StripTags'),                    
                )
             );
     
            $this->addElement('password', 'password', 
                array('label' => 'Password:','required' => true, 'filters'=> array('StringTrim'),)
            );
     
            $this->addElement('submit', 'submit', 
                array('ignore' => true, 'label' => 'Add',)
            );
     
        }
    }