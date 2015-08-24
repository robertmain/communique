<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')->setMethods(array('request'))->getMock();
    }

	/**
	 * - Loosen up requirement for equalTo
	 * - Check HTTP verb
	 * - Check URL
	 * - Check it's an instance/implementation of HTTPClient
	 */
    public function testGet(){
    	$rest = new \Communique\Communique('http://domain.com/', array(), $this->http);
    	$this->http->expects($this->once())->method('request')->with($this->equalTo(new \Communique\RESTClientRequest('get', 'http://domain.com/users', 'request+payload', array())));
    	$rest->get('users', 'request+payload');
    }

}
