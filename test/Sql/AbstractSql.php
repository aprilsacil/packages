<?php

namespace Cradle\Sql;

use StdClass;
use PHPUnit_Framework_TestCase;

use Cradle\Resolver\ResolverHandler;
use Cradle\Profiler\InspectorHandler;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 02:11:02.
 */
class Cradle_Sql_AbstractSql_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractSql
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new AbstractSqlStub;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Cradle\Sql\AbstractSql::bind
     */
    public function testBind()
    {
        $this->assertEquals(':bind0bind', $this->object->bind('foobar'));
        $this->assertEquals('(:bind1bind,:bind2bind)', $this->object->bind(array('foo','bar')));
        $this->assertEquals(1, $this->object->bind(1));
    }

    /**
     * @covers Cradle\Sql\AbstractSql::collection
     */
    public function testCollection()
    {
        $collection = $this->object->collection();
        $this->assertInstanceOf('Cradle\Sql\Collection', $collection);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::deleteRows
     */
    public function testDeleteRows()
    {
        $instance = $this->object->deleteRows('foobar', 'foo=bar');
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);

        $instance = $this->object->deleteRows('foobar', array('foo=%s', 'bar'));
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);

        $instance = $this->object->deleteRows('foobar', array(array('foo=%s', 'bar')));
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getBinds
     */
    public function testGetBinds()
    {
         $this->assertEquals(':bind0bind', $this->object->bind('foo'));
         $this->assertEquals(':bind1bind', $this->object->bind('bar'));

         $binds = $this->object->getBinds();

         $this->assertEquals('foo', $binds[':bind0bind']);
         $this->assertEquals('bar', $binds[':bind1bind']);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getConnection
     */
    public function testGetConnection()
    {
        $actual = $this->object->getConnection();
        $this->assertEquals('foobar', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getDeleteQuery
     */
    public function testGetDeleteQuery()
    {
        $actual = $this->object->getDeleteQuery('foobar');
        $this->assertInstanceOf('Cradle\Sql\QueryDelete', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getInsertQuery
     */
    public function testGetInsertQuery()
    {
        $actual = $this->object->getInsertQuery('foobar');
        $this->assertInstanceOf('Cradle\Sql\QueryInsert', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getLastInsertedId
     */
    public function testGetLastInsertedId()
    {
        $actual = $this->object->getLastInsertedId();
        $this->assertEquals(123, $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getModel
     */
    public function testGetModel()
    {
        $model = $this->object->getModel('foobar', 'foo_id', 3);
        $this->assertInstanceOf('Cradle\Sql\Model', $model);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getRow
     */
    public function testGetRow()
    {
        $actual = $this->object->getRow('foobar', 'foo_id', 3);
        $this->assertEquals('SELECT * FROM foobar WHERE foo_id = 3  LIMIT 0,1;', $actual['query']);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getSelectQuery
     */
    public function testGetSelectQuery()
    {
        $actual = $this->object->getSelectQuery('foobar');
        $this->assertInstanceOf('Cradle\Sql\QuerySelect', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getUpdateQuery
     */
    public function testGetUpdateQuery()
    {
        $actual = $this->object->getUpdateQuery('foobar');
        $this->assertInstanceOf('Cradle\Sql\QueryUpdate', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::insertRow
     */
    public function testInsertRow()
    {
        $instance = $this->object->insertRow('foobar', array(
            'foo' => 'bar',
            'bar' => null
        ));

        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::insertRows
     */
    public function testInsertRows()
    {
        $instance = $this->object->insertRows('foobar', array(
            array(
                'foo' => 'bar',
                'bar' => 'foo'
            ),
            array(
                'foo' => 'bar',
                'bar' => 'foo'
            )
        ));

        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::model
     */
    public function testModel()
    {
        $collection = $this->object->model();
        $this->assertInstanceOf('Cradle\Sql\Model', $collection);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::query
     */
    public function testQuery()
    {
        $actual = $this->object->query('foobar', array('foo', 'bar'));
        $this->assertEquals('foobar', $actual[0]['query']);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::search
     */
    public function testSearch()
    {
        $collection = $this->object->search('foobar');
        $this->assertInstanceOf('Cradle\Sql\Search', $collection);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::setBinds
     */
    public function testSetBinds()
    {
        $instance = $this->object->setBinds(array(
            'foo' => 'bar',
            'bar' => 'foo'
        ));

        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::setRow
     */
    public function testSetRow()
    {
        $instance = $this->object->setRow('foobar', 'foo_id', 3, array(
            'foo' => 'bar',
            'bar' => 'foo'
        ));

        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::updateRows
     */
    public function testUpdateRows()
    {
        $instance = $this->object->updateRows('foobar', array(
            'foo' => 'bar',
            'bar' => 'foo'
        ), 'foo=bar');

        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::i
     */
    public function testI()
    {
        $instance1 = AbstractSqlStub::i();
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance1);

        $instance2 = AbstractSqlStub::i();
        $this->assertTrue($instance1 !== $instance2);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::loop
     */
    public function testLoop()
    {
        $self = $this;
        $this->object->loop(function($i) use ($self) {
            $self->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $this);

            if ($i == 2) {
                return false;
            }
        });
    }

    /**
     * @covers Cradle\Sql\AbstractSql::when
     */
    public function testWhen()
    {
        $self = $this;
        $test = 'Good';
        $this->object->when(function() use ($self) {
            $self->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $this);
            return false;
        }, function() use ($self, &$test) {
            $self->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $this);
            $test = 'Bad';
        });
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getInspectorHandler
     */
    public function testGetInspectorHandler()
    {
        $instance = $this->object->getInspectorHandler();
        $this->assertInstanceOf('Cradle\Profiler\InspectorHandler', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::inspect
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
     * @covers Cradle\Sql\AbstractSql::setInspectorHandler
     */
    public function testSetInspectorHandler()
    {
        $instance = $this->object->setInspectorHandler(new InspectorHandler);
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::addLogger
     */
    public function testAddLogger()
    {
        $instance = $this->object->addLogger(function() {});
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $instance);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::log
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
     * @covers Cradle\Sql\AbstractSql::loadState
     */
    public function testLoadState()
    {
        $state1 = new AbstractSqlStub();
        $state2 = new AbstractSqlStub();

        $state1->saveState('state1');
        $state2->saveState('state2');

        $this->assertTrue($state2 === $state1->loadState('state2'));
        $this->assertTrue($state1 === $state2->loadState('state1'));
    }

    /**
     * @covers Cradle\Sql\AbstractSql::saveState
     */
    public function testSaveState()
    {
        $state1 = new AbstractSqlStub();
        $state2 = new AbstractSqlStub();

        $state1->saveState('state1');
        $state2->saveState('state2');

        $this->assertTrue($state2 === $state1->loadState('state2'));
        $this->assertTrue($state1 === $state2->loadState('state1'));
    }

    /**
     * @covers Cradle\Sql\AbstractSql::__call
     * @todo   Implement test__call().
     */
    public function test__call()
    {
        $actual = $this->object->addResolver(ResolverCallStub::class, function() {});
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::__callResolver
     * @todo   Implement test__callResolver().
     */
    public function test__callResolver()
    {
        $actual = $this->object->addResolver(ResolverCallStub::class, function() {});
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::addResolver
     */
    public function testAddResolver()
    {
        $actual = $this->object->addResolver(ResolverCallStub::class, function() {});
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::getResolverHandler
     */
    public function testGetResolverHandler()
    {
        $actual = $this->object->getResolverHandler();
        $this->assertInstanceOf('Cradle\Resolver\ResolverHandler', $actual);
    }

    /**
     * @covers Cradle\Sql\AbstractSql::resolve
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
     * @covers Cradle\Sql\AbstractSql::resolveShared
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
     * @covers Cradle\Sql\AbstractSql::resolveStatic
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
     * @covers Cradle\Sql\AbstractSql::setResolverHandler
     */
    public function testSetResolverHandler()
    {
        $actual = $this->object->setResolverHandler(new ResolverHandler);
        $this->assertInstanceOf('Cradle\Sql\AbstractSqlStub', $actual);
    }
}

if(!class_exists('Cradle\Sql\AbstractSqlStub')) {
    class AbstractSqlStub extends AbstractSql implements SqlInterface
    {
        public function connect($options = [])
        {
            $this->connection = 'foobar';
            return $this;
        }

        public function getLastInsertedId($column = null)
        {
            return 123;
        }

        public function query($query, array $binds = [], $fetch = null)
        {
            return array(array(
                'total' => 123,
                'query' => (string) $query,
                'binds' => $binds
            ));
        }

        public function getColumns()
        {
            return array(
                array(
                    'Field' => 'foobar_id',
                    'Type' => 'int',
                    'Key' => 'PRI',
                    'Default' => null,
                    'Null' => 1
                ),
                array(
                    'Field' => 'foobar_title',
                    'Type' => 'vachar',
                    'Key' => null,
                    'Default' => null,
                    'Null' => 1
                ),
                array(
                    'Field' => 'foobar_date',
                    'Type' => 'datetime',
                    'Key' => null,
                    'Default' => null,
                    'Null' => 1
                )
            );
        }
    }
}

if(!class_exists('Cradle\Sql\ResolverCallStub')) {
    class ResolverCallStub
    {
        public function foo($string)
        {
            return $string . 'foo';
        }
    }
}

if(!class_exists('Cradle\Sql\ResolverAddStub')) {
    class ResolverAddStub
    {
        public function foo($string)
        {
            return $string . 'foo';
        }
    }
}

if(!class_exists('Cradle\Sql\ResolverSharedStub')) {
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

if(!class_exists('Cradle\Sql\ResolverStaticStub')) {
    class ResolverStaticStub
    {
        public static function foo($string)
        {
            return $string . 'foo';
        }
    }
}
