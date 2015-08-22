<?php

/**
 * This file is part of Communique.
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Communique;

/**
 * REST Response
 *
 * This class is used to encapsulate the response from the API. Whilst it is used internally, it is also
 * made available to response interceptors for reading from and/or writing to.
 * 
 */
class RESTClientResponse{

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
	public function __construct($status, $payload, array $headers = array()){
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