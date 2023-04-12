<?php

namespace Spatie\Menu\Traits;

use Spatie\Menu\ActiveUrlChecker;
use Spatie\Menu\ExactUrlChecker;

/**
 * Expects an `$active` property on the class.
 *
 * @property string $url
 */
trait Activatable
{
    protected bool $exactActive = false;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool | callable $active = true): static
    {
        if (is_callable($active)) {
            $active = (bool)$active($this);
        }

        $this->active = $active;

        return $this;
    }

    public function setInactive(): static
    {
        $this->active = false;

        return $this;
    }

    public function url(): string | null
    {
        return $this->url;
    }

    public function hasUrl(): bool
    {
        return ! is_null($this->url);
    }

    public function setUrl(string | null $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function determineActiveForUrl(string $url, string $root = '/'): void
    {
        if (! $this->hasUrl()) {
            return;
        }

        ActiveUrlChecker::check($this->url, $url, $root)
            ? $this->setActive()
            : $this->setInactive();

        ExactUrlChecker::check($this->url, $url, $root)
            ? $this->setExactActive()
            : $this->setExactActive(false);
    }

    /**
     * Set if current Activatable should be marked as an exact url match.
     */
    public function setExactActive(bool | callable $exactActive = true): static
    {
	    if (is_callable($exactActive)) {
		    $this->exactActive = $exactActive($this);
		    
		    return $this;
	    }
		
        $this->exactActive = $exactActive;

        return $this;
    }

    /**
     * Check if current Activatable is marked as an exact url match.
     *
     * @return bool
     */
    public function isExactActive(): bool
    {
        return $this->exactActive;
    }
}
