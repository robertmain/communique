<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')
                            ->setMethods(array('request'))
                            ->getMock();
    	$this->rest = new \Communique\Communique('http://domain.com/', array(), $this->http);
    }

    public function test_get(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'GET');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

    	$this->rest->get('users', 'request+payload');
    }

    public function test_put(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'PUT');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->put('users', 'request+payload');
    }

    public function test_post(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'POST');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->post('users', 'request+payload');
    }

    public function test_delete(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'DELETE');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->delete('users', 'request+payload');
    }

}
