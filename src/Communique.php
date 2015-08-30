<?php

/**
 * This file is part of Communique.
 * 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * 
 */

namespace Communique;

/**
 * Communique Pluggable REST Client
 *
 * 
 * @author Robert Main
 * @package Communique
 * @copyright  Robert Main
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 */
class Communique {

	/**
	 * The base path of the API. All other API paths will be used relative to this
	 * @var String
	 */
	private $_BASE_URL;

	/**
	 * An array of interceptors used for processing the requests
	 * @var Array
	 */	
	private $_interceptors = array();

	/**
	 * An implementation of \Communique\HTTPClient
	 * @var \Communique\HTTPClient
	 */
	private $_http;

	/**
	 * Constructs Communique REST library.
	 * @param String $base_url The base URL of the API you wish to make requests to. All other paths referenced will be treated as relative to this.
	 * @param array $interceptors An array of any interceptors you wish to use to modify the request. An interceptor could do anything from JSON parsing to OAuth request signing.
	 * @param \Communique\HTTPClient $http_client The HTTP client you wish to make the request with
	 * @throws  \Communique\CommuniqueException
	 */
	public function __construct($base_url = '', array $interceptors = array(), $http_client = null) {
		$this->_BASE_URL = $base_url;
		$this->_interceptors = $interceptors;
		if ($http_client) {
			$this->_http = $http_client;
		} else {
			$this->_http = new \Communique\CurlHTTPClient();
		}
		foreach ($this->_interceptors as $interceptor) {
			if (!$interceptor instanceof \Communique\Interceptor) {
				throw new \Communique\CommuniqueException('Invalid request interceptor provided');
			}
		}
	}

	/**
	 * Makes the HTTP request using the chosen HTTP client.
	 * @param  \Communique\RESTClientRequest $request A RESTClientRequest object encapsulating the request
	 * @param  callable $debug A debugging callback to be run after the request has finished. This function is expected to accept two parameters, \Communique\RESTClientRequest and \Communique\RESTClientResponse
	 * @return \Communique\RESTClientResponse A RESTClientResponse object encapsulating the response
	 */
	protected function _call(\Communique\RESTClientRequest $request, $debug = null) {
		foreach ($this->_interceptors as $request_interceptor) {
			$request = $request_interceptor->request($request);
		}
		$response = $this->_http->request($request);
		foreach ($this->_interceptors as $response_interceptor) {
			$response = $response_interceptor->response($response);
		}
		if ($debug) {
			$debug($request, $response);
		}
		return $response;
	}

	/**
	 * Make an HTTP GET request
	 * @param  String $url     The API to make the request to
	 * @param  mixed  $payload The request payload (this will be url encoded and added as query string parameters)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function get($url, $payload = array(), array $headers = array(), $debug = null) {
		$request = new \Communique\RESTClientRequest('get', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request, $debug);
	}

	/**
	 * Make an HTTP PUT request
	 * @param  String $url     The API to make the request to
	 * @param  mixed  $payload The payload of the request(any data you wish to send across)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function put($url, $payload, array $headers = array(), $debug = null) {
		$request = new \Communique\RESTClientRequest('put', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request, $debug);
	}

	/**
	 * Make an HTTP POST request
	 * @param  String $url     The API to make the request to
	 * @param  mixed  $payload The payload of the request(any data you wish to send across)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function post($url, $payload, array $headers = array(), $debug = null) {
		$request = new \Communique\RESTClientRequest('post', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request, $debug);
	}

	/**
	 * Make an HTTP DELETE request
	 * @param  String $url     The API to make the request to
	 * @param  mixed  $payload The payload of the request(any data you wish to send across)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function delete($url, $payload = array(), array $headers = array(), $debug = null) {
		$request = new \Communique\RESTClientRequest('delete', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request, $debug);
	}
}