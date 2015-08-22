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