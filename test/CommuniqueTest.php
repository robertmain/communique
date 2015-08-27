<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->http = $this->getMockBuilder('\Communique\HTTPClient')
                            ->setMethods(array('request'))
                            ->getMock();
        $this->http->method('request')
                    ->will($this->returnCallback(function(){
                        return new \Communique\RESTClientResponse(200, 'response+payload', array());
                    }));
    	$this->rest = new \Communique\Communique('http://domain.com/', array(), $this->http);
    }

    public function test_get(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'GET');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

    	$this->rest->get('users', 'request+payload');
    }

    public function test_put(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'PUT');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->put('users', 'request+payload');
    }

    public function test_post(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'POST');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                    }));

        $this->rest->post('users', 'request+payload');
    }

    public function test_delete(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'DELETE');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
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

        //Response method just passes the response straight through, as we aren't testing that in this test
        $mockInterceptor->expects($this->once())
                        ->method('response')
                        ->will($this->returnArgument(0));
        
        $rest = new \Communique\Communique('http://domain.com/', array($mockInterceptor), $this->http);
        $rest->get('users', 'request+payload');
    }

    public function test_response_interceptor(){
        //Create the mock interceptor
        $mockInterceptor = $this->getMockBuilder('\Communique\Interceptor')
                                ->setMethods(array('request', 'response'))
                                ->getMock();

        //Request method just passes the response straight through, as we aren't testing that in this test
        $mockInterceptor->expects($this->once())
                        ->method('request')
                        ->will($this->returnArgument(0));
        //Set out the expectations for the stubbed request method
        $mockInterceptor->expects($this->once())
                        ->method('response')
                        ->will($this->returnCallback(function($response){
                            PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
                            PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
                            return $response;
                        }));
        $rest = new \Communique\Communique('http://domain.com/', array($mockInterceptor), $this->http);
        $rest->get('users', 'request+payload');
    }

}
