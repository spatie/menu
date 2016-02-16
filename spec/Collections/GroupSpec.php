<?php

namespace spec\Spatie\Navigation\Collections;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spatie\Navigation\Collections\Group;
use Spatie\Navigation\Node;

class GroupSpec extends ObjectBehavior
{
    function let(Node $node)
    {
        $this->beConstructedWith($node);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Group::class);
    }

    function it_starts_with_an_empty_set_of_children()
    {
        $this->children()->shouldHaveCount(0);
    }

    function it_accepts_new_children(Node $node)
    {
        $this->add($node);

        $this->children()->shouldHaveCount(1);
    }

    function it_starts_inactive()
    {
        $this->isActive()->shouldBe(false);
    }

    function it_is_inactive_al_long_as_it_doesnt_have_any_active_children(Node $node)
    {
        $node->isActive()->willReturn(false);

        $this->add($node);

        $this->children()->shouldHaveCount(1);
        $this->isActive()->shouldBe(false);
    }

    function it_is_active_if_it_contains_an_active_child(Node $node)
    {
        $node->isActive()->willReturn(true);

        $this->add($node);

        $this->children()->shouldHaveCount(1);
        $this->isActive()->shouldBe(true);
    }
}
