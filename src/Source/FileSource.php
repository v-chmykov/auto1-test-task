<?php

namespace App\Source;

use App\Factory\PositionsFactory;

class FileSource implements SourceInterface
{
    /** @var PositionsFactory */
    private $positionsFactory;

    /** @var string */
    private $filePath;

    public function __construct(
        PositionsFactory $positionsFactory,
        string $filePath
    ) {
        $this->positionsFactory = $positionsFactory;
        $this->filePath = $filePath;
    }

    /**
     * @return iterable
     */
    public function fetchAll(): iterable
    {
        $file = fopen($this->filePath, 'r');
        // skip header
        fgetcsv($file);

        // not the best solution (pretty bad readable)
        while (($row = fgetcsv($file)) !== FALSE) {
            yield $this->positionsFactory->createPosition($row);
        }

        fclose($file);
    }
}