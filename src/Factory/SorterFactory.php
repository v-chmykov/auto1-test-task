<?php

namespace App\Factory;

use App\Model\ListSorter;
use Symfony\Component\HttpFoundation\Request;

class SorterFactory
{
    public const ALLOWED_SORT = [
        'seniority_level' => 1,
        'salary' => 1,
    ];

    /**
     * @param Request $request
     * @return ListSorter|null
     */
    public function createListSorterFromRequest(Request $request): ?ListSorter
    {
        return new ListSorter(
            $this->getSort($request)
        );
    }

    /**
     * @param Request $request
     * @return string|null
     */
    private function getSort(Request $request): ?string
    {
        $sort = $request->query->get('sort');
        if (array_key_exists($sort, self::ALLOWED_SORT)) {
            return $sort;
        }

        return null;
    }

}