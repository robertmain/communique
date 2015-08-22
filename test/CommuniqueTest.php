<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{

	public function testGet(){
		/*$http_client = $this->getMockBuilder('\Communique\HTTPClient')->getMock();
		$this->rest = new \Communique\Communique(null, array(), $http_client);*/
		
		$this->rest = new \Communique\Communique('http://graph.facebook.com/', array());

		var_dump($this->rest->get('cocacola'));
	}

}
