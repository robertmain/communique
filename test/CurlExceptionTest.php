<?php

class CurlExceptionTest extends PHPUnit_Framework_TestCase{

	public function setUp(){
		$this->curl = $this->getMockBuilder('\Communique\Curl')
                            ->setMethods(array('exec', 'setopt_array', 'setopt', 'getinfo', 'error', 'errno'))
                            ->disableOriginalConstructor()
                            ->getMock();
    	$this->http_client = new \Communique\CurlHTTPClient($this->curl);
	}

	public function test_unsupported_protocol(){
		$this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}))
					->method('errno')
					->will($this->returnValue(CURLE_UNSUPPORTED_PROTOCOL));
		$request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
		$this->setExpectedException('\Communique\CommuniqueRESTConnectionException');
        $this->http_client->request($request);
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
}