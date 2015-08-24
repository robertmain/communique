<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')->setMethods(array('request'))->getMock();
    }


    public function testGet(){
    	$rest = new \Communique\Communique('http://domain.com/', array(), $this->http);

        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'GET');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

    	$rest->get('users', 'request+payload');
    }


    public function testPut(){
        $rest = new \Communique\Communique('http://domain.com/', array(), $this->http);

        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'PUT');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $rest->put('users', 'request+payload');
    }

    public function testPost(){
        $rest = new \Communique\Communique('http://domain.com/', array(), $this->http);

        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'POST');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $rest->post('users', 'request+payload');
    }

    public function testDelete(){
        $rest = new \Communique\Communique('http://domain.com/', array(), $this->http);
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'DELETE');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $rest->delete('users', 'request+payload');
    }

}
