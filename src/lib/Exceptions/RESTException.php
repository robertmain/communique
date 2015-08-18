<?php

/**
 * Author: Robert Main
 * Date: 14/08/15
 * Time: 21:58
 */

namespace Communique\lib\Exceptions;

class RESTException extends Exception{
	public function __construct($message){
		parent::__construct($message);
	}
}