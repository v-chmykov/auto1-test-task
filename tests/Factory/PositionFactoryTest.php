<?php

namespace App\Tests\Factory;

use App\Factory\CompanyFactory;
use App\Factory\PositionsFactory;
use App\Model\Company;
use App\Model\Position;
use PHPUnit\Framework\TestCase;

class PositionFactoryTest extends TestCase
{
    /** @var PositionsFactory */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new PositionsFactory(new CompanyFactory);
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param array $rowFromSource
     */
    public function createPosition(array $rowFromSource): void
    {
        $position = $this->factory->createPosition($rowFromSource);

        $this->assertInstanceOf(Position::class, $position);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'Valid position' => [
                [
                    1, // id
                    'job title',
                    'seniority level',
                    'country',
                    'city',
                    650000, // salary
                    'currency',
                    'skill1,skill2',
                    '10-100', // company size
                    'domain'
                ],
            ],
        ];
    }
}