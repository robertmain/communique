<?php

class CommuniqueTest extends PHPUnit_Framework_TestCase{
        
    public function setUp(){
        $this->http_client = $this->getMockBuilder('\Communique\HTTPClient')->getMock();
    }

    public function testGet(){
        $this->rest = new \Communique\Communique(null, array(), $this->http_client);
        $response = $this->rest->get('user');
        $this->assertEquals(json_encode(array('firstname' => 'John', 'surname' => 'Smith')), $response->payload);
    }

    public function testPost(){
        //@todo: Implement this test
    }

    public function testPut(){
        //@todo: Implement this test
    }

    public function testDelete(){
        //@todo: Implement this test
    }

}
