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
 * 
 */

namespace Communique;

/**
 * Interface
 *
 * This interface is used to describe the functionality of an http client
 * 
 */
interface HTTPClient {


	/**
	 * Make an HTTP request using the information provided in the RESTClientRequest object
	 * 
	 * @param  RESTClientRequest $request Request encapsulation object
	 * @return RESTClientResponse         Response encapsulation object
	 */
	public function request(\Communique\RESTClientRequest $request);

}