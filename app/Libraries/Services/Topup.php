<?php
/**
 * Created by PhpStorm.
 * User: salman
 * Date: 3/21/19
 * Time: 7:43 PM
 */

namespace App\Libraries\Services;


/**
 * Class Topup
 *
 * @package App\Libraries\Services
 */
class Topup
{
	
	private $_lib = '';
	
	/**
	 * Topup constructor.
	 *
	 * @param string $load_lib
	 *
	 * @throws \Exception
	 */
	public function __construct($load_lib = 'one_prepay')
	{
		$lib = to_camel_case($load_lib);
		if ( !class_exists('App\Libraries\Services\Topup\\' . $lib) )
			throw new \Exception('Class ' . $lib . ' not found.');
		
		$this->_lib = 'App\Libraries\Services\Topup\\' . $lib;
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