<?php

namespace App\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListFilter
{
    /** @var string */
    private $key;
    /** @var string */
    private $value;
    /** @var ListSorter */
    private $sorter;

    /**
     * ListFilter constructor.
     * @param $key
     * @param $value
     * @param ListSorter $sorter
     */
    public function __construct($key, $value, ListSorter $sorter)
    {
        $this->key = $key;
        $this->value = $value;
        $this->sorter = $sorter;
    }

    /**
     * @return string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param array $positions
     * @return array
     * @throws NotFoundHttpException
     */
    public function apply(array $positions): array
    {
        $filtered = $this->filter($positions);
        if (count($filtered) < 1) {
            $message = sprintf('Positions with the field "%s" and the value "%s" not found', $this->key, $this->value);
            throw new NotFoundHttpException($message);
        }

        return $this->sorter->apply($filtered);
    }

    /**
     * @param array $positions
     * @return array
     */
    private function filter(array $positions): array
    {
        return array_filter($positions, function (array $position) {
            return array_key_exists($this->key, $position)
                && (0 === strcasecmp($position[$this->key], $this->value));
        });
    }
}