<?php
/**
 * REST Exception
 *
 * General purpose REST exception
 * 
 * 
 * @author Robert Main
 * @package Communique\lib\Exceptions
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Communique\lib\Exceptions;

/**
 *
 * Exception
 *
 * This exception is a general purpose exception used to handle all nondescript errors with REST calls.
 * 
 */
class RESTException extends Exception{
	/**
	 * Constructor for general purpose REST Exception
	 * @param String $message A human readable description of the exception
	 */
	public function __construct($message){
		parent::__construct($message);
	}
}