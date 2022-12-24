<?php

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

/**
 * Class FiltersTest.
 */
it('can apply using each', function () {
    $this->menu = Menu::new()
        ->link('#', 'Beam')
        ->link('#', 'Me')
        ->each(function (Link $link) {
        $link->addClass('filtered');
        })
        ->link('#', 'Up')
        ->link('#', 'Scotty');

    assertRenders('
        <ul>
        <li><a href="#" class="filtered">Beam</a></li>
        <li><a href="#" class="filtered">Me</a></li>
        <li><a href="#">Up</a></li>
        <li><a href="#">Scotty</a></li>
        </ul>
    ');
});

it('can apply using register filter', function () {
    $this->menu = Menu::new()
        ->link('#', 'Beam')
        ->link('#', 'Me')
        ->registerFilter(function (Link $link) {
        $link->addClass('filtered');
        })
        ->link('#', 'Up')
        ->link('#', 'Scotty');

    assertRenders('
        <ul>
        <li><a href="#">Beam</a></li>
        <li><a href="#">Me</a></li>
        <li><a href="#" class="filtered">Up</a></li>
        <li><a href="#" class="filtered">Scotty</a></li>
        </ul>
    ');
});

it('can apply using apply to all', function () {
    $this->menu = Menu::new()
        ->link('#', 'Beam')
        ->link('#', 'Me')
        ->applyToAll(function (Link $link) {
        $link->addClass('filtered');
        })
        ->link('#', 'Up')
        ->link('#', 'Scotty');

    assertRenders('
        <ul>
        <li><a href="#" class="filtered">Beam</a></li>
        <li><a href="#" class="filtered">Me</a></li>
        <li><a href="#" class="filtered">Up</a></li>
        <li><a href="#" class="filtered">Scotty</a></li>
        </ul>
    ');
});

it('can register a closure as a filter', function () {
    $this->menu = Menu::new()->link('#', 'Foo')->applyToAll(function (Link $link) {
        $link->addClass('filtered');
    });

    assertRenders('
        <ul>
        <li><a href="#" class="filtered">Foo</a></li>
        </ul>
    ');
});

it('can register an invokable class as a filter', function () {
    // Use an anonymous class -- should be identical to a concrete class
    $invokable_class = new class () {
        public function __invoke(Link $link)
        {
        $link->addClass('filtered');
        }
    };

    $this->menu = Menu::new()->link('#', 'Foo')->applyToAll($invokable_class);

    assertRenders('
        <ul>
        <li><a href="#" class="filtered">Foo</a></li>
        </ul>
    ');
});
