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
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                        return new \Communique\RESTClientResponse(200, 'response+payload', array('X-PoweredBy' => 'Dreams'));
                    }));
        $response =  $this->rest->get('users', 'request+payload');
        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
        PHPUnit_Framework_TestCase::assertEquals($response->status, 200);
        PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
        PHPUnit_Framework_TestCase::assertEquals($response->headers, array('X-PoweredBy' => 'Dreams'));
    }

    public function test_put(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'PUT');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                        return new \Communique\RESTClientResponse(200, 'response+payload', array('X-PoweredBy' => 'Dreams'));
                    }));
        $response = $this->rest->put('users', 'request+payload');
        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
        PHPUnit_Framework_TestCase::assertEquals($response->status, 200);
        PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
        PHPUnit_Framework_TestCase::assertEquals($response->headers, array('X-PoweredBy' => 'Dreams'));
    }

    public function test_post(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'POST');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                        return new \Communique\RESTClientResponse(200, 'response+payload', array('X-PoweredBy' => 'Dreams'));
                    }));
        $response = $this->rest->post('users', 'request+payload');
        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
        PHPUnit_Framework_TestCase::assertEquals($response->status, 200);
        PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
        PHPUnit_Framework_TestCase::assertEquals($response->headers, array('X-PoweredBy' => 'Dreams'));
    }

    public function test_delete(){
        $this->http->expects($this->once())
                    ->method('request')
                    ->will($this->returnCallback(function($request){
                        PHPUnit_Framework_TestCase::assertEquals($request->method, 'DELETE');
                        PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/' . 'users');
                        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
                        return new \Communique\RESTClientResponse(200, 'response+payload', array('X-PoweredBy' => 'Dreams'));
                    }));
        $response = $this->rest->delete('users', 'request+payload');
        PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
        PHPUnit_Framework_TestCase::assertEquals($response->status, 200);
        PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
        PHPUnit_Framework_TestCase::assertEquals($response->headers, array('X-PoweredBy' => 'Dreams'));
    }

    public function test_request_interceptor(){
        $this->http->method('request')
                    ->will($this->returnCallback(function(){
                        return new \Communique\RESTClientResponse(200, 'response+payload', array());
                    }));

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
        $this->http->method('request')
                    ->will($this->returnCallback(function(){
                        return new \Communique\RESTClientResponse(200, 'response+payload', array());
                    }));
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

    public function test_interceptor_type_checking(){
        $this->setExpectedException('\Communique\CommuniqueException');
        $rest = new \Communique\Communique('http://domain.com/', array('bad value'), $this->http);
    }

    public function test_debug_function_is_called(){
        $this->http->method('request')
                    ->will($this->returnCallback(function(){
                        return new \Communique\RESTClientResponse(200, 'response+payload', array('X-PoweredBy' => 'Dreams'));
                    }));
        $rest = new \Communique\Communique('http://domain.com/', array(), $this->http);
        $rest->get('users', array('request' => 'payload'), array('Foo' => 'Bar'), function($request, $response){
            PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientRequest', $request);
            PHPUnit_Framework_TestCase::assertEquals($request->url, 'http://domain.com/users');
            PHPUnit_Framework_TestCase::assertEquals($request->payload, array('request' => 'payload'));
            PHPUnit_Framework_TestCase::assertEquals($request->headers, array('Foo' => 'Bar'));

            PHPUnit_Framework_TestCase::assertInstanceOf('\Communique\RESTClientResponse', $response);
            PHPUnit_Framework_TestCase::assertEquals($response->status, 200);
            PHPUnit_Framework_TestCase::assertEquals($response->payload, 'response+payload');
            PHPUnit_Framework_TestCase::assertEquals($response->headers, array('X-PoweredBy' => 'Dreams'));
        });
    }
}
