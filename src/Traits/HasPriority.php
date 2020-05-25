<?php

namespace Spatie\Menu\Traits;

trait HasPriority
{
    /**
     * @var int
     */
    protected $itemPriority = 0;

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->itemPriority;
    }

    /**
     * @param int $priority
     * @return $this
     */
    public function setPriority(int $priority = 0)
    {
        $this->itemPriority = $priority;

        return $this;
    }
}
