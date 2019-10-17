<?php

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\CompanyFactory;

class CompanyFactoryTest extends TestCase
{
    /** @var CompanyFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new CompanyFactory();
    }

    /**
     * @dataProvider dataProvider
     * @test
     *
     * @param array $size
     * @param string $domain
     * @param array $expectedCompany
     */
    public function createCompany(
        array $size,
        string $domain,
        array $expectedCompany
    ): void {
        $company = $this->factory->createCompany($size, $domain);

        $this->assertEquals($size[0], $company->getMinSize());
        $this->assertEquals($size[1], $company->getMaxSize());
        $this->assertEquals($size[0] . '-' . $size[1], $company->getSize());
        $this->assertEquals($domain, $company->getDomain());
        $this->assertEquals($expectedCompany, $company->toArray());
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            'Valid company with FinTech domain' => [
                [1, 10],
                'FinTech',
                [
                    'size'   => '1-10',
                    'domain' => 'FinTech',
                ],
            ],
            'Valid company with Real Estate domain' => [
                [10, 100],
                'Real Estate',
                [
                    'size'   => '10-100',
                    'domain' => 'Real Estate',
                ],
            ],
        ];
    }
}