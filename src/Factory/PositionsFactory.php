<?php

namespace App\Factory;

use App\Model\Position;

class PositionsFactory
{
    /** @var CompanyFactory */
    private $companyFactory;

    /**
     * PositionsFactory constructor.
     * @param CompanyFactory $companyFactory
     */
    public function __construct(CompanyFactory $companyFactory)
    {
        $this->companyFactory = $companyFactory;
    }

    /**
     * @param array $row
     * @return Position
     */
    public function createPosition(array $row): Position
    {
        $skills = explode(', ', $row[7]);
        $size = explode('-', $row[8]);
        $company = $this->companyFactory->createCompany($size, $row[9]);

        return new Position(
            $row[0],
            $row[1],
            $row[2],
            $row[3],
            $row[4],
            $row[5],
            $row[6],
            $skills,
            $company
        );
    }
}