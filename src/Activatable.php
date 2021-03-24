<?php

namespace Spatie\Menu;

interface Activatable
{
    public function setActive(bool | callable $active = true): static;

    public function setInactive(): static;

    public function url(): string | null;

    public function hasUrl(): bool;

    public function setUrl(string | null $url): static;

    public function determineActiveForUrl(string $url, string $root = '/'): void;
}
