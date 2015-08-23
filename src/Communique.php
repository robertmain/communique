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
 * ###Typical Usage
 * 
 * You can make a request with the REST library using the code below. It is worth noting, the get, put, post, delete etc. methods 
 * do not return the raw response payload, but an encapsulation object of type \Communique\RESTClientResponse. This object contains
 * 1. The HTTP status code (200, 201, 404, 500 etc.)
 * 1. The response payload (the response body from the server)
 * 1. The server headers (any headers that the server returned with the payload, these are often useful for cache control).
 * 
 * You can find more information from the [\Communique\RESTClientResponse](Communique.RESTClientResponse.html) documentation
 * 
 * ```php
 * <?php
 *      $rest = new \Communique\Communique('http://api.company.com/');
 *      $response = $rest->get('users/1'); //Contains information about user number 1
 *      // Since $response is actually a RESTClientResponse object (rather than the raw response payload), we can get
 *      // properties of the request like so:
 * 
 *      echo $response->status; //This will be the HTTP status code
 *      // If we want the raw request payload we do this:
 *      echo $response->payload;
 *      // Headers can be retrieved like so:
 *      echo $response->getHeader('header_key');
 * ?>
 * ```
 *
 * ###Request Interceptors
 *
 * Whilst the above example is useful for making simple requests and returning the result from the API,
 * you may wish to have a little more control over the request. Communique provides a method to do this using Interceptors. 
 * 
 * An interceptor is a class with request and response methods. The request method of each interceptor is called on each request
 * and each the response interceptor method is called on each response. This allows the complex modification of requests juts before
 * they are sent and just after they are retured. This allows for things like JSON parsing, OAuth request signing or caching.
 * Interceptors are executed in the order in which they are provided.
 * 
 * If you wish to add an interceptor, you may do so by passing an array with an instance of your interceptor as the second constructor
 * argumment to Communique.
 *
 * **Interceptors should implement the [\Communique\Interceptor](Communique.Interceptor.html) interface**
 * 
 * ```php
 * <?php
 *      $rest = new \Communique\Communiqe('http://api.company.com/', array(new JSONParser(), new OAuth()));
 *      // Use the library as before
 * ?>
 * ```
 * 
 * ##Custom HTTP Client
 * 
 * This library ships out of the box with a cURL implementation, however if you wish to provide your own you may do so
 * using the third constructor argument as follows:
 * 
 * ```php
 * <?php
 *     $rest = new \Communique\Communiqe('http://api.company.com/', array(new JSONParser(), new OAuth()), new CustomHTTPClient());
 *     // Use the library as before
 * ?>
 * ```
 * 
 * 
 * @author Robert Main
 * @package Communique
 * @copyright  Robert Main
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
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
	 * Instance of an HTTP client
	 * @var \Communique\HTTPClient
	 */
	private $_http;

	/**
	 * Constructs Communique REST library.
	 * @param String $base_url The base URL of the API you wish to make requests to. All other paths referenced will be treated as relative to this.
	 * @param array $interceptors An array of any interceptors you wish to use to modify the request. An interceptor could do anything from JSON parsing to OAuth request signing.
	 * @param \Communique\HTTPClient $http_client The HTTP client you wish to make the request with
	 */
	public function __construct($base_url = '', array $interceptors = array(), $http_client = null){
		$this->_BASE_URL = $base_url;
		$this->_interceptors = $interceptors;
		if($http_client){
			$this->_http = $http_client;
		} else {
			$this->_http = new \Communique\CurlHTTPClient();
		}
	}

	/**
	 * Makes the HTTP request using the HTTP client passed into the constructor(defaults to cURL).
	 * @param  \Communique\RESTClientRequest $request A RESTClientRequest object encapsulating the request
	 * @return \Communique\RESTClientResponse A RESTClientResponse object encapsulating the response
	 * @todo bubble the request and response through the interceptors
	 */
	private function _call(\Communique\RESTClientRequest $request){
		return $this->_http->request($request);
	}

	/**
	 * Make an HTTP GET request
	 * @param  String $url     The API to make the request to
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function get($url, array $headers = array(), $debug = null){
		$request = new \Communique\RESTClientRequest('get', $this->_BASE_URL . $url, null, $headers);
		return $this->_call($request);
	}

	/**
	 * Make an HTTP PUT request
	 * @param  String $url     The API to make the request to
	 * @param  array  $payload The payload of the request(any data you wish to send across)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function put($url, array $payload, array $headers = array(), $debug = null){
		$request = new \Communique\RESTClientRequest('put', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request);
	}

	/**
	 * Make an HTTP POST request
	 * @param  String $url     The API to make the request to
	 * @param  array  $payload The payload of the request(any data you wish to send across)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function post($url, array $payload, array $headers = array(), $debug = null){
		$request = new \Communique\RESTClientRequest('post', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request);
	}

	/**
	 * Make an HTTP DELETE request
	 * @param  String $url     The API to make the request to
	 * @param  array  $payload The payload of the request(any data you wish to send across)
	 * @param  array  $headers Any headers you want to add to the request(optional)
	 * @param  callable $debug A function to be used for request debugging. 
	 * This function should accept two parameters, one for the request object one for the response object.
	 * @return \Communique\RESTClientResponse  REST response encapsulation object
	 */
	public function delete($url, array $payload, array $headers = array(), $debug = null){
		$request = new \Communique\RESTClientRequest('delete', $this->_BASE_URL . $url, $payload, $headers);
		return $this->_call($request);
	}
}