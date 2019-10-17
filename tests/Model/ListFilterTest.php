<?php

namespace App\Tests\Model;

use App\Model\ListFilter;
use App\Model\ListSorter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListFilterTest extends TestCase
{
    private const POSITIONS = [
        ['country' => 'DE', 'city' => 'Berlin'],
        ['country' => 'DE', 'city' => 'Munich'],
        ['country' => 'NL', 'city' => 'Amsterdam'],
    ];

    /** @var ListSorter */
    private $sorter;

    public function setUp()
    {
        $this->sorter = new ListSorter(null);
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param $key
     * @param $value
     * @param $expectedPositions
     * @param $expectedException
     * @throws NotFoundHttpException
     */
    public function apply($key, $value, $expectedPositions, $expectedException): void
    {
        $filter = new ListFilter($key, $value, $this->sorter);
        $this->assertEquals($key, $filter->getKey());
        $this->assertEquals($value, $filter->getValue());

        if (null !== $expectedException) {
            $this->expectException($expectedException);
        }

        $this->assertEquals($expectedPositions, $filter->apply(self::POSITIONS));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'Filter by country' => [
                'country',
                'NL',
                [
                    ['country' => 'NL', 'city' => 'Amsterdam'],
                ],
                null
            ],
            'Filter by country (case insensitive)' => [
                'country',
                'de',
                [
                    ['country' => 'DE', 'city' => 'Berlin'],
                    ['country' => 'DE', 'city' => 'Munich'],
                ],
                null
            ],
            'Filter by city' => [
                'city',
                'Berlin',
                [
                    ['country' => 'DE', 'city' => 'Berlin'],
                ],
                null
            ],
            'Nothing found' => [
                'city',
                'Neverland',
                [],
                NotFoundHttpException::class
            ],
        ];
    }
}