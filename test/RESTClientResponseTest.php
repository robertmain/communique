<?php

class RESTClientResponseTest extends PHPUnit_Framework_TestCase{
	
	public function test_get_header(){
		$response = new \Communique\RESTClientResponse(200, null, array('key'=>'value'));

		$this->assertEquals('value', $response->get_header('key'));
	}
	
}