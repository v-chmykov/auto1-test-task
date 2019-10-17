<?php

namespace App\Tests\Source;

use App\Factory\PositionsFactory;
use App\Model\Position;
use App\Source\FileSource;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class FileSourceTest extends TestCase
{
    /** @var FileSource */
    private $source;

    public function setUp()
    {
        $this->source = new FileSource(
            $this->createPositionsFactory(),
            __DIR__ . DIRECTORY_SEPARATOR . 'example.csv'
        );
    }

    /**
     * @test
     */
    public function fetchAll(): void
    {
        /** @var Position $item */
        foreach ($this->source->fetchAll() as $item) {
            $this->assertInstanceOf(MockObject::class, $item);
        }
    }

    /**
     * @return MockObject
     */
    private function createPositionsFactory(): MockObject
    {
        $factory = $this->getMockBuilder(PositionsFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['createPosition'])
            ->getMock();

        // Factory skip header and return just 1 row
        $factory->expects($this->once())
            ->method('createPosition')
            ->with(['cell1', 'cell2']);

        return $factory;
    }
}