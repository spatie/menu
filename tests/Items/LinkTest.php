<?php

namespace Spatie\Menu\Test\Items;

use Spatie\Menu\Link;
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    /** @test */
    public function it_contains_text()
    {
        $this->assertEquals(
            'Home',
            Link::to('https://spatie.be', 'Home')->text()
        );
    }

    /** @test */
    public function it_has_an_url()
    {
        $this->assertEquals(
            'https://spatie.be',
            Link::to('https://spatie.be', 'Home')->url()
        );
    }

    /** @test */
    public function it_can_be_rendered()
    {
        $this->assertEquals(
            '<a href="https://spatie.be">Home</a>',
            Link::to('https://spatie.be', 'Home')->render()
        );
    }

    /** @test */
    public function it_can_render_classes()
    {
        $this->assertEquals(
            '<a href="https://spatie.be" class="home">Home</a>',
            Link::to('https://spatie.be', 'Home')->addClass('home')->render()
        );
    }

    /** @test */
    public function it_can_render_attributes()
    {
        $this->assertEquals(
            '<a href="https://spatie.be" data-home-link>Home</a>',
            Link::to('https://spatie.be', 'Home')->setAttribute('data-home-link')->render()
        );
    }
}
