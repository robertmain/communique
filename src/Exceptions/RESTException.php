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
 * This exception is a general purpose exception used to handle all nondescript errors with REST calls.
 * 
 */
class RESTException extends \Exception{
	/**
	 * Constructor for general purpose REST Exception
	 * @param String $message A human readable description of the exception
	 */
	public function __construct($message){
		parent::__construct($message);
	}
}