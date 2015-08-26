<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{

    private $_TEST_BASE_URL = 'http://domain.com/';
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')
                            ->setMethods(array('request'))
                            ->getMock();
        $this->http->method('request')
                    ->will($this->returnCallback(function(){
                        return new \Communique\RESTClientResponse(200, 'response+payload', array());
                    }));
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

    public function test_request_interceptor(){
        //Create the mock interceptor
        $mockInterceptor = $this->getMockBuilder('\Communique\Interceptor')
                                ->setMethods(array('request', 'response'))
                                ->getMock();

        //Set out the expectations for the stubbed request method
        $mockInterceptor->expects($this->once())
                        ->method('request')
                        ->will($this->returnCallback(function($request){
                            PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                            PHPUnit_Framework_TestCase::assertEquals($request->payload, 'request+payload');
                            return $request;
                        }));
        
        //Set out the expectations for the stubbed response method. Since we aren't performing any tests on the
        // response interceptor currently, we just want to return the response object to keep the unit tests happy
        $mockInterceptor->expects($this->once())
                        ->method('response')
                        ->will($this->returnCallback(function($response){
                            PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
                            PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
                            return $response;
                        }));

        $rest = new \Communique\Communique($this->_TEST_BASE_URL, array($mockInterceptor), $this->http);
        $rest->get('users', 'request+payload');
    }

}
