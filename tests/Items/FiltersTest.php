<?php

namespace Spatie\Menu\Test\Items;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;
use Spatie\Menu\Test\MenuTestCase;

/**
 * Class FiltersTest.
 */
class FiltersTest extends MenuTestCase
{
    /** @test */
    public function it_can_apply_using_each()
    {
        $this->menu = Menu::new()
            ->link('#', 'Beam')
            ->link('#', 'Me')
            ->each(function (Link $link) {
                $link->addClass('filtered');
            })
            ->link('#', 'Up')
            ->link('#', 'Scotty');

        $this->assertRenders('
            <ul>
                <li><a href="#" class="filtered">Beam</a></li>
                <li><a href="#" class="filtered">Me</a></li>
                <li><a href="#">Up</a></li>
                <li><a href="#">Scotty</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_apply_using_register_filter()
    {
        $this->menu = Menu::new()
            ->link('#', 'Beam')
            ->link('#', 'Me')
            ->registerFilter(function (Link $link) {
                $link->addClass('filtered');
            })
            ->link('#', 'Up')
            ->link('#', 'Scotty');

        $this->assertRenders('
            <ul>
                <li><a href="#">Beam</a></li>
                <li><a href="#">Me</a></li>
                <li><a href="#" class="filtered">Up</a></li>
                <li><a href="#" class="filtered">Scotty</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_apply_using_apply_to_all()
    {
        $this->menu = Menu::new()
            ->link('#', 'Beam')
            ->link('#', 'Me')
            ->applyToAll(function (Link $link) {
                $link->addClass('filtered');
            })
            ->link('#', 'Up')
            ->link('#', 'Scotty');

        $this->assertRenders('
            <ul>
                <li><a href="#" class="filtered">Beam</a></li>
                <li><a href="#" class="filtered">Me</a></li>
                <li><a href="#" class="filtered">Up</a></li>
                <li><a href="#" class="filtered">Scotty</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_register_a_closure_as_a_filter()
    {
        $this->menu = Menu::new()->link('#', 'Foo')->applyToAll(function (Link $link) {
            $link->addClass('filtered');
        });

        $this->assertRenders('
            <ul>
                <li><a href="#" class="filtered">Foo</a></li>
            </ul>
        ');
    }

    /** @test */
    public function it_can_register_an_invokable_class_as_a_filter()
    {
        // Use an anonymous class -- should be identical to a concrete class
        $invokable_class = new class() {
            public function __invoke(Link $link)
            {
                $link->addClass('filtered');
            }
        };

        $this->menu = Menu::new()->link('#', 'Foo')->applyToAll($invokable_class);

        $this->assertRenders('
            <ul>
                <li><a href="#" class="filtered">Foo</a></li>
            </ul>
        ');
    }
}
