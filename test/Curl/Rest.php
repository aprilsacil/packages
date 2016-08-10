<?php

namespace Cradle\Curl;

use StdClass;
use PHPUnit_Framework_TestCase;
use Cradle\Resolver\ResolverHandler;
use Cradle\Event\EventHandler;
use Cradle\Profiler\InspectorHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 02:10:59.
 */
class Cradle_Curl_Rest_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rest
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Rest('http://foobar.com', function($options) {
			$options['response'] = '{"foo":"bar"}';
			return $options;
		});
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Cradle\Curl\Rest::__call
     * @covers Cradle\Curl\Rest::getKey
     * @covers Cradle\Curl\Rest::getPath
     * @covers Cradle\Curl\Rest::getRoute
     */
    public function test__call()
    {
		$instance = $this->object->__call('setPostData', array('foobar', '_'));
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		
		$instance = $this->object->__call('addComment', array('foobar1', '_'));
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		
		$actual = $this->object->__call('getFriendTweets', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->__call('createFriendTweet', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->__call('postFriendTweet', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->__call('updateFriendTweet', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->__call('putFriendTweet', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->__call('deleteFriendTweet', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->__call('removeFriendTweet', array('foobar1'));
		$this->assertEquals('bar', $actual['foo']);
		
		$this->object->addRoute('get/posts', array(
			'method' => 'get', 	
			'route' => '/*/feed',
			'data' => array('access_token' => 'required')
		));
		
		$this->object->addRoute('get/post', 'get/posts');
		
		$actual = $this->object
			->setData('access_token', '123')
			->__call('getPosts', array('foobar1'));
		
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object
			->setData('access_token', '123')
			->__call('getPost', array('foobar1'));
		
		$this->assertEquals('bar', $actual['foo']);
		
		$this->object->addRoute('friend/tweet/posts', array(
			'method' => 'get', 	
			'route' => '/*/feed',
			'data' => array('access_token' => 'required')
		));
		
		$actual = $this->object
			->setData('access_token', '123')
			->__call('friend', array())
			->__call('tweet', array())
			->__call('post', array('foobar1'));
		
		$this->assertEquals('bar', $actual['foo']);
		
		$trigger = false;
		try {
			$this->object->__call('foobarzoo', array(123));
		} catch(RestException $e) {
			$trigger = true;
		}
		
		$this->assertTrue($trigger);
    }

	/**
     * @covers Cradle\Curl\Rest::__construct
     */
    public function test__construct()
    {
		$actual = $this->object->__construct('http://foobar.com', function($options) {
			$options['response'] = '{"foo":"bar"}';
			return $options;
		});
		
		$this->assertNull($actual);
	}

    /**
     * @covers Cradle\Curl\Rest::addHeader
     */
    public function testAddHeader()
    {
		$instance = $this->object->addHeader(array());
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		
		$instance = $this->object->addHeader('Expect');
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		
		$instance = $this->object->addHeader('Content-Type', 'text/html');
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::addRoute
     */
    public function testAddRoute()
    {
		$instance = $this->object->addRoute('/foo/bar', 'zoo');
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::setData
     */
    public function testSetData()
    {
		$instance = $this->object->setData(array());
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		
		$instance = $this->object->setData('post_title');
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		
		$instance = $this->object->setData('post_title', 'foobar');
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::send
     * @covers Cradle\Curl\Rest::getMetaData
     * @covers Cradle\Curl\Rest::getQueryAndPost
     * @covers Cradle\Curl\Rest::getRequestEncode
     * @covers Cradle\Curl\Rest::getResponseEncode
     * @covers Cradle\Curl\Rest::isFieldValid
     */
    public function testSend()
    {
		$actual = $this->object->send('GET', '/foo/bar');
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->send('PUT', '/foo/bar', array(
			'url' => '/foo/bar',
			'post' => array('foo' => 'bar'),
			'agent' => 'Mozilla',
			'encode' => 'query',
			'headers' => array('foo' => 'bar')
		));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->send('PUT', '/foo/bar', array(
			'url' => '/foo/bar',
			'post' => array('foo' => 'bar'),
			'agent' => 'Mozilla',
			'encode' => 'xml',
			'headers' => array('foo' => 'bar')
		));
		$this->assertEquals('bar', $actual['foo']);
		
		$actual = $this->object->send('PUT', '/foo/bar', array(
			'url' => '/foo/bar',
			'post' => array('foo' => 'bar'),
			'agent' => 'Mozilla',
			'encode' => 'raw',
			'headers' => array('foo' => 'bar')
		));
		$this->assertEquals('bar', $actual['foo']);
    }

    /**
     * @covers Cradle\Curl\Rest::getEventHandler
     */
    public function testGetEventHandler()
    {
        $instance = $this->object->getEventHandler();
		$this->assertInstanceOf('Cradle\Event\EventHandler', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::on
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
		
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		$this->assertTrue($trigger->success);
    }

    /**
     * @covers Cradle\Curl\Rest::setEventHandler
     */
    public function testSetEventHandler()
    {
        $instance = $this->object->setEventHandler(new EventHandler);
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::trigger
     */
    public function testTrigger()
    {
		$trigger = new StdClass();
		$trigger->success = null;
		
        $instance = $this
			->object
			->on('foobar', function($trigger) {
				$trigger->success = true;
			})
			->trigger('foobar', $trigger);
		
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
		$this->assertTrue($trigger->success);
    }

    /**
     * @covers Cradle\Curl\Rest::i
     */
    public function testI()
    {
        $instance1 = Rest::i('http://foobar.com');
		
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance1);
		
		$instance2 = Rest::i('http://foobar.com');
		
		$this->assertTrue($instance1 !== $instance2);
    }

     /**
     * @covers Cradle\Curl\Rest::loop
     */
    public function testLoop()
    {
        $self = $this;
        $this->object->loop(function($i) use ($self) {
            $self->assertInstanceOf('Cradle\Curl\Rest', $this);
            
            if ($i == 2) {
                return false;
            }
        });
    }

    /**
     * @covers Cradle\Curl\Rest::when
     */
    public function testWhen()
    {
        $self = $this;
        $test = 'Good';
        $this->object->when(function() use ($self) {
            $self->assertInstanceOf('Cradle\Curl\Rest', $this);
            return false;
        }, function() use ($self, &$test) {
            $self->assertInstanceOf('Cradle\Curl\Rest', $this);
            $test = 'Bad';
        });
    }

    /**
     * @covers Cradle\Curl\Rest::getInspectorHandler
     */
    public function testGetInspectorHandler()
    {
        $instance = $this->object->getInspectorHandler();
		$this->assertInstanceOf('Cradle\Profiler\InspectorHandler', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::inspect
     */
    public function testInspect()
    {
        ob_start();
		$this->object->inspect('foobar');
		$contents = ob_get_contents();
		ob_end_clean();  
		
		$this->assertEquals(
			'<pre>INSPECTING Variable:</pre><pre>foobar</pre>', 
			$contents
		);
    }

    /**
     * @covers Cradle\Curl\Rest::setInspectorHandler
     */
    public function testSetInspectorHandler()
    {
        $instance = $this->object->setInspectorHandler(new InspectorHandler);
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::addLogger
     */
    public function testAddLogger()
    {
        $instance = $this->object->addLogger(function() {});
		$this->assertInstanceOf('Cradle\Curl\Rest', $instance);
    }

    /**
     * @covers Cradle\Curl\Rest::log
     */
    public function testLog()
    {
		$trigger = new StdClass();
		$trigger->success = null;
        $this->object->addLogger(function($trigger) {
			$trigger->success = true;
		})
		->log($trigger);
		
		
		$this->assertTrue($trigger->success);
    }

    /**
     * @covers Cradle\Curl\Rest::loadState
     */
    public function testLoadState()
    {
		$state1 = new Rest('http://foobar.com');
		$state2 = new Rest('http://foobar.com');
		
		$state1->saveState('state1');
		$state2->saveState('state2');
		
		$this->assertTrue($state2 === $state1->loadState('state2'));
		$this->assertTrue($state1 === $state2->loadState('state1'));
    }

    /**
     * @covers Cradle\Curl\Rest::saveState
     */
    public function testSaveState()
    {
		$state1 = new Rest('http://foobar.com');
		$state2 = new Rest('http://foobar.com');
		
		$state1->saveState('state1');
		$state2->saveState('state2');
		
		$this->assertTrue($state2 === $state1->loadState('state2'));
		$this->assertTrue($state1 === $state2->loadState('state1'));
    }

    /**
     * @covers Cradle\Curl\Rest::__callResolver
     */
    public function test__callResolver()
    {
        $actual = $this->object->addResolver(ResolverCallStub::class, function() {});
		$this->assertInstanceOf('Cradle\Curl\Rest', $actual);
    }

    /**
     * @covers Cradle\Curl\Rest::addResolver
     */
    public function testAddResolver()
    {
        $actual = $this->object->addResolver(ResolverCallStub::class, function() {});
		$this->assertInstanceOf('Cradle\Curl\Rest', $actual);
    }

    /**
     * @covers Cradle\Curl\Rest::getResolverHandler
     */
    public function testGetResolverHandler()
    {
        $actual = $this->object->getResolverHandler();
		$this->assertInstanceOf('Cradle\Resolver\ResolverHandler', $actual);
    }

    /**
     * @covers Cradle\Curl\Rest::resolve
     */
    public function testResolve()
    {
        $actual = $this->object->addResolver(
			ResolverCallStub::class, 
			function() {
				return new ResolverAddStub();
			}
		)
		->resolve(ResolverCallStub::class)
		->foo('bar');
		
        $this->assertEquals('barfoo', $actual);
    }

    /**
     * @covers Cradle\Curl\Rest::resolveShared
     */
    public function testResolveShared()
    {
        $actual = $this
			->object
			->resolveShared(ResolverSharedStub::class)
			->reset()
			->foo('bar');
		
        $this->assertEquals('barfoo', $actual);
		
		$actual = $this
			->object
			->resolveShared(ResolverSharedStub::class)
			->foo('bar');
		
        $this->assertEquals('barbar', $actual);
    }

    /**
     * @covers Cradle\Curl\Rest::resolveStatic
     */
    public function testResolveStatic()
    {
        $actual = $this
			->object
			->resolveStatic(
				ResolverStaticStub::class, 
				'foo', 
				'bar'
			);
		
        $this->assertEquals('barfoo', $actual);
    }

    /**
     * @covers Cradle\Curl\Rest::setResolverHandler
     */
    public function testSetResolverHandler()
    {
        $actual = $this->object->setResolverHandler(new ResolverHandler);
		$this->assertInstanceOf('Cradle\Curl\Rest', $actual);
    }
}

if(!class_exists('Cradle\Curl\ResolverCallStub')) {
	class ResolverCallStub
	{
		public function foo($string)
		{
			return $string . 'foo';
		}
	}
}

if(!class_exists('Cradle\Curl\ResolverAddStub')) {
	class ResolverAddStub
	{
		public function foo($string)
		{
			return $string . 'foo';
		}
	}
}

if(!class_exists('Cradle\Curl\ResolverSharedStub')) {
	class ResolverSharedStub
	{
		public $name = 'foo';
		
		public function foo($string)
		{
			$name = $this->name;
			$this->name = $string;
			return $string . $name;
		}
		
		public function reset()
		{
			$this->name = 'foo';
			return $this;
		}
	}
}

if(!class_exists('Cradle\Curl\ResolverStaticStub')) {
	class ResolverStaticStub
	{
		public static function foo($string)
		{
			return $string . 'foo';
		}
	}
}