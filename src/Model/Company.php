<?php

namespace App\Model;


class Company
{
    /** @var int */
    private $minSize;

    /** @var int */
    private $maxSize;

    /** @var string */
    private $domain;

    /**
     * Company constructor.
     * @param int $minSize
     * @param int $maxSize
     * @param string $domain
     */
    public function __construct(int $minSize, int $maxSize, string $domain)
    {
        $this->minSize = $minSize;
        $this->maxSize = $maxSize;
        $this->domain = $domain;
    }

    /**
     * @return int
     */
    public function getMinSize(): int
    {
        return $this->minSize;
    }

    /**
     * @return int
     */
    public function getMaxSize(): int
    {
        return $this->maxSize;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'size'   => $this->getSize(),
            'domain' => $this->domain,
        ];
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->minSize . '-' . $this->maxSize;
    }
}