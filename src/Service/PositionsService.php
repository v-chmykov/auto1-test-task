<?php

namespace App\Service;

use App\Factory\FilterFactory;
use App\Storage\PositionsStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PositionsService
 */
class PositionsService
{
    /** @var PositionsStorage */
    private $storage;

    /** @var FilterFactory */
    private $filterFactory;

    public function __construct(
        PositionsStorage $storage,
        FilterFactory $filterFactory
    ) {
        $this->storage = $storage;
        $this->filterFactory = $filterFactory;
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotFoundHttpException
     */
    public function getList(Request $request): array
    {
        $filter = $this->filterFactory->createListFilterFromRequest($request);
        $list = $this->storage->getAll();

        if (null !== $filter) {
            return $filter->apply($list);
        }

        return $list;
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function getDetails(int $id): array
    {
        $position = $this->storage->getById($id);
        if (isset($position)) {
            return $position->toArray();
        }

        $message = sprintf('Position with ID = %d not found', $id);
        throw new NotFoundHttpException($message);
    }

    /**
     * @param Request $request
     * @return array
     * @throws BadRequestHttpException
     */
    public function getMostInteresting(Request $request): array
    {
        $filter = $this->filterFactory->createSkillsFilterFromRequest($request);

        if (null === $filter) {
            throw new BadRequestHttpException('No skills provided');
        }

        $list = $this->storage->getAll();

        return $filter->apply($list);
    }
}