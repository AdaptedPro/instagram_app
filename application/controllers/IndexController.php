<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	$config						= Zend_Registry::get('config');
    	$this->view->client_id		= $config['instagram']['client_id'];
    	$this->view->client_secret	= $config['instagram']['client_secret'];
    	$this->view->website_url	= $config['instagram']['website_url'];
    	$this->view->redirect_uri	= $config['instagram']['redirect_uri'];
    }

    public function indexAction()
    {
        // action body
        $this->view->auth_url = "https://api.instagram.com/oauth/authorize/?client_id=". $this->view->client_id ."&redirect_uri=". $this->view->redirect_uri . "&response_type=code";
    }
    
    public function ajaxsearchAction()
    {
    	$request = $this->getRequest()->getPost();
    	//$message = $request['name'];
    		
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout(); 

    	
    	$json = json_decode($json);
    } 


}

