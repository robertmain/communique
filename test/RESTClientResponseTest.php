<?php

class RESTClientResponseTest extends PHPUnit_Framework_TestCase{

	/**
	 * 1. Create a new response with headers
	 * 1. Make sure that the get_header functino returns the header it's supposed to
	 */
	
	public function test_get_header(){
		$response = new \Communique\RESTClientResponse(200, null, array('key'=>'value'));

		$this->assertEquals('value', $response->get_header('key'));
	}
	
}