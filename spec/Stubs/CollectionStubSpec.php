<?php

namespace spec\Spatie\Menu\Stubs;

use Spatie\Menu\Item;
use Spatie\Menu\Items\Link;
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
