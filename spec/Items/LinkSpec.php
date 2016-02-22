<?php

namespace spec\Spatie\Menu\Items;

use Prophecy\Argument;
use Spatie\Menu\Item;
use Spatie\Menu\Items\Link;
use spec\Spatie\Menu\ObjectBehavior;

class LinkSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', ['Home', 'https://spatie.be']);
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
        $this->beConstructedThrough('create', ['Open Source', 'https://spatie.be/opensource']);

        $this->segment(1)->shouldBe('opensource');
    }

    function it_can_retrieve_a_segment_from_a_relative_url()
    {
        $this->beConstructedThrough('create', ['Open Source', '/opensource']);

        $this->segment(1)->shouldBe('opensource');
    }

    function it_can_be_rendered()
    {
        $this->beConstructedThrough('create', ['Open Source', '/opensource']);

        $this->render()->shouldReturn('<li><a href="/opensource">Open Source</a></li>');
    }

    function it_has_an_active_class_when_rendered_active()
    {
        $this->beConstructedThrough('create', ['Open Source', '/opensource']);
        $this->setActive();

        $this->render()->shouldReturn('<li class="active"><a href="/opensource">Open Source</a></li>');
    }
}
