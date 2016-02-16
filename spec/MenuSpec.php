<?php

namespace spec\Spatie\Navigation;

use Prophecy\Argument;
use Spatie\Navigation\Item;
use Spatie\Navigation\Menu;

class MenuSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Menu::class);
    }

    function it_can_be_initialized_with_items(Item $item1, Item $item2)
    {
        $this->beConstructedWith($item1, $item2);

        $this->items()->shouldHaveCount(2);
    }

    function it_can_be_initialized_via_a_factory_method(Item $item1, Item $item2)
    {
        $this->beConstructedThrough('create', [$item1, $item2]);

        $this->items()->shouldHaveCount(2);
    }

    function it_renders_an_empty_list_if_there_arent_any_items()
    {
        $this->render()->shouldReturnHtml('<ul></ul>');
    }

    function it_renders_its_items(Item $item)
    {
        $item->render()->willReturn('<li></li>');

        $this->addItem($item);

        $this->render()->shouldReturnHtml('<ul><li></li></ul>');
    }
}
