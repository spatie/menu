<?php

namespace spec\Spatie\Navigation\Displayers;

use Prophecy\Argument;
use Spatie\Navigation\Collections\Group;
use Spatie\Navigation\Displayers\BreadcrumbDisplayer;
use Spatie\Navigation\Collections\Root;
use Spatie\Navigation\Items\Link;

class BreadcrumbDisplayerSpec extends DisplayerBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BreadcrumbDisplayer::class);
    }

    function it_renders_nothing_if_no_links_are_active()
    {
        $root = new Root(
            new Link('Home', 'https://spatie.be'),
            new Link('Open Source', 'https://spatie.be/opensource')
        );

        $this->display($root)->shouldReturn('');
    }

    function it_can_generate_breadcrumbs_for_a_collection_of_links()
    {
        $root = new Root(
            new Link('Home', 'https://spatie.be'),
            (new Link('Open Source', 'https://spatie.be/opensource'))->setActive()
        );

        $this->display($root)->shouldReturnHtml('
            <ul>
                <li>
                    <a href="https://spatie.be/opensource">Open Source</a>
                </li>
            </ul>
        ');
    }

    function it_can_display_multiple_levels_of_breadcrumbs()
    {
        $group = new Root(
            (new Group(new Link('Home', 'https://spatie.be')))->fill(
                new Link('Open Source', 'https://spatie.be/opensource/php'),
                (new Link('Open Source', 'https://spatie.be/opensource/javascript'))->setActive()
            )
        );
    }
}
