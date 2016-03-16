<?php

namespace Spatie\Menu\Test\Items;

use Spatie\Menu\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    function it_contains_html()
    {
        $this->assertEquals(
            'Hello world',
            Html::raw('Hello world')->getHtml()
        );
    }

    /** @test */
    function it_can_be_set_active()
    {
        $this->assertTrue(Html::raw('')->setActive()->isActive());
    }
}
