<?php

use Spatie\Menu\Html;

it('contains html', function () {
    expect(Html::raw('Hello world')->html())->toEqual('Hello world');
});

it('can make an empty item', function () {
    expect(Html::empty()->html())->toEqual('');
});
