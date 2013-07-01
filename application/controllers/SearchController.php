<?php
class SearchController extends Zend_Controller_Action
{

	protected $_instagram = array();
	
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
    	#SET DB CONNECTIONS
    	#DECLARE VIEW VARS
    }
    
    public function startAction()
    {
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	
    	$ch = curl_init();
    	/*
    	//THIS DOESN'T WORK EITHER
    	$ch = curl_init("https://api.instagram.com/oauth/access_token?client_id=". $this->view->client_id .
    			"&client_secret=".$this->view->client_secret.
    			"&redirect_uri=".$this->view->redirect_uri.
    			"&grant_type=authorization_code". 
    			"&code=".$_GET['code']);
    	*/
    	//THIS DOESN'T WORK
    	$data = array("client_id"	=> $this->view->client_id,
    				"client_secret"	=> $this->view->client_secret,
    				"grant_type"	=> "authorization_code",
    				"redirect_uri"	=> $this->view->redirect_uri,
    				"code"			=> $_GET['code']);
    	
    	curl_setopt($ch, CURLOPT_URL,"https://api.instagram.com/oauth/access_token");
    	curl_setopt($ch, CURLOPT_POST, 1);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(data));    	
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    	
    	$server_output = curl_exec ($ch);
    	curl_close ($ch);
    	
    	if ($server_output == "OK") {
    		//CAN'T GET ACCESS TOKEN USING SUGGESTED STEPS
    		echo "123";
    	} else {
    		echo "ABC";
    	} 
    }    
    
    public function ajaxsearchAction() 
    {
    	#DISABLE TEMPLATE FOR AJAX CALL
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	    	  	 
    	$json = file_get_contents($search_url);
    	$json_data = json_decode($json);    	
    }

}

