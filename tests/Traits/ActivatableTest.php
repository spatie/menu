<?php

namespace Spatie\Menu\Test\Traits;

use Spatie\Menu\Traits\Activatable;

class ActivatableTest extends \PHPUnit_Framework_TestCase
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
    public function it_can_be_set_inactive()
    {
        $this->assertFalse($this->activatable->setActive()->setInactive()->isActive());
    }
}
