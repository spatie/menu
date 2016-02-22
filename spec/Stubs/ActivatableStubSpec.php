<?php

namespace spec\Spatie\Menu\Stubs;

use Prophecy\Argument;
use Spatie\Menu\Stubs\ActivatableStub;
use spec\Spatie\Menu\ObjectBehavior;

class ActivatableStubSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ActivatableStub::class);
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
}
