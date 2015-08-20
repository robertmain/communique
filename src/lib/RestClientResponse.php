<?php

/**
 * Response encapsulation object
 *
 * This file contains the object intended to encapsulate all API responses.
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Communique;

/**
 * Response object
 *
 * This object is used to encapsulate the response from the API. Whilst it is used internally, it is also
 * made available to request interceptors for reading from and/or writing to. *
 * 
 */
class RestClientResponse{

	/** @var int The HTTP status code returned by the server */
	public $status;

	/** @var Mixed The response payload from the server */
	public $payload;

	/** @var Array An array of headers returned by the server */
	public $headers;

	/**
	 * Response object constructor. Response properties should be set here (rather than just setting the object properties directly).
	 * @param int    $status  The HTTP status code of the request
	 * @param mixed  $payload The response issued by the API
	 * @param array  $headers Any headers returned by the server
	 */
	public function __construct($status, $payload, $headers = array()){
		$this->status = $status;
		$this->payload = $payload;
		$this->headers = $headers;
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