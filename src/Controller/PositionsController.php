<?php

namespace App\Controller;

use App\Factory\FilterFactory;
use App\Service\PositionsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PositionsController
{
    /** @var PositionsService */
    private $positionsService;

    public function __construct(PositionsService $positionsService) {
        $this->positionsService = $positionsService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function listAction(Request $request): JsonResponse
    {
        try {
            $list = $this->positionsService->getList($request);
            return new JsonResponse(
                $list,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function detailsAction(int $id): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->positionsService->getDetails($id),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function mostInterestingAction(Request $request): JsonResponse
    {
        try {
            return new JsonResponse(
                $this->positionsService->getMostInteresting($request),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @param HttpException $e
     * @return JsonResponse
     */
    private function responseWithError(HttpException $e): JsonResponse
    {
        return new JsonResponse(
            [
                'description' => $e->getMessage(),
            ],
            $e->getStatusCode()
        );
    }
}