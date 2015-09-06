<?php

class CurlHTTPClientTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->curl = $this->getMockBuilder('\Communique\Curl')
                            ->setMethods(array('exec', 'setopt_array', 'setopt', 'getinfo', 'error', 'errno'))
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->http_client = new \Communique\CurlHTTPClient($this->curl);
    }

    public function test_general_exception(){
        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return false;
                    }));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTException');
        $this->http_client->request($request);
    }

    public function test_get(){
        $curlopts = array();
        $this->curl->method('setopt')
                    ->will($this->returnCallback(function($curlopt, $value) use (&$curlopts){
                        $curlopts[$curlopt] = $value;
                    }));

        $this->curl->method('setopt_array')
                    ->will($this->returnCallback(function($optarray) use (&$curlopts){
                        foreach($optarray as $optkey => $optvalue){
                            $curlopts[$optkey] = $optvalue;
                        }
                    }));

        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array('example' => 'payload'), array('Example' => 'header'));
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPGET, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_HTTPGET], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_URL], 'https://domain.com/users?example=payload');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_HTTPHEADER], array('Example: header'));
    }

    public function test_put(){
        $curlopts = array();
        $this->curl->method('setopt')
                    ->will($this->returnCallback(function($curlopt, $value) use (&$curlopts){
                        $curlopts[$curlopt] = $value;
                    }));

        $this->curl->method('setopt_array')
                    ->will($this->returnCallback(function($optarray) use (&$curlopts){
                        foreach($optarray as $optkey => $optvalue){
                            $curlopts[$optkey] = $optvalue;
                        }
                    }));

        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('PUT', 'https://domain.com/users', array('example' => 'payload'), array('Example' => 'header'));
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_PUT, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_PUT], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POSTFIELDS, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_POSTFIELDS], array('example' => 'payload'));

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $curlopts));
        PHPUnit_Framework_TestCase::assertEquals($curlopts[CURLOPT_HTTPHEADER], array('Example: header'));
    }
}
