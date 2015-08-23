<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')->setMethods(array('request'))->getMock();
    }

    public function testGet(){
    	$rest = new \Communique\Communique('http://domain.com/', array(), $this->http);
    	$this->http->expects($this->once())->method('request')->with($this->equalTo(new \Communique\RESTClientRequest('get', 'http://domain.com/users', 'request+payload', array())));
    	$rest->get('users', 'request+payload');
    }

}
