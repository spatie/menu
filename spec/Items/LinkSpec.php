<?php

namespace spec\Spatie\Navigation\Items;

use Prophecy\Argument;
use Spatie\Navigation\Item;
use Spatie\Navigation\Items\Link;
use spec\Spatie\Navigation\ObjectBehavior;

class LinkSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Home', 'https://spatie.be');
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

    function it_starts_inactive()
    {
        $this->isActive()->shouldBe(false);
    }

    function it_can_be_set_active()
    {
        $this->setActive();
        $this->isActive()->shouldBe(true);
    }

    function it_can_be_set_inactive()
    {
        $this->setActive();
        $this->setInactive();
        $this->isActive()->shouldBe(false);
    }

    function it_can_retrieve_a_segment_from_an_absolute_root_url()
    {
        $this->beConstructedWith('Home', 'https://spatie.be');

        $this->segment(1)->shouldBe(null);
    }

    function it_can_retrieve_a_segment_from_an_absolute_url()
    {
        $this->beConstructedWith('Open Source', 'https://spatie.be/opensource');

        $this->segment(1)->shouldBe('opensource');
    }

    function it_can_retrieve_a_segment_from_a_relative_url()
    {
        $this->beConstructedWith('Open Source', '/opensource');

        $this->segment(1)->shouldBe('opensource');
    }

    function it_can_be_rendered()
    {
        $this->beConstructedWith('Open Source', '/opensource');

        $this->render()->shouldReturn('<li><a href="/opensource">Open Source</a></li>');
    }

    function it_has_an_active_class_when_rendered_active()
    {
        $this->beConstructedWith('Open Source', '/opensource');
        $this->setActive();

        $this->render()->shouldReturn('<li class="active"><a href="/opensource">Open Source</a></li>');
    }
}
