<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:43 PM
 */

namespace App\Libraries\Services;


/**
 * Class Cards
 *
 * @package App\Libraries\Services
 */
class Cards
{
	
	/**
	 * Library
	 *
	 * @var string
	 */
	private $_lib = '';
	
	
	/**
	 * Cards constructor.
	 *
	 * @param string $load_lib
	 *
	 * @throws \Exception
	 */
	public function __construct(string $load_lib = 'mint_route')
	{
		$load_lib = to_camel_case($load_lib);
		if ( !class_exists('App\Libraries\Services\Cards\\' . $load_lib) )
			throw new \Exception('Class ' . $load_lib . ' not found.');
		
		$this->_lib = 'App\Libraries\Services\Cards\\' . $load_lib;
		$this->_lib = new $this->_lib;
	}
	
	
	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	function __call($name, $arguments)
	{
		// find method
		if ( !method_exists($this->_lib, $name) )
			throw new \Exception('Method ' . $name . ' not found.');
		
		return isset($arguments[0]) ?
			$this->_lib->{$name}($arguments[0]) :
			$this->_lib->{$name}();
	}
	
	
	
	
}