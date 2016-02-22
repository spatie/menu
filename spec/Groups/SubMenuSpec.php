<?php

namespace spec\Spatie\Menu\Groups;

use Prophecy\Argument;
use Spatie\Menu\Groups\SubMenu;
use Spatie\Menu\Item;
use Spatie\Menu\Items\Link;
use spec\Spatie\Menu\ObjectBehavior;

class SubMenuSpec extends ObjectBehavior
{
    function let(Item $base)
    {
        $this->beConstructedThrough('create', [$base, []]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SubMenu::class);
    }

    function it_is_inactive_al_long_as_it_doesnt_have_any_active_items(Item $base, Item $item)
    {
        $this->beConstructedThrough('create', [$base, []]);

        $base->isActive()->willReturn(false);
        $item->isActive()->willReturn(false);

        $this->addItem($item);

        $this->items()->shouldHaveCount(1);
        $this->isActive()->shouldBe(false);
    }

    function it_is_active_if_it_contains_an_active_child(Item $base, Item $item)
    {
        $this->beConstructedThrough('create', [$base, []]);

        $base->isActive()->willReturn(false);
        $item->isActive()->willReturn(true);

        $this->addItem($item);

        $this->items()->shouldHaveCount(1);
        $this->isActive()->shouldBe(true);
    }

    function it_can_be_rendered(Link $base, Link $link1, Link $link2)
    {
        $this->beConstructedThrough('create', [$base, [$link1, $link2]]);

        $base->render()->willReturn('<a href="/opensource">Open Source</a>');
        $link1->render()->willReturn('<a href="/opensource/laravel">Laravel</a>');
        $link2->render()->willReturn('<a href="/opensource/php">PHP</a>');

        $this->render()->shouldReturnHtml('
            <li>
                <a href="/opensource">Open Source</a>
                <ul>
                    <li><a href="/opensource/laravel">Laravel</a></li>
                    <li><a href="/opensource/php">PHP</a></li>
                </ul>
            </li>
        ');
    }
}
