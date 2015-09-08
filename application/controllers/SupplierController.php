<?php

class SupplierController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->db = Zend_Registry::get('dbNorthwind');
    }

    public function indexAction()
    {
        // action body
        $this->view->suppliers = $this->db->select()
                                 ->from('Suppliers')
                                 ->query()
                                 ->fetchAll();
    }


}

