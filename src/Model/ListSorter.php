<?php

namespace App\Model;

class ListSorter
{
    /** @var string */
    private $sort;

    /**
     * ListSorter constructor.
     * @param null $sort
     */
    public function __construct($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return string|null
     */
    public function getSort(): ?string
    {
        return $this->sort;
    }

    /**
     * @param array $positions
     * @return array
     */
    public function apply(array $positions): array
    {
        if (null !== $this->sort) {
            return $this->sortByKey($positions, $this->sort);
        }

        return array_values($positions);
    }

    /**
     * @param array $positions
     * @param string $key
     * @return array
     */
    private function sortByKey(array $positions, string $key): array
    {
        $sorted = $positions;
        uasort($sorted, $this->sorter($key));

        return array_values($sorted);
    }

    /**
     * @param $key
     * @return callable
     */
    private function sorter($key): callable
    {
        return function ($a, $b) use ($key) {
            if (is_numeric($a) && is_numeric($b)) {
                return ($a[$key] <> $b[$key]);
            }

            return strcasecmp($a[$key], $b[$key]);
        };
    }

}