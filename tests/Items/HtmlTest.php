<?php

namespace Spatie\Menu\Test\Items;

use Spatie\Menu\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_contains_html()
    {
        $this->assertEquals(
            'Hello world',
            Html::raw('Hello world')->html()
        );
    }

    /** @test */
    public function it_can_make_an_empty_item()
    {
        $this->assertEquals(
            '',
            Html::empty()->html()
        );
    }
}
