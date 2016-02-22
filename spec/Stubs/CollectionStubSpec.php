<?php

namespace spec\Spatie\Menu\Stubs;

use Prophecy\Argument;
use Spatie\Menu\Item;
use Spatie\Menu\Stubs\CollectionStub;
use spec\Spatie\Menu\ObjectBehavior;

class CollectionStubSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CollectionStub::class);
    }

    function it_starts_out_empty()
    {
        $this->items()->shouldHaveCount(0);
    }

    function it_can_receive_an_item(Item $item)
    {
        $this->addItem($item);

        $this->items()->shouldHaveCount(1);
    }

    function it_can_be_filled_with_multiple_items(Item $item1, Item $item2)
    {
        $this->fill($item1, $item2);

        $this->items()->shouldHaveCount(2);
    }

    function it_provides_a_fluent_interface(Item $item)
    {
        $this->addItem($item)->shouldReturnAnInstanceOf(CollectionStub::class);
        $this->fill()->shouldReturnAnInstanceOf(CollectionStub::class);
    }

    function it_is_mappable(Item $item1, Item $item2)
    {
        $item1->render()->willReturn('foo');
        $item2->render()->willReturn('bar');

        $this->fill($item1, $item2);

        $this->map(function(Item $item) {
            return $item->render();
        })->shouldBeLike(['foo', 'bar']);
    }

    function it_can_return_a_concatenated_string_after_mapping(Item $item1, Item $item2)
    {
        $item1->render()->willReturn('foo');
        $item2->render()->willReturn('bar');

        $this->fill($item1, $item2);

        $this->mapAndJoin(function(Item $item) {
            return $item->render();
        })->shouldBeLike('foobar');
    }
}
