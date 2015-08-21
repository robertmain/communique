<?php
use \Communique;

class CommuniqueTest extends PHPUnit_Framework_TestCase{

	public function setUp(){
		$this->rest = new Communique('http://graph.facebook.com');
	}

    public function testCall(){
        $this->rest->__call();
    }
}
?>