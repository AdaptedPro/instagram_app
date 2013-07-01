<?php
class SearchController extends Zend_Controller_Action
{
	const status_msg = "Error on page";
    public function init()
    {
    	$config						= Zend_Registry::get('config');
    	$this->view->client_id		= $config['instagram']['client_id'];
    	$this->view->client_secret	= $config['instagram']['client_secret'];
    	$this->view->website_url	= $config['instagram']['website_url'];
    	$this->view->redirect_uri	= $config['instagram']['redirect_uri'];
    	
    	#SEND POST TO OBTAIN ACCESS TOKEN
    	$ch		= curl_init();
    	 
    	$url	= 'https://api.instagram.com/oauth/access_token?"';
    	$vars	= "client_id=". $this->view->client_id .
    	"&client_secret=".$this->view->client_secret.
    	"&redirect_uri=".$this->view->redirect_uri.
    	"&grant_type=authorization_code".
    	"&code=".$_GET['code'];
    	 
    	$ch = curl_init( $url );
    	curl_setopt( $ch, CURLOPT_POST, 1);
    	curl_setopt( $ch, CURLOPT_POSTFIELDS, $vars);
    	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt( $ch, CURLOPT_HEADER, 0);
    	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    	 
    	$response = curl_exec( $ch );
    	$response_json = json_decode($response);
    	 
    	#SET ACCESS TOKEN FOR CONTROLLER->VIEW
    	$this->view->access_token = $response_json->access_token; 

    	if ($response_json->error) {
    		//self::status_msg;
    	}
    }
    
    public function indexAction()
    {    	
    	#SET VIEW
    	$this->view->render("search/index.phtml");
    }
    
    public function startAction()
    {	
    	#SET VIEW
    	$this->view->token = $this->view->access_token;
    	$_SESSION['access_token'] = $this->view->access_token;
    	$this->view->render("search/start.phtml");    	
    }    
   						 
   	public function ajaxsearchAction() 
    {
    	#DISABLE TEMPLATE FOR AJAX CALL
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->getHelper('layout')->disableLayout();
    	
    	#GET SEARCH RESULTS
    	//https://api.instagram.com/v1/locations/search?
    	$search_url	= "https://api.instagram.com/v1/media/search?lat="
    			.urlencode($_POST['cur_loc_lat'])."&lng="
    			.urlencode($_POST['cur_loc_lon'])."&access_token="
    			.urlencode($_POST['acc_token']);
    	$json		= file_get_contents($search_url);
    	$json_data	= json_decode($json, true);
    	
    	return $this->buildOutput($json_data['data']);
    }
    
    private function buildOutput($json)
    {    	
    	foreach($json as $key => $val) {
    		$output .= "<li><a href='" .$val['link']. "' target='blank'>".$val['user']['username']. "</a></li> \n";  		
    	}
    	
    	if ($output!=null) {
    		echo "<ul> \n" . $output . " \n </ul> \n";
    	} else {
    		echo "<p>No Images found. The limit must have been reached.</p>";
    	}
    		
    }

}

