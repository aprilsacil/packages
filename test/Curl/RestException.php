<?php

namespace Cradle\Curl;

use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 02:10:59.
 */
class Cradle_Curl_RestException_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var RestException
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new RestException;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Cradle\Curl\RestException::forMissingHost
     */
    public function testForMissingHost()
    {
        $message = null;
		
		try {
			throw RestException::forMissingHost();
		} catch(RestException $e) {
			$message = $e->getMessage();
		}
		
		$this->assertEquals('Host is not defined', $message);
    }

    /**
     * @covers Cradle\Curl\RestException::forMissingData
     */
    public function testForMissingData()
    {
        $message = null;
		
		try {
			throw RestException::forMissingData('foobar');
		} catch(RestException $e) {
			$message = $e->getMessage();
		}
		
		$this->assertEquals('foobar does not exist', $message);
    }

    /**
     * @covers Cradle\Curl\RestException::forMissingRequired
     */
    public function testForMissingRequired()
    {
        $message = null;
		
		try {
			throw RestException::forMissingRequired('foobar');
		} catch(RestException $e) {
			$message = $e->getMessage();
		}
		
		$this->assertEquals('foobar is required', $message);
    }

    /**
     * @covers Cradle\Curl\RestException::forInvalidData
     */
    public function testForInvalidData()
    {
        $message = null;
		
		try {
			throw RestException::forInvalidData('foobar');
		} catch(RestException $e) {
			$message = $e->getMessage();
		}
		
		$this->assertEquals('foobar does not have a valid value', $message);
    }
}
