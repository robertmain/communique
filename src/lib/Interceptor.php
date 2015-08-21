<?php

/**
 * Request modifier
 *
 * This file contains the interface that all interceptors must implement
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Communique;

/**
 * Interface
 *
 * This interface is used to describe the functionality of an interceptor
 * 
 */
interface Interceptor{


	/**
	 * Process the outgoing request.
	 * 
	 * When implementing this method, it is permitted to simply return the request object unchanged if needed.
	 * 
	 * @param  RESTClientRequest $request Request encapsulation object
	 * @return RESTClientRequest          Request encapsulation object
	 */
	public function request(\Communique\RESTClientRequest $request);


	/**
	 * Process the incoming response.
	 * 
	 * When implementing this method, it is permitted to simply return the request object unchanged if needed.
	 * 
	 * @param  RESTClientResponse $response Response encapsulation object
	 * @return RESTClientResponse           Response encapsulation object
	 */
	public function response(\Communique\RESTClientRequest $response);

}