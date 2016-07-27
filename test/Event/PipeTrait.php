<?php

namespace Cradle\Event;

use StdClass;
use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 02:11:00.
 */
class Cradle_Event_PipeTrait_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var EventPipe
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new PipeTraitStub;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
		//otherwise it would trigger multiple times
		$this->object->getEventHandler()
			->off('foobar')
			->off('step1')
			->off('step2')
			->off('step3')
			->off(EventPipeTriggerStub::class . '::foobar')
			->off(EventPipeTriggerStub::class . '@barfoo');
    }

    /**
     * @covers Cradle\Event\PipeTrait::flow
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
		
		$this->assertInstanceOf('Cradle\Event\PipeTraitStub', $instance);
		$this->assertTrue($trigger->success1);
		$this->assertTrue($trigger->success2);
		$this->assertTrue($trigger->success3);
		$this->assertEquals(18, $trigger->total);
		
    }

    /**
     * @covers Cradle\Event\PipeTrait::trigger
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
				EventPipeTriggerStub::class . '::foobar',
				EventPipeTriggerStub::class . '@barfoo'
			)
			->on('step1', function($trigger, $foo, $bar) {
				$foo += 1;
				$bar += 2;
				$trigger->success1 = true;
				$trigger->total += $foo + $bar;
			})
			->trigger('foobar', $trigger, 1, 2);
		
		$this->assertInstanceOf('Cradle\Event\PipeTraitStub', $instance);
		$this->assertTrue($trigger->success1);
		$this->assertTrue($trigger->success2);
		$this->assertTrue($trigger->success3);
		$this->assertTrue($trigger->success4);
		$this->assertEquals(24, $trigger->total);
    }

    /**
     * @covers Cradle\Event\PipeTrait::triggerController
     */
    public function testTriggerController()
    {
		$trigger = new StdClass();
		$trigger->success4 = null;
		$trigger->total = 0;
		
        $instance = $this
			->object
			->triggerController(
				EventPipeTriggerStub::class . '@barfoo', 
				$trigger, 
				1, 
				2
			);
		
		$this->assertInstanceOf('Cradle\Event\PipeTraitStub', $instance);
		$this->assertTrue($trigger->success4);
		$this->assertEquals(6, $trigger->total);
    }

    /**
     * @covers Cradle\Event\PipeTrait::getEventHandler
     */
    public function testGetEventHandler()
    {
		$instance = $this->object->getEventHandler();
		$this->assertInstanceOf('Cradle\Event\EventHandler', $instance);
		
        $instance = $this->object
			->setEventHandler(new EventPipeEventHandlerStub)
			->getEventHandler();
		$this->assertInstanceOf('Cradle\Event\EventPipeEventHandlerStub', $instance);
    }

    /**
     * @covers Cradle\Event\PipeTrait::on
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
		
		$this->assertInstanceOf('Cradle\Event\PipeTraitStub', $instance);
		$this->assertTrue($trigger->success);
    }

    /**
     * @covers Cradle\Event\PipeTrait::setEventHandler
     */
    public function testSetEventHandler()
    {
        $instance = $this->object->setEventHandler(new EventPipeEventHandlerStub);
		$this->assertInstanceOf('Cradle\Event\PipeTraitStub', $instance);
    }

    /**
     * @covers Cradle\Event\PipeTrait::triggerEvent
     */
    public function testTriggerEvent()
    {
        $trigger = new StdClass();
		$trigger->success = null;
		
        $callback = function() use ($trigger) {
			$trigger->success = true;
		};
		
		$instance = $this
			->object
			->on('foobar', $callback)
			->triggerEvent('foobar');
		
		$this->assertInstanceOf('Cradle\Event\PipeTraitStub', $instance);
		$this->assertTrue($trigger->success);
    }
}

if(!class_exists('Cradle\Event\EventPipeTriggerStub')) {
	class EventPipeTriggerStub
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

if(!class_exists('Cradle\Event\EventPipeEventHandlerStub')) {
	class EventPipeEventHandlerStub extends EventHandler
	{
	}
}

if(!class_exists('Cradle\Event\PipeTraitStub')) {
	class PipeTraitStub
	{
		use PipeTrait;
	}
}
