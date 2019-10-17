<?php

namespace App\Model;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SkillsFilter
{
    /** @var array $skills */
    private $skills;

    public function __construct(array $skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return array
     */
    public function getSkills(): array
    {
        return $this->skills;
    }

    /**
     * @param array $positions
     * @return array
     */
    public function apply(array $positions): array
    {
        $filtered = $this->filter($positions);
        if (count($filtered) < 1) {
            $message = sprintf('Positions with skills "%s" not found', implode(',', $this->skills));
            throw new NotFoundHttpException($message);
        }

        return array_values($this->filter($positions));
    }

    /**
     * @param array $positions
     * @return array
     */
    private function filter(array $positions): array
    {
        return array_values(array_filter($positions, function (array $position) {
            $skills = $this->arrayToLowerCase($position['skills']);

            return (array_intersect($this->skills, $skills) === $this->skills);
        }));
    }

    /**
     * @param array $array
     * @return array
     */
    private function arrayToLowerCase(array $array): array
    {
        return explode(',', strtolower(implode(',', $array)));
    }
}