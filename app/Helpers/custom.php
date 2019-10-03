<?php
/**
 * Custom helper for common functions if exists
 * Long description for file (if any)...
 * PHP version 5
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   helper
 * @package    helper
 * @author     Salman Khimani <salman.khimani@cubixlabs.com>
 * @author     Another Author <php@cubixlabs.com>
 * @copyright  Cubixlabs
 */


/**
 * Function to convert string, object, array into utf-8 encoding
 *
 * @param $input
 *
 * @return void
 */

function utf8_encode_deep(&$input)
{
	if ( is_string($input) ) {
		$input = utf8_encode($input);
	} else if ( is_array($input) ) {
		foreach ( $input as &$value ) {
			utf8_encode_deep($value);
		}
		
		unset($value);
	} else if ( is_object($input) ) {
		$vars = array_keys(get_object_vars($input));
		
		foreach ( $vars as $var ) {
			utf8_encode_deep($input->$var);
		}
	}
}


/**
 * utf8 Encode String
 *
 * @param $str
 *
 * @return bool|string|string[]|null
 */
function utf8_encode_str($str)
{
	//$regex = '/[\x00-\x1F\x7F\xA0]/u'; // A0 is space
	$regex = '/[\x00-\x1F\x7F]/u';
	$regex2 = '/[\xA0]/u';
	
	try {
		$enc = preg_replace("/\r|\n/", "", trim(
			preg_replace($regex, '', // filter further
				preg_replace($regex2, ' ', // set spaces
					iconv(
						mb_detect_encoding($str, mb_detect_order(), TRUE),
						"UTF-8", $str
					)
				)
			)
		));
	} catch ( \Exception $e ) {
		$enc = utf8_encode($str);
	}
	
	return $enc;
	
}

/**
 * To calculate load time
 *
 * @param $started_at
 */
function load_time($started_at = NULL)
{
	return $started_at ?
		'Cool, that only took ' . ( microtime(TRUE) - $started_at ) . ' seconds!' :
		'Start time invalid';
}

/**
 * Background call
 *
 * @param $url
 * @param int $port
 * @param string $method
 * @param array $params
 *
 * @throws Exception
 */
function background_call($url, $port = 80, $method = 'GET', $params = [])
{
	// get/set params
	$parts = parse_url($url);
	$method = strtoupper($method);
	
	$url = str_replace(url('/'), '', $url);
	$url = url('/') . ':' . $port . $url;
	
	try {
		
		$fp = fsockopen(
			$parts['host'],
			isset($parts['port']) ? $parts['port'] : $port,
			$errno,
			$errstr,
			NULL
		);
		
		if ( $fp ) {
			//$user_agent = $_SERVER['HTTP_USER_AGENT'];
			// Fake user agent
			$user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36';
			
			// prepare data to write to socket
			$out = $method . " " . $parts['path'] . " HTTP/1.1\r\n";
			$out .= "Host: " . $parts['host'] . "\r\n";
			$out .= "User-Agent: " . $user_agent . "\r\n";
			
			
			if ( $method == 'POST' ) {
				$params = is_array($params) ? $params : [];
				
				// build query param
				$content = http_build_query($params);
				
				// push csrf token
				// push other headers
				$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$out .= "Content-Length: " . strlen($content) . "\r\n";
			}
			
			$out .= "Accept: */*\r\n";
			$out .= "\r\n";
			
			fwrite($fp, $out);
			
			// write post params if exists
			if ( $method == 'POST' && isset($content) ) {
				fwrite($fp, $content);
			}
			
			fclose($fp);
		}
	} catch
	( \Exception $e ) {
		//echo "$errstr ($errno)<br />\n";
		throw new \Exception('bagroundCall : ' . $e->getMessage());
	}
	
}

/**
 * @param $array
 *
 * @return mixed
 */
function last_key($array)
{
	$keys = array_keys($array);
	return end($keys);
}

/**
 * To CamelCase
 *
 * @param $word
 *
 * @return string|string[]|null
 */
function to_camel_case($word)
{
	
	return preg_replace_callback(
		"/(^|_)([a-z])/",
		function ($m) {
			return strtoupper($m[2]);
		},
		$word);
	
	return preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $word);
}

/**
 * Change Keys
 *
 * @param array $array
 * @param array $mapping_array
 *
 * @return array
 */
function change_keys(array $array, array $mapping_array)
{
	$arr = [];
	foreach ( $array as $k => $v ) {
		$key = $mapping_array[ $k ] ?? $k;
		$arr[ $key ] = is_array($v) ? change_keys($v, $mapping_array) : $v;
	}
	return $arr;
}


/**
 * Map Keys
 *
 * @param array $array
 * @param array $mapping_array
 */
function map_keys(array &$array, array $mapping_array)
{
	array_walk($array, function ($v, $k) use (&$array, $mapping_array) {
		if ( isset($mapping_array [ $k ]) ) {
			$array[ $mapping_array [ $k ] ] = $v;
			unset($array[ $k ]);
		}
	});
}


/**
 * Function if not defined
 */
if ( !function_exists('array_key_first') ) {
	/**
	 * Gets the first key of an array
	 *
	 * @param array $array
	 *
	 * @return mixed
	 */
	function array_key_first(array $array)
	{
		return $array ? array_keys($array)[0] : NULL;
	}
}


/**
 * Check Value
 *
 * @param $var
 * @param null $def_value
 * @return null
 */
function check_val(&$var, $def_value = NULL)
{
	$param = is_object($var) ? (array)$var : $var;
	
	return isset($param) ?
		(is_string($param) ? trim($param) : $param)
		: $def_value;
}

function roundOfAmount($number)
{
    if ((strpos($number,".") !== false)) {
        return number_format($number, 2, '.', '');
    }
    return $number;
}