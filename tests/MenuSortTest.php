<?php

namespace Spatie\Menu\Test;

use Spatie\Menu\Link;
use Spatie\Menu\Menu;

class MenuSortTest extends MenuTestCase
{
    /** @test */
    public function element_has_priority()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/contact', 'Contact')->setPriority(10));

        $items = $this->menu->getIterator();
        $first = $items[0];

        $this->assertTrue(method_exists($first, 'getPriority'));
        $this->assertEquals(10, $first->getPriority());
    }

    /** @test */
    public function uses_default_order()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/', 'Home'))
            ->add(Link::to('/contact', 'Contact'));

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        ');
    }

    /** @test */
    public function sort_based_on_priority()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/contact', 'Contact')->setPriority(10))
            ->add(Link::to('/', 'Home')->setPriority(0));

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        ');
    }

    /** @test */
    public function modify_sorting_process()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/contact', 'Contact')->setPriority(10))
            ->add(Link::to('/', 'Home')->setPriority(100))
            ->setSortCallback(function ($a, $b) {
                return $a->getPriority() > $b->getPriority() ? -1 : 1;
            });

        $this->assertRenders('
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        ');
    }

    /** @test */
    public function try_another_sorting_approach()
    {
        $this->menu = Menu::new()
            ->add(Link::to('/contact', 'Contact')->setPriority(10))
            ->add(Link::to('/', 'Home')->setPriority(100))
            ->setSortCallback(function ($a, $b) {
                return strcmp($a->text(), $b->text());

            });

        $this->assertRenders('
            <ul>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/">Home</a></li>
            </ul>
        ');
    }
}
