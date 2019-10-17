<?php

namespace App\Factory;

use App\Model\Company;

class CompanyFactory
{
    /**
     * @param array $size
     * @param string $domain
     * @return Company
     */
    public function createCompany(array $size, string $domain): Company
    {
        return new Company($size[0], $size[1], $domain);
    }
}