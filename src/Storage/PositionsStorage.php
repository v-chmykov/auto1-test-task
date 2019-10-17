<?php

namespace App\Storage;

use App\Model\Position;
use App\Source\SourceInterface;

class PositionsStorage
{
    /** @var SourceInterface */
    private $source;

    /**
     * PositionsStorage constructor.
     * @param SourceInterface $source
     */
    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $positions = [];
        /** @var Position $position */
        foreach($this->source->fetchAll() as $position) {
            $positions[] = $position->toArray();
        }

        return $positions;
    }

    /**
     * @param int $id
     * @return Position|null
     */
    public function getById(int $id): ?Position
    {
        /** @var Position $position */
        foreach($this->source->fetchAll() as $position) {
            if ($id === $position->getId()) {
                return $position;
            }
        }

        return null;
    }
}