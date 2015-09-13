<?php

class CurlExceptionTest extends PHPUnit_Framework_TestCase{

	public function setUp(){
		$this->curl = $this->getMockBuilder('\Communique\Curl')
                            ->setMethods(array('exec', 'setopt_array', 'setopt', 'getinfo', 'error', 'errno'))
                            ->disableOriginalConstructor()
                            ->getMock();
    	$this->http_client = new \Communique\CurlHTTPClient($this->curl);
	}

   	public function test_ssl_peer_certificate(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_PEER_CERTIFICATE));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    }

   	public function test_ssl_engine_notfound(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_ENGINE_NOTFOUND));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    }

   	public function test_ssl_engine_setfailed(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_ENGINE_SETFAILED));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    }

   	public function test_ssl_cert_problem(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_CERTPROBLEM));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    } 

   	public function test_ssl_cipher(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_CIPHER));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    }

   	public function test_ssl_cacert(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_CACERT));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    }

   	public function test_ssl_connect_error(){
        $this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_SSL_CONNECT_ERROR));
        $request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
        $this->setExpectedException('\Communique\CommuniqueRESTSSLException');
        $this->http_client->request($request);
    }

	public function test_unsupported_protocol(){
		$this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_UNSUPPORTED_PROTOCOL));

		$request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
		$this->setExpectedException('\Communique\CommuniqueRESTConnectionException');
		$this->http_client->request($request);
	}

	public function test_couldnt_connect(){
		$this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_COULDNT_CONNECT));

		$request = new \Communique\RESTClientRequest('GET', 'https://domain.com/users', array(), array());
		$this->setExpectedException('\Communique\CommuniqueRESTConnectionException');
		$this->http_client->request($request);
	}

	public function test_couldnt_resolve_host(){
		$this->curl->expects($this->once())
					->method('exec')
					->will($this->returnCallback(function(){
						return false;
					}));

		$this->curl->expects($this->once())
					->method('errno')
					->will($this->returnValue(CURLE_COULDNT_RESOLVE_HOST));

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