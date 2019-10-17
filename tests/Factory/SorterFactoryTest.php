<?php

namespace App\Tests\Factory;

use App\Factory\SorterFactory;
use App\Model\ListSorter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class SorterFactoryTest extends TestCase
{
    /** @var SorterFactory */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new SorterFactory();
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param array $queryParams
     * @param string|null $expectedSortValue
     */
    public function createListSorterFromRequest(
        array $queryParams,
        ?string $expectedSortValue
    ): void {
        $request = $this->createRequestWithQueryParams($queryParams);
        $sorter = $this->factory->createListSorterFromRequest($request);


        $this->assertInstanceOf(ListSorter::class, $sorter);
        $this->assertEquals($expectedSortValue, $sorter->getSort());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'No parameters passed' => [
                [],
                null,
            ],
            'Sort not found' => [
                ['test' => 1],
                null,
            ],
            'Sort value is invalid' => [
                ['sort' => 'test'],
                null,
            ],
            'Sort value is valid' => [
                ['sort' => 'salary'],
                'salary',
            ],
        ];
    }

    /**
     * @param array $queryParams
     * @return MockObject
     */
    private function createRequestWithQueryParams(array $queryParams): MockObject
    {
        $queryBag = $this->createMock(ParameterBag::class);
        $queryBag->expects($this->never())
            ->method('all')
            ->willReturn($queryParams);

        if (isset($queryParams['sort'])) {
            $queryBag->expects($this->once())
                ->method('get')
                ->with('sort')
                ->willReturn($queryParams['sort']);
        }

        $request = $this->createMock(Request::class);
        $request->query = $queryBag;

        return $request;
    }
}