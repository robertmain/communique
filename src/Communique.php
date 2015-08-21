<?php

/**
 * Communique
 *
 * A pluggable, flexible REST client
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Communique;

use Curl;

/**
 * Communique
 *
 * A pluggable, flexible REST client.
 * 
 */
class Communique{

	/**
	 * The base path of the API. All other API paths will be used relative to this
	 * @var String
	 */
	private $_BASE_URL;

	/**
	 * An array of interceptors used for processing the requests
	 * @var String
	 */
	private $_interceptors = array();

	/**
	 * Constructs Communique REST library. This constructor expects one argument(the second is optional)
	 * @param String $base_url     The base URL of the API you wish to make requests to. All other paths referenced will be treated as relative to this. For example, for facebook this would be http://graph.facebook.com.
	 * @param array $interceptors  An array of any interceptors you wish to use to modify the request. An interceptor could do anything from JSON parsing to OAuth request signing.
	 */
	public function __construct($base_url, array $interceptors = array()){
		$this->_BASE_URL = $base_url;
		$this->_interceptors = $interceptors;
	}

	/**
	 * Actually makes the request
	 * @param  RESTClientRequest  $request A RESTClientRequest object encapsulating the request
	 * @return RESTClientResponse          A RESTClientResponse object encapsulating the response
	 */
	private function _call(\Communique\RESTClientRequest $request){
		
		return new \Communique\RESTClientResponse(200, 'BOOM!');
	}
}