<?php

namespace Spatie\Menu\Traits;

trait Activatable
{
    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->active;
    }

    /**
     * @return static
     */
    public function setActive()
    {
        $this->active = true;

        return $this;
    }

    /**
     * @return static
     */
    public function setInactive()
    {
        $this->active = false;

        return $this;
    }
}
