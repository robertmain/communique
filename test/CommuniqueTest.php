<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{

	public function setUp(){
	}

	public function testGet(){
		$http_client = $this->getMockBuilder('\Communique\HTTPClient')->getMock();
		$this->rest = new \Communique\Communique(null, array(), $http_client);
		
	}

}
