<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{

    private $_TEST_BASE_URL = 'http://domain.com/';
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')
                            ->setMethods(array('request'))
                            ->getMock();
    	$this->rest = new \Communique\Communique($this->_TEST_BASE_URL, array(), $this->http);
    }

    public function test_get(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'GET');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, $this->_TEST_BASE_URL . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

    	$this->rest->get('users', 'request+payload');
    }

    public function test_put(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'PUT');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, $this->_TEST_BASE_URL . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->put('users', 'request+payload');
    }

    public function test_post(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'POST');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, $this->_TEST_BASE_URL . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->post('users', 'request+payload');
    }

    public function test_delete(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'DELETE');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, $this->_TEST_BASE_URL . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->delete('users', 'request+payload');
    }

    /**
     * 1. Check that the request interceptor recieved a request object 
     * 1. Check that request object had the correct payload
     * 1. Check that the response interceptor returns a request object
     * 1. Check that response object has the correct payload
     */
    public function test_request_interceptor(){
        $mockInterceptor = $this->getMockBuilder('\Communique\Interceptor')
                                -> setMethods(array('request', 'response'))
                                -> getMock();
        $mockInterceptor->expects($this->once())
                        ->method('request')
                        ->will($this->returnCallback(function($request){
                            PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                        }));
        $rest = new \Communique\Communique($this->_TEST_BASE_URL, array($mockInterceptor), $this->http);
        $rest->get('users');
    }

}
