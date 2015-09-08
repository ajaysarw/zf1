<?php

class Application_Form_Album extends Zend_Form
{

    public function init()
    {
        $this->setName('album');
        $id = new Zend_Form_Element_Hidden('id');        
        $id->addFilter('Int');
        
        $artist = new Zend_Form_Element_Text('artist');        
        $artist->setLabel('Artist')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');

        $price = new Zend_Form_Element_Text('price');
        $price->setLabel('Price')            
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
            

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        // adding above html elements to the form
        $this->addElements(
            array(
                $id, 
                $artist, 
                $title, 
                $price, 
                $submit,
            )
        );
    }
}