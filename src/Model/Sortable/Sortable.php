<?php

declare(strict_types=1);

namespace Knp\DoctrineBehaviors\Model\Sortable;

trait Sortable
{
    /**
     * @var int
     */
    protected $sort = 1;

    /**
     * @var bool
     */
    private $reordered = false;

    /**
     * Get sort.
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * Set sort.
     *
     * @param int $sort Sort the value to set
     *
     * @return $this
     */
    public function setSort(int $sort)
    {
        $this->reordered = $this->sort !== $sort;
        $this->sort = $sort;

        return $this;
    }

    public function isReordered(): bool
    {
        return $this->reordered;
    }

    /**
     * @return $this
     */
    public function setReordered()
    {
        $this->reordered = true;

        return $this;
    }
}
