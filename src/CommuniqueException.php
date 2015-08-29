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
use \Exception;

/**
 *
 * Exception
 *
 * This exception is thrown when problems within the library occur. For example, an interceptor that does not implement the Interceptor interface
 * 
 */
class CommuniqueException extends \Exception {
	/**
	 * Constructor for general purpose exception
	 * @param String $message A human readable description of the exception
	 */
	public function __construct($message) {
		parent::__construct($message);
	}
}