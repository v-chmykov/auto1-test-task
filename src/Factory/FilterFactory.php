<?php

namespace App\Factory;

use App\Model\ListFilter;
use App\Model\SkillsFilter;
use Symfony\Component\HttpFoundation\Request;

class FilterFactory
{
    public const ALLOWED_KEYS = [
        'country' => 1,
        'city' => 1,
    ];

    /** @var SorterFactory */
    private $sorterFactory;

    public function __construct(SorterFactory $sorterFactory)
    {
        $this->sorterFactory = $sorterFactory;
    }

    /**
     * @param Request $request
     * @return ListFilter|null
     */
    public function createListFilterFromRequest(Request $request): ?ListFilter
    {
        $filter = $this->getFilter($request);
        if (null === $filter) {
            return null;
        }

        return new ListFilter(
            $filter['key'],
            $filter['value'],
            $this->sorterFactory->createListSorterFromRequest($request)
        );
    }

    /**
     * @param Request $request
     * @return SkillsFilter|null
     */
    public function createSkillsFilterFromRequest(Request $request): ?SkillsFilter
    {
        $skills = $this->getSkills($request);
        if (null === $skills) {
            return null;
        }

        return new SkillsFilter($skills);
    }

    /**
     * @param Request $request
     * @return array|null
     */
    private function getFilter(Request $request): ?array
    {
        $params = $request->query->all();
        unset($params['sort']);

        $value = reset($params);
        $key = key($params);
        if ((false !== $key) && array_key_exists($key, self::ALLOWED_KEYS)) {
            return [
                'key' => $key,
                'value' => $value,
            ];
        }

        return null;
    }

    /**
     * @param Request $request
     * @return array|null
     */
    private function getSkills(Request $request): ?array
    {
        $skillsStr = $request->query->get('skills');
        if (empty($skillsStr)) {
            return null;
        }

        return explode(',', strtolower($skillsStr));
    }
}