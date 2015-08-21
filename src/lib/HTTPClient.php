<?php

/**
 * HTTP Client Interface
 *
 * This file describes how an HTTP client should look
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Communique;

/**
 * Interface
 *
 * This interface is used to describe the functionality of an http client
 * 
 */
interface HTTPClient{


	/**
	 * Make an HTTP request using the information provided in the RESTClientRequest object
	 * 
	 * @param  RESTClientRequest $request Request encapsulation object
	 * @return RESTClientResponse         Response encapsulation object
	 */
	public function request($request);

}