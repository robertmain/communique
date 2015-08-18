<?php

/**
 * Author: Robert Main
 * Date: 14/08/15
 * Time: 21:58
 */

namespace Communique\lib;

class RestClientResponse{
	public $status;
	public $payload;
	public $headers;

	/**
	 * Constructs the response object
	 * @param int    $status  The HTTP status code of the request
	 * @param mixed  $payload The response issued by the API
	 * @param array  $headers Any headers returned by the server
	 */
	public function __construct($status, $payload, $headers = array()){
		$this->status = $status;
		$this->payload = $payload;
		$this->headers = = $headers;
	}

	/**
	 * Searches the request headers by key
	 * @param  String $key The key of the header to return
	 * @return mixed       The value of the requested header
	 */
	public function get_header($key){
		return $this->headers[$key];
	}
}