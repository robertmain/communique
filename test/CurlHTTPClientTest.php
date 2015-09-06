<?php

class CurlHTTPClientTest extends PHPUnit_Framework_TestCase{

    private $_curlopts;
        
    public function setUp(){
    	$this->curl = $this->getMockBuilder('\Communique\Curl')
                            ->setMethods(array('exec', 'setopt_array', 'setopt'))
                            ->disableOriginalConstructor()
                            ->getMock();
        $this->http_client = new \Communique\CurlHTTPClient($this->curl);

        $curlopts = &$this->_curlopts;

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
    }

    public function test_get(){
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
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPGET, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPGET], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users?example=payload');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array('Example: header'));
    }

    public function test_put(){
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
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_PUT, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_PUT], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POSTFIELDS, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_POSTFIELDS], array('example' => 'payload'));

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array('Example: header'));
    }

    public function test_post(){
        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('POST', 'https://domain.com/users', array('example' => 'payload'), array('Example' => 'header'));
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POST, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_POST], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POSTFIELDS, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_POSTFIELDS], array('example' => 'payload'));

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array('Example: header'));
    }

    public function test_delete(){

        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('DELETE', 'https://domain.com/users', array('example' => 'payload'), array('Example' => 'header'));
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_CUSTOMREQUEST, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_CUSTOMREQUEST], 'DELETE');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users?example=payload');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array('Example: header'));
    }

    public function test_empty_get_payload(){
        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPGET, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPGET], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array());
    }

    public function test_empty_put_payload(){
        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('PUT', 'https://domain.com/users', array(), array());
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_PUT, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_PUT], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POSTFIELDS, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_POSTFIELDS], array());

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array());
    }

    public function test_empty_post_payload(){
        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('POST', 'https://domain.com/users', array(), array());
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POST, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_POST], true);

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_POSTFIELDS, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_POSTFIELDS], array());

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array());
    }

    public function test_empty_delete_payload(){
        $this->curl->expects($this->once())
                    ->method('exec')
                    ->will($this->returnCallback(function(){
                        return array(
                            'http_status_code' => 200,
                            'body' => 'response+payload',
                            'headers' => array()
                        );
                    }));

        $request = new \Communique\RESTClientRequest('DELETE', 'https://domain.com/users', array(), array());
        $this->http_client->request($request);
        
        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_CUSTOMREQUEST, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_CUSTOMREQUEST], 'DELETE');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_URL, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_URL], 'https://domain.com/users');

        PHPUnit_Framework_TestCase::assertTrue(array_key_exists(CURLOPT_HTTPHEADER, $this->_curlopts));
        PHPUnit_Framework_TestCase::assertEquals($this->_curlopts[CURLOPT_HTTPHEADER], array());
    }
}
