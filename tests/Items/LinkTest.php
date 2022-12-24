<?php

use Spatie\Menu\Link;

it('contains text', function () {
    expect(Link::to('https://spatie.be', 'Home')->text())->toEqual('Home');
});

it('has an url', function () {
    expect(Link::to('https://spatie.be', 'Home')->url())->toEqual('https://spatie.be');
});

it('can be rendered', function () {
    expect(Link::to('https://spatie.be', 'Home')->render())->toEqual('<a href="https://spatie.be">Home</a>');
});

it('can render classes', function () {
    expect(Link::to('https://spatie.be', 'Home')->addClass('home')->render())->toEqual('<a href="https://spatie.be" class="home">Home</a>');
});

it('can render attributes', function () {
    expect(Link::to('https://spatie.be', 'Home')->setAttribute('data-home-link')->render())->toEqual('<a href="https://spatie.be" data-home-link>Home</a>');
});
