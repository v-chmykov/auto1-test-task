<?php

namespace App\Tests\Model;

use App\Model\ListSorter;
use PHPUnit\Framework\TestCase;

class ListSorterTest extends TestCase
{
    private const POSITIONS = [
        ['seniority_level' => 'Senior', 'salary' => 2],
        ['seniority_level' => 'Junior', 'salary' => 1],
        ['seniority_level' => 'Middle', 'salary' => 3],
    ];

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param string $sort
     * @param array $expectedArray
     */
    public function apply(?string $sort, array $expectedArray): void
    {
        $sorter = new ListSorter($sort);

        $this->assertEquals(
            $expectedArray,
            $sorter->apply(self::POSITIONS)
        );
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'No sorting' => [
                null,
                self::POSITIONS,
            ],
            'Sort by salary' => [
                'salary',
                [
                    ['seniority_level' => 'Junior', 'salary' => 1],
                    ['seniority_level' => 'Senior', 'salary' => 2],
                    ['seniority_level' => 'Middle', 'salary' => 3],
                ],
            ],
            'Sort by seniority_level' => [
                'seniority_level',
                [
                    ['seniority_level' => 'Junior', 'salary' => 1],
                    ['seniority_level' => 'Middle', 'salary' => 3],
                    ['seniority_level' => 'Senior', 'salary' => 2],
                ],
            ],
        ];
    }
}