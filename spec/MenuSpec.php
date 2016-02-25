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

    function it_renders_before_content_from_an_item(Item $before)
    {
        $before->render()->willReturn('<h2>Header</h2>');

        $this->before($before);

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul></ul>
        ');
    }

    function it_renders_before_content_from_a_string()
    {
        $this->before('<h2>Header</h2>');

        $this->render()->shouldReturnHtml('
            <h2>Header</h2>
            <ul></ul>
        ');
    }

    function it_renders_items_and_before_content(Item $before, Item $item)
    {
        $before->render()->willReturn('<h2>Header</h2>');
        $item->isActive()->willReturn(false);
        $item->render()->willReturn('<a href>Item</a>');

        $this->before($before);
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

    function it_renders_after_content_from_an_item(Item $after)
    {
    }

    function it_renders_after_content_from_a_string()
    {
    }

    function it_renders_items_and_after_content(Item $after, Item $item)
    {
    }

    function it_can_set_specific_types_of_children_active()
    {
    }

    function it_adds_attributes_to_the_ul_tag()
    {
    }

    function it_can_prefix_links()
    {
        $this
            ->setLinkPrefix('/opensource')
            ->addLink('laravel', 'Laravel');

        $this->render()->shouldReturnHtml('
            <ul>
                <li><a href="/opensource/laravel">Laravel</a></li>
            </ul>
        ');
    }
}
