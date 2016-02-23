<?php

namespace spec\Spatie\Menu\Items;

use Spatie\Menu\Item;
use Spatie\Menu\Items\Link;
use spec\Spatie\Menu\ObjectBehavior;

class LinkSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', ['https://spatie.be', 'Home']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Link::class);

        $this->shouldImplement(Item::class);
    }

    function it_contains_text()
    {
        $this->text()->shouldBe('Home');
    }

    function it_has_an_url()
    {
        $this->url()->shouldBe('https://spatie.be');
    }

    function it_can_retrieve_a_segment_from_an_absolute_root_url()
    {
        $this->segment(1)->shouldBe(null);
    }

    function it_can_retrieve_a_segment_from_an_absolute_url()
    {
        $this->beConstructedThrough('create', ['https://spatie.be/opensource', 'Home']);

        $this->segment(1)->shouldBe('opensource');
    }

    function it_can_retrieve_a_segment_from_a_relative_url()
    {
        $this->beConstructedThrough('create', ['/opensource', 'Open Source']);

        $this->segment(1)->shouldBe('opensource');
    }

    function it_can_be_rendered()
    {
        $this->beConstructedThrough('create', ['/opensource', 'Open Source']);

        $this->render()->shouldReturn('<a href="/opensource">Open Source</a>');
    }
}
