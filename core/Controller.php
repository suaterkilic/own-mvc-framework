<?php

class Controller
{
	public $postList 	= [];
	public $state 		= 0;
	
	public function view($pageName)
	{
		require 'app/views/'. $pageName. '.php';
	}

	public function model($name)
	{
		require_once 'app/models/' . ucfirst($name) . '.php';

        return new $name();
	}

	public function request($input_name)
	{
		if(isset($_POST))
        {
            @$input_value = $_POST[$input_name];

            return $input_value;
        }
	}

	public function requestAll($namePattern)
	{
		foreach (array_values($_POST) as $key => $value)
		{
			$this->postList[] = $value;
		}

		foreach(array_keys($_POST) as $value)
		{
			if(strstr($value, $namePattern))
			{
				$this->state = 1;
			}
		}

		if($this->state == 1)
		{
			return $this->postList;
		}

	}
	
	public function randName($name)
	{
		$nameArray              = array('ab','cd','ef','gh','pr','tq','qw');
		$imgStr                 = substr($name,-5,5);
		$numberPut              = rand(158,104925);
		$randName               = $nameArray[rand(0,5)].$numberPut.$imgStr;

		return $randName;
	}
}
