<?php

use Spatie\Menu\Traits\Activatable;

beforeEach(function () {
    $this->activatable = new class () {
        use Activatable;
        protected $active = false;
    };
});

it('can be set active', function () {
    expect($this->activatable->setActive()->isActive())->toBeTrue();
});

it('can be set inactive via set active', function () {
    expect($this->activatable->setActive()->setActive(false)->isActive())->toBeFalse();
});

it('can be set inactive via set inactive', function () {
    expect($this->activatable->setActive()->setInactive()->isActive())->toBeFalse();
});

it('can be set active via a callable', function () {
    expect($this->activatable->setActive(function () {
        return false;
    })->isActive())->toBeFalse();
});
