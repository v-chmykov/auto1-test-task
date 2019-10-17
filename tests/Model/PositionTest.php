<?php

namespace App\Tests\Model;

use App\Model\Company;
use App\Model\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @test
     *
     * @param int $id
     * @param string $title
     * @param string $seniorityLevel
     * @param string $country
     * @param string $city
     * @param int $salary
     * @param string $currency
     * @param array $skills
     * @param Company $company
     * @param $expectedArray
     */
    public function toArray(
        int $id,
        string $title,
        string $seniorityLevel,
        string $country,
        string $city,
        int $salary,
        string $currency,
        array $skills,
        Company $company,
        $expectedArray
    ): void {
        $position = new Position($id, $title, $seniorityLevel, $country, $city, $salary, $currency, $skills, $company);

        $this->assertEquals($id, $position->getId());
        $this->assertEquals($expectedArray, $position->toArray());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $company = new Company(1, 10, 'Real Estate');

        return [
            'Valid position' => [
                1,
                'PHP Developer',
                'Middle',
                'DE',
                'Berlin',
                650000,
                'SVU',
                ['PHP', 'SQL'],
                $company,
                [
                    'id' => 1,
                    'title' => 'PHP Developer',
                    'seniority_level' => 'Middle',
                    'country' => 'DE',
                    'city' => 'Berlin',
                    'salary' => 650000,
                    'currency' => 'SVU',
                    'skills' => ['PHP', 'SQL'],
                    'company' => $company->toArray(),
                ],
            ],
        ];
    }
}