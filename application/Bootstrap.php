<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
	{
		$this->bootstrap('view');
		//$view = $this->getResource('view');
		//$view->doctype('XHTML1_STRICT');
	}
	
	protected function _initConfig() 
	{
		Zend_Registry::set('config', $this->getOptions());
	}	

}

