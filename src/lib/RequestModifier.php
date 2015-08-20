<?php

/**
 * Request modifier
 *
 * This file contains the interface that all request modifiers must implement
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Communique;

/**
 * Interface
 *
 * This interface is used to describe the functionality of a request modifier
 * 
 */
interface RequestModifier{


	/**
	 * This method is used to process the request on the way out.
	 * Whilst implementing this method is mandatory, it is permitted to simply return the
	 * request object unchanged if needed.
	 * 
	 * @param  RESTClientRequest $request Request encapsulation object
	 * @return RESTClientRequest          Request encapsulation object
	 */
	public function request($request);


	/**
	 * This method is used to process the response on the way back in. 
	 * Whilst implementing this method is mandatory, it is permitted to simply return the
	 * response object unchanged if needed.
	 * @param  RESTClientResponse $response Response encapsulation object
	 * @return RESTClientResponse           Response encapsulation object
	 */
	public function response($response);

}