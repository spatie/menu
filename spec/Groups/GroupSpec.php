<?php

namespace spec\Spatie\Navigation\Groups;

use Prophecy\Argument;
use Spatie\Navigation\Groups\Group;
use Spatie\Navigation\Item;
use spec\Spatie\Navigation\ObjectBehavior;

class GroupSpec extends ObjectBehavior
{
    function let(Item $base)
    {
        $this->beConstructedWith($base);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Group::class);
    }

    function it_starts_inactive()
    {
        $this->isActive()->shouldBe(false);
    }

    function it_is_inactive_al_long_as_it_doesnt_have_any_active_items(Item $item)
    {
        $item->isActive()->willReturn(false);

        $this->addItem($item);

        $this->items()->shouldHaveCount(1);
        $this->isActive()->shouldBe(false);
    }

    function it_is_active_if_it_contains_an_active_child(Item $item)
    {
        $item->isActive()->willReturn(true);

        $this->addItem($item);

        $this->items()->shouldHaveCount(1);
        $this->isActive()->shouldBe(true);
    }
}
