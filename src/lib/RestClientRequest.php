<?php

/**
 * Author: Robert Main
 * Date: 14/08/15
 * Time: 21:58
 */

namespace Communique\lib;

class RestClientRequest{

	public $method;
	public $url;
	public $data
	public $headers;

	/**
 	 * Constructs the request object
 	 * @param String $method  The HTTP method you wish to use for the request
 	 * @param String $url     The URL path to make the request to (relative to the API base path)
 	 * @param mixed  $payload The payload of the request
 	 * @param array  $headers Any headers you wish to include with the request
	*/
	public function __construct($method, $url, $payload, $headers = array()){
		$this->method = $method;
		$this->url = $url;
		$this->payload = $payload;
		$this->headers = = $headers;
	}

}