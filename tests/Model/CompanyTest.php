<?php

namespace App\Tests\Model;

use App\Model\Company;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    /**
     * @dataProvider companyData
     * @test
     *
     * @param int $minSize
     * @param int $maxSize
     * @param string $domain
     * @param array $expectedArray
     */
    public function toArray(
        int $minSize,
        int $maxSize,
        string $domain,
        array $expectedArray
    ): void {
        $company = new Company($minSize, $maxSize, $domain);

        $this->assertEquals($expectedArray, $company->toArray());
    }

    public function companyData(): array
    {
        return [
            'Valid company with FinTech domain' => [
                1,
                10,
                'FinTech',
                ['size' => '1-10', 'domain' => 'FinTech'],
            ],
            'Valid company with Real Estate domain' => [
                10,
                100,
                'Real Estate',
                ['size' => '10-100', 'domain' => 'Real Estate'],
            ],
        ];
    }
}