<?php

namespace App\Tests\Factory;

use App\Factory\FilterFactory;
use App\Factory\SorterFactory;
use App\Model\ListFilter;
use App\Model\SkillsFilter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class FilterFactoryTest extends TestCase
{
    /** @var FilterFactory */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new FilterFactory(new SorterFactory);
    }

    /**
     * @test
     * @dataProvider dataProviderList
     *
     * @param array $queryParam
     * @param string|null $expectedClass
     * @param array $expected
     */
    public function createListFilterFromRequest(
        array $queryParam,
        ?string $expectedClass,
        array $expected
    ): void {
        $request = $this->createRequestWithQueryParams($queryParam);
        $filter = $this->factory->createListFilterFromRequest($request);

        if (null === $expectedClass) {
            $this->assertNull($filter);
        } else {
            $this->assertInstanceOf($expectedClass, $filter);
            $this->assertEquals($expected['key'], $filter->getKey());
            $this->assertEquals($expected['value'], $filter->getValue());
        }
    }

    /**
     * @test
     * @dataProvider dataProviderSkills
     *
     * @param string $skillStr
     * @param string|null $expectedClass
     * @param array $expectedSkills
     */
    public function createSkillsFilterFromRequest(
        string $skillStr,
        ?string $expectedClass,
        array $expectedSkills
    ): void {
        $request = $this->createRequestWithSkills($skillStr);
        $filter = $this->factory->createSkillsFilterFromRequest($request);

        if (null === $expectedClass) {
            $this->assertNull($filter);
        } else {
            $this->assertInstanceOf($expectedClass, $filter);
            $this->assertEquals($expectedSkills, $filter->getSkills());
        }
    }

    /**
     * @return array
     */
    public function dataProviderList(): array
    {
        return [
            'Invalid query parameter' => [
                ['param' => 'invalid value'],
                null,
                ['key' => 'country', 'value' => 'DE', 'sorter' => null],
            ],
            'Filter by country' => [
                ['country' => 'DE'],
                ListFilter::class,
                ['key' => 'country', 'value' => 'DE', 'sorter' => null],
            ],
            'Filter by city' => [
                ['city' => 'Berlin', 'sort' => 'salary'],
                ListFilter::class,
                ['key' => 'city', 'value' => 'Berlin', 'sorter' => null],
            ],
        ];
    }

    /**
     * @return array
     */
    public function dataProviderSkills(): array
    {
        return [
            'Invalid query parameter' => [
                '',
                null,
                [],
            ],
            'Valid values' => [
                'PHP,NoSQL',
                SkillsFilter::class,
                ['php', 'nosql'],
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
        $queryBag->expects($this->once())
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

    /**
     * @param string $skillsStr
     * @return MockObject
     */
    private function createRequestWithSkills(string $skillsStr): MockObject
    {
        $queryBag = $this->createMock(ParameterBag::class);
        $queryBag->expects($this->once())
            ->method('get')
            ->with('skills')
            ->willReturn($skillsStr);

        $request = $this->createMock(Request::class);
        $request->query = $queryBag;

        return $request;
    }
}