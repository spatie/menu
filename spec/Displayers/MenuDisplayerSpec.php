<?php

namespace spec\Spatie\Navigation\Displayers;

use Spatie\Navigation\Displayers\MenuDisplayer;
use Spatie\Navigation\Collections\Root;
use Spatie\Navigation\Items\Link;

class MenuDisplayerSpec extends DisplayerBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MenuDisplayer::class);
    }

    function it_can_display_a_collection_of_links()
    {
        $root = new Root(
            new Link('Home', 'https://spatie.be'),
            new Link('Open Source', 'https://spatie.be/opensource')
        );

        $this->display($root)->shouldReturnHtml('
            <ul>
                <li>
                    <a href="https://spatie.be">Home</a>
                </li>
                <li>
                    <a href="https://spatie.be/opensource">Open Source</a>
                </li>
            </ul>
        ');
    }

    function it_can_display_a_collection_of_links_that_contains_an_active_link()
    {
        $root = new Root(
            new Link('Home', 'https://spatie.be'),
            (new Link('Open Source', 'https://spatie.be/opensource'))->setActive()
        );

        $this->display($root)->shouldReturnHtml('
            <ul>
                <li>
                    <a href="https://spatie.be">Home</a>
                </li>
                <li class="active">
                    <a href="https://spatie.be/opensource">Open Source</a>
                </li>
            </ul>
        ');
    }
}
