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
 * REST Request
 *
 * This class is used to encapsulate request related data such as method, url, headers etc. Whilst this class
 * is used internally, it is also made available to request interceptors for modification before the request is made.
 * 
 */
class RESTClientRequest {

	/** @var String The HTTTP method to use for the request. This should be either GET|PUT|POST|DELETE */
	public $method;

	/** @var String The URL to make the request to */
	public $url;

	/** @var Mixed The payload of the request  */
	public $payload;

	/** @var Array Request headers */
	public $headers;

	/**
	 * Request object constructor. Request properties should be set here (rather than just setting the object properties directly).
	 * @param String $method  The HTTP method you wish to use for the request
	 * @param String $url     The URL path to make the request to (relative to the API base path)
	 * @param Mixed  $payload The payload of the request
	 * @param Array  $headers Request headers
	 */
	public function __construct($method, $url, $payload, array $headers = array()) {
		$this->method = strtoupper($method);
		$this->url = $url;
		$this->payload = $payload;
		$this->headers = $headers;
	}

}