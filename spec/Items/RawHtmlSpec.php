<?php

namespace spec\Spatie\Navigation\Items;

use Prophecy\Argument;
use Spatie\Navigation\Items\RawHtml;
use spec\Spatie\Navigation\ObjectBehavior;

class RawHtmlSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('create', ['<span>HTML</span>']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RawHtml::class);
    }

    function it_renders_its_html_contents()
    {
        $this->render()->shouldReturn('<li><span>HTML</span></li>');
    }
}
