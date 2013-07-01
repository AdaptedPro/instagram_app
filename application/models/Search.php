<?php

//namespace application\models;

class SignUp {

	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

}
