<?php

namespace Cradle\Handlebars;

use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-07-27 at 02:11:00.
 */
class Cradle_Handlebars_HandlebarsTokenizer_Test extends PHPUnit_Framework_TestCase
{
    /**
     * @var HandlebarsTokenizer
     */
    protected $object;

	 /**
     * @var string
     */
    protected $source;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
		$this->source = file_get_contents(__DIR__.'/../assets/handlebars/tokenizer.html');
        $this->object = new HandlebarsTokenizer($this->source);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

	/**
     * @covers Cradle\Handlebars\HandlebarsTokenizer::__construct
     */
    public function test__construct()
    {
		$actual = $this->object->__construct($this->source);
		
		$this->assertNull($actual);
	}

    /**
     * @covers Cradle\Handlebars\HandlebarsTokenizer::tokenize
     */
    public function testTokenize()
    {
        $i = 0;
		
		//should we test for more?
		$tests = array(
			'<div class="product-fields">
	<div class="form-group',
		"if errors.product_title",
		' has-error',
		"if",
		' clearfix">
        <label class="control-label">',
			"_ 'Title'",
			'</label>
        <div>
            <input
                type="text"
                class="form-control"
                name="product_title"
                placeholder="',
			"_ 'What is the name of this product?'",
			'"
                value="',
			"item.product_title",
			'" />

            ',
			"if errors.product_title",
			'
            <span class="help-text text-danger">',
			"errors.product_title",
			'</span>
            ',
			"if",
			'
        </div>
    </div>

    <div class="form-group'
		);
		
		$unit = $this;
		
		$this->object->tokenize(function($node) use ($unit, $tests, &$i) {
			if(isset($tests[$i])) {
				$unit->assertEquals($tests[$i], $node['value']);
			}

			$i++;
		});
    }
}
