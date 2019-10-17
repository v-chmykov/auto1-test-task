<?php

namespace App\Tests\Service;

use App\Factory\FilterFactory;
use App\Model\ListFilter;
use App\Model\Position;
use App\Model\SkillsFilter;
use App\Service\PositionsService;
use App\Storage\PositionsStorage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PositionsServiceTest extends TestCase
{
    /**
     * @test
     */
    public function getListWithFilter(): void
    {
        $request = $this->createMock(Request::class);

        $filter = $this->getMockBuilder(ListFilter::class)
            ->disableOriginalConstructor()
            ->setMethods(['apply'])
            ->getMock();
        $filter->expects($this->once())
            ->method('apply')
            ->willReturn([]);

        $storage = $this->getMockBuilder(PositionsStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAll'])
            ->getMock();
        $storage->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        $factory = $this->createMockFactory('createListFilterFromRequest', $filter, $request);

        $service = new PositionsService($storage, $factory);
        $this->assertEquals([], $service->getList($request));
    }
    /**
     * @test
     */
    public function getList(): void
    {
        $request = $this->createMock(Request::class);

        $storage = $this->getMockBuilder(PositionsStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAll'])
            ->getMock();
        $storage->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        $factory = $this->createMockFactory('createListFilterFromRequest', null, $request);

        $service = new PositionsService($storage, $factory);
        $this->assertEquals([], $service->getList($request));
    }

    /**
     * @test
     */
    public function getMostInteresting(): void
    {
        $request = $this->createMock(Request::class);

        $filter = $this->getMockBuilder(SkillsFilter::class)
            ->disableOriginalConstructor()
            ->setMethods(['apply'])
            ->getMock();
        $filter->expects($this->once())
            ->method('apply')
            ->willReturn([]);

        $storage = $this->getMockBuilder(PositionsStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAll'])
            ->getMock();
        $storage->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        $factory = $this->createMockFactory('createSkillsFilterFromRequest', $filter, $request);

        $service = new PositionsService($storage, $factory);
        $this->assertEquals([], $service->getMostInteresting($request));
    }

    /**
     * @test
     */
    public function getMostInterestingWithException(): void
    {
        $request = $this->createMock(Request::class);

        $storage = $this->getMockBuilder(PositionsStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAll'])
            ->getMock();
        $storage->expects($this->never())
            ->method('getAll');

        $factory = $this->createMockFactory('createSkillsFilterFromRequest', null, $request);

        $service = new PositionsService($storage, $factory);
        $this->expectException(BadRequestHttpException::class);
        $this->assertEquals([], $service->getMostInteresting($request));
    }

    /**
     * @test
     */
    public function getDetails(): void
    {
        $fakePosition = ['id' => 1];
        $fakePositionId = $fakePosition['id'];

        $position = $this->createMockPosition($fakePosition);
        $storage = $this->createMockStorage('getById', $position, $fakePositionId);

        $factory = $this->getMockBuilder(FilterFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $service = new PositionsService($storage, $factory);
        $result = $service->getDetails($fakePositionId);

        $this->assertEquals($fakePosition, $result);
    }

    /**
     * @test
     */
    public function getDetailsWithException(): void
    {
        $nonExistentPositionId = 2;
        $storage = $this->createMockStorage('getById', null, 2);

        $factory = $this->getMockBuilder(FilterFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expectException(NotFoundHttpException::class);

        $service = new PositionsService($storage, $factory);
        $service->getDetails($nonExistentPositionId);
    }

    /**
     * @param array $positionFields
     * @return MockObject
     */
    private function createMockPosition(array $positionFields): MockObject
    {
        $position = $this->getMockBuilder(Position::class)
            ->disableOriginalConstructor()
            ->setMethods(['toArray'])
            ->getMock();
        $position->expects($this->once())
            ->method('toArray')
            ->willReturn($positionFields);

        return $position;
    }

    /**
     * @param $method
     * @param $return
     * @param null $with
     * @return MockObject
     */
    private function createMockStorage($method, $return, $with = null): MockObject
    {
        $storage = $this->getMockBuilder(PositionsStorage::class)
            ->disableOriginalConstructor()
            ->setMethods([$method])
            ->getMock();
        $storage->expects($this->once())
            ->method($method)
            ->with($with)
            ->willReturn($return);

        return $storage;
    }

    /**
     * @param $method
     * @param $return
     * @param null $with
     * @return MockObject
     */
    private function createMockFactory($method, $return, $with = null): MockObject
    {
        $factory = $this->getMockBuilder(FilterFactory::class)
            ->disableOriginalConstructor()
            ->setMethods([$method])
            ->getMock();
        $factory->expects($this->once())
            ->method($method)
            ->with($with)
            ->willReturn($return);

        return $factory;
    }
}