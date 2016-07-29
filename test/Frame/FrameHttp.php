<?php

namespace Cradle\Frame;

use StdClass;
use PHPUnit_Framework_TestCase;
use Cradle\Event\EventHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 13:49:45.
 */
class Cradle_Frame_FrameHttp_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var FrameHttp
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new FrameHttp;
		$this->object->getEventHandler()->off();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Cradle\Frame\FrameHttp::route
     */
    public function testRoute()
    {
		$instance = $this->object->route('foobar', '/foo/bar', function() {});
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::getEventHandler
     */
    public function testGetEventHandler()
    {
		$instance = $this->object->getEventHandler();
		$this->assertInstanceOf('Cradle\Event\EventHandler', $instance);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::on
     * @todo   Implement testOn().
     */
    public function testOn()
    {
        $trigger = new StdClass();
		$trigger->success = null;
		
        $callback = function() use ($trigger) {
			$trigger->success = true;
		};
		
		$instance = $this
			->object
			->on('foobar', $callback)
			->trigger('foobar');
		
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
		$this->assertTrue($trigger->success);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::setEventHandler
     * @todo   Implement testSetEventHandler().
     */
    public function testSetEventHandler()
    {
        $instance = $this->object->setEventHandler(new EventHandler);
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::trigger
     * @todo   Implement testTrigger().
     */
    public function testTrigger()
    {
		$trigger = new StdClass();
		$trigger->success1 = null;
		$trigger->success2 = null;
		$trigger->success3 = null;
		$trigger->success4 = null;
		$trigger->total = 0;
		
        $instance = $this
			->object
			->flow(
				'foobar',
				'step1',
				function($trigger, $foo, $bar) {
					$foo += 1;
					$bar += 2;
					$trigger->success2 = true;
					$trigger->total += $foo + $bar;
				},
				EventPipeStub::class . '::foobar',
				EventPipeStub::class . '@barfoo'
			)
			->on('step1', function($trigger, $foo, $bar) {
				$foo += 1;
				$bar += 2;
				$trigger->success1 = true;
				$trigger->total += $foo + $bar;
			})
			->trigger('foobar', $trigger, 1, 2);
		
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
		$this->assertTrue($trigger->success1);
		$this->assertTrue($trigger->success2);
		$this->assertTrue($trigger->success3);
		$this->assertTrue($trigger->success4);
		$this->assertEquals(24, $trigger->total);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::bindCallback
     */
    public function testBindCallback()
    {
        $trigger = new StdClass;
        $trigger->success = null;
		$trigger->test = $this;
		
		$callback = $this->object->bindCallback(function() use ($trigger) {
	    	$trigger->success = true;
			$trigger->test->assertInstanceOf('Cradle\Frame\FrameHttp', $this);
		});
		
		$callback();
		
		$this->assertTrue($trigger->success);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::package
     */
    public function testPackage()
    {
		$instance = $this->object->register('foobar')->package('foobar');
		
		$this->assertInstanceOf('Cradle\Frame\Package', $instance);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::register
     */
    public function testRegister()
    {
		$instance = $this->object->register('foobar')->package('foobar');
		
		$this->assertInstanceOf('Cradle\Frame\Package', $instance);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::setBoostrapFile
     */
    public function testSetBoostrapFile()
    {
		$instance = $this->object->setBootstrapFile('foobar');
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::flow
     * @todo   Implement testFlow().
     */
    public function testFlow()
    {
        $trigger = new StdClass();
		$trigger->success1 = null;
		$trigger->success2 = null;
		$trigger->success3 = null;
		$trigger->total = 0;
		
        $instance = $this
			->object
			->flow(
				'foobar',
				'step1',
				'step2',
				'step3'
			)
			->on('step1', function($trigger, $foo, $bar) {
				$foo += 1;
				$bar += 2;
				$trigger->success1 = true;
				$trigger->total += $foo + $bar;
			})
			->on('step2', function($trigger, $foo, $bar) {
				$foo += 1;
				$bar += 2;
				$trigger->success2 = true;
				$trigger->total += $foo + $bar;
			})
			->on('step3', function($trigger, $foo, $bar) {
				$foo += 1;
				$bar += 2;
				$trigger->success3 = true;
				
				$trigger->total += $foo + $bar;
			})
			->trigger('foobar', $trigger, 1, 2);
		
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
		$this->assertTrue($trigger->success1);
		$this->assertTrue($trigger->success2);
		$this->assertTrue($trigger->success3);
		$this->assertEquals(18, $trigger->total);
    }

    /**
     * @covers Cradle\Frame\FrameHttp::triggerController
     */
    public function testTriggerController()
    {
        $trigger = new StdClass();
		$trigger->success4 = null;
		$trigger->total = 0;
		
        $instance = $this
			->object
			->triggerController(
				EventPipeStub::class . '@barfoo', 
				$trigger, 
				1, 
				2
			);
		
		$this->assertInstanceOf('Cradle\Frame\FrameHttp', $instance);
		$this->assertTrue($trigger->success4);
		$this->assertEquals(6, $trigger->total);
    }
	
    /**
     * @covers Cradle\Frame\FrameHttp::triggerProtocol
     */
    public function testTriggerProtocol()
    {
		$trigger = new StdClass();
		$trigger->success = null;
		
		$this
			->object
			->protocol('foobar', function() use ($trigger) {
				$trigger->success = true;
			})
			->triggerProtocol('foobar://something');
		
		$this->assertTrue($trigger->success);
    }
}

if(!class_exists('Cradle\Frame\EventPipeStub')) {
	class EventPipeStub
	{
		public static function foobar($trigger, $foo, $bar)
		{
			$foo += 1;
			$bar += 2;
			$trigger->success3 = true;
			$trigger->total += $foo + $bar;
		}
		
		public function barfoo($trigger, $foo, $bar)
		{
			$foo += 1;
			$bar += 2;
			$trigger->success4 = true;
			
			$trigger->total += $foo + $bar;
		}
	}
}