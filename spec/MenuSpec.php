<?php

namespace spec\Spatie\Menu;

use Prophecy\Argument;
use Spatie\Menu\Item;
use Spatie\Menu\Items\Link;
use Spatie\Menu\Menu;

class MenuSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', []);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Menu::class);
    }

    function it_can_be_initialized_with_items(Item $item1, Item $item2)
    {
        $this->beConstructedThrough('create', [[$item1, $item2]]);

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

    function it_renders_a_header_from_an_item(Item $header, Item $item)
    {
        $header->render()->willReturn('<h2>Header</h2>');
        $item->render()->willReturn('<li></li>');

        $this->setHeader($header);
        $this->addItem($item);

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul>
                <li>
                </li>
            </ul>
        ');
    }

    function it_renders_a_header_from_a_string(Item $item)
    {
        $item->render()->willReturn('<li></li>');

        $this->setHeader('<h2>Header</h2>');
        $this->addItem($item);

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul>
                <li>
                </li>
            </ul>
        ');
    }

    function it_can_manipulate_items(Item $item)
    {
        $this->addItem($item);

        $i = 0;

        $this->manipulate(function ($item) use (&$i) {
            expect($item)->toBe($item);
            $i++;
        });

        expect($i)->toBe(1);
    }

    function it_can_manipulate_a_specific_type_of_items_with_a_typehint(Item $item)
    {
        // We can't mock this one since manipulate depends on an `instanceof` call
        $link = Link::create('https://spatie.be', 'Spatie');

        $this->addItem($item);
        $this->addItem($link);

        $i = 0;

        $this->manipulate(function (Link $link) use (&$i) {
            expect($link)->toBe($link);
            $i++;
        });

        expect($i)->toBe(1);
    }
}
