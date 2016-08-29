<?php

namespace Spatie\Menu\Test\Items;

use Spatie\Menu\Link;

class LinkTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_contains_text()
    {
        $this->assertEquals(
            'Home',
            Link::to('https://spatie.be', 'Home')->getText()
        );
    }

    /** @test */
    public function it_has_an_url()
    {
        $this->assertEquals(
            'https://spatie.be',
            Link::to('https://spatie.be', 'Home')->getUrl()
        );
    }

    /** @test */
    public function it_can_retrieve_a_segment_from_an_absolute_root_url()
    {
        $this->assertEquals(
            null,
            Link::to('https://spatie.be', 'Home')->segment(1)
        );
    }

    /** @test */
    public function it_can_retrieve_a_segment_from_an_absolute_url()
    {
        $this->assertEquals(
            'opensource',
            Link::to('https://spatie.be/opensource', 'Open Source')->segment(1)
        );
    }

    /** @test */
    public function it_can_retrieve_a_segment_from_a_relative_url()
    {
        $this->assertEquals(
            'opensource',
            Link::to('/opensource', 'Open Source')->segment(1)
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

    /** @test */
    public function it_can_prefix_an_url()
    {
        $this->assertEquals(
            '/foo/bar',
            Link::to('/bar', 'Bar')->prefix('/foo')->getUrl()
        );
    }

    /** @test */
    public function it_can_prefix_an_url_multiple_times()
    {
        $this->assertEquals(
            '/foo/bar/baz',
            Link::to('/baz', 'Bar')->prefix('/foo')->prefix('/bar')->getUrl()
        );
    }
}
