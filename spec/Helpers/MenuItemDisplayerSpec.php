<?php

namespace spec\Spatie\Menu\Helpers;

use Spatie\Menu\Helpers\MenuItemDisplayer;
use spec\Spatie\Menu\ObjectBehavior;

class MenuItemDisplayerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MenuItemDisplayer::class);
    }

    function it_renders_list_elements()
    {

    }

    function it_adds_a_class_if_the_item_is_active()
    {

    }
}
