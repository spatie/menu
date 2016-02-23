<?php

namespace spec\Spatie\Menu;

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

    function it_accepts_links()
    {

    }

    function it_accepts_raw_html()
    {

    }

    function it_accepts_submenus()
    {

    }

    function it_renders_an_empty_list_if_there_arent_any_items()
    {
        $this->render()->shouldReturnHtml('
            <ul></ul>
        ');
    }

    function it_renders_its_items(Item $item)
    {
        $item->isActive()->willReturn(false);
        $item->render()->willReturn('<a href>Item</a>');

        $this->addItem($item);

        $this->render()->shouldReturnHtml('
            <ul>
                <li><a href>Item</a></li>
            </ul>
        ');
    }

    function it_renders_a_header_from_an_item(Item $header)
    {
        $header->render()->willReturn('<h2>Header</h2>');

        $this->setHeader($header);

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul></ul>
        ');
    }

    function it_renders_a_header_from_a_string()
    {
        $this->setHeader('<h2>Header</h2>');

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul></ul>
        ');
    }

    function it_renders_items_and_a_header(Item $header, Item $item)
    {
        $header->render()->willReturn('<h2>Header</h2>');
        $item->isActive()->willReturn(false);
        $item->render()->willReturn('<a href>Item</a>');

        $this->setHeader($header);
        $this->addItem($item);

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul>
                <li>
                    <a href>Item</a>
                </li>
            </ul>
        ');
    }

    function it_can_set_specific_types_of_children_active()
    {

    }

    function it_adds_attributes_to_the_ul_tag()
    {

    }
}
