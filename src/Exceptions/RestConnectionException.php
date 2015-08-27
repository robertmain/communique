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
 *
 * Exception
 *
 * This exception is thrown for connection errors when attempting to reach the API.
 * 
 */
class RESTConnectionException extends RESTException {
	/**
	 * Constructor for REST Connection Exception
	 * @param String $message A human readable description of the exception
	 */
	public function __construct($message) {
		parent::__construct($message);
	}
}