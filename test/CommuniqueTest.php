<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
    	$this->http_client = $this->getMockBuilder('\Communique\HTTPClient')->setMethods(array('request'))->getMock();
        $this->http_client->expects($this->once())->method('request')->with();
    }

    public function testGet(){
        $rest = new \Communique\Communique('example.com', array(), $this->http_client);
        var_dump($this->http_client);
    }

    /**
     * @todo  Implement this test
     */
    public function testPost(){

    }

    /**
     * @todo  Implement this test
     */
    public function testPut(){

    }

    /**
     * @todo  Implement this test
     */
    public function testDelete(){

    }

}
