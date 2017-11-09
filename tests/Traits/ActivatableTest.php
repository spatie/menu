<?php

namespace Spatie\Menu\Test\Traits;

use PHPUnit\Framework\TestCase;
use Spatie\Menu\Traits\Activatable;

class ActivatableTest extends TestCase
{
    protected $activatable;

    public function setUp()
    {
        $this->activatable = new class {
            use Activatable;
            protected $active = false;
        };
    }

    /** @test */
    public function it_can_be_set_active()
    {
        $this->assertTrue($this->activatable->setActive()->isActive());
    }

    /** @test */
    public function it_can_be_set_inactive_via_set_active()
    {
        $this->assertFalse($this->activatable->setActive()->setActive(false)->isActive());
    }

    /** @test */
    public function it_can_be_set_inactive_via_set_inactive()
    {
        $this->assertFalse($this->activatable->setActive()->setInactive()->isActive());
    }

    /** @test */
    public function it_can_be_set_active_via_a_callable()
    {
        $this->assertFalse($this->activatable->setActive(function () {
            return false;
        })->isActive());
    }
}
