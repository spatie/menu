<?php

namespace Spatie\Menu;

interface Activatable
{
    /**
     * @return $this
     */
    public function setActive();

    /**
     * @return $this
     */
    public function setInactive();
}
