<?php

class ArtistController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function newAction()
    {
        // action body
        $genres = array("Electronic",
                    "Country",
                    "Rock",
                    "R & B",
                    "Hip-Hop",
                    "Heavy-Metal",
                    "Alternative Rock",
                    "Christian",
                    "Jazz",
                    "Pop");
        
        //Set the view variables
        $this->view->genres = $genres;

    }

    public function saveArtistAction()
    {
        // action body
        //echo "<pre/>";        var_dump( $this->_request);
        // Initialize variables
        $artistName = $this->_request->getPost('artistName');
        $genre = $this->_request->getPost('genre');
        $rating = $this->_request->getPost('rating');
        $isFav = $this->_request->getPost('isFav');

        //Validate
        //Save the input into the DB

    }





}


