<?php

/**
 * Mock HTTP Client
 *
 * Mock HTTP Client class intended for unit testing and subbing purposes
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
 * made available to response interceptors for reading from and/or writing to.
 * 
 */
class MockHTTPClient implements HTTPClient{

	/**
	 * Make an HTTP request
	 * @param  \Communique\RESTClientRequest  $request  Request object
	 * @return \Communique\RESTClientResponse $response Response object
	 */
	public function request(\Communique\RESTClientRequest $request){
		//Method stub. This gets mocked out for unit testing.
	}
}