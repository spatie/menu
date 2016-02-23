<?php

namespace spec\Spatie\Menu\Stubs;

use Spatie\Menu\Stubs\HtmlElementStub;
use spec\Spatie\Menu\ObjectBehavior;

class HtmlElementStubSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HtmlElementStub::class);
    }

    function it_initially_doesnt_have_attributes()
    {
        $this->attributes()->shouldHaveCount(0);
    }

    function it_accepts_attributes()
    {
        $this->addAttribute('foo', 'bar');

        $this->attributes()->shouldBeLike(['foo' => 'bar']);
    }

    function it_accepts_attributes_without_values()
    {
        $this->addAttribute('foo');

        $this->attributes()->shouldBeLike(['foo' => null]);
    }

    function it_renders_an_html_element()
    {
        $this->addAttribute('class', 'menu col-md-6');
        $this->addAttribute('id', 'menu');
        $this->addAttribute('data-menu');

        $this->renderHtml()->shouldReturnHtml('
            <ul class="menu col-md-6" id="menu" data-menu></ul>
        ');
    }

    function it_only_adds_a_class_attribute_it_necessary()
    {
        $this->addAttribute('id', 'menu');
        $this->addAttribute('data-menu');

        $this->renderHtml()->shouldReturnHtml('
            <ul id="menu" data-menu></ul>
        ');
    }

    function it_provides_a_fluent_interface()
    {
        $this
            ->addAttribute('class', 'menu col-md-6')
            ->addAttribute('id', 'menu')
            ->addAttribute('data-menu');

        $this->renderHtml()->shouldReturnHtml('
            <ul class="menu col-md-6" id="menu" data-menu></ul>
        ');
    }

    function it_accepts_extra_attributes()
    {

    }
}
