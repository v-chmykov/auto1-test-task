<?php

namespace App\Tests\Storage;

use App\Model\Position;
use App\Source\SourceInterface;
use App\Storage\PositionsStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class PositionsStorageTest extends TestCase
{
    private const FAKE_POSITION = ['id', 'job title'];

    /**
     * @test
     */
    public function getAll(): void
    {
        $position = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->setMethods(['toArray'])
            ->getMock();

        $position->expects($this->once())
            ->method('toArray')
            ->willReturn(self::FAKE_POSITION);

        $storage = new PositionsStorage($this->createStorageWithPositions([$position]));

        $positions = $storage->getAll();
        foreach ($positions as $position) {
            $this->assertSame(self::FAKE_POSITION, $position);
        }
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param int $id
     * @param $expectedResult
     */
    public function getById(int $id, $expectedResult): void
    {
        $position = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->setMethods(['getId'])
            ->getMock();

        $position->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $storage = new PositionsStorage($this->createStorageWithPositions([$position]));
        $result = $storage->getById($id);

        if (null === $expectedResult) {
            $this->assertNull($result);
        } else {
            $this->assertInstanceOf(Position::class, $result);
        }
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'Existent position' => [
                1,
                Position::class,
            ],
            'Non-existent position' => [
                2,
                null,
            ],
        ];
    }

    /**
     * @param array $positions
     * @return MockObject
     */
    private function createStorageWithPositions(array $positions): MockObject
    {
        $source = $this->getMockBuilder(SourceInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['fetchAll'])
            ->getMock();

        $source->expects($this->once())
            ->method('fetchAll')
            ->willReturn($positions);

        return $source;
    }
}